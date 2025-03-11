<?php

namespace lib\db;

use \PDO;
use \lib\App;
use \lib\core\FileSystem;

class Connection
{
	public $app;
	public $server;
	public $options;
	public $pdo;

	public static function get(App $app, $name) {
		if (isset($app->db[$name])) {
			return $app->db[$name];
		}

		$path = realpath($app->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules/Connections/' . $name . '.php'));
		if (FileSystem::exists($path)) {
			require(FileSystem::encode($path));
			$data = json_decode($exports);
            return new Connection($app, $app->parseObject($data->options), $name);
		}
		
		throw new \Exception('Connection "' . $name . '" not found.');
	}

	public function __construct(App $app, $options, $name) {
		$this->app = $app;

		$options = $this->app->parseObject($options);
		$this->options = $options;

		if (!isset($options->connectionString)) {
			throw new \Exception('Connection String is Required');
		}

		$className = '\\lib\\db\\server\\' . $options->server;
		$this->server = new $className();

		$dsn = $options->connectionString;
		$user = '';
		$password = '';
		$preps = FALSE;
		$sslca = '';
		$sslverify = FALSE;
		$charset = 'utf8';
		$pdo_options = NULL;

		if (preg_match("/user=([^;]*)/i", $dsn, $match)) {
			$user = $match[1];
		}

		if (preg_match("/password=([^;]*)/i", $dsn, $match)) {
			$password = $match[1];
		}

		if (!preg_match('/^pgsql:/', $dsn)) {
			$dsn = preg_replace("/(user|password)=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/preps=([^;]*)/i', $dsn, $match)) {
			$preps = $match[1] === 'true' ? TRUE : FALSE;
			$dsn = preg_replace("/preps=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/sslca=([^;]*)/i', $dsn, $match)) {
			$sslca = $match[1];
			$dsn = preg_replace("/sslca=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/sslverify=([^;]*)/i', $dsn, $match)) {
			$sslverify = $match[1] === 'true' ? TRUE : FALSE;
			$dsn = preg_replace("/sslverify=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/charset=([^;]*)/i', $dsn, $match)) {
			$charset = $match[1];
			$dsn = preg_replace("/charset=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/^mysql:/', $dsn)) {
			$pdo_options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset,
				PDO::ATTR_EMULATE_PREPARES => $preps,
				PDO::ATTR_STRINGIFY_FETCHES => FALSE
			);

			if (version_compare(PHP_VERSION, '5.3.7', '>=') && $sslca) {
				$pdo_options[PDO::MYSQL_ATTR_SSL_CA] = $sslca;

				if (version_compare(PHP_VERSION, '7.0.18', '>=')) {
					$pdo_options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = $sslverify;
				}
			}
		}

		if (preg_match('/^sqlite:/', $dsn)) {
			$dsn = str_replace('sqlite:', 'sqlite:'. $_SERVER['DOCUMENT_ROOT'] . '/', $dsn);
		}

		$this->pdo = new PDO($dsn, $user, $password, $pdo_options);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->app->db[$name] = $this;
	}

	public function execute($query, array $params, $returnRecords = TRUE, $table = '', $meta = []) {
		$statement = $this->pdo->prepare($query);

		foreach ($params as $key => $param) {
			$param = $this->app->parseObject($param);

			if (isset($param->type) && isset($param->value) && is_string($param->value)) {
				switch (strtolower($param->type)) {
					case 'date':
						$param->value = date('Y-m-d', strtotime($param->value));
						break;
					case 'time':
						$param->value = date('H:i:s', strtotime($param->value));
						break;
					case 'datetime':
						$param->value = date('Y-m-d H:i:s', strtotime($param->value));
						break;
				}
			}

			if (isset($param->type) && $param->type == 'json') {
				$param->value = json_encode($param->value);
			}

			if (isset($param->whereType) && $param->whereType == 'Like') {
				$param->value = $this->server->escapeLike(strval($param->value));
			} elseif (isset($param->operation) && $param->operation == 'LIKE') {
				$param->value = $this->server->escapeLike(strval($param->value));
			}

			$statement->bindParam($key + 1, $param->value, $this->getParamType($param->value));
		}

		$statement->execute();

		if ($returnRecords && $statement->columnCount() > 0) {
			$records = array();
			$types = is_array($meta) ? array_column($meta, 'type', 'name') : array();

			while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				foreach ($row as $name => $value) {
					if ($value !== NULL && isset($types[$name]) && ($types[$name] == 'json' || $types[$name] == 'object' || $types[$name] == 'array')) {
						// json support
						$row[$name] = json_decode($value);
					}
				}
				array_push($records, $row);
			}

			return $records;
			//return $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		$identity = NULL;

		try {
			if (stristr($query, 'insert')) {
				if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) == 'pgsql') {
					$identity = $this->pdo->lastInsertId($table.'_id_seq');
				} else {
					$identity = $this->pdo->lastInsertId();
				}
			}
		} catch(\Exception $err) {
			// Ignore the error
		}

		return (object)array(
			'identity' => $identity,
			'affected' => $statement->rowCount()
		);
	}

	private function getParamType($value) {
		if ($value === NULL) {
			return PDO::PARAM_NULL;
		}
		elseif (is_bool($value)) {
			return PDO::PARAM_BOOL;
		}
		elseif (is_int($value)) {
			return PDO::PARAM_INT;
		}

		return PDO::PARAM_STR;
	}
}

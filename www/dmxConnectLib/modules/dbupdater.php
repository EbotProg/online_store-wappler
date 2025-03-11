<?php

namespace modules;

use \lib\core\Module;
use \lib\db\Connection;
use \lib\db\SqlBuilder;

class dbupdater extends Module
{
	public function insert($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'table');

		$options = $this->parseOptions($options);

        $options->sql->type = 'insert';

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

		if (isset($options->sql->sub)) {
			try {
				$connection->pdo->beginTransaction();

				$db = $connection->options->server;
				$pdo = $connection->pdo;
				$server = $connection->server;
				$version = str_replace('5.5.5-', '', $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION));
				$sql = $options->sql;

				$table = $server->quoteIdentifier($sql->table);
				$returning = $server->quoteIdentifier($sql->returning);
				$columns = implode(', ', array_map(function ($value) use ($server) {
					return $server->quoteIdentifier($value->column);
				}, $sql->values));
				$values = implode(', ', array_fill(0, count($sql->values), '?'));
				$query = "INSERT INTO $table ($columns) VALUES ($values)";

				switch ($db) {
					case 'mssql':
						// Create temp table
						$pdo->exec("SELECT TOP(0) [t].$returning INTO #out FROM $table AS t LEFT JOIN $table ON 0=1");

						// The actual insert statement with output inserted to temp table
						$stmt = $pdo->prepare("INSERT INTO $table ($columns) OUTPUT inserted.$returning INTO #out VALUES ($values)");
						$stmt->execute(array_map(array($this, 'prepareParams'), $sql->values));

						// Get the returned values
						$identity = $pdo->query("SELECT $returning FROM #out", \PDO::FETCH_COLUMN, 0);

						// Drop the temp table to prevent memory leaks
						$pdo->exec("DROP TABLE #out");

						break;

					case 'mysql':
						if (strpos($version, 'MariaDB') !== FALSE && version_compare($version, '10.5', '>=')) {
							// MariaDB 10.5+ supports RETURNING
							$query .= " RETURNING $returning";

							$stmt = $pdo->prepare($query);
							$stmt->execute(array_map(array($this, 'prepareParams'), $sql->values));

							$identity = $stmt->fetchColumn();
						} else {
							$stmt = $pdo->prepare($query);
							$stmt->execute(array_map(array($this, 'prepareParams'), $sql->values));

							$identity = $pdo->lastInsertId();
						}

						break;

					case 'postgres':
						$query .= " RETURNING $returning";

						$stmt = $pdo->prepare($query);
						$stmt->execute(array_map(array($this, 'prepareParams'), $sql->values));

						$identity = $stmt->fetchColumn();

						break;

					case 'sqlite':
						if (version_compare($version, '3.35', '>=')) {
							// Returning is supported in version 3.35+
							$query .= " RETURNING $returning";

							$stmt = $pdo->prepare($query);
							$stmt->execute(array_map(array($this, 'prepareParams'), $sql->values));

							$identity = $stmt->fetchColumn();
						} else {
							$stmt = $pdo->prepare($query);
							$stmt->execute(array_map(array($this, 'prepareParams'), $sql->values));

							$identity = $pdo->query("SELECT $returning FROM $table WHERE rowid = last_insert_rowid()", \PDO::FETCH_COLUMN, 0);
						}
						break;
				}

				foreach ($sql->sub as $sub) {
					if (!is_array($sub->value)) break;

					$table = $server->quoteIdentifier($sub->table);

					foreach ($sub->value as $current) {
						if (is_object($current)) {
							$current->{$sub->key} = $identity;
						} elseif (is_array($current)) {
							$current = (object)array_merge(
								array($sub->key => $identity),
								$current
							);
						} else {
							$current = (object)array(
								$sub->key => $identity,
								$sub->values[0]->column => $current
							);
						}

						$keys = array_keys((array)$current);
						$params = array_values((array)$current);

						$columns = implode(', ', array_map(array($server, 'quoteIdentifier'), $keys));
						$values = implode(', ', array_fill(0, count($params), '?'));

						$query = "INSERT INTO $table ($columns) VALUES ($values)";

						$stmt = $pdo->prepare($query);
						$stmt->execute($params);
					}
				}

				$connection->pdo->commit();
			} catch (\Exception $e) {
				$connection->pdo->rollback();
				throw $e;
			}

			return (object)array(
				'affected' => 1,
				'identity' => $identity
			);
		}

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
		$sql->compile();

		if (isset($options->test)) {
			return (object)array(
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params, FALSE, $sql->table);
	}

	public function update($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'table');

		$options = $this->parseOptions($options);

        $options->sql->type = 'update';

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

		if (isset($options->sql->sub)) {
			try {
				$connection->pdo->beginTransaction();

				$db = $connection->options->server;
				$pdo = $connection->pdo;
				$server = $connection->server;
				$version = str_replace('5.5.5-', '', $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION));
				$sql = $options->sql;

				$builder = new SqlBuilder($this->app, $connection);
                $builder->fromJSON($sql);
                $builder->compile();
                
				$query = $builder->query;
                $params = $builder->params;

				$table = $server->quoteIdentifier($sql->table);
				$returning = $server->quoteIdentifier($sql->returning);

				switch ($db) {
					case 'mssql':
						// Create temp table
						$pdo->exec("SELECT TOP(0) [t].$returning INTO #out FROM $table AS t LEFT JOIN $table ON 0=1");

						// The actual update statement with output to temp table
						$pos = strpos($query, ' WHERE');
						$update = substr($query, 0, $pos);
						$update .= " OUTPUT inserted.$returning INTO #out";
						$update .= substr($query, $pos);
						
						$stmt = $pdo->prepare($update);
						$stmt->execute(array_map(array($this, 'prepareParams'), $params));

						// Get the returned values
						$stmt = $pdo->query("SELECT $returning FROM #out");

						$updated = array();
						while ($ident = $stmt->fetchColumn()) {
							$updated[] = $ident;
						}

						// Drop the temp table to prevent memory leaks
						$pdo->exec("DROP TABLE #out");

						break;

					case 'mysql':
						$stmt = $pdo->prepare($query);
						$stmt->execute(array_map(array($this, 'prepareParams'), $params));

						// Get the returned values
						$pos = strpos($query, ' WHERE');
						$stmt = $pdo->prepare("SELECT $returning FROM $table" . substr($query, $pos));
						$stmt->execute(array_map(array($this, 'prepareParams'), array_values(array_filter($params, function($value) { return isset($value->operation); }))));

						$updated = array();
						while ($ident = $stmt->fetchColumn()) {
							$updated[] = $ident;
						}

						break;

					case 'postgres':
						$stmt = $pdo->prepare($query . " RETURNING $returning");
						$stmt->execute(array_map(array($this, 'prepareParams'), array_values(array_filter($params, function($value) { return isset($value->operation); }))));

						$updated = array();
						while ($ident = $stmt->fetchColumn()) {
							$updated[] = $ident;
						}

						break;

					case 'sqlite':
						if (version_compare($version, '3.35', '>=')) {
							// Returning is supported in version 3.35+
							$stmt = $pdo->prepare($query . " RETURNING $returning");
							$stmt->execute(array_map(array($this, 'prepareParams'), array_values(array_filter($params, function($value) { return isset($value->operation); }))));

							$updated = array();
							while ($ident = $stmt->fetchColumn()) {
								$updated[] = $ident;
							}
						} else {
							$stmt = $pdo->prepare($query);
							$stmt->execute(array_map(array($this, 'prepareParams'), $params));

							// Get the returned values
							$pos = strpos($query, ' WHERE');
							$stmt = $pdo->prepare("SELECT $returning FROM $table" . substr($query, $pos));
							$stmt->execute(array_map(array($this, 'prepareParams'), array_values(array_filter($params, function($value) { return isset($value->operation); }))));

							$updated = array();
							while ($ident = $stmt->fetchColumn()) {
								$updated[] = $ident;
							}
						}

						break;
				}

				foreach ($sql->sub as $sub) {
					if (!is_array($sub->value)) break;

					$table = $server->quoteIdentifier($sub->table);
					$returning = $server->quoteIdentifier($sub->returning);
					$key = $server->quoteIdentifier($sub->key);
					$params = implode(', ', array_fill(0, count($updated), '?'));

					$query = "DELETE FROM $table WHERE $key IN ($params)";

					$stmt = $pdo->prepare($query);
					$stmt->execute($updated);

					foreach ($updated as $identity) {
						foreach ($sub->value as $current) {
							if (is_object($current)) {
								$current->{$sub->key} = $identity;
							} elseif (is_array($current)) {
								$current = (object)array_merge(
									array($sub->key => $identity),
									$current
								);
							} else {
								$current = (object)array(
									$sub->key => $identity,
									$sub->values[0]->column => $current
								);
							}

							$keys = array_keys((array)$current);
                            $params = array_values((array)$current);

							$columns = implode(', ', array_map(array($server, 'quoteIdentifier'), $keys));
							$values = implode(', ', array_fill(0, count($params), '?'));

							$query = "INSERT INTO $table ($columns) VALUES ($values)";

							$stmt = $pdo->prepare($query);
							$stmt->execute($params);
						}
					}
				}

				$connection->pdo->commit();
			} catch (\Exception $e) {
				$connection->pdo->rollback();
				throw $e;
			}

			return (object)array(
				'affected' => count($updated)
			);
		}

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
		$sql->compile();

		if (isset($options->test)) {
			return (object)array(
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params);
	}

	public function delete($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'table');

		$options = $this->parseOptions($options);

        $options->sql->type = 'delete';

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
		$sql->compile();

		if (isset($options->test)) {
			return (object)array(
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params);
	}

	public function custom($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'query');
		option_require($options->sql, 'params');

		$options = $this->parseOptions($options);

		$connection = Connection::get($this->app, $options->connection);

		if ($connection === NULL) {
			throw new \Exception('Connection "' . $options->connection . '" not found.');
		}

		$query = $options->sql->query;
		$params = array();

        $query = preg_replace_callback('/((?<=[^:])[:@][a-zA-Z_]\w*|\?)/', function($matches) use (&$params, $options) {
            $match = $matches[0];

            if ($match == '?') {
                $params[] = $options->sql->params[count($params)];
            } else {
                $columns = array_column($options->sql->params, 'name');
                $key = array_search($match, $columns);
                $params[] = $options->sql->params[$key];
            }

            return '?';
        }, $query);

        if (isset($options->test)) {
			return (object)array(
				'query' => $query,
				'params' => $params
			);
		}

		return $connection->execute($query, $params);
	}

	public function execute($options) {
		option_require($options, 'connection');
		option_require($options, 'query');
		option_default($options, 'params', array());

		$options = $this->app->parseObject($options);

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

		return $connection->execute($options->query, $options->params);
	}

	public function bulkinsert($options) {
		option_require($options, 'connection');
		option_require($options, 'source');
		option_require($options, 'sql');
		option_require($options->sql, 'table');
		option_require($options->sql, 'values');
		//option_default($options, 'batchsize', 100);

		$options = $this->parseOptions($options);

		$connection = Connection::get($this->app, $options->connection);

		// change bulkinsert back to insert for SqlBuilder
		$options->sql->type = 'insert';
		
		$sql = new SqlBuilder($this->app, $connection);
		$sql->fromJSON($options->sql);
		$sql->compile();

		if ($connection === NULL) {
				throw new \Exception('Connection "' . $options->connection . '" not found.');
		}

		$statement = $connection->pdo->prepare($sql->query);

		try {
			$connection->pdo->beginTransaction();

			foreach ($options->source as $record) {
				$record = (object)$record;
				$values = array();

				foreach ($options->sql->values as $key => $param) {
					$value = isset($record->{$param->value}) ? $record->{$param->value} : NULL;

					if (isset($param->type) && isset($value) && is_string($value)) {
						switch (strtolower($param->type)) {
							case 'date':
								$value = date('Y-m-d', strtotime($value));
								break;
							case 'time':
								$value = date('H:i:s', strtotime($value));
								break;
							case 'datetime':
								$value = date('Y-m-d H:i:s', strtotime($value));
								break;
						}
					}
		
					if (isset($param->type) && $param->type == 'json') {
						$value = json_encode($value);
					}
		
					$values[] = $value;
				}

				$statement->execute($values);
			}

			$connection->pdo->commit();
		} catch (\Exception $e) {
			$connection->pdo->rollBack();
			throw $e;
		}

		return (object)array(
			'affected' => count($options->source)
		);
	}

	public function transaction($options) {
		option_require($options, 'connection');
		option_require($options, 'exec');

		$connection = Connection::get($this->app, $options->connection);
		$data = array();

		if ($connection === NULL) {
			throw new \Exception('Connection "' . $options->connection . '" not found.');
		}

		try {
			$connection->pdo->beginTransaction();

			if (!empty($name)) {
				$appData = $this->app->data;
				$this->app->data = array();
				$this->app->exec($options->exec, TRUE);
				$data = $this->app->data;
				$this->app->data = $appData;
			} else {
				$this->app->exec($options->exec, TRUE);
			}

			$connection->pdo->commit();
		} catch (\Exception $e) {
			$connection->pdo->rollBack();
			throw $e;
		}

		return $data;
	}

	protected function parseOptions($options) {
			$props = array('values', 'wheres', 'orders');

			foreach ($props as $prop) {
					if (isset($options->sql->{$prop}) && is_array($options->sql->{$prop})) {
							$options->sql->{$prop} = array_filter($options->sql->{$prop}, array($this, 'filter'));
					}
			}

			if (isset($options->sql->wheres) && isset($options->sql->wheres->rules)) {
					if (!empty($options->sql->wheres->conditional) && !$this->app->parseObject($options->sql->wheres->conditional)) {
							unset($options->sql->wheres);
					} else {
							$options->sql->wheres->rules = array_filter($options->sql->wheres->rules, array($this, 'filterRules'));

							if (empty($options->sql->wheres->rules)) {
									unset($options->sql->wheres);
							}
					}
			}

			return $this->app->parseObject($options);
	}

	protected function filterRules($rule) {
			if (!isset($rule->rules)) return TRUE;
			if (!empty($rule->conditional) && !$this->app->parseObject($rule->conditional)) return FALSE;
			$rule->rules = array_filter($rule->rules, array($this, 'filterRules'));
			return !empty($rule->rules);
	}

	protected function filter($val) {
		if (!isset($val->condition)) return TRUE;
		return $this->app->parseObject($val->condition);
	}

	protected function prepareParams($param) {
		if (isset($param->type) && isset($param->value) && is_string($param->value)) {
			switch (strtolower($param->type)) {
				case 'date': return date('Y-m-d', strtotime($param->value));
				case 'time': return date('H:i:s', strtotime($param->value));
				case 'datetime': return date('Y-m-d H:i:s', strtotime($param->value));
			}
		}

		if (isset($param->type) && $param->type == 'json') {
			return json_encode($param->value);
		}

		return $param->value;
	}
}

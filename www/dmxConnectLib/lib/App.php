<?php

namespace lib;

use \lib\core\Scope;
use \lib\core\Lexer;
use \lib\core\Parser;
use \lib\core\Request;
use \lib\core\Response;
use \lib\core\Session;
use \lib\core\FileSystem;

class App
{
    public $modules = array();

    public $WIN = FALSE;
    public $debug = FALSE;
    public $error = FALSE;
    public $data = array();
    public $meta = NULL;

    public $scope;
    public $lexer;
    public $parser;
    public $request;
    public $response;
    public $session;

    public $arrays;
    public $db;
    public $mail;
    public $auth;
    public $oauth;
    public $s3;
    public $jwt;

    public function __construct() {
        $this->WIN = strtoupper(substr(PHP_OS, 0, 3));

		$this->scope = new Scope();
        $this->lexer = new Lexer();
        $this->parser = new Parser($this);
        $this->request = new Request($this);
        $this->response = new Response($this);
        $this->session = new Session();

        $this->arrays = array();
        $this->db = array();
        $this->mail = array();
        $this->auth = array();
        $this->oauth = array();
        $this->s3 = array();
        $this->jwt = array();

        $globalsPath = BASE_URL . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, '../dmxConnect/globals.php');
        if (file_exists($globalsPath)) {
            include($globalsPath);
            $globals = json_decode($exports);
            if (isset($globals->data)) {
                $this->scope->set($globals->data);
            }
        }

        if (CONFIG('ENV')) {
            $env = json_decode(CONFIG('ENV'), TRUE);

            foreach ($env as $name => $value) {
                if (!isset($_ENV[$name])) {
                    $_ENV[$name] = $value;
                }
            }
        }

        $this->scope->set(array(
            '$_ERROR' => NULL,
            '$_SERVER' => $this->request->server,
            '$_ENV' => $_ENV,
            '$_GET' => $this->request->get,
            '$_POST' => $this->request->post,
            '$_HEADER' => $this->request->headers,
            '$_COOKIE' => $this->request->cookies,
            '$_SESSION' => $this->session
        ));
    }

    public function set($key, $value = NULL) {
        $this->scope->global->set($key, $value);
    }

    public function get($key, $defaultValue = NULL) {
        $value = $this->scope->global->get($key);
        return $value !== NULL ? $value : $defaultValue;
    }

    public function define($cfg) {
        if (is_string($cfg) && !preg_match('/^[\w\/]+$/', $cfg)) {
            $cfg = json_decode($cfg);

            if ($cfg === NULL) {
                Throw new \Exception('Error parsing the JSON in define');
            }
        }

        if (isset($cfg->settings)) $this->settings($cfg->settings);
        if (isset($cfg->meta)) $this->meta($cfg->meta);
        if (isset($cfg->vars)) $this->set($cfg->vars);
        $path = realpath($this->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules'));
        if (file_exists($path . DIRECTORY_SEPARATOR . 'global.php')) {
            require(FileSystem::encode($path . DIRECTORY_SEPARATOR . 'global.php'));
            $this->exec(json_decode($exports), TRUE);
        }
        $this->exec($cfg, defined('TEMPLATE'));
    }

    protected function settings($settings) {
        $checkCsrfToken = TRUE;

        if (isset($settings->options)) {
            if (isset($settings->options->scriptTimeout)) {
                set_time_limit((int)$settings->options->scriptTimeout);
            }

            if (isset($settings->options->method)) {
                if ($_SERVER['REQUEST_METHOD'] != strtoupper($settings->options->method)) {
                    header('Status: 405 Method Not Allowed');
                    exit('Method Not Allowed');
                }
            }

            if (isset($settings->options->nocsrf)) {
                $checkCsrfToken = !$settings->options->nocsrf;
            }
        }

        if ($checkCsrfToken) {
            checkCsrfToken();
        }
    }

    protected function meta($meta) {
        if (class_exists('\\lib\\validator\\Validator')) {
            $validator = \lib\validator\Validator::getInstance($this);
            $validator->parseMeta($meta);
        }

        $this->meta = $meta;
    }

    public function exec($actions, $internal = FALSE) {
        if (isset($actions->exec)) {
            return $this->exec($actions->exec, $internal);
        }

        if (is_string($actions) && !preg_match('/^[\w\/]+$/', $actions)) {
            $actions = json_decode($actions);

            if ($actions === NULL) {
                Throw new \Exception('Error parsing the JSON in exec');
            }
        }

        $this->execSteps(isset($actions->steps) ? $actions->steps : $actions);

        if ($this->error !== FALSE) {
            if (isset($actions->catch)) {
                $this->scope->set('$_ERROR', $this->error->getMessage());
                $this->error = FALSE;
                $this->execSteps($actions->catch);
            } else {
                throw $this->error;
            }
        }

        if (!$internal) {
            $this->response->json($this->data);
        }
    }

    private function execSteps($steps) {
        if (is_string($steps)) {
            if (!preg_match("/\.php/", $steps)) {
                $steps .= ".php";
            }

			$path = realpath($this->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules'));
            require(FileSystem::encode($path . DIRECTORY_SEPARATOR . $steps));
            $steps = json_decode($exports);
            $this->exec($steps, TRUE);
            return;
        }

        if (is_array($steps)) {
            foreach ($steps as $step) {
                $this->execSteps($step);
                if ($this->error !== FALSE) return;
            }
        }

        if (isset($steps->disabled)) {
            if ($steps->disabled) return;
        }

        if (is_callable($steps)) {
            try {
                $steps();
            } catch(\Exception $err) {
                $this->error = $err;
                return;
            }
        }

        if (isset($steps->module) && isset($steps->action)) {
            if (!isset($this->modules[$steps->module])) {
                $className = '\\modules\\' . $steps->module;
                $this->modules[$steps->module] = new $className($this);
            }

            $module = $this->modules[$steps->module];

			try {
                if (method_exists($module, $steps->action)) {
				    $data = $module->{$steps->action}(isset($steps->options) ? clone $steps->options : NULL, isset($steps->name) ? $steps->name : NULL, isset($steps->meta) ? $steps->meta : NULL);
                } elseif (method_exists($module, '_'.$steps->action)) {
                    $data = $module->{'_'.$steps->action}(isset($steps->options) ? clone $steps->options : NULL, isset($steps->name) ? $steps->name : NULL, isset($steps->meta) ? $steps->meta : NULL);
                } else {
                    throw new \Exception("Action $steps->action doesn't exist in $module", 1);
                }
			} catch (\Exception $err) {
				$this->error = $err;
				return;
			}

			if (isset($steps->name) && (isset($data) || is_null($data))) {
				$this->scope->set($steps->name, $data);

				if (isset($steps->output) && $steps->output === TRUE) {
					$this->data[$steps->name] = $data;
				}
			}
        }
    }

	public function parse($value, Scope $scope = NULL, $stripNull = FALSE) {
		return $this->parseObject($value, $scope, $stripNull);
	}

    public function parseObject($value, Scope $scope = NULL, $stripNull = FALSE) {
        if ($value === NULL) {
            return NULL;
        }

        if (is_object($value)) {
            $value = clone $value;
            foreach ($value as $key => $val) {
                $value->$key = $this->parseObject($val, $scope);
                if ($stripNull && is_null($value->$key)) {
                    unset($value->$key);
                }
            }
        }

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->parseObject($val, $scope);
                if ($stripNull && is_null($value[$key])) {
                    unset($value[$key]);
                }
            }
        }

        if (is_string($value)) {
            if (substr($value, 0, 2) == '{{' && substr($value, -2) == '}}') {
                $expression = substr($value, 2, -2);

                if (strpos($expression, '{{') === FALSE) {
                    return $this->parser->parse($expression, $scope);
                }
            }

            return $this->parseTemplate($value, $scope);
        }

        return $value;
    }

    public function parseTemplate($value, Scope $scope = NULL) {
        if (strpos($value, '{{') === FALSE) {
            return $value;
        }

        $self = $this;

        return preg_replace_callback('/\{\{(.*?)\}\}/', function($matches) use ($self, $scope) {
            $value = $self->parser->parse($matches[1], $scope);

            if ($value === NULL) {
                return '';
            }

            if (!is_string($value)) {
                return json_encode($value);
            }

            return $value;
        }, $value);
    }
}

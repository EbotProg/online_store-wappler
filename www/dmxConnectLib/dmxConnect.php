<?php
define('BASE_URL', __DIR__);

// default config
$CONFIG_DEBUG = FALSE;
$CONFIG_TEMP_FOLDER = sys_get_temp_dir();
$CONFIG_CORS_ORIGIN = FALSE;
$CONFIG_CORS_METHODS = 'GET,POST';
$CONFIG_CORS_ALLOWED_HEADERS = '';
$CONFIG_CORS_CREDENTIALS = TRUE;
$CONFIG_CSRF_ENABLED = FALSE;
$CONFIG_CSRF_EXCLUDE = 'GET,HEAD,OPTIONS';
$CONFIG_ENV = FALSE;

$configPath = BASE_URL . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, '../dmxConnect/config.php');
if (file_exists($configPath)) {
	include_once($configPath);
}

function CONFIG($prop) {
	global ${'CONFIG_' . $prop};
	$val = ${'CONFIG_' . $prop};
	return $val;
}

if (!CONFIG('DEBUG')) {
	$errorlevel = error_reporting();
	error_reporting($errorlevel & ~(E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED));
}

$composer_path = BASE_URL . '/../vendor/autoload.php';
if (is_readable($composer_path)) {
	require $composer_path;
}

function fatal_handler() {
	$error = error_get_last();

	if ($error !== NULL && $error['type'] == 1) {
		//ob_clean();

		$phpSapiName = substr(php_sapi_name(), 0, 3);
        if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
            header('Status: 500 Internal Server Error');
        } else {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
            header($protocol . ' 500 Internal Server Error');
        }

		if (CONFIG('DEBUG')) {
			header('Content-Type: Application/json; charset=utf-8');
			exit(json_encode(array(
				'code'    => $error["type"],
				'file'    => $error["file"],
				'line'    => $error["line"],
				'message' => $error["message"]
			)));
		} else {
			exit('A server error occured, to see the error enable the DEBUG flag.');
		}
	}
}

register_shutdown_function('fatal_handler');

function exception_error_handler($errno, $errstr, $errfile, $errline) {
	if (error_reporting() == 0) {
		return;
	}

	throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('exception_error_handler');

function exception_handler($exception) {
	if (error_reporting() == 0) {
		return;
	}

	$phpSapiName = substr(php_sapi_name(), 0, 3);
	if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
		header('Status: 500 Internal Server Error');
	} else {
		$protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
		header($protocol . ' 500 Internal Server Error');
	}

	if (CONFIG('DEBUG')) {
		header('Content-Type: Application/json; charset=utf-8');
		exit(json_encode(array(
			'code'    => $exception->getCode(),
			'file'    => $exception->getFile(),
			'line'    => $exception->getLine(),
			'message' => $exception->getMessage(),
			'trace'   => $exception->getTraceAsString()
		)));
	} else {
		exit('A server error occured, to see the error enable the DEBUG flag.');
	}
}

set_exception_handler('exception_handler');
spl_autoload_register(function($class) {
	$path = BASE_URL . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'server_connect' . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';

	if (file_exists($path) === FALSE || is_readable($path) === FALSE) {
		$path = BASE_URL . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';
	}

	if (file_exists($path) === FALSE || is_readable($path) === FALSE) {
		return FALSE;
	}

	require($path);
});

require(__DIR__ . '/portable-utf8.php');
require(__DIR__ . '/templateFunctions.php');

function option_require($options, $option) {
	if (is_array($option)) {
		foreach ($option as $o) {
			option_require($options, $o);
		}
		return;
	}

	if (isset($options->$option)) {
		return;
	}

	throw new \Exception('Option "' . $option . '" is required!');
}

function option_default(&$options, $option, $value) {
	if (is_array($option)) {
		foreach ($option as $o => $v) {
			option_default($options, $o, $v);
		}
		return;
	}

	if (!isset($options->$option)) {
		$options->$option = $value;
	}
}

function checkCsrfToken() {
	if (CONFIG('CSRF_ENABLED') !== TRUE) {
		return;
	}

	$exclude = explode(',', CONFIG('CSRF_EXCLUDE'));
	if (in_array($_SERVER['REQUEST_METHOD'], $exclude)) {
		return;
	}

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?: $_POST['_csrf'];

	if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
		header('Status: 403 Forbidden');
		exit('Invalid CSRF token');
	}
}

//checkCsrfToken();

if (CONFIG('CORS_ORIGIN') !== FALSE) {
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		$origin = CONFIG('CORS_ORIGIN') ?: '*';
		$methods = CONFIG('CORS_METHODS');
		$allowedHeaders = CONFIG('CORS_ALLOWED_HEADERS') ?: $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			if ($origin == '*') {
				$origin = $_SERVER['HTTP_ORIGIN'];
			}

			$allowedOrigins = explode(',', $origin);
			if (count($allowedOrigins) > 1) {
				$origin = FALSE;
				foreach ($allowedOrigins as $allowedOrigin) {
					if ($allowedOrigin == $_SERVER['HTTP_ORIGIN']) {
						$origin = $allowedOrigin;
						break;
					}
				}
			}
		}
		
		header("HTTP/1.1 204 NO CONTENT");
		if ($origin) {
			header("Access-Control-Allow-Origin: $origin");
			header("Vary: Origin");
		}
		header("Access-Control-Allow-Methods: $methods");
		if (CONFIG('CORS_CREDENTIALS') === TRUE) {
			header("Access-Control-Allow-Credentials: true");
		}
		header("Access-Control-Allow-Headers: $allowedHeaders");

		exit();
	} else {
		$origin = CONFIG('CORS_ORIGIN') ?: '*';

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			if ($origin == '*') {
				$origin = $_SERVER['HTTP_ORIGIN'];
			}

			$allowedOrigins = explode(',', $origin);
			if (count($allowedOrigins) > 1) {
				$origin = FALSE;
				foreach ($allowedOrigins as $allowedOrigin) {
					if ($allowedOrigin == $_SERVER['HTTP_ORIGIN']) {
						$origin = $allowedOrigin;
						break;
					}
				}
			}
		}

		try {
			if (!empty($_SERVER['HTTPS'])) {
				if (version_compare(PHP_VERSION, '7.3.0', '<')) {
					session_set_cookie_params(0, '/; samesite=None', $_SERVER['HTTP_HOST'], TRUE, TRUE);
				} else {
					session_set_cookie_params([
						'samesite' => 'None',
						'httponly' => TRUE,
						'secure' => TRUE
					]);
				}
			}
		} catch (\Exception $e) {
			// ignore
		}
		
		if ($origin) {
			header("Access-Control-Allow-Origin: $origin");
			header("Vary: Origin");
		}
		if (CONFIG('CORS_CREDENTIALS') === TRUE) {
			header("Access-Control-Allow-Credentials: true");
		}
	}
}
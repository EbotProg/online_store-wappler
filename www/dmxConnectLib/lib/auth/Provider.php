<?php

namespace lib\auth;

use \lib\App;
use \lib\core\FileSystem;

class Provider
{
	protected $app;
	protected $cfg;
	protected $provider;
	public $identity = FALSE;

	protected $key;

	public static function get(App $app, $name) {
		if (isset($app->auth[$name])) {
			return $app->auth[$name];
		}

		$path = realpath($app->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules/SecurityProviders/' . $name . '.php'));
		if (FileSystem::exists($path)) {
			require(FileSystem::encode($path));
			$data = json_decode($exports);
            return new Provider($app, $data->options, $name);
		}
		
		throw new \Exception('Security provider "' . $name . '" not found.');
	}

	public function __construct(App $app, $cfg, $name = NULL) {
		$this->app = $app;

		$cfg = $this->app->parseObject($cfg);

		if (!isset($cfg->provider)) {
	      throw new \Exception('Security provider is Required');
	    }

		if (!isset($cfg->secret)) {
	      throw new \Exception('A secret is Required');
	    }

		if (empty($name) || $name == 'dmxSiteSecurity') {
			$name = 'dmxSecurity';
		}

		if (!isset($cfg->path)) {
			$cfg->path = '/';
		}

		if (!isset($cfg->expires)) {
			$cfg->expires = 30;
		}

		if (!isset($cfg->basicAuth)) {
			$cfg->basicAuth = FALSE;
		}

		if (!isset($cfg->basicRealm)) {
			$cfg->basicRealm = '';
		}

		if (!isset($cfg->passwordVerify)) {
			$cfg->passwordVerify = FALSE;
		}

		$cfg->httpOnly = TRUE;
		$cfg->name = $name;

		$providerClass = '\\lib\\auth\\' . ucfirst($cfg->provider) . 'Provider';

		$this->cfg = $cfg;
		$this->provider = new $providerClass($this->app, $cfg);
		$this->identity = $this->app->session->get($this->cfg->name . 'Id');

		$this->key = hash('sha256', $cfg->secret, TRUE);

		if ($cfg->basicAuth && isset($_SERVER['PHP_AUTH_USER'])) {
			$this->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], FALSE, TRUE);
		}

		if (!$this->identity && isset($this->app->request->cookies[$cfg->name])) {
			$credentials = $this->readCookie();
			if (is_array($credentials) && count($credentials) == 2) {
				$this->login($credentials[0], $credentials[1], TRUE, TRUE);
			}
		}

		$this->app->auth[$name] = $this;
	}

	public function setIdentity($identity = FALSE) {
		$this->identity = $identity;
		
		if ($identity) {
			$this->app->session->set($this->cfg->name . 'Id', $identity);
		} else {
			$this->app->session->remove($this->cfg->name . 'Id');
			$this->app->response->clearCookie($this->cfg->name, $this->cfg);
		}
        
		$this->app->session->regenerate();
	}

	public function readCookie() {
		if (!isset($this->app->request->cookies[$this->cfg->name])) {
			return FALSE;
		}

		try {
			$data = base64_decode($this->app->request->cookies[$this->cfg->name]);

			if ($data === FALSE) {
				return FALSE;
			}

			$iv = substr($data, 0, 16);
			$decrypted = openssl_decrypt(substr($data, 16), 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);

			if ($decrypted === FALSE) {
				return FALSE;
			}

			return explode($iv, str_replace("\0", '', $decrypted));
		} catch(\Exception $e) {
			return FALSE;
		}
	}

	public function writeCookie($username, $password) {
		$iv = openssl_random_pseudo_bytes(16);
		$data = base64_encode($iv . openssl_encrypt(implode($iv, array($username, $password)), 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv));

		$this->app->response->setCookie($this->cfg->name, $data, $this->cfg);
	}

	public function login($username, $password, $remember = FALSE, $autologin = FALSE) {
		$identity = $this->provider->validate($username, $password, $this->cfg->passwordVerify);

		if (!$autologin && !$identity) {
			if ($this->cfg->basicRealm) {
				$this->app->response->addHeader('WWW-Authenticate', 'Basic realm="' . $this->cfg->basicRealm . '"');
			}
			$this->app->response->end(401);
		}

		$this->setIdentity($identity);

		if ($identity && $remember) {
			$this->writeCookie($username, $password);
		}

		return $this->identity;
	}

	public function logout() {
		$this->setIdentity();
	}

	public function restrict($opts) {
		if (!$this->identity) {
			if (isset($opts->loginUrl) && !empty($opts->loginUrl)) {
				header('Cache-Control: no-store');
				header('Location: ' . $opts->loginUrl);
				die();
			} else {
				if ($this->cfg->basicRealm) {
					$this->app->response->addHeader('WWW-Authenticate', 'Basic realm="' . $this->cfg->basicRealm . '"');
				}
				$this->app->response->end(401);
			}
		}

		if (isset($opts->permissions) && !empty($opts->permissions)) {
			$opts->permissions = is_array($opts->permissions) ? $opts->permissions : array($opts->permissions);
			if (!$this->provider->permissions($this->identity, $opts->permissions)) {
				if (isset($opts->forbiddenUrl) && !empty($opts->forbiddenUrl)) {
					header('Cache-Control: no-store');
					header('Location: ' . $opts->forbiddenUrl);
					die();
				} else {
					$this->app->response->end(403);
				}
			}
		}
	}
}

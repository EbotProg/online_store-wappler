<?php

namespace lib\oauth;

use \lib\App;
use \lib\core\FileSystem;
use \lib\jwt\Jwt;

class Oauth2
{
    protected $app;
    protected $name;
    protected $options;
    
    public $access_token = NULL;
    public $refresh_token = NULL;
    
    public static function get(App $app, $name) {
		if (isset($app->oauth[$name])) {
			return $app->oauth[$name];
		}

		$path = realpath($app->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules/oauth/' . $name . '.php'));
		if (FileSystem::exists($path)) {
			require(FileSystem::encode($path));
			$data = json_decode($exports);
            return new Oauth2($app, $app->parseObject($data->options), $name);
		}
		
		throw new \Exception('OAuth2 provider "' . $name . '" not found.');
	}

    public function __construct(App $app, $options, $name = '') {
        option_default($options, 'service', NULL);
        option_default($options, 'client_id', NULL);
        option_default($options, 'client_secret', NULL);
        option_default($options, 'token_endpoint', NULL);
        option_default($options, 'auth_endpoint', NULL);
        option_default($options, 'scope_separator', ' ');
        option_default($options, 'access_token', NULL);
        option_default($options, 'refresh_token', NULL);
        option_default($options, 'jwt_bearer', FALSE);
        option_default($options, 'client_credentials', FALSE);
        option_default($options, 'verifySSL', TRUE);
        option_default($options, 'params', (object)array());

                /*
            google (https://developers.google.com/identity/protocols/OAuth2WebServer#creatingclient)
              * include_granted_scopes
              * login_hint
              * prompt
            facebook (https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow)
              * display=popup
              * auth_type=rerequest
            linkedin (https://developer.linkedin.com/docs/oauth2)
            github (https://github.com/jaredhanson/passport-github)
            instagram (https://github.com/jaredhanson/passport-instagram)
            amazon (https://github.com/jaredhanson/passport-amazon)
            dropbox (https://github.com/florianheinemann/passport-dropbox-oauth2)
            foursquare (https://github.com/jaredhanson/passport-foursquare)
            imgur (https://github.com/mindfreakthemon/passport-imgur)
            wordpress (https://github.com/mjpearson/passport-wordpress)
            spotify (https://developer.spotify.com/documentation/general/guides/authorization-guide/)
            slack (https://api.slack.com/docs/sign-in-with-slack#identify_users_and_their_teams)
            reddit (https://github.com/Slotos/passport-reddit)
            twitch (https://github.com/Schmoopiie/passport-twitch)
            paypal (https://github.com/jaredhanson/passport-paypal-oauth)
            pinterest (https://github.com/analog-nico/passport-pinterest)
            stripe (https://github.com/mathisonian/passport-stripe)
            coinbase (https://github.com/digitaltangibletrust/passport-coinbase)
        */

        switch ($options->service) {
            case 'google':
                $options->auth_endpoint = 'https://accounts.google.com/o/oauth2/v2/auth';
                $options->token_endpoint = 'https://www.googleapis.com/oauth2/v4/token';
                $options->params->access_type = 'offline';
            break;

            case 'facebook':
                $options->auth_endpoint = 'https://www.facebook.com/v3.2/dialog/oauth';
                $options->token_endpoint = 'https://graph.facebook.com/v3.2/oauth/access_token';
            break;

            case 'linkedin':
                $options->auth_endpoint = 'https://www.linkedin.com/oauth/v2/authorization';
                $options->token_endpoint = 'https://www.linkedin.com/oauth/v2/accessToken';
            break;

            case 'github':
                $options->auth_endpoint = 'https://github.com/login/oauth/authorize';
                $options->token_endpoint = 'https://github.com/login/oauth/access_token';
            break;

            case 'instagram':
                $options->auth_endpoint = 'https://api.instagram.com/oauth/authorize/';
                $options->token_endpoint = 'https://api.instagram.com/oauth/access_token';
            break;

            case 'amazon':
                $options->auth_endpoint = 'https://www.amazon.com/ap/oa';
                $options->token_endpoint = 'https://api.amazon.com/auth/o2/token';
            break;

            case 'dropbox':
                $options->auth_endpoint = 'https://www.dropbox.com/oauth2/authorize';
                $options->token_endpoint = 'https://api.dropbox.com/oauth2/token';
                $options->scope_separator = ',';
            break;

            case 'foursquare':
                $options->auth_endpoint = 'https://foursquare.com/oauth2/authenticate';
                $options->token_endpoint = 'https://foursquare.com/oauth2/access_token';
            break;

            case 'imgur':
                $options->auth_endpoint = 'https://api.imgur.com/oauth2/authorize';
                $options->token_endpoint = 'https://api.imgur.com/oauth2/token';
            break;

            case 'wordpress':
                $options->auth_endpoint = 'https://public-api.wordpress.com/oauth2/authorize';
                $options->token_endpoint = 'https://public-api.wordpress.com/oauth2/token';
            break;

            case 'spotify':
                $options->auth_endpoint = 'https://accounts.spotify.com/authorize';
                $options->token_endpoint = 'https://accounts.spotify.com/api/token';
            break;

            case 'slack':
                $options->auth_endpoint = 'https://slack.com/oauth/authorize';
                $options->token_endpoint = 'https://slack.com/api/oauth.access';
            break;

            case 'reddit':
                $options->auth_endpoint = 'https://ssl.reddit.com/api/v1/authorize';
                $options->token_endpoint = 'https://ssl.reddit.com/api/v1/access_token';
                $options->scope_separator = ',';
            break;

            case 'twitch':
                $options->auth_endpoint = 'https://api.twitch.tv/kraken/oauth2/authorize';
                $options->token_endpoint = 'https://api.twitch.tv/kraken/oauth2/token';
            break;

            case 'paypal':
                $options->auth_endpoint = 'https://identity.x.com/xidentity/resources/authorize';
                $options->token_endpoint = 'https://identity.x.com/xidentity/oauthtokenservice';
            break;

            case 'pinterest':
                $options->auth_endpoint = 'https://api.pinterest.com/oauth/';
                $options->token_endpoint = 'https://api.pinterest.com/v1/oauth/token';
                $options->scope_separator = ',';
            break;

            case 'stripe':
                $options->auth_endpoint = 'https://connect.stripe.com/oauth/authorize';
                $options->token_endpoint = 'https://connect.stripe.com/oauth/token';
                $options->scope_separator = ',';
            break;

            case 'coinbase':
                $options->auth_endpoint = 'https://www.coinbase.com/oauth/authorize';
                $options->token_endpoint = 'https://www.coinbase.com/oauth/token';
            break;
        }

        if ($options->jwt_bearer) {
            $options->jwt_bearer = Jwt::get($app, $options->jwt_bearer);
        }

        $this->app = $app;
        $this->name = $name;
        $this->options = $options;

        $this->access_token = $options->access_token;
        $this->refresh_token = $options->refresh_token;

        if (is_null($this->access_token)) {
            $this->access_token = $this->getSession('access_token');
        }

        if (is_null($this->refresh_token)) {
            $this->refresh_token = $this->getSession('refresh_token');
        }

        if (!is_null($this->access_token)) {
            $expires = $this->getSession('expires');

            if (!is_null($expires) && $expires - time() < 10) {
                $this->access_token = NULL;
                $this->removeSession('access_token');
                $this->removeSession('expires');

                if (!is_null($this->refresh_token)) {
                    $this->refreshToken($this->refresh_token);
                }
            }
        }

        if ($options->jwt_bearer && is_null($this->access_token)) {
            $response = $this->grant('urn:ietf:params:oauth:grant-type:jwt-bearer', array(
                'assertion' => $options->jwt_bearer
            ));
            $this->access_token = $response->access_token;
        }

        if ($options->client_credentials && is_null($this->access_token)) {
            $response = $this->grant('client_credentials');
            $this->access_token = $response->access_token;
        }

        $this->app->oauth[$name] = $this;
    }

    public function authorize($scopes = array(), $params = array()) {
        $state = $this->getQuery('state');

        if (!is_array($scopes)) $scopes = array();

        if ($state && $state == $this->getSession('state')) {
            $this->removeSession('state');

            if ($this->getQuery('error')) {
                throw new \Exception($this->getQuery('error_message', $this->getQuery('error')));
            }

            if ($this->getQuery('code')) {
                return $this->grant('authorization_code', array(
                    'redirect_uri' => isset(((array)$this->options->params)['redirect_uri']) ? ((array)$this->options->params)['redirect_uri'] : $this->getRedirectUri(),
                    'code' => $this->getQuery('code')
                ));
            }
        }

        $params = array_merge(array(
            'response_type' => 'code',
            'client_id' => $this->options->client_id,
            'scope' => implode($this->options->scope_separator, $scopes),
            'redirect_uri' => $this->getRedirectUri(),
            'state' => $this->generateState()
        ), (array)$this->options->params, (array)$params);

        $this->setSession('state', $params['state']);

        $this->redirect($this->buildUri($this->options->auth_endpoint, $params));
    }

    public function refreshToken($refresh_token) {
        return $this->grant('refresh_token', array(
            'refresh_token' => $refresh_token
        ));
    }

    protected function grant($type, $params = array()) {
        $response = $this->httpPost($this->options->token_endpoint, array_merge(array(
            'grant_type' => $type,
            'client_id' => $this->options->client_id,
            'client_secret' => $this->options->client_secret
        ), $params));

        if (isset($response->error)) {
            throw new \Exception(isset($response->error_description) ? $response->error_description : $response->error);
        }

        if (!isset($response->access_token)) {
            throw new \Exception('Http response has no access_token.');
        }

        $this->setSession('access_token', $response->access_token);
        $this->access_token = $response->access_token;

        if (isset($response->expires_in)) {
            $this->setSession('expires', time() + $response->expires_in);
        }

        if (isset($response->refresh_token)) {
            $this->setSession('refresh_token', $response->refresh_token);
            $this->refresh_token = $response->refresh_token;
        }

        return $response;
    }

    protected function generateState() {
        $state = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);

        $this->setSession('state', $state);

        return $state;
    }

    protected function buildUri($endpoint, $params) {
        $uri = $endpoint;
        $uri .= strpos($uri, '?') === FALSE ? '?' : '&';
        $uri .= http_build_query($params, PHP_QUERY_RFC3986);

        return $uri;
    }

    protected function getRedirectUri() {
        $https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
        $port = $_SERVER['SERVER_PORT'];

        $url = 'http';
        $url .= $https ? 's' : '';
        $url .= '://';
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $url .= $_SERVER['HTTP_X_FORWARDED_HOST'];
        } else {
            $url .= $_SERVER['SERVER_NAME'];
            $url .= isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || ($https && $port == '443') || (!$https && $port == '80') ? '' : ':' . $port;
        }
        $url .= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        return $url;
    }

    protected function getQuery($key, $default = NULL) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    protected function setSession($name, $value) {
        $this->app->session->set($this->name . '_' . $name, $value);
    }

    protected function getSession($name) {
        return $this->app->session->get($this->name . '_' . $name);
    }

    protected function removeSession($name) {
        $this->app->session->remove($this->name . '_' . $name);
    }

    protected function redirect($url) {
        header('Cache-Control: no-store');
        header("Location: {$url}");
        exit();
    }

    protected function httpPost($url, $data) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->options->verifySSL);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        if ($error) {
            throw new \Exception($error);
        }

        // strip any utf8 BOM
        if (substr($response, 0, 3) == pack('CCC', 239, 187, 191)) {
            $response = substr($response, 3);
        }

        $output = json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg() . ' - (' . $info['http_code'] . ') ' . $response);
        }

        return $output;
    }
}

<?php

// Social Logins (https://github.com/26medias/social-login/blob/master/social-login.js)
// Passport packages (http://www.passportjs.org/packages/)

namespace modules;

use \lib\core\Module;
use \lib\oauth\Oauth2;

class oauth extends Module
{
    public function provider($options, $name) {
        return new Oauth2($this->app, $this->app->parseObject($options), $name);
    }

    public function authorize($options) {
        option_require($options, 'provider');
        option_default($options, 'scopes', NULL);
        option_default($options, 'params', (object)array());

        $provider = Oauth2::get($this->app, $options->provider);

        return $provider->authorize($this->app->parseObject($options->scopes), $this->app->parseObject($options->params));
    }

    public function refreshToken($options) {
        option_require($options, 'provider');
        option_default($options, 'refresh_token', NULL);

        $provider = Oauth2::get($this->app, $options->provider);

        return $provider->refreshToken($this->app->parseObject($options->refresh_token));
    }
}

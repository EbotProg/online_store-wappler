<?php

namespace modules;

use \lib\core\Module;

class jwt extends Module
{
/*
        $options
        {
            "alg": "String", // algorithm for signing (HS256, HS384, HS512, RS256, RS384, RS512)
            "key": "String", // key for signing
            "iss": "String", // issuer
            "sub": "String", // subject
            "aud": "String", // audience
            "jti": "String", // token id
            "iat": "Number", // time that the token was issued
            "nbf": "Number", // time before which the token cannot be accepted
            "exp": "Number", // expiration time
            "headers": "Object", // header items
            "claims": "Object" // claim items
        }
    */
    public function sign($options, $name) {
        option_require($options, 'alg');
        option_require($options, 'key');
        option_default($options, 'expiresIn', 3600);

        $options = $this->app->parseObject($options);

        $time = time();

        $header = array(
            'alg' => $options->alg,
            'typ' => 'JWT'
        );

        if (isset($options->headers)) {
            $header = array_merge($header, (array)$options->headers);
        }

        $payload = array(
            'iat' => $time,
            'nbf' => $time + 60,
            'exp' => $time + $options->expiresIn
        );

        if (isset($options->iss)) {
            $payload['iss'] = $options->iss;
        }

        if (isset($options->sub)) {
            $payload['sub'] = $options->sub;
        }

        if (isset($options->aud)) {
            $payload['aud'] = $options->aud;
        }

        if (isset($options->jti)) {
            $payload['jti'] = $options->jti;
        }

        if (isset($options->iat)) {
            $time = $options->iat;
        }
        
        if (isset($options->claims)) {
            foreach ($options->claims as $key => $value) {
                $payload[$key] = $value;
            }
        }

        $this->app->jwt[$name] = \lib\jwt\Jwt::sign(array(
            'header' => $header,
            'payload' => $payload,
            'alg' => $options->alg,
            'key' => $options->key
        ));

        return $this->app->jwt[$name];
    }

    public function decode($options) {
        option_require($options, 'token');

        $options = $this->app->parseObject($options);

        return \lib\jwt\Jwt::decode($options);
    }

    public function verify($options) {
        option_require($options, 'token');
        option_require($options, 'key');

        $options = $this->app->parseObject($options);

        $payload = NULL;

        try {
            $payload = \lib\jwt\Jwt::verify($options);
        } catch (\Exception $err) {
            // Invalid
        }

        return $payload;
    }
}

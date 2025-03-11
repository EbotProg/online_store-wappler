<?php

namespace modules;

use \lib\core\Module;

class crypto extends Module
{
  // supports argon2i, argon2id and bcrypt
  public function passwordHash($options) {
    option_require($options, 'password');
    option_default($options, 'algo', 'argon2i');

    $options = $this->app->parseObject($options);

    $algo = PASSWORD_DEFAULT;
    switch ($options->algo) {
      case 'argon2i':
        $algo = PASSWORD_ARGON2I;
        break;
      case 'argon2id':
        $algo = PASSWORD_ARGON2ID;
        break;
      case 'bcrypt':
        $algo = PASSWORD_BCRYPT;
        break;
    }

    return password_hash($options->password, $algo);
  }

  public function passwordVerify($options) {
    option_require($options, 'password');
    option_require($options, 'hash');

    $options = $this->app->parseObject($options);

    return password_verify($options->password, $options->hash);
  }

  public function passwordNeedsRehash($options) {
    option_require($options, 'hash');
    option_default($options, 'algo', 'argon2i');

    $options = $this->app->parseObject($options);

    $algo = PASSWORD_DEFAULT;
    switch ($options->algo) {
      case 'argon2i':
        $algo = PASSWORD_ARGON2I;
        break;
      case 'argon2id':
        $algo = PASSWORD_ARGON2ID;
        break;
      case 'bcrypt':
        $algo = PASSWORD_BCRYPT;
        break;
    }

    return password_needs_rehash($options->hash, $algo);
  }

  public function uuid($options) {
    $data = function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[7] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}
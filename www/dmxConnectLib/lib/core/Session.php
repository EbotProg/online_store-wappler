<?php

namespace lib\core;

class Session
{
    public function __construct() {
		if (PHP_SAPI != 'cli' && isset($_COOKIE[session_name()])) {
        	session_start();
            session_write_close();
		}
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }

    public function __get($name) {
        return $this->get($name);
    }

    public function __isset($name) {
        return $this->has($name);
    }

    public function __unset($name) {
        $this->remove($name);
    }

    public function items() {
        return $_SESSION;
    }

    public function regenerate() {
        session_start();
        $CookieInfo = session_get_cookie_params();
        if ((empty($CookieInfo['domain'])) && (empty($CookieInfo['secure']))) {
            setcookie(session_name(), '', time()-3600, $CookieInfo['path']);
        } elseif (empty($CookieInfo['secure'])) {
            setcookie(session_name(), '', time()-3600, $CookieInfo['path'], $CookieInfo['domain']);
        } else {
            setcookie(session_name(), '', time()-3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure']);
        }
        if (!empty($_SESSION)) {
            session_regenerate_id(TRUE);
        } else {
            session_destroy();
        }
        session_write_close();
    }

    public function keys() {
        return array_keys($_SESSION);
    }

    public function values() {
        return array_values($_SESSION);
    }

    public function has($name) {
        return isset($_SESSION[$name]);
    }

    public function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
    }

    public function set($name, $value) {
        session_start();
        $_SESSION[$name] = $value;
        session_write_close();
    }

    public function remove($name) {
        session_start();
        unset($_SESSION[$name]);
        session_write_close();
    }
}

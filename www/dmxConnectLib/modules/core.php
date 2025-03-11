<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Scope;
use \lib\core\FileSystem;

class core extends Module
{
    public function repeat($options) {
		option_require($options, 'repeat');
        option_default($options, 'outputFilter', 'include');
        option_default($options, 'outputFields', array());

        $repeater = $this->app->parseObject($options->repeat);

        if ($repeater === NULL) {
            return;
        }

        if (is_bool($repeater)) {
            $repeater = $repeater ? array(0) : array();
        }

        if (is_string($repeater)) {
            $repeater = str_split($repeater);
        }

        if (is_numeric($repeater)) {
            $repeater = range(0, $repeater - 1);
        }

        if (!(is_array($repeater) || is_object($repeater))) {
            throw new \Exception('Repeater data is not an array or object.');
        }

        $index = 0;
        $data = array();
        $appData = $this->app->data;

        foreach ($repeater as $key => $value) {
            $this->app->data = array();

            if (is_array($value) || is_object($value)) {
                foreach ($value as $k => $v) {
                    if ($options->outputFilter == 'exclude') {
                        if (!(isset($options->outputFields) && in_array($k, $options->outputFields))) {
                            $this->app->data[$k] = $v;
                        }
                    } else {
                        if (isset($options->outputFields) && in_array($k, $options->outputFields)) {
                            $this->app->data[$k] = $v;
                        }
                    }
                }
            }

            $scope = is_array($value) || is_object($value) ? (array)$value : array();
            //$scope['$repeat'] = $repeater;
            $scope['$key'] = $key;
            $scope['$name'] = $key;
            $scope['$value'] = $value;
            $scope['$index'] = $index;
            $scope['$number'] = $index + 1;
            $scope['$oddeven'] = $index % 2;

            $this->app->scope = new Scope($this->app->scope, $scope);
            $this->app->exec($options->exec, TRUE);
            if ($this->app->scope->parent === NULL) {
                throw new \Exception('Error.');
            }
            $this->app->scope = $this->app->scope->parent;

            $data[] = $this->app->data;

            $index++;
        }

        $this->app->data = $appData;

        return $data;
    }

    public function _while($options) {
        option_require($options, array('while', 'exec'));
        option_default($options, 'max', PHP_INT_MAX);

        $i = 0;
        while ($this->app->parseObject($options->while)) {
            $this->app->exec($options->exec, TRUE);
            if (++$i == $options->max) break;
        }
    }

    public function condition($options) {
		option_require($options, array('if', 'then'));

        if ($this->app->parseObject($options->if)) {
            $this->app->exec($options->then, TRUE);
        } elseif (isset($options->else)) {
            $this->app->exec($options->else, TRUE);
        }
    }

    public function conditions($options) {
        option_require($options, 'conditions');

        if (is_array($options->conditions)) {
            foreach ($options->conditions as $condition) {
                if ($this->app->parseObject($condition->when)) {
                    $this->app->exec($condition->then, TRUE);
                    return;
                }
            }
        }
    }

    public function select($options) {
        option_require($options, array('expression', 'cases'));

        if (is_array($options->cases)) {
            $expression = $this->app->parseObject($options->expression);

            foreach ($options->cases as $case) {
                if ($expression === $case->value) {
                    $this->app->exec($case->exec, TRUE);
                    return;
                }
            }
        }
    }

    public function setvalue($options) {
		option_require($options, 'value');

        $options = $this->app->parseObject($options);

        if (isset($options->key) && $options->key <> '') {
            $this->app->scope->global->set($options->key, $options->value);
        }

        return $options->value;
    }

    public function setsession($options, $name) {
        $value = $this->app->parseObject($options->value);

        $this->app->session->set($name, $value);
        $this->app->scope->global->set('$_SESSION', $this->app->session);
    }

    public function removesession($options, $name) {
        $this->app->session->remove($name);
        $this->app->scope->global->set('$_SESSION', $this->app->session);
    }

    public function setcookie($options, $name) {
        $options = $this->app->parseObject($options);
        $this->app->response->setCookie($name, $options->value, $options);
    }

    public function removecookie($options, $name) {
        $options = $this->app->parseObject($options);
        $this->app->response->clearCookie($name, $options);
    }

    public function response($options) {
		option_require($options, 'data');

        $options = $this->app->parseObject($options);

        if (!isset($options->status) || !is_int($options->status)) {
            $options->status = 200;
        }

        $this->app->response->end($options->status, $options->data);
    }

    public function end($options) {
        $this->app->response->json($this->app->data);
    }

    public function error($options) {
		option_require($options, 'message');

        //$this->app->response->error($options->message);
        throw new \Exception($options->message);
    }

    public function redirect($options) {
        option_require($options, 'url');
        option_default($options, 'status', 302);

        header('Cache-Control: no-store');
        header('Location: ' . $this->app->parseObject($options->url), TRUE, $options->status == 301 ? 301 : 302);
        exit();
    }

    public function trycatch($options) {
        option_require($options, 'try');

        try {
            $this->app->exec($options->try, TRUE);
        } catch(\Exception $error) {
            $this->app->scope->set('$_ERROR', $error->getMessage());
            $this->app->error = FALSE;
            if (isset($options->catch)) {
                $this->app->exec($options->catch, TRUE);
            }
        }
    }

    public function exec($options) {
        option_require($options, 'exec');

        $data = array();

        $path = realpath($this->app->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules/lib/' . $options->exec . '.php'));
		if (FileSystem::exists($path)) {
            $appData = $this->app->data;
            $this->app->data = array();
            $scope = array();
            $scope['$_PARAM'] = isset($options->params) ? $this->app->parseObject($options->params) : array();
            $this->app->scope = new Scope($this->app->scope, $scope);
			require(FileSystem::encode($path));
            $this->app->exec(json_decode($exports), TRUE);
            $data = $this->app->data;
            $this->app->scope = $this->app->scope->parent;
            $this->app->data = $appData;
		} else {
            throw new \Exception('There is no action called ' . $options->exec . ' found in the library.');
        }

        return $data;
    }

    public function group($options, $name) {
        option_require($options, 'exec');

        $data = array();

        if (!empty($name)) {
            $appData = $this->app->data;
            $this->app->data = array();
            $this->app->exec($options->exec, TRUE);
            $data = $this->app->data;
            $this->app->data = $appData;
        } else {
            $this->app->exec($options->exec, TRUE);
        }

        return $data;
    }

    public function randomUUID() {
        $data = function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[7] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
      }
      
}

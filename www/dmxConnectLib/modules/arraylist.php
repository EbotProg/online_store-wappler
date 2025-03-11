<?php

namespace modules;

use \lib\core\Module;

class arraylist extends Module
{
  public function create($options, $name) {
    option_default($options, 'value', array());

    $options = $this->app->parseObject($options);

    if (!isset($this->app->arrays)) {
      $this->app->arrays = array();
    }

    $this->app->arrays[$name] = is_array($options->value) ? $options->value : array();
  }

  public function value($options) {
    option_require($options, 'ref');

    $options = $this->app->parseObject($options);

    return $this->app->arrays[$options->ref];
  }

  public function size($options) {
    option_require($options, 'ref');

    $options = $this->app->parseObject($options);

    return count($this->app->arrays[$options->ref]);
  }

  public function get($options) {
    option_require($options, 'ref');
    option_require($options, 'index');

    $options = $this->app->parseObject($options);

    return $this->app->arrays[$options->ref][$options->index];
  }

  public function add($options) {
    option_require($options, 'ref');
    option_require($options, 'value');

    $options = $this->app->parseObject($options);

    $this->app->arrays[$options->ref][] = $options->value;
  }

  public function addAll($options) {
    option_require($options, 'ref');
    option_require($options, 'value');

    $options = $this->app->parseObject($options);

    foreach ($options->value as $value) {
      $this->app->arrays[$options->ref][] = $value;
    }
  }

  public function set($options) {
    option_require($options, 'ref');
    option_require($options, 'index');
    option_require($options, 'value');

    $options = $this->app->parseObject($options);

    $this->app->arrays[$options->ref][$options->index] = $options->value;
  }

  public function remove($options) {
    option_require($options, 'ref');
    option_require($options, 'value');

    $options = $this->app->parseObject($options);

    $index = array_search($options->value, $this->app->arrays[$options->ref]);

    if ($index === FALSE) {
      throw new \Exception('arraylist.remove: Value does not exist in the ArrayList.');
    }

    array_splice($this->app->arrays[$options->ref], $index, 1);
  }

  public function removeAt($options) {
    option_require($options, 'ref');
    option_require($options, 'index');

    $options = $this->app->parseObject($options);

    array_splice($this->app->arrays[$options->ref], $options->index, 1);
  }

  public function clear($options) {
    option_require($options, 'ref');

    $options = $this->app->parseObject($options);

    $this->app->arrays[$options->ref] = array();
  }

  public function sort($options) {
    option_require($options, 'ref');
    option_default($options, 'prop', '');
    option_default($options, 'desc', FALSE);

    $options = $this->app->parseObject($options);
    $prop = $options->prop;
    $desc = $options->desc;

    usort($this->app->arrays[$options->ref], function($a, $b) use ($prop, $desc) {
      if ($prop == '') {
        if ($a == $b) return 0;
        if ($a < $b) return $desc ? 1 : -1;
        return $desc ? -1 : 1;
      }
      if ($a->$prop == $b->$prop) return 0;
      if ($a->$prop < $b->$prop) return $desc ? 1 : -1;
      return $desc ? -1 : 1;
    });
  }

  public function indexOf($options) {
    option_require($options, 'ref');
    option_require($options, 'value');

    $options = $this->app->parseObject($options);

    $index = array_search($options->value, $this->app->arrays[$options->ref]);

    return $index !== FALSE ? $index : -1;
  }

  public function contains($options) {
    option_require($options, 'ref');
    option_require($options, 'value');

    $options = $this->app->parseObject($options);

    return in_array($options->value, $this->app->arrays[$options->ref]);
  }

  public function isEmpty($options) {
    option_require($options, 'ref');

    $options = $this->app->parseObject($options);

    return empty($this->app->arrays[$options->ref]);
  }
}
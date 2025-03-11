<?php

namespace modules;

use \lib\core\Module;
use \lib\db\Connection;
use \lib\db\SqlBuilder;

class dbconnector extends Module
{
    public function connect($options, $name) {
        return new Connection($this->app, $this->app->parseObject($options), $name);
    }

    public function select($options, $name, $meta) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');
        option_default($options->sql, 'sort', '{{$_GET.sort}}');
        option_default($options->sql, 'dir', '{{$_GET.dir}}');

        $options = $this->parseOptions($options);

        $options->sql->type = 'select';

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        if (!isset($options->sql->orders)) {
            $options->sql->orders = array();
        }

        if (isset($options->sql->sort)) {
          foreach ($options->sql->columns as $column) {
            if ($column->column == $options->sql->sort || (isset($column->alias) && $column->alias == $options->sql->sort)) {
              $order = (object)array(
                'isAlias' => isset($column->alias),
                'column' => isset($column->alias) ? $column->alias : $column->column,
                'direction' => isset($options->sql->dir) && strtoupper($options->sql->dir) == 'DESC' ? 'DESC' : 'ASC'
              );

              if (isset($column->table)) {
                  $order->table = $column->table;
              }

              array_unshift($options->sql->orders, $order);
              break;
            }
          }
        }

        if ($this->hasSubs($options->sql)) {
            $this->prepareColumns($options->sql);

            $sql = new SqlBuilder($this->app, $connection);
            $sql->fromJSON($options->sql);
            $sql->compile();

            $results = $connection->execute($sql->query, $sql->params);

            if (count($results)) {
                if (isset($options->sql->sub)) {
                    $this->processSubQueries($connection, $results, $options->sql->sub);
                }

                if (isset($options->sql->joins) && count($options->sql->joins)) {
                    foreach ($options->sql->joins as $join) {
                        if (isset($join->sub)) {
                            $prefix = isset($join->alias) ? $join->alias : $join->table;
                            $this->processSubQueries($connection, $results, $join->sub, '_' . $prefix);
                        }
                    }
                }

                $this->cleanupResults($results);
            }

            return $results;
        }

        $sql = new SqlBuilder($this->app, $connection);
        $sql->fromJSON($options->sql);
        $sql->compile();

		if (isset($options->test)) {
			return (object)array(
                'options' => $options,
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params, TRUE, '', $meta);
    }

    public function single($options, $name, $meta) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');

        $options = $this->parseOptions($options);

        $options->sql->type = 'select';

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        if ($this->hasSubs($options->sql)) {
            $this->prepareColumns($options->sql);

            $sql = new SqlBuilder($this->app, $connection);
            $sql->fromJSON($options->sql);
            $sql->compile();

            $results = $connection->execute($sql->query, $sql->params);

            if (count($results)) {
                if (isset($options->sql->sub)) {
                    $this->processSubQueries($connection, $results, $options->sql->sub);
                }

                if (isset($options->sql->joins) && count($options->sql->joins)) {
                    foreach ($options->sql->joins as $join) {
                        if (isset($join->sub)) {
                            $prefix = isset($join->alias) ? $join->alias : $join->table;
                            $this->processSubQueries($connection, $results, $join->sub, '_' . $prefix);
                        }
                    }
                }

                $this->cleanupResults($results);
            }

            return count($results) ? $results[0] : NULL;
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
        $sql->compile();

        if (isset($options->test)) {
            return (object)array(
                'options' => $options,
                'query' => $sql->query,
                'params' => $sql->params
            );
        }

        $results = $connection->execute($sql->query, $sql->params, TRUE, '', $meta);

        return count($results) ? $results[0] : NULL;
    }

    public function count($options) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');

        $options = $this->parseOptions($options);

        $options->sql->type = 'count';

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
        $sql->compile();

    		if (isset($options->test)) {
    			return (object)array(
                    'options' => $options,
    				'query' => $sql->query,
    				'params' => $sql->params
    			);
    		}

        $result = $connection->execute($sql->query, $sql->params);

        return $result[0]['Total'];
    }

    public function paged($options, $name, $meta) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');
        option_default($options->sql, 'offset', '{{$_GET.offset}}');
        option_default($options->sql, 'limit', '{{$_GET.limit}}');
        option_default($options->sql, 'sort', '{{$_GET.sort}}');
        option_default($options->sql, 'dir', '{{$_GET.dir}}');

        $options = $this->parseOptions($options);

        if (is_null($options->sql->offset)) $options->sql->offset = 0;
        if (is_null($options->sql->limit)) $options->sql->limit = 25;

        $connection = Connection::get($this->app, $options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        if (!isset($options->sql->orders)) {
            $options->sql->orders = array();
        }

        if (isset($options->sql->sort)) {
          foreach ($options->sql->columns as $column) {
            if ($column->column == $options->sql->sort || (isset($column->alias) && $column->alias == $options->sql->sort)) {
              $order = (object)array(
                'isAlias' => isset($column->alias),
                'column' => isset($column->alias) ? $column->alias : $column->column,
                'direction' => isset($options->sql->dir) && strtoupper($options->sql->dir) == 'DESC' ? 'DESC' : 'ASC'
              );

              if (isset($column->table)) {
                  $order->table = $column->table;
              }

              array_unshift($options->sql->orders, $order);
              break;
            }
          }
        }

        $sql = new SqlBuilder($this->app, $connection);

        $options->sql->type = 'count';
        $sql->fromJSON($options->sql);
        $sql->compile();
        $results = $connection->execute($sql->query, $sql->params);
        $total = 0;
        // Check if Total is available (prevent error)
        if (isset($results[0]['Total'])) {
          $total = $results[0]['Total'];
        }
        // Postgres converts column names to lowercase
        if (isset($results[0]['total'])) {
          $total = $results[0]['total'];
        }

        $options->sql->type = 'select';
        
        if ($this->hasSubs($options->sql)) {
            $this->prepareColumns($options->sql);

            $sql = new SqlBuilder($this->app, $connection);
            $sql->fromJSON($options->sql);
            $sql->compile();

            $results = $connection->execute($sql->query, $sql->params);

            if (count($results)) {
                if (isset($options->sql->sub)) {
                    $this->processSubQueries($connection, $results, $options->sql->sub);
                }

                if (isset($options->sql->joins) && count($options->sql->joins)) {
                    foreach ($options->sql->joins as $join) {
                        if (isset($join->sub)) {
                            $prefix = isset($join->alias) ? $join->alias : $join->table;
                            $this->processSubQueries($connection, $results, $join->sub, '_' . $prefix);
                        }
                    }
                }

                $this->cleanupResults($results);
            }
        } else {
            $sql->fromJSON($options->sql);
            $sql->compile();
            $results = $connection->execute($sql->query, $sql->params, TRUE, '', $meta);
        }

        return array(
            'offset' => intval($options->sql->offset),
            'limit' => intval($options->sql->limit),
            'total' => intval($total),
            'page' => array(
                'offset' => array(
                    'first' => 0,
                    'prev' => intval($options->sql->offset - $options->sql->limit > 0 ? $options->sql->offset - $options->sql->limit : 0),
                    'next' => intval($options->sql->offset + $options->sql->limit < $total ? $options->sql->offset + $options->sql->limit : $options->sql->offset),
                    'last' => (ceil($total / $options->sql->limit)-1) * $options->sql->limit
                ),
                'current' => floor($options->sql->offset / $options->sql->limit)+1,
                'total' => ceil($total / $options->sql->limit)
            ),
            'data' => $results
        );
    }

    protected function parseOptions($options) {
        $props = array('values', 'wheres', 'orders');

        foreach ($props as $prop) {
            if (isset($options->sql->{$prop}) && is_array($options->sql->{$prop})) {
                $options->sql->{$prop} = array_filter($options->sql->{$prop}, array($this, 'filter'));
            }
        }

        if (isset($options->sql->wheres) && isset($options->sql->wheres->rules)) {
            if (!empty($options->sql->wheres->conditional) && !$this->app->parseObject($options->sql->wheres->conditional)) {
                unset($options->sql->wheres);
            } else {
                $options->sql->wheres->rules = array_filter($options->sql->wheres->rules, array($this, 'filterRules'));

                if (empty($options->sql->wheres->rules)) {
                    unset($options->sql->wheres);
                }
            }
        }

        return $this->app->parseObject($options);
    }

    protected function filterRules($rule) {
        if (!isset($rule->rules)) return TRUE;
        if (!empty($rule->conditional) && !$this->app->parseObject($rule->conditional)) return FALSE;
        $rule->rules = array_filter($rule->rules, array($this, 'filterRules'));
        return !empty($rule->rules);
    }

	protected function filter($val) {
		if (!isset($val->condition)) return TRUE;
		return $this->app->parseObject($val->condition);
	}

    protected function arrayAny(array $array, callable $fn) {
        foreach ($array as $value) {
            if ($fn($value)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    protected function processSubQueries($connection, &$results, $sub, $prefix = '') {
        $lookup = array();
        $keys = array();

        foreach ($results as &$result) {
            $key = $result['__dmxPrimary' . $prefix];

            if (isset($lookup[$key])) {
                $lookup[$key][] = &$result;
            } else {
                $lookup[$key] = array(&$result);
            }

            $keys[] = $key;

            foreach ($sub as $field => $ast) {
                $result[$field] = array();
            }
        }

        foreach ($sub as $field => $ast) {
            $ast->type = 'select';

            $this->prepareColumns($ast);
            
            $sql = new SqlBuilder($this->app, $connection);
            $sql->fromJSON($ast);
            $sql->where($ast->key, 'in', array_values(array_unique($keys)));
            $sql->compile();

            $subResults = $connection->execute($sql->query, $sql->params);

            if (count($subResults)) {
                if (isset($ast->sub)) {
                    $this->processSubQueries($connection, $subResults, $ast->sub);
                }

                if (isset($ast->joins) && count($ast->joins)) {
                    foreach ($ast->joins as $join) {
                        if (isset($join->sub)) {
                            $prefix = isset($join->alias) ? $join->alias : $join->table;
                            $this->processSubQueries($connection, $subResults, $join->sub, '_' . $prefix);
                        }
                    }
                }

                foreach ($subResults as &$subResult) {
                    $results = &$lookup[$subResult['__dmxForeign']];

                    foreach ($results as &$result) {
                        $result[$field][] = &$subResult;
                    }
                }
            }
        }
    }

    protected function hasSubs($ast) {
        if (isset($ast->sub)) return TRUE;

        if (isset($ast->joins) && count($ast->joins)) {
            foreach ($ast->joins as $join) {
                if (isset($join->sub)) return TRUE;
            }
        }

        return FALSE;
    }

    protected function prepareColumns(&$sql) {
        $table = isset($sql->table->alias) ? $sql->table->alias : (isset($sql->table->name) ? $sql->table->name : $sql->table);

        if (!isset($sql->columns) || !count($sql->columns)) {
            $sql->columns = array((object)array(
                'table' => $table,
                'column' => '*'
            ));

            if (isset($sql->joins) && count($sql->joins)) {
                foreach ($sql->joins as $join) {
                    $sql->columns[] = (object)array(
                        'table' => isset($join->alias) ? $join->alias : $join->table,
                        'column' => '*'
                    );
                }
            }
        }

        if (isset($sql->primary)) {
            $sql->columns[] = (object)array(
                'table' => $table,
                'column' => $sql->primary,
                'alias' => '__dmxPrimary'
            );
        }

        if (isset($sql->key)) {
            $sql->columns[] = (object)array(
                'table' => $table,
                'column' => $sql->key,
                'alias' => '__dmxForeign'
            );
        }

        if (isset($sql->joins) && count($sql->joins)) {
            foreach ($sql->joins as $join) {
                if (isset($join->primary)) {
                    $sql->columns[] = (object)array(
                        'table' => isset($join->alias) ? $join->alias : $join->table,
                        'column' => $join->primary,
                        'alias' => '__dmxPrimary_' . (isset($join->alias) ? $join->alias : $join->table)
                    );
                }
            }
        }
    }

    protected function cleanupResults(&$results) {
        foreach ($results as &$result) {
            $fields = array_keys($result);

            foreach ($fields as $field) {
                if (strpos($field, '__dmx') === 0) {
                    unset($result[$field]);
                } elseif (is_array($result[$field])) {
                    $this->cleanupResults($result[$field]);
                }
            }
        }
    }
}

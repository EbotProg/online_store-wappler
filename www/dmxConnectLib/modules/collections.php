<?php

namespace modules;

use \lib\core\Module;

class collections extends Module
{
    public function addColumns($options) {
        option_require($options, 'collection');
        option_require($options, 'add');
        option_default($options, 'overwrite', FALSE);

        $options = $this->app->parseObject($options);
        $output = array();

        foreach ($options->collection as $row) {
            $row = clone (object)$row;

            foreach ($options->add as $column => $value) {
                if ($options->overwrite || !isset($row->$column)) {
                    $row->$column = $value;
                }
            }

            $output[] = $row;
        }

        return $output;
    }

    public function filterColumns($options) {
        option_require($options, 'collection');
        option_require($options, 'columns');
        option_default($options, 'keep', FALSE);

        $options = $this->app->parseObject($options);
        $output = array();

        foreach ($options->collection as $row) {
            $newRow = (object)array();

            foreach ($row as $column => $value) {
                if (in_array($column, $options->columns)) {
                    if ($options->keep) {
                        $newRow->$column = $value;
                    }
                } elseif (!$options->keep) {
                    $newRow->$column = $value;
                }
            }

            $output[] = $newRow;
        }

        return $output;
    }

    public function renameColumns($options) {
        option_require($options, 'collection');
        option_require($options, 'rename');

        $options = $this->app->parseObject($options);
        $output = array();

        foreach ($options->collection as $row) {
            $newRow = (object)array();

            foreach ($row as $column => $value) {
                if (isset($options->rename->$column)) {
                    $column = $options->rename->$column;
                }
                $newRow->$column =  $value;
            }

            $output[] = $newRow;
        }

        return $output;
    }

    public function fillDown($options) {
        option_require($options, 'collection');
        option_require($options, 'columns');

        $options = $this->app->parseObject($options);
        $output = array();
        $toFill = array();

        foreach ($options->columns as $column) {
            $toFill[$column] = NULL;
        }

        foreach ($options->collection as $row) {
            $row = clone (object)$row;

            foreach ($options->columns as $column) {
                if (!isset($row->$column)) {
                    $row->$column = $toFill[$column];
                } else {
                    $toFill[$column] = $row->$column;
                }
            }

            $output[] = $row;
        }

        return $output;
    }

    public function addRows($options) {
        option_require($options, 'collection');
        option_require($options, 'rows');

        $options = $this->app->parseObject($options);

        return array_merge($options->collection, $options->rows);
    }

    public function addRownumbers($options) {
        option_require($options, 'collection');
        option_require($options, 'column');
        option_require($options, 'startAt');
        option_default($options, 'desc', FALSE);

        $options = $this->app->parseObject($options);
        $column = $options->column;
        $total = count($options->collection);
        $output = array();

        foreach ($options->collection as $index => $row) {
            $row = clone (object)$row;

            $row->$column = $options->desc ? $total + $options->startAt - $index : $options->startAt + $index;
            
            $output[] = $row;
        }

        return $output;
    }

    public function join($options) {
        option_require($options, 'collection1');
        option_require($options, 'collection2');
        option_require($options, 'matches');
        option_default($options, 'matchAll', FALSE);

        $options = $this->app->parseObject($options);
        $output = array();

        foreach ($options->collection1 as $row1) {
            $row1 = clone (object)$row1;

            foreach ($options->collection2 as $row2) {
                $row2 = clone (object)$row2;
                $isMatch = FALSE;

                foreach ($options->matches as $column1 => $column2) {
                    if ($row1->$column1 == $row2->$column2) {
                        $isMatch = TRUE;
                        if (!$options->matchAll) {
                            break;
                        }
                    } elseif ($options->matchAll) {
                        $isMatch = FALSE;
                        break;
                    }
                }

                if ($isMatch) {
                    foreach ($row2 as $column => $value) {
                        $row1->$column = $value;
                    }
                    break;
                }
            }

            $output[] = $row1;
        }

        return $output;
    }

    public function normalize($options) {
        option_require($options, 'collection');

        $options = $this->app->parseObject($options);
        $columns = array();
        $output = array();

        foreach ($options->collection as $row) {
            foreach ($row as $column => $value) {
                if (!in_array($column, $columns)) {
                    $columns[] = $column;
                }
            }
        }

        foreach ($options->collection as $row) {
            $newRow = (object)array();

            foreach ($columns as $column) {
                $newRow->$column = isset($row->$column) ? $row->$column : NULL;
            }

            $output[] = $newRow;
        }

        return $output;
    }
}
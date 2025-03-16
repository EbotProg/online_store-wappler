<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "sort"
      },
      {
        "type": "text",
        "name": "dir"
      }
    ]
  },
  "exec": {
    "steps": {
      "name": "productsAbove15k",
      "module": "dbupdater",
      "action": "custom",
      "options": {
        "connection": "db",
        "sql": {
          "query": "SELECT * FROM products WHERE price>15000",
          "params": []
        }
      },
      "output": true,
      "meta": [
        {
          "name": "id",
          "type": "number"
        },
        {
          "name": "name",
          "type": "text"
        },
        {
          "name": "price",
          "type": "number"
        },
        {
          "name": "qty",
          "type": "number"
        }
      ]
    }
  }
}
JSON
);
?>
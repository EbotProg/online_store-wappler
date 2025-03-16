<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "offset"
      },
      {
        "type": "text",
        "name": "limit"
      },
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
      "name": "listCustomers",
      "module": "dbupdater",
      "action": "custom",
      "options": {
        "connection": "db",
        "sql": {
          "query": "SELECT * FROM customer\norder by createdOn desc;",
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
          "name": "firstname",
          "type": "text"
        },
        {
          "name": "lastname",
          "type": "text"
        },
        {
          "name": "address",
          "type": "text"
        },
        {
          "name": "email",
          "type": "text"
        },
        {
          "name": "phone",
          "type": "text"
        },
        {
          "name": "createdOn",
          "type": "datetime"
        }
      ]
    }
  }
}
JSON
);
?>
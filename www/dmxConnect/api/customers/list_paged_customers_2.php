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
      "name": "listCustomers2",
      "module": "dbconnector",
      "action": "select",
      "options": {
        "connection": "db",
        "sql": {
          "type": "select",
          "columns": [
            {
              "table": "customer",
              "column": "firstname"
            },
            {
              "table": "customer",
              "column": "lastname"
            },
            {
              "table": "customer",
              "column": "address"
            },
            {
              "table": "customer",
              "column": "email"
            },
            {
              "table": "customer",
              "column": "phone"
            }
          ],
          "params": [],
          "orders": [],
          "table": {
            "name": "customer"
          },
          "primary": "id",
          "joins": [],
          "query": "select `firstname`, `lastname`, `address`, `email`, `phone` from `customer`"
        }
      },
      "output": true,
      "meta": [
        {
          "type": "text",
          "name": "firstname"
        },
        {
          "type": "text",
          "name": "lastname"
        },
        {
          "type": "text",
          "name": "address"
        },
        {
          "type": "text",
          "name": "email"
        },
        {
          "type": "number",
          "name": "phone"
        }
      ],
      "outputType": "array"
    }
  }
}
JSON
);
?>
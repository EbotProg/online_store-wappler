<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "number",
        "name": "limit"
      },
      {
        "type": "number",
        "name": "offset"
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
      "name": "queryPagedProducts",
      "module": "dbconnector",
      "action": "paged",
      "options": {
        "connection": "db",
        "sql": {
          "type": "select",
          "columns": [
            {
              "table": "products",
              "column": "*"
            }
          ],
          "params": [],
          "table": {
            "name": "products"
          },
          "primary": "id",
          "joins": [],
          "orders": [],
          "query": "select * from `products`",
          "limit": 5
        }
      },
      "output": true,
      "meta": [
        {
          "name": "offset",
          "type": "number"
        },
        {
          "name": "limit",
          "type": "number"
        },
        {
          "name": "total",
          "type": "number"
        },
        {
          "name": "page",
          "type": "object",
          "sub": [
            {
              "name": "offset",
              "type": "object",
              "sub": [
                {
                  "name": "first",
                  "type": "number"
                },
                {
                  "name": "prev",
                  "type": "number"
                },
                {
                  "name": "next",
                  "type": "number"
                },
                {
                  "name": "last",
                  "type": "number"
                }
              ]
            },
            {
              "name": "current",
              "type": "number"
            },
            {
              "name": "total",
              "type": "number"
            }
          ]
        },
        {
          "name": "data",
          "type": "array",
          "sub": [
            {
              "type": "number",
              "name": "id"
            },
            {
              "type": "text",
              "name": "name"
            },
            {
              "type": "number",
              "name": "price"
            },
            {
              "type": "number",
              "name": "qty"
            }
          ]
        }
      ],
      "outputType": "object"
    }
  }
}
JSON
);
?>
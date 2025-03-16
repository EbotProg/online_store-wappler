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
    ],
    "$_POST": [
      {
        "type": "text",
        "name": "id"
      }
    ]
  },
  "exec": {
    "steps": [
      {
        "name": "deleteCustomerOrders",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
            "table": "orders",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "customer_id",
                  "field": "customer_id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.id}}",
                  "data": {
                    "column": "customer_id"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "returning": "id",
            "query": "delete from `orders` where `customer_id` = ?",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.id}}",
                "test": ""
              }
            ]
          }
        },
        "meta": [
          {
            "name": "affected",
            "type": "number"
          }
        ]
      },
      {
        "name": "deleteCustomer",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "db",
          "sql": {
            "type": "delete",
            "table": "customer",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.id}}",
                  "data": {
                    "column": "id"
                  },
                  "operation": "="
                }
              ]
            },
            "returning": "id",
            "query": "delete from `customer` where `id` = ?",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.id}}",
                "test": ""
              }
            ]
          }
        },
        "meta": [
          {
            "name": "affected",
            "type": "number"
          }
        ]
      }
    ]
  }
}
JSON
);
?>
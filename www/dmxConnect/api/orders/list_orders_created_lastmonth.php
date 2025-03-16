<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "start_date"
      },
      {
        "type": "text",
        "name": "end_date"
      }
    ]
  },
  "exec": {
    "steps": [
      {
        "name": "getCustomerNameProductName",
        "module": "dbupdater",
        "action": "custom",
        "options": {
          "connection": "db",
          "sql": {
            "query": "SELECT customer.firstname AS customer_firstname, \n\t\tproducts.name AS product_name, \n        products.price AS product_price,\n        orders.orderedOn AS ordered_date,\n        orders.status AS order_status\nFROM orders \n       INNER JOIN customer ON orders.customer_id = customer.id\n      INNER JOIN products ON orders.product_id = products.id\n      WHERE orders.orderedOn BETWEEN :start_date AND :end_date;",
            "params": [
              {
                "name": ":start_date",
                "value": "{{$_GET.start_date}}",
                "test": "2025-02-01"
              },
              {
                "name": ":end_date",
                "value": "{{$_GET.end_date}}",
                "test": "2025-04-30"
              }
            ]
          }
        },
        "output": true,
        "meta": [
          {
            "name": "customer_firstname",
            "type": "text"
          },
          {
            "name": "product_name",
            "type": "text"
          },
          {
            "name": "product_price",
            "type": "number"
          },
          {
            "name": "ordered_date",
            "type": "datetime"
          },
          {
            "name": "order_status",
            "type": "text"
          }
        ]
      },
      {
        "name": "qryOrdersCreatedLastMonth",
        "module": "dbupdater",
        "action": "custom",
        "options": {
          "connection": "db",
          "sql": {
            "query": "SELECT * FROM orders WHERE orderedOn BETWEEN :start_date AND :end_date;",
            "params": [
              {
                "name": ":start_date",
                "value": "{{$_GET.start_date}}",
                "test": "2025-02-01",
                "recid": 1
              },
              {
                "name": ":end_date",
                "value": "{{$_GET.end_date}}",
                "test": "2025-02-28",
                "recid": 2
              }
            ]
          }
        },
        "output": true,
        "meta": [
          {
            "name": "id",
            "type": "number"
          },
          {
            "name": "customer_id",
            "type": "number"
          },
          {
            "name": "product_id",
            "type": "number"
          },
          {
            "name": "status",
            "type": "text"
          },
          {
            "name": "orderedOn",
            "type": "datetime"
          },
          {
            "name": "executedOn",
            "type": "datetime"
          }
        ],
        "outputType": "array",
        "disabled": true
      }
    ]
  }
}
JSON
);
?>
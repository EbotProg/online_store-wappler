<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "id"
      }
    ]
  },
  "exec": {
    "steps": {
      "name": "qryCustomerOrders",
      "module": "dbupdater",
      "action": "custom",
      "options": {
        "connection": "db",
        "sql": {
          "query": "select customer.firstname, customer.lastname, products.name as productName, orders.status, orders.qtyOrdered, orders.totalAmount, orders.orderedOn, orders.executedOn\nfrom ((orders\ninner join customer on orders.customer_id = customer.id)\ninner join products on orders.product_id = products.id)\nwhere orders.customer_id = :id",
          "params": [
            {
              "name": ":id",
              "value": "{{$_GET.id}}",
              "test": "2"
            }
          ]
        }
      },
      "output": true,
      "meta": [
        {
          "name": "firstname",
          "type": "text"
        },
        {
          "name": "lastname",
          "type": "text"
        },
        {
          "name": "productName",
          "type": "text"
        },
        {
          "name": "status",
          "type": "text"
        },
        {
          "name": "qtyOrdered",
          "type": "number"
        },
        {
          "name": "totalAmount",
          "type": "number"
        },
        {
          "name": "orderedOn",
          "type": "datetime"
        },
        {
          "name": "executedOn",
          "type": "datetime"
        }
      ]
    }
  }
}
JSON
);
?>
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
      "name": "qryOrdersWithCustomerInfo",
      "module": "dbupdater",
      "action": "custom",
      "options": {
        "connection": "db",
        "sql": {
          "query": "select customer.firstname, customer.lastname, customer.email\nfrom orders\ninner join customer on customer.id = orders.customer_id\nwhere orders.orderedOn >= '2025-03-12'",
          "params": []
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
          "name": "email",
          "type": "text"
        }
      ]
    }
  }
}
JSON
);
?>
<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "name": "qryCustomersWithoutOrders",
  "module": "dbupdater",
  "action": "custom",
  "options": {
    "connection": "db",
    "sql": {
      "query": "select firstname, lastname\nfrom customer\nwhere not EXISTS\n(select customer_id from orders where customer.id = customer_id)",
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
    }
  ]
}
JSON
);
?>
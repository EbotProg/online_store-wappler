<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "name": "qryProductsNeverOrdered",
  "module": "dbupdater",
  "action": "custom",
  "options": {
    "connection": "db",
    "sql": {
      "query": "select id, name, price\nfrom products\nwhere (select count(*) from orders where products.id = orders.product_id) = 0",
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
    }
  ]
}
JSON
);
?>
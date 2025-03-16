<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "name": "qryProductsOrderedOnceTotalQtyOrdered",
  "module": "dbupdater",
  "action": "custom",
  "options": {
    "connection": "db",
    "sql": {
      "query": "select products.name,\nsum(orders.qtyOrdered) as totalQuantityOrdered\nfrom products\ninner join orders on products.id = orders.product_id\ngroup by products.id, products.name\nhaving count(*) >= 1 \n",
      "params": []
    }
  },
  "output": true,
  "meta": [
    {
      "name": "name",
      "type": "text"
    },
    {
      "name": "totalQuantityOrdered",
      "type": "text"
    }
  ]
}
JSON
);
?>
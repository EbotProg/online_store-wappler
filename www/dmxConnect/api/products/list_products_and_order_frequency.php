<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "name": "qryProductsAndOrderFrequency",
  "module": "dbupdater",
  "action": "custom",
  "options": {
    "connection": "db",
    "sql": {
      "query": "SELECT products.name,\n\t(select COUNT(*) from orders where orders.product_id = products.id) as NumOfTimesOrdered\nFROM products\norder by NumOfTimesOrdered desc;",
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
      "name": "NumOfTimesOrdered",
      "type": "text"
    }
  ]
}
JSON
);
?>
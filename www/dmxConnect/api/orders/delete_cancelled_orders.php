<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "name": "deleteCancelledOrders",
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
            "id": "status",
            "field": "status",
            "type": "string",
            "operator": "equal",
            "value": "CANCELLED",
            "data": {
              "column": "status"
            },
            "operation": "="
          }
        ],
        "conditional": null,
        "valid": true
      },
      "returning": "id",
      "query": "delete from `orders` where `status` = ?",
      "params": []
    }
  },
  "meta": [
    {
      "name": "affected",
      "type": "number"
    }
  ]
}
JSON
);
?>
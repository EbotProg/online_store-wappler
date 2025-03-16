<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "name": "qryTopCustomersByOrderValue",
  "module": "dbupdater",
  "action": "custom",
  "options": {
    "connection": "db",
    "sql": {
      "query": "select firstname, lastname, \n (select count(*) from orders where customer.id = customer_id) as orderFrequency\n  from customer\n order by orderFrequency desc\n limit 5;",
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
      "name": "orderFrequency",
      "type": "text"
    }
  ]
}
JSON
);
?>
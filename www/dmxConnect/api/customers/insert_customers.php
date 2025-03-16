<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "name": "firstname"
      },
      {
        "type": "text",
        "name": "lastname"
      },
      {
        "type": "text",
        "name": "address"
      },
      {
        "type": "text",
        "name": "email"
      },
      {
        "type": "number",
        "name": "phone"
      }
    ]
  },
  "exec": {
    "steps": {
      "name": "insertCustomer",
      "module": "dbupdater",
      "action": "insert",
      "options": {
        "connection": "db",
        "sql": {
          "type": "insert",
          "values": [
            {
              "table": "customer",
              "column": "firstname",
              "type": "text",
              "value": "{{$_POST.firstname}}"
            },
            {
              "table": "customer",
              "column": "lastname",
              "type": "text",
              "value": "{{$_POST.lastname}}"
            },
            {
              "table": "customer",
              "column": "address",
              "type": "text",
              "value": "{{$_POST.address}}"
            },
            {
              "table": "customer",
              "column": "email",
              "type": "text",
              "value": "{{$_POST.email}}"
            },
            {
              "table": "customer",
              "column": "phone",
              "type": "number",
              "value": "{{$_POST.phone}}"
            }
          ],
          "table": "customer",
          "returning": "id",
          "query": "insert into `customer` (`address`, `email`, `firstname`, `lastname`, `phone`) values (?, ?, ?, ?, ?)",
          "params": [
            {
              "name": ":P1",
              "type": "expression",
              "value": "{{$_POST.firstname}}",
              "test": ""
            },
            {
              "name": ":P2",
              "type": "expression",
              "value": "{{$_POST.lastname}}",
              "test": ""
            },
            {
              "name": ":P3",
              "type": "expression",
              "value": "{{$_POST.address}}",
              "test": ""
            },
            {
              "name": ":P4",
              "type": "expression",
              "value": "{{$_POST.email}}",
              "test": ""
            },
            {
              "name": ":P5",
              "type": "expression",
              "value": "{{$_POST.phone}}",
              "test": ""
            }
          ]
        }
      },
      "meta": [
        {
          "name": "identity",
          "type": "text"
        },
        {
          "name": "affected",
          "type": "number"
        }
      ]
    }
  }
}
JSON
);
?>
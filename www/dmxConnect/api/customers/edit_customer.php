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
      },
      {
        "type": "number",
        "name": "id"
      }
    ]
  },
  "exec": {
    "steps": {
      "name": "editCustomer",
      "module": "dbupdater",
      "action": "update",
      "options": {
        "connection": "db",
        "sql": {
          "type": "update",
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
            },
            {
              "table": "customer",
              "column": "updatedOn",
              "type": "datetime",
              "value": "{{NOW}}"
            }
          ],
          "table": "customer",
          "wheres": {
            "condition": "AND",
            "rules": [
              {
                "id": "id",
                "type": "double",
                "operator": "equal",
                "value": "{{$_POST.id}}",
                "data": {
                  "column": "id"
                },
                "operation": "="
              }
            ]
          },
          "returning": "id",
          "query": "update `customer` set `firstname` = ?, `lastname` = ?, `address` = ?, `email` = ?, `phone` = ?, `updatedOn` = ? where `id` = ?",
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
            },
            {
              "name": ":P6",
              "type": "expression",
              "value": "{{NOW}}",
              "test": ""
            },
            {
              "operator": "equal",
              "type": "expression",
              "name": ":P7",
              "value": "{{$_POST.id}}",
              "test": ""
            }
          ]
        }
      },
      "meta": [
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
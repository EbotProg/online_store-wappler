<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "number",
        "name": "limit"
      },
      {
        "type": "number",
        "name": "offset"
      },
      {
        "type": "text",
        "name": "sort"
      },
      {
        "type": "text",
        "name": "dir"
      },
      {
        "type": "text",
        "name": "firstnamefilter"
      },
      {
        "type": "text",
        "name": "addressfilter"
      }
    ]
  },
  "exec": {
    "steps": [
      {
        "name": "qryPagedCustomers",
        "module": "dbconnector",
        "action": "paged",
        "options": {
          "connection": "db",
          "sql": {
            "type": "select",
            "columns": [
              {
                "table": "customer",
                "column": "firstname"
              },
              {
                "table": "customer",
                "column": "lastname"
              },
              {
                "table": "customer",
                "column": "address"
              },
              {
                "table": "customer",
                "column": "email"
              },
              {
                "table": "customer",
                "column": "phone"
              },
              {
                "table": "customer",
                "column": "id"
              }
            ],
            "params": [
              {
                "operator": "contains",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.firstnamefilter}}",
                "test": ""
              },
              {
                "operator": "contains",
                "type": "expression",
                "name": ":P2",
                "value": "{{$_GET.addressfilter}}",
                "test": ""
              }
            ],
            "table": {
              "name": "customer"
            },
            "primary": "id",
            "joins": [],
            "orders": [],
            "query": "select `firstname`, `lastname`, `address`, `email`, `phone`, `id` from `customer` where (`customer`.`firstname` like ?) and (`customer`.`address` like ?) limit ?",
            "limit": 5,
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "condition": "AND",
                  "rules": [
                    {
                      "id": "customer.firstname",
                      "field": "customer.firstname",
                      "type": "string",
                      "operator": "contains",
                      "value": "{{$_GET.firstnamefilter}}",
                      "data": {
                        "table": "customer",
                        "column": "firstname",
                        "type": "text",
                        "columnObj": {
                          "type": "string",
                          "maxLength": 255,
                          "primary": false,
                          "nullable": true,
                          "name": "firstname"
                        }
                      },
                      "operation": "LIKE",
                      "table": "customer"
                    }
                  ],
                  "conditional": "{{$_GET.firstnamefilter}}",
                  "table": "customer",
                  "id": "customer.undefined"
                },
                {
                  "condition": "AND",
                  "rules": [
                    {
                      "id": "customer.address",
                      "field": "customer.address",
                      "type": "string",
                      "operator": "contains",
                      "value": "{{$_GET.addressfilter}}",
                      "data": {
                        "table": "customer",
                        "column": "address",
                        "type": "text",
                        "columnObj": {
                          "type": "string",
                          "maxLength": 255,
                          "primary": false,
                          "nullable": true,
                          "name": "address"
                        }
                      },
                      "operation": "LIKE",
                      "table": "customer"
                    }
                  ],
                  "conditional": "{{$_GET.addressfilter}}",
                  "table": "customer",
                  "id": "customer.undefined"
                }
              ],
              "conditional": null,
              "valid": true
            }
          }
        },
        "output": true,
        "meta": [
          {
            "name": "offset",
            "type": "number"
          },
          {
            "name": "limit",
            "type": "number"
          },
          {
            "name": "total",
            "type": "number"
          },
          {
            "name": "page",
            "type": "object",
            "sub": [
              {
                "name": "offset",
                "type": "object",
                "sub": [
                  {
                    "name": "first",
                    "type": "number"
                  },
                  {
                    "name": "prev",
                    "type": "number"
                  },
                  {
                    "name": "next",
                    "type": "number"
                  },
                  {
                    "name": "last",
                    "type": "number"
                  }
                ]
              },
              {
                "name": "current",
                "type": "number"
              },
              {
                "name": "total",
                "type": "number"
              }
            ]
          },
          {
            "name": "data",
            "type": "array",
            "sub": [
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
          }
        ],
        "outputType": "object"
      },
      {
        "name": "qryPagedCustomers",
        "module": "dbupdater",
        "action": "custom",
        "options": {
          "connection": "db",
          "sql": {
            "query": "SELECT * FROM customer\nORDER BY id\nLIMIT :limit\nOFFSET :offset;",
            "params": [
              {
                "name": ":limit",
                "value": "{{$_GET.limit}}",
                "test": "",
                "recid": 1
              },
              {
                "name": ":offset",
                "value": "{{$_GET.offset}}",
                "test": "",
                "recid": 2
              }
            ]
          }
        },
        "output": true,
        "meta": [
          {
            "name": "id",
            "type": "number"
          },
          {
            "name": "firstname",
            "type": "text"
          },
          {
            "name": "lastname",
            "type": "text"
          },
          {
            "name": "address",
            "type": "text"
          },
          {
            "name": "email",
            "type": "text"
          },
          {
            "name": "phone",
            "type": "text"
          }
        ],
        "outputType": "array",
        "disabled": true
      }
    ]
  }
}
JSON
);
?>
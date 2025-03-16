<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "number",
        "name": "price"
      },
      {
        "type": "number",
        "name": "id"
      },
      {
        "type": "array",
        "name": "record",
        "sub": [
          {
            "type": "number",
            "name": "price"
          },
          {
            "type": "number",
            "name": "$_POST"
          },
          {
            "type": "number",
            "name": "id"
          }
        ]
      }
    ]
  },
  "exec": {
    "steps": [
      {
        "name": "qryProducts",
        "module": "dbupdater",
        "action": "custom",
        "options": {
          "connection": "db",
          "sql": {
            "query": "SELECT id, price FROM products;",
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
            "name": "price",
            "type": "number"
          }
        ]
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{qryProducts}}",
          "then": {
            "steps": {
              "name": "repeat",
              "module": "core",
              "action": "repeat",
              "options": {
                "repeat": "{{qryProducts}}",
                "outputFields": [],
                "exec": {
                  "steps": {
                    "name": "updPriceBy5Percent",
                    "module": "dbupdater",
                    "action": "update",
                    "options": {
                      "connection": "db",
                      "sql": {
                        "type": "update",
                        "values": [
                          {
                            "table": "products",
                            "column": "price",
                            "type": "number",
                            "value": "{{price.toNumber() * 1.05}}"
                          }
                        ],
                        "table": "products",
                        "wheres": {
                          "condition": "AND",
                          "rules": [
                            {
                              "id": "id",
                              "field": "id",
                              "type": "double",
                              "operator": "equal",
                              "value": "{{id}}",
                              "data": {
                                "column": "id"
                              },
                              "operation": "="
                            }
                          ],
                          "conditional": null,
                          "valid": true
                        },
                        "returning": "id",
                        "query": "update `products` set `price` = ? where `id` = ?",
                        "params": [
                          {
                            "name": ":P1",
                            "type": "expression",
                            "value": "{{price.toNumber() * 1.05}}",
                            "test": ""
                          },
                          {
                            "operator": "equal",
                            "type": "expression",
                            "name": ":P2",
                            "value": "{{id}}",
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
              },
              "output": true,
              "meta": [
                {
                  "name": "$index",
                  "type": "number"
                },
                {
                  "name": "$number",
                  "type": "number"
                },
                {
                  "name": "$name",
                  "type": "text"
                },
                {
                  "name": "$value",
                  "type": "object"
                },
                {
                  "name": "id",
                  "type": "number"
                },
                {
                  "name": "price",
                  "type": "number"
                }
              ],
              "outputType": "array"
            }
          },
          "else": {
            "steps": {
              "name": "Error",
              "module": "core",
              "action": "response",
              "options": {
                "status": 400,
                "data": "'products not found'"
              }
            }
          }
        },
        "outputType": "boolean"
      }
    ]
  }
}
JSON
);
?>
dmx.config({
  "index": {
    "ddCustomerOrder": {
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
          "name": "productName",
          "type": "text"
        },
        {
          "name": "status",
          "type": "text"
        },
        {
          "name": "qtyOrdered",
          "type": "number"
        },
        {
          "name": "totalAmount",
          "type": "number"
        },
        {
          "name": "orderedOn",
          "type": "datetime"
        },
        {
          "name": "executedOn",
          "type": "datetime"
        }
      ],
      "outputType": "text"
    }
  }
});

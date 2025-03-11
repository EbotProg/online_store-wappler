
exports.up = function(knex) {
  return knex.schema
    .createTable('customer', async function (table) {
      table.increments('id');
      table.string('firstname');
      table.string('lastname');
      table.string('address');
      table.string('email');
    })
    .createTable('products', async function (table) {
      table.increments('id');
      table.string('name');
      table.integer('price');
      table.integer('qty');
    })
    .createTable('orders', async function (table) {
      table.increments('id');
      table.integer('customer_id');
      table.integer('product_id');
      table.enum('status', ["DONE","PENDING","CANCELLED"]);
      table.datetime('orderedOn').defaultTo(knex.fn.now());
      table.datetime('executedOn');
    })

};

exports.down = function(knex) {
  return knex.schema
    .dropTable('orders')
    .dropTable('products')
    .dropTable('customer')
};


exports.up = function(knex) {
  return knex.schema
    .table('orders', async function (table) {
      table.integer('totalAmount');
    })

};

exports.down = function(knex) {
  return knex.schema
    .table('orders', async function (table) {
      table.dropColumn('totalAmount');
    })
};

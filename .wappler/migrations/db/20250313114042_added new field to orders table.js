
exports.up = function(knex) {
  return knex.schema
    .table('orders', async function (table) {
      table.integer('qtyOrdered');
    })

};

exports.down = function(knex) {
  return knex.schema
    .table('orders', async function (table) {
      table.dropColumn('qtyOrdered');
    })
};

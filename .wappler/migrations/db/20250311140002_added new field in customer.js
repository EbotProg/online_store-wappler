
exports.up = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.bigInteger('phone');
    })

};

exports.down = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.dropColumn('phone');
    })
};

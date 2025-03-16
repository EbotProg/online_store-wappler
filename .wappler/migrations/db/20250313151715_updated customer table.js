
exports.up = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.datetime('updatedOn').defaultTo(knex.fn.now());
    })

};

exports.down = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.dropColumn('updatedOn');
    })
};

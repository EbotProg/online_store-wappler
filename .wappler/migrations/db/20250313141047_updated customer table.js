
exports.up = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.datetime('createdOn');
    })

};

exports.down = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.dropColumn('createdOn');
    })
};

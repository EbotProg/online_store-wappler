
exports.up = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.datetime('createdOn').defaultTo(knex.fn.now()).alter();
    })

};

exports.down = function(knex) {
  return knex.schema
    .table('customer', async function (table) {
      table.datetime('createdOn').defaultTo().alter();
    })
};

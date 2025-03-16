<?php
// Database Type : "MySQL"
// Database Adapter : "mysql"
$exports = <<<'JSON'
{
    "name": "db",
    "module": "dbconnector",
    "action": "connect",
    "options": {
        "server": "mysql",
        "connectionString": "mysql:host=db;sslverify=false;port=3306;dbname=online_store;user=db_user;password=Rx5JiGGJ;charset=utf8",
        "meta"  : {}
    }
}
JSON;
?>
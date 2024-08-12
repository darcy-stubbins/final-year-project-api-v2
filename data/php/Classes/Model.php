<?php
//connecting the API to the db

namespace Classes;

class Model
{
    public \PDO $db;

    public function __construct()
    {

        $db_name = "craftingapp";
        $db_server = "db";
        $db_port = "3306";
        $db_user = "darcy";
        $db_pass = "password";

        $options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->db = new \PDO("mysql:host={$db_server};port={$db_port};dbname={$db_name};charset=utf8", $db_user, $db_pass, $options);
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}


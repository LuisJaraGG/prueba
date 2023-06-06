<?php

function conectarDB(): mysqli
{
    $db = new mysqli('db1.civkdwxiujte.us-east-2.rds.amazonaws.com', 'admin', 'password', 'dbaws');

    if (!$db) {
        echo 'Error no se puedo conectar';
        exit;
    }

    return $db;
}

<?php
    $DB_host  = "localhost";
    $DB_login = "root";
    $DB_pass  = "";
    $DB_db    = "gerador_parcelas";

    $con = new mysqli($DB_host, $DB_login, $DB_pass, $DB_db);
    if ($con->connect_errno) {
        echo "Falha ao conectar ao banco: (" . $con->connect_errno . ") " . $con->connect_error;
    }

    $con->set_charset("utf8");
?>

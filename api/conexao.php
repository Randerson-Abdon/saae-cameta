<?php

/* $banco = 'saae-santaizabelpa-local';
$host = 'localhost';
$usuario = 'root';
$senha = '';
 */
$banco = 'santaizabel-pa';
$host = 'santaizabel-pa.cvpyiyze5epg.sa-east-1.rds.amazonaws.com';
$usuario = 'provider';
$senha = 'Jp?20061965';

date_default_timezone_set('America/Belem');

//VALIDAÇÃO DA CONEXAO
try {
    $pdo = new PDO("mysql:dbname=$banco;host=$host;charset=utf8", "$usuario", "$senha");
} catch (Exception $e) {
    echo "Erro ao conectar com o banco de dados! " . $e;
}

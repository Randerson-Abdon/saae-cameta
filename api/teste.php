<?php
include_once('funcoes.php');

$data = date('d/m/Y');

$numero_parcela = 6;

$arrayDate = calcularVencimentoParcelas2($data, $numero_parcela);

var_dump($arrayDate);

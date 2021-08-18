<?php
include_once('../conexao.php');

$uc = $_GET['matricula'];
$localidade = 01;

/* $uc = '00730';
$localidade = 01; */


$dados = array();

$query = $pdo->query("CALL sp_lista_financeiro_devedor_vencido($localidade,$uc);");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $dados = $res;
}

echo ($res) ?
    json_encode(array('code' => 1, 'result' => $dados)) :
    json_encode(array('code' => 0, 'message' => 'Dados Incorretos!'));

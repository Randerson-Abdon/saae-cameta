<?php
include_once('../conexao.php');

$uc   = $_GET['uc'];
$fatura = $_GET['fatura'];
$fatura = explode('/', $fatura);
$dataFatura = $fatura[1] . '/' . $fatura[0];
/* $uc     = '00730';
$fatura = '2011/02'; */


$dados = array();

$query = $pdo->query("SELECT * FROM historico_financeiro WHERE id_unidade_consumidora = '$uc' AND mes_faturado = '$dataFatura'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $dados = $res;
}

echo ($res) ?
    json_encode(array('code' => 1, 'result' => $dados)) :
    json_encode(array('code' => 0, 'message' => 'Dados Incorretos!'));

<?php
include_once('../conexao.php');

$cpf = $_GET['cpf'];

if ($cpf == '') {
    $cpf = '0';
}

$dados = array();

$query = $pdo->query("SELECT * FROM unidade_consumidora WHERE numero_cpf_cnpj = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $dados = $res;
}

echo ($res) ?
    json_encode(array('code' => 1, 'result' => $dados)) :
    json_encode(array('code' => 0, 'message' => 'Dados Incorretos!'));

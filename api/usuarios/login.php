<?php
include_once('../conexao.php');

$senha   = $_GET['senha'];
$cpf = $_GET['cpf'];

/* $senha   = '123';
$cpf = '17107237268'; */

$dados = array();

$query = $pdo->query("SELECT * FROM acesso_seguro_web WHERE numero_cpf_cnpj = '$cpf' AND senha_acesso_permanente = '$senha'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $dados = $res;
}

echo ($res) ?
    json_encode(array('code' => 1, 'result' => $dados)) :
    json_encode(array('code' => 0, 'message' => 'Dados Incorretos!'));

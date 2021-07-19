<?php
include_once('../conexao.php');

$uc = $_GET['matricula'];
$localidade = 0;

/* if ($cpf == '') {
    $cpf = '0';
} */

/* $result = mysqli_query(
    $conexao,
    "CALL sp_lista_financeiro_devedor($localidade,$uc);"
) or die("Erro na query da procedure: " . mysqli_error($conexao));
mysqli_next_result($conexao); */


$dados = array();

$query = $pdo->query("CALL sp_lista_financeiro_devedor($localidade,$uc);");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $dados = $res;
}

echo ($res) ?
    json_encode(array('code' => 1, 'result' => $dados)) :
    json_encode(array('code' => 0, 'message' => 'Dados Incorretos!'));

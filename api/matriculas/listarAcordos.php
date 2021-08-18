<?php
include_once('../conexao.php');

$uc = $_GET['matricula'];

//recupera id_localidade
$result = $pdo->prepare(" SELECT id_localidade from unidade_consumidora where id_unidade_consumidora = :id ");
$result->bindValue(':id', $uc);
$result->execute();
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $value) {
    $localidade = $value['id_localidade'];
}

$dados = array();

$query = $pdo->query("CALL sp_lista_parcelas_acordo('DEVEDORA',$localidade,$uc);");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $dados = $res;
}

echo ($res) ?
    json_encode(array('code' => 1, 'result' => $dados)) :
    json_encode(array('code' => 0, 'message' => 'Dados Incorretos!'));

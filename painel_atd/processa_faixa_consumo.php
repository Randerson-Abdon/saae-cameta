<?php


$id = $_GET["id"];

include_once('../conexao.php');

//info cx_termo_abertura_encerramento
$query_hc = "SELECT * FROM tarifa_estimada WHERE tipo_consumo = '$id' ";
$result_hc = mysqli_query($conexao, $query_hc);

while ($res = mysqli_fetch_array($result_hc)) {
    $id_historico_movimento_caixa = $res["id_historico_movimento_caixa"];

    $valor = 'R$ ' . str_replace('.', ',', $res['valor_faixa_consumo']);

    echo "<option value='$res[faixa_consumo]'>$valor</option>";
}

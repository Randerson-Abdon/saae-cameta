<?php
include_once('../../conexao.php');

$dados = array();

//consulta para numeração automatica acordo
$query_num_ac = "select * from acordo_parcelamento order by id_acordo_parcelamento desc ";
$result_num_ac = mysqli_query($conexao, $query_num_ac);
$res_num_ac = mysqli_fetch_array($result_num_ac);
@$ultimo_ac = $res_num_ac["id_acordo_parcelamento"];
$ultimo_ac = $ultimo_ac + 1;
$dados = str_pad($ultimo_ac, 4, '0', STR_PAD_LEFT);

echo json_encode(array('code' => 1, 'result' => $dados));

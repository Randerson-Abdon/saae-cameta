<?php
include_once('../conexao.php');
include_once('controller/controller_acordos.php');

$id_acordo_parcelamento = $_GET['id'];

//echo $id_acordo_parcelamento;

$query = "DELETE FROM acordo_parcelamento where id_acordo_parcelamento = '$id_acordo_parcelamento' ";
$result = mysqli_query($conexao, $query);

$query_bl = "DELETE FROM controle_boleto_acordo where id_acordo_parcelamento = '$id_acordo_parcelamento' ";
$result_bl = mysqli_query($conexao, $query_bl);

$query_hf = "UPDATE historico_financeiro SET id_acordo_parcelamento = '0' where id_acordo_parcelamento = '$id_acordo_parcelamento' ";
$result_hf = mysqli_query($conexao, $query_hf);

if ($result == '' && $query_hf == '') {
    echo "<script language='javascript'>window.alert('Erro ao cancelar acordo!!!'); </script>";
} else {
    echo "<script language='javascript'>window.alert('Acordo cancelado com sucesso!!!'); </script>";
    echo "<script language='javascript'>window.location='atendimento.php?acao=acordos'; </script>";
}

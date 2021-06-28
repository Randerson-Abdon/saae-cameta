<?php

include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');

date_default_timezone_set('America/Sao_Paulo');

if ($_SESSION['nivel_usuario'] != '5' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}

$codigo_barras = $_POST['codigo_barras'];
$id_caixa = $_POST['id_caixa'];

$codigo_barras = preg_replace("/[^0-9]/", "", $codigo_barras);

$uc = substr($codigo_barras, 33, 2) . substr($codigo_barras, 36, 3); //Matrícula

$query_del = "DELETE FROM cx_caixa_temporario WHERE id_caixa = '$id_caixa' ";
$result_del = mysqli_query($conexao, $query_del);

if ($result_del == '') {
    echo "<script language='javascript'>window.alert('Ocorreu um erro ao cancelar!'); </script>";
} else {
    echo "<script language='javascript'>window.alert('Operação Cancelada!'); </script>";
    echo "<script language='javascript'>window.location='operacao.php'; </script>";
}

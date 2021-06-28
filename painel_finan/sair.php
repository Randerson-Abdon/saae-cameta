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

$codigo_barras = preg_replace("/[^0-9]/", "", $codigo_barras);

$uc = substr($codigo_barras, 33, 2) . substr($codigo_barras, 36, 3); //Matrícula

$query_del = "DELETE FROM cx_caixa_temporario WHERE id_unidade_consumidora = '$uc' ";
$result_del = mysqli_query($conexao, $query_del);

if ($result_del == '') {
    echo "<script language='javascript'>window.alert('Ocorreu um erro ao sair!!!'); </script>";
} else {
    echo "<script language='javascript'>window.alert('Se esta finalizando seu dia não esqueça de feixar seu caixa!!!'); </script>";
    echo "<script language='javascript'>window.location='caixa.php'; </script>";
}

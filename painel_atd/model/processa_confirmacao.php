<?php
session_start();

include_once('../../conexao.php');
include_once('../controller/controller_confirmacao.php');

$login_usuario = $_SESSION['login_usuario'];
$senha = $_POST['senha'];
$id_unidade_consumidora = $_POST['id_unidade_consumidora'];
$id_localidade = $_POST['id_localidade'];
$mes_faturado1 = $_POST['mes_faturado1'];
$mes_faturado2 = $_POST['mes_faturado2'];


///echo $senha . ', ' . $login_usuario;

//
$linha = confirmaUsuario($login_usuario, $senha);

if ($linha > 0) {
    echo "<script language='javascript'>window.alert('Confirmado com Sucesso!!!'); </script>";
    echo "<script language='javascript'>window.location='../atendimento.php?acao=baixa&id=' + $id_unidade_consumidora + '&localidade=' + $id_localidade + '&mes_faturado1=' + $mes_faturado1 + '&mes_faturado2=' + $mes_faturado2; </script>";
} else {
    echo "<script language='javascript'>window.alert('Não confirmado!!!'); </script>";
    echo "<script language='javascript'>window.location='../atendimento.php?acao=confirma; </script>";
}

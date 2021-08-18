<?php
@session_start(); # Deve ser a primeira linha do arquivo
include_once('../controller/controller_lancamento_da.php');
include_once('../../conexao.php');


$excluir       = $_POST['excluir'];
$slBuscar      = $_POST['slBuscar'];
$id_operador   = $_SESSION['id_usuario'];

if ($excluir < 1) {
    echo "<script language='javascript'>window.alert('Escolha o número de ultimos meses a serem excluidos!!!'); </script>";
    echo "<script language='javascript'>window.close(); </script>";
    exit;
}

if ($slBuscar == 'uc') {
    $id_localidade = $_POST['localidade'];
    $id_unidade_consumidora = $_POST['id_unidade_consumidora'];


    //executa o store procedure para gerar notificação
    $result_gera_notificacao = mysqli_query(
        $conexao,
        "CALL sp_processa_notificacao_extrajudicial($excluir,$id_localidade,'0','0',$id_unidade_consumidora,$id_operador);"
    ) or die("Erro na query da procedure 1: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    if ($result_gera_notificacao == '') {

        echo "<script language='javascript'>window.alert('Erro ao gerar notificação!!!'); </script>";
    } else {
        echo "<script language='javascript'>window.alert('Gerado com Sucesso!!!'); </script>";
        echo "<script language='javascript'>window.close(); </script>";
    }
} elseif ($slBuscar == 'endereco') {

    $id_localidade = $_POST['id_localidade'];
    $id_bairro     = $_POST['id_bairro'];
    $id_logradouro = $_POST['id_logradouro'];

    //echo $excluir . ', ' . $id_localidade . ', ' . $id_bairro . ', ' . $id_logradouro . ', ' . $id_operador;

    //executa o store procedure para gerar notificação
    $result_gera_notificacao = mysqli_query(
        $conexao,
        "CALL sp_processa_notificacao_extrajudicial($excluir,$id_localidade,$id_bairro ,$id_logradouro,'0',$id_operador);"
    ) or die("Erro na query da procedure 2: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    if ($result_gera_notificacao == '') {

        echo "<script language='javascript'>window.alert('Erro ao gerar notificação!!!'); </script>";
    } else {
        echo "<script language='javascript'>window.alert('Gerado com Sucesso!!!'); </script>";
        echo "<script language='javascript'>window.close(); </script>";
    }
}

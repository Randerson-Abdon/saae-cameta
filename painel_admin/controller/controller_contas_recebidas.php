<?php

@session_start(); # Deve ser a primeira linha do arquivo


// LISTAR sp_lista_documento_arrecadado
function lista_documento_arrecadacao($id_banco, $periodo_inicial, $periodo_final)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_documento_arrecadado($id_banco,'$periodo_inicial','$periodo_final');"
    ) or die("Erro na query da procedure lista_documento_arrecadacao: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}


// LISTAR sp_lista_documento_arrecadacao
function lista_uc_baixadas($id_banco, $id_unidade_consumidora, $periodo_inicial, $periodo_final)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_uc_baixadas($id_banco, $id_unidade_consumidora,'$periodo_inicial','$periodo_final');"
    ) or die("Erro na query da procedure lista_uc_baixadas: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}


function formataMoeda($valor)
{
    $valor = trim($valor);
    $valor = str_replace('R$', '', $valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);

    return $valor;
}


function formataMoeda2($valor)
{

    $valor = str_replace('.', '', $valor) / 100;
    $valor = number_format($valor, 2, ",", ".");
    $valor = 'R$ ' . $valor;

    return $valor;
}

function ativasInativas($localidade, $bairro, $logradouro, $status)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query = "SELECT * from notificacoes_divida_ativa where id_localidade = '$localidade' and id_bairro = '$bairro' and id_logradouro = '$logradouro' and status_ligacao = '$status' ";

    $result = mysqli_query($conexao, $query);

    $numero = mysqli_num_rows($result);


    return $numero;
}

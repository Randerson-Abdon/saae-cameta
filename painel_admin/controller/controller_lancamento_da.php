<?php

@session_start(); # Deve ser a primeira linha do arquivo

function finalDeSemana($aData)
{
    $dia = substr($aData, 8, 2);
    $mes = substr($aData, 5, 2);
    $ano = substr($aData, 0, 4);
    $date = date('w', mktime(0, 0, 0, $mes, $dia, $ano));

    if ($date == 6) :
        $aData = DateTime::createFromFormat('Y-m-d', $aData)->modify('+2 day');
        $aData = date_format($aData, 'Y-m-d');
    elseif ($date == 0) :
        $aData = DateTime::createFromFormat('Y-m-d', $aData)->modify('+1 day');
        $aData = date_format($aData, 'Y-m-d');
    else :
        $aData = $aData;
    endif;

    return $aData;
}

function listaMeses($localidade, $id, $data)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query = "SELECT * from historico_financeiro WHERE id_localidade = '$localidade' AND id_unidade_consumidora = '$id' AND data_vencimento_fatura < '$data' AND data_pagamento_fatura IS NULL ORDER BY mes_faturado ASC ";

    $result = mysqli_query($conexao, $query);

    $numero_meses = mysqli_num_rows($result);

    $descricao_meses = "";
    while ($res = mysqli_fetch_array($result)) {
        $mes_faturado = $res["mes_faturado"];

        //Ttransformando em lista de string os meses
        $rData = explode("/", $mes_faturado);
        $rData = ' -' . $rData[1] . '/' . $rData[0];

        $arr1 = str_split($rData, 9);

        $fatura3 = implode(" - ", $arr1);

        $descricao_meses .= $fatura3;
    }
    return array($descricao_meses, $numero_meses);
}

function formataMoeda($valor)
{
    $valor = trim($valor);
    $valor = str_replace('R$', '', $valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);

    return $valor;
}

// LISTAR notificacoes_divida_ativa
function listaNotificacao_sp($localidade, $bairro, $logradouro)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_notificacoes(NULL,$localidade,$bairro ,$logradouro,'0');"
    ) or die("Erro na query da procedure 6: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}

// LISTAR notificacoes_divida_ativa com uc
function listaNotificacao_uc_sp($localidade, $id)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_notificacoes(NULL,$localidade,'0','0',$id);"
    ) or die("Erro na query da procedure 5: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}

// LISTAR notificacoes_divida_ativa com uc
function listaNotificacao_uc_manutencao($localidade, $id)
{
    @require('../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_notificacoes(NULL,$localidade,'0','0',$id);"
    ) or die("Erro na query da procedure 4: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}

// LISTAR notificacoes_divida_ativa com logradouro
function listaNotificacao_log_sp($localidade, $bairro, $logradouro)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_notificacoes(NULL,$localidade,$bairro,$logradouro,'0');"
    ) or die("Erro na query da procedure 3: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
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

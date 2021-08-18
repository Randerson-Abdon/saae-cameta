<?php

@session_start(); # Deve ser a primeira linha do arquivo


// LISTAR sp_lista_inadimplencia
function processa_inadimplencia($id_localidade, $bairro, $competencia)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_processa_inadimplencia($id_localidade, $bairro, '$competencia');"
    ) or die("Erro na query da procedure sp_processa_inadimplencia: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}

// LISTAR sp_lista_inadimplencia
function lista_inadimplencia($id_localidade, $bairro)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_inadimplencia($id_localidade, $bairro);"
    ) or die("Erro na query da procedure sp_lista_inadimplencia: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    return $result;
}

// LISTAR sp_resumo_inadimplencia
function resumo_inadimplencia($id_localidade, $bairro)
{
    @require('../../conexao.php');
    //executa o store procedure para gerar notificação
    $result = mysqli_query(
        $conexao,
        "CALL sp_resumo_inadimplencia($id_localidade, $bairro);"
    ) or die("Erro na query da procedure sp_resumo_inadimplencia: " . mysqli_error($conexao));
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


function repleaceData($rData)
{

    $rData = explode("/", $rData);
    $rData = $rData[1] . '/' . $rData[0];

    return $rData;
}

function extencoData($rData)
{

    $rData = explode("/", $rData);

    switch ($rData[1]) {
        case '01':
            $mes = 'JANEIRO';
            break;
        case '02':
            $mes = 'FEVEREIRO';
            break;
        case '03':
            $mes = 'MARÇO';
            break;
        case '04':
            $mes = 'ABRIL';
            break;
        case '05':
            $mes = 'MAIO';
            break;
        case '06':
            $mes = 'JUNHO';
            break;
        case '07':
            $mes = 'JULHO';
            break;
        case '08':
            $mes = 'AGOSTO';
            break;
        case '09':
            $mes = 'SETEMBRO';
            break;
        case '10':
            $mes = 'OUTUBRO';
            break;
        case '11':
            $mes = 'NOVEMBRO';
            break;

        default:
            $mes = 'DEZEMBRO';
            break;
    }

    $rData = $mes . ' DE ' . $rData[0];

    return $rData;
}


function inadimplencia2($id_localidade, $mes_competencia)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query = "SELECT * from inadimplencia where id_localidade = '$id_localidade' and mes_competencia = '$mes_competencia' order by total_uc_cadastrada DESC ";

    $result = mysqli_query($conexao, $query);

    return $result;
}

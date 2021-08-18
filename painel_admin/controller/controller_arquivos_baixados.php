<?php

@session_start(); # Deve ser a primeira linha do arquivo

//CONSULTA SEM A VARIAVEL BANCO
function consulta01_retorno_bancario_g($localidade, $periodo_inicial)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query01 = "SELECT 
	id_banco_conveniado,
    id_sequencial_arquivo,
    data_credito_bancario,
    count(*) AS qtde_doc,
    sum(valor_recebido_fatura) AS valor
FROM retorno_bancario_g
where data_credito_bancario = '$periodo_inicial'
and id_localidade = '$localidade'
group by 	
    id_banco_conveniado,
	data_credito_bancario
order by
	data_credito_bancario,
    id_banco_conveniado";

    $result01 = mysqli_query($conexao, $query01);

    return $result01;
}

//CONSULTA SEM A VARIAVEL BANCO PARA RESUMO
function consulta01_retorno_bancario_g2($localidade, $periodo_inicial, $periodo_final)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query01 = "SELECT 
	id_banco_conveniado,
    id_sequencial_arquivo,
    data_credito_bancario,
    count(*) AS qtde_doc,
    sum(valor_recebido_fatura) AS valor
FROM retorno_bancario_g
where data_credito_bancario between '$periodo_inicial' and '$periodo_final'
and id_localidade = '$localidade'
group by 	
    id_banco_conveniado,
	data_credito_bancario
order by
	data_credito_bancario,
    id_banco_conveniado";

    $result01 = mysqli_query($conexao, $query01);

    return $result01;
}

//CONSULTA SEM A VARIAVEL BANCO
function consulta01_retorno_bancario_az($id_sequencial_arquivo, $id_banco_arrecadador)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query02 = "SELECT * from retorno_bancario_az where id_sequencial_arquivo = '$id_sequencial_arquivo' and id_banco_conveniado = '$id_banco_arrecadador'";

    $result02 = mysqli_query($conexao, $query02);

    return $result02;
}


//CONSULTA COM A VARIAVEL BANCO
function consulta02_retorno_bancario_g($localidade, $id_banco, $periodo_inicial, $periodo_final)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query03 = "SELECT * from retorno_bancario_g where id_localidade = '$localidade' AND id_banco_conveniado = '$id_banco' AND data_credito_bancario BETWEEN '$periodo_inicial' AND '$periodo_final' GROUP BY id_sequencial_arquivo ";

    $result03 = mysqli_query($conexao, $query03);

    return $result03;
}

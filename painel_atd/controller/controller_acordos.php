<?php

// SP ACORDOS
function listaAcordos($status, $localidade, $id)
{
    @require('../../conexao.php');

    //executa o store procedure para listar acordos
    $result = mysqli_query(
        $conexao,
        "CALL sp_lista_parcelas_acordo('$status','$localidade','$id');"
    ) or die("Erro na query da procedure 1: " . mysqli_error($conexao));
    //liberando para proxima procedure
    mysqli_next_result($conexao);


    return $result;
}

// CONSULTA EM ACORDOS PARA VALIDAÇÃO DE BOTÕES
function validaBotao($id)
{
    @require('../../conexao.php');

    //consulta acordo_parcelamento
    $query = "SELECT * from acordo_parcelamento where id_acordo_parcelamento = '$id' and numero_parcela = '00/00' and data_pagamento_parcela is null ";

    $result = mysqli_query($conexao, $query);

    $numero = mysqli_num_rows($result);

    return $numero;
}

// SP COMSUMIDORES
function listaConsumidor($localidade, $id)
{
    @require('../../conexao.php');

    //executa o store procedure para listar acordos
    $result = mysqli_query(
        $conexao,
        "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
    ) or die("Erro na query da procedure 2: " . mysqli_error($conexao));
    //liberando para proxima procedure
    mysqli_next_result($conexao);


    return $result;
}

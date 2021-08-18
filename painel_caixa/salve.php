<?php
session_start();
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

date_default_timezone_set('America/Sao_Paulo');

if ($_SESSION['nivel_usuario'] != '4' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}


$total_entradas                 = $_SESSION['total_entradas'];
$id_termo_abertura_encerramento = $_POST['id_termo_abertura_encerramento'];
$id_caixa                       = $_POST['id_caixa'];
$codigo_barras2                 = $_POST['codigo_barras'];
$id_usuario_editor              = $_SESSION['id_usuario'];

$query_copia = "INSERT INTO cx_caixa_permanente (id_termo_abertura_encerramento, data_recebimento_fatura, id_caixa, id_localidade, id_unidade_consumidora, mes_fatura_arrecadada, tipo_arrecadacao, data_vencimento_fatura, numero_dias_atraso, numero_meses_atraso, valor_arrecadacao, valor_multa, valor_juros, valor_total_arrecadacao) SELECT * FROM cx_caixa_temporario where id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' ";

$result_copia = mysqli_query($conexao, $query_copia);

$data = date('Y-m-d');

$id_banco_arrecadador = '999';
$id_sequencial_documento = '0';

$mes_gerador = date("Y/m");
$mes_lancamento = date('Y/m', strtotime('+30 days'));


//info cx_caixa_permanente
$qty = 0;
$query_cp = "SELECT * FROM cx_caixa_temporario WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_caixa = '$id_caixa' ";
$result_cp = mysqli_query($conexao, $query_cp);

while ($row = mysqli_fetch_assoc($result_cp)) {

    $mes_fatura_arrecadada     = $row["mes_fatura_arrecadada"];
    $id_unidade_consumidora    = $row["id_unidade_consumidora"];
    $localidade                = $row["id_localidade"];
    $data_vencimento_fatura    = $row["data_vencimento_fatura"];

    $total_pagamento_fatura  = $row["valor_total_arrecadacao"];

    // trabalhando tipo de arrecadação para descrição do movimento
    $tipo_arrecadacao  = $row["tipo_arrecadacao"];

    $ta2 = substr($tipo_arrecadacao, 1, 2);
    if ($ta2 == '2') {
        $dm2 = ', JUROS E MULTAS';
    }

    $ta3 = substr($tipo_arrecadacao, 2, 3);
    if ($ta3 == '3') {
        $dm3 = ', PARCELAS DE ACORDOS';
    }

    $ta4 = substr($tipo_arrecadacao, 3, 4);
    if ($ta4 == '4') {
        $dm4 = ', SERVIÇOS';
    }

    $ta1 = substr($tipo_arrecadacao, 0, 1);
    if ($ta1 == '1') {
        $descricao_movimento = 'FATURA NORMAL' . @$dm2 . @$dm3 . @$dm4;
    } elseif ($ta1 == '2') {
        $descricao_movimento = 'ENTRADA DE ACORDO';
    } elseif ($ta1 == '3') {
        $descricao_movimento = 'VALOR DE SERVIÇOS'; //
    } elseif ($ta1 == '4') {
        $descricao_movimento = 'FATURA AVULSA'; //
    } elseif ($ta1 == '0') {
        $descricao_movimento = 'PARCELA DE ACORDO'; //
    }

    if ($ta1 == '4') {
        // BAIXANDO CONTAS AVULSAS
        $query_ba = "SELECT * FROM boleto_avulso WHERE id_localidade = '$localidade' AND id_unidade_consumidora = '$id_unidade_consumidora' AND total_geral_faturado = '$total_pagamento_fatura' AND data_vencimento_boleto = '$data_vencimento_fatura' ";
        $result_ba = mysqli_query($conexao, $query_ba);
        $res_ba = mysqli_fetch_array($result_ba);
        $id_boleto_avulso = $res_ba["id_boleto_avulso"];

        echo $data . ', ' . $id_banco_arrecadador . ', ' . $id_sequencial_documento . ', ' . $id_usuario_editor . ', ' . $id_boleto_avulso;

        $query_up = "UPDATE historico_financeiro SET data_pagamento_fatura = '$data', id_banco_conveniado = '$id_banco_arrecadador', id_sequencial_arquivo = '$id_sequencial_documento', id_usuario_editor_registro = '$id_usuario_editor' where id_boleto_avulso = '$id_boleto_avulso' ";

        $result_up = mysqli_query($conexao, $query_up);
    } elseif ($ta1 == '2') {
        // BAIXANDO ACORDOS
        $query_up = "UPDATE acordo_parcelamento SET data_pagamento_parcela = '$data', id_banco_arrecadador = '$id_banco_arrecadador', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$id_unidade_consumidora' AND valor_parcela = '$total_pagamento_fatura' AND data_vencimento_parcela = '$data_vencimento_fatura' AND id_localidade = '$localidade' ";

        //echo $ta1 . ', ' . $id_unidade_consumidora . ', ' . $total_pagamento_fatura . ', ' . $data_vencimento_fatura . ', ' . $localidade;

        $result_up = mysqli_query($conexao, $query_up);
    } elseif ($ta1 == '3') {
        // BAIXANDO SERVIÇOS
        $query_up = "UPDATE controle_boleto_servico SET data_pagamento_boleto = '$data', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$id_unidade_consumidora' AND data_vencimento_boleto = '$data_vencimento_fatura' AND valor_boleto = '$total_pagamento_fatura' ";

        $result_up = mysqli_query($conexao, $query_up);
    } else {
        //baixa na tabela de historico_financeiro
        $query = "UPDATE historico_financeiro SET data_pagamento_fatura = '$data', total_pagamento_fatura = '$total_pagamento_fatura', id_banco_conveniado = '$id_banco_arrecadador', id_sequencial_arquivo = '$id_sequencial_documento', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$id_unidade_consumidora' AND mes_faturado = '$mes_fatura_arrecadada' ";

        $result = mysqli_query($conexao, $query);
    }


    //ver se conseguimos eliminar este
    $resultado = mysqli_query($conexao, "SELECT sum(valor_total_arrecadacao) FROM cx_caixa_temporario WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_caixa = '$id_caixa' ");
    $linhas = mysqli_num_rows($resultado);

    while ($linhas = mysqli_fetch_array($resultado)) {
        $valor_total_arrecadacao = $linhas['sum(valor_total_arrecadacao)'];
    }

    $valor_novo = $valor_total_arrecadacao + $total_entradas;


    // Insert na tabela de cx_historico_movimento_caixa
    //consulta para numeração automatica
    $query_num_aula = "SELECT * from cx_historico_movimento_caixa WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_operador = '$id_usuario_editor' order by id_historico_movimento_caixa desc ";
    $result_num_aula = mysqli_query($conexao, $query_num_aula);
    $res_num_aula = mysqli_fetch_array($result_num_aula);
    @$id_historico_movimento_caixa = $res_num_aula["id_historico_movimento_caixa"];
    $id_historico_movimento_caixa = $id_historico_movimento_caixa + 1;

    @$saldo_anterior            = $res_num_aula["saldo_anterior"];
    @$saldo_atual               = $res_num_aula["saldo_atual"];

    $saldo_atual2 = $total_pagamento_fatura + $saldo_atual;

    $query_movimento = "INSERT INTO cx_historico_movimento_caixa (id_termo_abertura_encerramento, data_cadastro_movimento , id_historico_movimento_caixa, tipo_movimento, descricao_movimento, saldo_anterior, valor_entrada, saldo_atual, id_localidade, id_unidade_consumidora, id_operador) values ('$id_termo_abertura_encerramento', '$data', '$id_historico_movimento_caixa', 'E', '$descricao_movimento', '$saldo_atual', '$total_pagamento_fatura', '$saldo_atual2', '$localidade', '$id_unidade_consumidora', '$id_usuario_editor')";

    $result_movimento = mysqli_query($conexao, $query_movimento);
}
// fim das inserssões do while



if ($query_copia == '') {
    echo "<script language='javascript'>window.alert('Ocorreu um erro ao finalizar!!!');</script>";
} else {

    $query_up2 = "UPDATE cx_termo_abertura_encerramento SET total_entradas = '$valor_novo' WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_operador = '$id_usuario_editor' ";
    $result_up2 = mysqli_query($conexao, $query_up2);

    $query_del = "DELETE FROM cx_caixa_temporario WHERE id_caixa = '$id_caixa' ";
    $result_del = mysqli_query($conexao, $query_del);

    echo "<script language='javascript'>window.alert('Finalizado com Sucesso!!!');</script>";
    echo "<script language='javascript'>window.location ='operacao.php';</script>";
}

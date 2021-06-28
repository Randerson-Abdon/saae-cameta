<?php
session_start();
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

date_default_timezone_set('America/Sao_Paulo');

if ($_SESSION['nivel_usuario'] != '4' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}

@$id_termo_abertura_encerramento = $_POST['id_termo_abertura_encerramento'];
@$id_caixa = $_POST['id_caixa'];

$resultado = mysqli_query($conexao, "SELECT sum(valor_total_arrecadacao), sum(valor_arrecadacao), sum(valor_multa), sum(valor_juros) FROM cx_caixa_temporario WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_caixa = '$id_caixa' ");
$linhas = mysqli_num_rows($resultado);

while ($linhas = mysqli_fetch_array($resultado)) {
    $valor_total_arrecadacao = $linhas['sum(valor_total_arrecadacao)'];
    $valor_arrecadacao       = $linhas['sum(valor_arrecadacao)'];
    $valor_multa             = $linhas['sum(valor_multa)'];
    $valor_juros             = $linhas['sum(valor_juros)'];
}

//echo 'valor 1 ' . $valor_arrecadacao2 . ', valor 2 ' . $valor_total_arrecadacao2 . ', valor_multa ' . $valor_multa2 . ', valor_juros ' . $valor_juros2;

?>



<div class="row ml-5">

    <div class="form-group col-md-4">
        <label class="cor" for="id_produto">Valor da Tarifa</label>
        <input type="text" class="form-control" name="v_tarifa" value="<?php echo @$valor_arrecadacao; ?>" placeholder="0,00" style="background-color: #E0DCDC; color: #b90000; font-weight: bolder;">
    </div>

    <div class="form-group col-md-4">
        <label class="cor" for="id_produto">Valor da Multa</label>
        <input type="text" class="form-control" name="v_multa" value="<?php echo @$valor_multa; ?>" placeholder="0,00" style="background-color: #E0DCDC; color: #b90000; font-weight: bolder;">
    </div>

</div>

<div class="row ml-5">

    <div class="form-group col-md-4">
        <label class="cor" for="id_produto">Valor da Juros</label>
        <input type="text" class="form-control" name="v_juros" value="<?php echo @$valor_juros; ?>" placeholder="0,00" style="background-color: #E0DCDC; color: #b90000; font-weight: bolder;">
    </div>

    <div class="form-group col-md-4">
        <label class="cor" for="id_produto">Valor do Débito</label>
        <input type="text" class="form-control" name="v_debito" value="<?php echo @$valor_total_arrecadacao; ?>" placeholder="0,00" style="background-color: #E0DCDC; color: #b90000; font-weight: bolder;">
    </div>

</div>

<div class="row ml-5">

    <div class="form-group col-md-8">
        <label class="cor" for="id_produto" style="margin-left: 25%;">Valor Pago</label>
        <input type="text" class="form-control" name="v_pago" placeholder="0,00" style="background-color: #00ffff; color: #b90000; font-weight: bolder; width: 50%; margin-left: 25%;">
    </div>

</div>

<hr style="background-color: #ffffff; margin-top: -5px;">
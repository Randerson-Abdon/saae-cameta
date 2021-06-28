<?php
@session_start(); # Deve ser a primeira linha do arquivo
date_default_timezone_set('America/Belem');

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gerador de Parcelas</title>
    <!-- CSS -->
    <link type="text/css" href="../css/estilo.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" href="libs/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Plugin Mask -->
    <script src="../lib/jquery.mask/jquery.mask.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="../lib/bootstrap/bootstrap.min.js" type="text/javascript"></script>

    <script src="../js/geral.js" type="text/javascript"></script>
</head>

<body>

    <?php
    include_once('../conexao.php');

    @$id = $_POST['id'];
    @$id_localidade = $_POST['id_localidade'];
    @$mes_faturado = $_POST['mes_faturado'];
    @$fatura = $_POST['fatura'];
    @$total_fatura = $_POST['total_fatura'];

    $_SESSION['mes_faturado'] = $mes_faturado;
    $_SESSION['id'] = $id;
    $_SESSION['id_localidade'] = $id_localidade;

    @$linha = count($mes_faturado);

    $sufixo = date('H:i:s');
    $sufixo = str_replace(':', '', $sufixo);

    $query_create_table = "CREATE TABLE temp_acordo$sufixo(
    id INT PRIMARY KEY AUTO_INCREMENT,
    mes_faturado CHAR(7),
    total_fatura DECIMAL(10,2)
    )"
        or die("Erro ao criar a tabela..." . $conexao->connect_errno);
    $result_create_table = $conexao->query($query_create_table);

    $j = 0;
    for ($x = 1; $x <= $linha; $x++) {
        $sql = "INSERT INTO temp_acordo$sufixo(
        mes_faturado,
        total_fatura
    )VALUES(
        '" . $mes_faturado[$j] . "',
        '" . $total_fatura[$j] . "'
    )";

        if (!$conexao->query($sql)) {
            die("<p class='erro'><strong>Erro!</strong> " . $conexao->error . "</p>");
        }
        $j++;
    }

    $soma = 0;
    foreach ($mes_faturado as $mes_fat) {
        $query_uc = "SELECT * from temp_acordo$sufixo where mes_faturado = '$mes_fat' order by id asc ";
        $result_uc = mysqli_query($conexao, $query_uc);
        $row_uc = mysqli_fetch_array($result_uc);
        $mes_fat = $row_uc["mes_faturado"];
        $total_fat = $row_uc["total_fatura"];

        $soma = $soma + $row_uc["total_fatura"];
        $soma2 = number_format($soma, 2, ",", ".");

        $_SESSION['soma2'] = $soma2;

        $entrada = $soma * 0.30;
        $entrada = number_format($entrada, 2, ",", ".");


        //$query_del = "DROP TABLE temp_acordo$sufixo";
        //$result_del =  mysqli_query($conexao, $query_del);

    }

    ?>

    <?php

    //consulta para numeração automatica acordo
    $query_num_ac = "select * from acordo_parcelamento order by id_acordo_parcelamento desc ";
    $result_num_ac = mysqli_query($conexao, $query_num_ac);
    $res_num_ac = mysqli_fetch_array($result_num_ac);
    @$ultimo_ac = $res_num_ac["id_acordo_parcelamento"];
    $ultimo_ac = $ultimo_ac + 1;
    $ultimo_ac = str_pad($ultimo_ac, 4, '0', STR_PAD_LEFT);

    $query_n = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id' ";
    $result_n = mysqli_query($conexao, $query_n);
    $row_n = mysqli_fetch_array($result_n);
    $nome_razao_social = $row_n["nome_razao_social"];


    ?>

    <div class="container">



        <ul class="linha bg-primary text-white">
            <li>
                <b>Matrícula:</b> <?php echo $id; ?></b>
            </li>
            <li>
                <b>Nome /Razão Social:</b> <?php echo $nome_razao_social; ?></b>
            </li>
            <li style="list-style: none;">
                <b>Você esta acessando o módulo de acordos e parcelamentos de débitos</b>
            </li>

        </ul>


        <form id="form" name="form" action="" method="post">
            <div class="row">
                <div class="col-md-3">

                    <input type="text" name="id_localidade" value="<?php echo $id_localidade ?>" style="display: none;">

                    <div class="form-group">
                        <label for="data">Acordo Número</label>
                        <input class="bg-primary text-white" type="text" name="id_acordo_parcelamento" value="<?php echo $ultimo_ac ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="data">Matrícula n°</label>
                        <input class="bg-primary text-white" type="text" name="id" value="<?php echo $id ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="data">Data do Acordo</label>
                        <input class="bg-primary text-white" type="text" id="data" name="data" value="<?= date("d/m/Y") ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="valorTotal">Valor Total (R$)</label>
                        <input class="bg-primary text-white" type="text" id="valorTotal" name="valorTotal" value="<?php echo $soma2 ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="valorEntrada">Valor Entrada (R$)</label>
                        <input type="text" id="valorEntrada" name="valorEntrada" value="<?php echo $entrada ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="valorEntrada">Parcelas</label>
                        <select id="parcelas" name="parcelas" class="form-control">
                            <option selected="selected" value="0">selecione o número de parcelas</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-5">&nbsp;</div>

                <div class="col-md-4">
                    <div id="resultado"></div>
                </div>
            </div>
        </form>
    </div>

    <?php

    $query_del = "DROP TABLE temp_acordo$sufixo";
    $result_del =  mysqli_query($conexao, $query_del);

    ?>

</body>

</html>
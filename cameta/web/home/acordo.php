<?php
@session_start(); # Deve ser a primeira linha do arquivo
date_default_timezone_set('America/Belem');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gerador de Parcelas</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="../js/painel.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/javascript.js"></script>
    <script type="text/javascript" src="../js/post.js"></script>



    <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- LINK DO fontawesome via cdn(navegador) para icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

    <!-- link com a folha de stilos -->
    <link rel="stylesheet" type="text/css" href="../css/estilos-site.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos-padrao.css">
    <link rel="stylesheet" type="text/css" href="../css/cursos.css">
    <link rel="stylesheet" type="text/css" href="../css/painel.css">
    <link rel="stylesheet" type="text/css" href="../css/cards.css">

    <!-- OS SCRIPTS DEVEM SEMPRE VIM DEPOIS DAS FOLHAS DE ESTILO -->
    <!-- script cdn(pelo navegador) jquery.min.js para menu em resoluções menores -->


    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->



    <!-- CSS -->
    <link type="text/css" href="css/estilo.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" href="libs/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Plugin Mask -->
    <script src="jquery.mask/jquery.mask.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="bootstrap/bootstrap.min.js" type="text/javascript"></script>

    <script src="js/geral.js" type="text/javascript"></script>
</head>

<style>
    body {
        margin-top: 50px;
        width: 100%;

    }

    @media (max-width:768px) {
        body {
            width: 150%;
        }
    }
</style>

<body>

    <?php
    include_once('conexao.php');


    @$id = $_POST['id'];
    @$id_localidade = $_POST['id_localidade'];
    @$mes_faturado = $_POST['mes_faturado'];
    @$fatura = $_POST['fatura'];
    @$total_fatura = $_POST['total_fatura'];

    $_SESSION['mes_faturado'] = $mes_faturado;
    $_SESSION['id'] = $id;


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
                        <label for="data">Acordo n°</label>
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
                        <input type="text" id="valorEntrada" name="valorEntrada" value="50,00" class="form-control">
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

</body>

</html>
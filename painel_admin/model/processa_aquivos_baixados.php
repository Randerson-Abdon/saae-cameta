<?php
include_once('../../conexao.php');
include_once('../controller/controller_arquivos_baixados.php');

/* //trazendo info bairro
$query_ps = "SELECT * FROM bairro WHERE id_localidade = '$id_localidade' AND id_bairro = '$id_bairro' ";
$result_ps = mysqli_query($conexao, $query_ps);
$row_ps = mysqli_fetch_array($result_ps);
$nome_bairro = $row_ps['nome_bairro'];

$titulo = strtolower($nome_bairro); */

$id_localidade   = $_POST['localidade'];
$id_banco        = $_POST['id_banco'];
$periodo_inicial = $_POST['periodo_inicial'];
$periodo_final   = $_POST['periodo_final'];




//condições para execução do script
if ($id_banco != 0) {


    if ($periodo_final == '') {
        $periodo_final = date('Y-m-d');
    }

    if ($periodo_inicial == '') {
        echo "<script language='javascript'>
        window.alert('Prencha a data inícial!!!');
    </script>";
        echo "<script language='javascript'>
        window.close();
    </script>";
        exit();
    }

    if ($periodo_inicial != '' && $periodo_final != '') {

        if ($periodo_inicial > $periodo_final) {
            echo "<script language='javascript'>
        window.alert('A Data Inícial não pode ser maior que a Data Final!!!');
    </script>";
            echo "<script language='javascript'>
        window.close();
    </script>";
            exit();
        }
    }

    if ($id_banco == 0) {
        $result = consulta01_retorno_bancario_g($id_localidade, $periodo_inicial, $periodo_final);
    } else {
        $result = consulta02_retorno_bancario_g($id_localidade, $id_banco, $periodo_inicial, $periodo_final);

        //trazendo info bancos
        $query_banco = "SELECT * FROM banco_conveniado WHERE id_febraban = '$id_banco'";
        $result_banco = mysqli_query($conexao, $query_banco);
        $row_banco = mysqli_fetch_array($result_banco);
        $nome_banco = $row_banco['nome_banco'];

        $titulo = strtolower($nome_banco);
    }

    $linha_count = mysqli_num_rows($result);

    if ($linha_count == 0) {
        echo "<script language='javascript'>
        window.alert('Não foi encontrado dados com esses parâmetros!!!');
    </script>";
        echo "<script language='javascript'>
        window.close();
    </script>";
        exit();
    }

?>

    <!DOCTYPE html>
    <html lang="en" style="width: 110%;">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <h1 style="font-size: 30px;">
            <title> Relatório de credito bancario <?php if ($id_banco != 0) {
                                                        echo $titulo;
                                                    } ?> </title>
        </h1>
        <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- LINK DO fontawesome via cdn(navegador) para icones -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>

    <body style="width: 110%;">


        <script>
            window.print();
            window.addEventListener("afterprint", function(event) {
                window.close();
            });
            window.onafterprint();
        </script>

        <style>
            @media print {
                tr:nth-child(even) td {
                    background-color: #e9e9e9 !important;
                    -webkit-print-color-adjust: exact;
                }

            }

            img.face {
                float: right;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px 10px 10px 0px;
                max-width: 1386px;
                margin-left: 1270px;
                margin-top: 30px;

            }

            img.face2 {
                float: left;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px -250px 10px 0;
                max-width: 1386px;
                margin-top: 30px;
            }
        </style>



        <div class="container ml-4" style="width: 110%;">

            <br>

            <div class="content" style="width: 110%;">
                <div class="row" style="width: 110%;">
                    <div class="col-md-12" style="width: 110%;">

                        <!--TAMANHO DA TABELA -->
                        <div class="card-body" style="width: 110%;">
                            <div class="card" style="width: 120%; margin-left: -50px;">
                                <div class="table-responsive">

                                    <?php

                                    //trazendo info perfil_saae
                                    $query_ps = "SELECT * from perfil_saae";
                                    $result_ps = mysqli_query($conexao, $query_ps);
                                    $row_ps = mysqli_fetch_array($result_ps);
                                    @$nome_prefeitura = $row_ps['nome_prefeitura'];
                                    //mascarando cnpj
                                    @$cnpj_saae = $row_ps['cnpj_saae'];
                                    $p1 = substr($cnpj_saae, 0, 2);
                                    $p2 = substr($cnpj_saae, 2, 3);
                                    $p3 = substr($cnpj_saae, 5, 3);
                                    $p4 = substr($cnpj_saae, 8, 4);
                                    $p5 = substr($cnpj_saae, 12, 2);
                                    $saae_cnpj = $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4 . '-' . $p5;
                                    @$nome_bairro_saae = $row_ps['nome_bairro_saae'];
                                    @$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
                                    @$numero_imovel_saae = $row_ps['numero_imovel_saae'];
                                    @$nome_municipio_saae = $row_ps['nome_municipio_saae'];
                                    @$uf_saae = $row_ps['uf_saae'];
                                    @$nome_saae = $row_ps['nome_saae'];
                                    @$email_saae = $row_ps['email_saae'];
                                    @$logo_orgao = $row_ps['logo_orgao'];

                                    $data = date('d/m/Y');


                                    ?>

                                    <table style="margin-bottom: 15px; margin-left: 30px; font-size: 14pt;">
                                        <thead>
                                            <tr>
                                                <th>

                                                    <img class="face2" width="10%" src="../../img/sIzabel/saae.png" alt="">

                                                    <img class="face" width="10%" src="../../img/sIzabel/prefeitura.png" alt="">

                                                    <p class="text-center" style="margin-top: 40px; margin-left: 380px; position: absolute;">


                                                        <?php echo $nome_prefeitura . ' - ' . $uf_saae; ?> <br>
                                                        <?php echo $nome_saae; ?> <br>
                                                        SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                        RELATÓRIO DE CRÉDITO BANCÁRIO - <?php echo 'GERADO EM ' . $data; ?><?php if ($id_banco != 0) {
                                                                                                                                echo ' - ' . $nome_banco;
                                                                                                                            } ?> <br>

                                                    </p>

                                                </th>
                                            </tr>
                                    </table>



                                    <table class="table table-sm table-bordered table-striped" style="margin-top: -20px;  font-size: 14pt;">

                                        <thead>

                                            <th style="background-color: darkgrey !important;">
                                                BANCO ARRECADADOR
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                CONVÊNIO
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                DATA DE CRÉDITO
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                ID ARQUIVO
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                QTDE. DE DOC
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                VALOR
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                VERIFICAÇÃO
                                            </th>

                                        </thead>
                                        <tbody>

                                            <?php


                                            //loop retorno_g
                                            $qty = 0;
                                            $qty1 = 0;
                                            $qty2 = 0;
                                            while ($res = mysqli_fetch_array($result)) {
                                                $id_sequencial_arquivo = $res["id_sequencial_arquivo"];
                                                $id_banco_arrecadador = $res["id_banco_conveniado"];
                                                $data_credito_bancario = date('d/m/Y', strtotime($res["data_credito_bancario"])); //recebe data já convertida

                                                //var_dump($data_credito_bancario);

                                                $result_az = consulta01_retorno_bancario_az($id_sequencial_arquivo, $id_banco_arrecadador);

                                                $linha_count_az = mysqli_num_rows($result_az);

                                                //loop retorno_az                                           
                                                while ($res_az = mysqli_fetch_array($result_az)) {
                                                    $id_banco_arrecadador  = $res_az["id_banco_conveniado"];
                                                    $codigo_convenio       = $res_az["codigo_convenio"];
                                                    $id_sequencial_arquivo = $res_az["id_sequencial_arquivo"];
                                                    $quantidade_documentos = $res_az["quantidade_documentos"];
                                                    $valor_arrecadacao     = $res_az["valor_arrecadacao"];

                                                    //trazendo info bancos
                                                    $query_banco = "SELECT * FROM banco_conveniado WHERE id_febraban = '$id_banco_arrecadador'";
                                                    $result_banco = mysqli_query($conexao, $query_banco);
                                                    $row_banco = mysqli_fetch_array($result_banco);
                                                    $nome_banco = $row_banco['nome_banco'];


                                            ?>

                                                    <tr>

                                                        <td><?php echo $nome_banco; ?></td>
                                                        <td><?php echo $codigo_convenio; ?></td>
                                                        <td><?php echo $data_credito_bancario; ?></td>
                                                        <td><?php echo $id_sequencial_arquivo; ?></td>
                                                        <td><?php echo $quantidade_documentos; ?></td>
                                                        <td>R$ <?php echo number_format($valor_arrecadacao, 2, ",", "."); ?></td>
                                                        <td class="text-center">SIM(&nbsp;&nbsp;)&nbsp;&nbsp; NÃO(&nbsp;&nbsp;)</td>

                                                    </tr>

                                            <?php }

                                                $qty += $quantidade_documentos;
                                                $total_doc = $qty;

                                                $qty1 += $valor_arrecadacao;
                                                $total_valor = $qty1;

                                                $qty2 += $linha_count_az;
                                                $total_linhas = $qty2;
                                            }
                                            ?>

                                        </tbody>



                                    </table>


                                    <table class="table table-sm table-bordered" style="margin-top: 40px; color: #d70000 !important; background-color: #c0c0c0 !important; font-size: 14pt;">
                                        <thead>

                                            <th style="background-color: darkgrey !important;">
                                                QUANTIDADE DE REGISTROS
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                QTDE. DE DOC
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                VALOR TOTAL
                                            </th>


                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td><?php echo $total_linhas; ?></td>
                                                <td><?php echo $total_doc; ?></td>
                                                <td>R$ <?php echo number_format($total_valor, 2, ",", "."); ?></td>

                                            </tr>



                                        </tbody>

                                    </table>

                                    <!-- ESPAÇO DE OBSERVAÇÕES -->
                                    <table class="table table-sm table-bordered" style="margin-top: 40px; background-color: #c0c0c0 !important; font-size: 14pt;  font-weight: bold;">
                                        <thead>

                                            <th style="background-color: darkgrey !important;">
                                                OBSERVAÇÕES:
                                            </th>


                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td style="height: 150px;"></td>


                                            </tr>

                                        </tbody>

                                    </table>

                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>


    </body>

    </html>



<?php } else {
    if ($periodo_final == '') {
        $periodo_final = date('Y-m-d');
    }

    if ($periodo_inicial == '') {
        echo "<script language='javascript'>
        window.alert('Prencha a data inícial!!!');
    </script>";
        echo "<script language='javascript'>
        window.close();
    </script>";
        exit();
    }

    if ($periodo_inicial != '' && $periodo_final != '') {

        if ($periodo_inicial > $periodo_final) {
            echo "<script language='javascript'>
        window.alert('A Data Inícial não pode ser maior que a Data Final!!!');
    </script>";
            echo "<script language='javascript'>
        window.close();
    </script>";
            exit();
        }
    }

    /* if ($linha_count == 0) {
    echo "<script language='javascript'>
        window.alert('Não foi encontrado dados com esses parâmetros!!!');
    </script>";
    echo "<script language='javascript'>
        window.close();
    </script>";
    exit();
    } */

?>

    <!DOCTYPE html>
    <html lang="en" style="width: 110%;">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <h1 style="font-size: 30px;">
            <title> Relatório de credito bancario <?php if ($id_banco != 0) {
                                                        echo $titulo;
                                                    } ?> </title>
        </h1>
        <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- LINK DO fontawesome via cdn(navegador) para icones -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>

    <body style="width: 110%;">


        <script>
            window.print();
            window.addEventListener("afterprint", function(event) {
                window.close();
            });
            window.onafterprint();
        </script>

        <style>
            @media print {
                tr:nth-child(even) td {
                    background-color: #e9e9e9 !important;
                    -webkit-print-color-adjust: exact;
                }

            }

            img.face {
                float: right;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px 10px 10px 0px;
                max-width: 1386px;
                margin-left: 1270px;
                margin-top: 30px;

            }

            img.face2 {
                float: left;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px -250px 10px 0;
                max-width: 1386px;
                margin-top: 30px;
            }
        </style>



        <div class="container ml-4" style="width: 110%;">

            <br>

            <div class="content" style="width: 110%;">
                <div class="row" style="width: 110%;">
                    <div class="col-md-12" style="width: 110%;">

                        <!--TAMANHO DA TABELA -->
                        <div class="card-body" style="width: 110%;">
                            <div class="card" style="width: 120%; margin-left: -50px;">
                                <div class="table-responsive">

                                    <?php

                                    //trazendo info perfil_saae
                                    $query_ps = "SELECT * from perfil_saae";
                                    $result_ps = mysqli_query($conexao, $query_ps);
                                    $row_ps = mysqli_fetch_array($result_ps);
                                    @$nome_prefeitura = $row_ps['nome_prefeitura'];
                                    //mascarando cnpj
                                    @$cnpj_saae = $row_ps['cnpj_saae'];
                                    $p1 = substr($cnpj_saae, 0, 2);
                                    $p2 = substr($cnpj_saae, 2, 3);
                                    $p3 = substr($cnpj_saae, 5, 3);
                                    $p4 = substr($cnpj_saae, 8, 4);
                                    $p5 = substr($cnpj_saae, 12, 2);
                                    $saae_cnpj = $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4 . '-' . $p5;
                                    @$nome_bairro_saae = $row_ps['nome_bairro_saae'];
                                    @$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
                                    @$numero_imovel_saae = $row_ps['numero_imovel_saae'];
                                    @$nome_municipio_saae = $row_ps['nome_municipio_saae'];
                                    @$uf_saae = $row_ps['uf_saae'];
                                    @$nome_saae = $row_ps['nome_saae'];
                                    @$email_saae = $row_ps['email_saae'];
                                    @$logo_orgao = $row_ps['logo_orgao'];

                                    $data = date('d/m/Y');


                                    ?>

                                    <table style="margin-bottom: 15px; margin-left: 30px; font-size: 14pt;">
                                        <thead>
                                            <tr>
                                                <th>

                                                    <img class="face2" width="10%" src="../../img/sIzabel/saae.png" alt="">

                                                    <img class="face" width="10%" src="../../img/sIzabel/prefeitura.png" alt="">

                                                    <p class="text-center" style="margin-top: 40px; margin-left: 450px; position: absolute;">


                                                        <?php echo $nome_prefeitura . ' - ' . $uf_saae; ?> <br>
                                                        <?php echo $nome_saae; ?> <br>
                                                        SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                        RELATÓRIO DE CRÉDITO BANCÁRIO - <?php echo 'GERADO EM ' . $data; ?><?php if ($id_banco != 0) {
                                                                                                                                echo ' - ' . $nome_banco;
                                                                                                                            } ?> <br>

                                                    </p>

                                                </th>
                                            </tr>
                                    </table>



                                    <table class="table table-sm table-bordered table-striped" style="margin-top: -20px; font-size: 14pt;">

                                        <thead>

                                            <th style="background-color: darkgrey !important;">
                                                DATA DE CRÉDITO
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                BANCO ARRECADADOR
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                ID ARQUIVO
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                QTDE. DE DOC
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                VALOR
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                VERIFICAÇÃO
                                            </th>

                                        </thead>

                                        <?php

                                        // Calcula a diferença em segundos entre as datas
                                        $diferenca = strtotime($periodo_final) - strtotime($periodo_inicial);
                                        //Calcula a diferença em dias
                                        $dias = floor($diferenca / (60 * 60 * 24));

                                        //echo $dias;

                                        $data_inicial = date('Y-m-d', strtotime('-1 days', strtotime($periodo_inicial)));
                                        $qty3 = 0;
                                        $qty4 = 0;
                                        $qty5 = 0;
                                        //inicio do lupe de tabelas
                                        for ($i = 0; $i <= $dias; $i++) {
                                            $data_inicial = date('Y-m-d', strtotime('+1 days', strtotime($data_inicial)));

                                            //echo $data_inicial;
                                        ?>

                                            <tbody>

                                                <?php

                                                if ($id_banco == 0) {
                                                    $result = consulta01_retorno_bancario_g($id_localidade, $data_inicial);
                                                } else {
                                                    $result = consulta02_retorno_bancario_g($id_localidade, $id_banco, $periodo_inicial, $periodo_final);

                                                    /* //trazendo info bancos
                                                $query_banco = "SELECT * FROM bancos WHERE id_febraban = '$id_banco'";
                                                $result_banco = mysqli_query($conexao, $query_banco);
                                                $row_banco = mysqli_fetch_array($result_banco);
                                                $nome_banco = $row_banco['nome_banco'];

                                                $titulo = strtolower($nome_banco); */
                                                }

                                                $linha_count = mysqli_num_rows($result);

                                                //loop retorno_g
                                                $qty = 0;
                                                $qty1 = 0;
                                                $qty2 = 0;
                                                while ($res = mysqli_fetch_array($result)) {
                                                    $id_sequencial_arquivo = $res["id_sequencial_arquivo"];
                                                    $id_banco_arrecadador = $res["id_banco_conveniado"];
                                                    $data_credito_bancario = date('d/m/Y', strtotime($res["data_credito_bancario"])); //recebe data já convertida
                                                    $qtde_doc = $res["qtde_doc"];
                                                    $valor = $res["valor"];

                                                    //var_dump($data_credito_bancario);
                                                    $qty += $qtde_doc;
                                                    $total_doc = $qty;

                                                    $qty1 += $valor;
                                                    $total_valor = $qty1;

                                                    //trazendo info bancos
                                                    $query_banco = "SELECT * FROM banco_conveniado WHERE id_febraban = '$id_banco_arrecadador'";
                                                    $result_banco = mysqli_query($conexao, $query_banco);
                                                    $row_banco = mysqli_fetch_array($result_banco);
                                                    $nome_banco = $row_banco['nome_banco'];

                                                ?>
                                                    <tr>

                                                        <td><?php echo $data_credito_bancario; ?></td>
                                                        <td><?php echo $nome_banco; ?></td>
                                                        <td><?php echo $id_sequencial_arquivo; ?></td>
                                                        <td><?php echo $qtde_doc; ?></td>
                                                        <td>R$ <?php echo number_format($valor, 2, ",", "."); ?></td>
                                                        <td class="text-center">SIM(&nbsp;&nbsp;)&nbsp;&nbsp; NÃO(&nbsp;&nbsp;)</td>

                                                    </tr>

                                                <?php
                                                }

                                                ?>

                                            </tbody>

                                            <tfoot>
                                                <?php if ($linha_count != '') { ?>
                                                    <tr>
                                                        <td style="background-color: darkgray !important; font-weight: bold;" colspan="3">Sub-Total do dia <?php echo  date('d/m/Y', strtotime($data_inicial)); ?></td>
                                                        <td style="background-color: darkgray !important; font-weight: bold;"><?php if (@$total_doc == '') {
                                                                                                                                    echo 'SEM CREDITO';
                                                                                                                                } else {
                                                                                                                                    echo $total_doc;
                                                                                                                                } ?></td>
                                                        <td style="background-color: darkgray !important; font-weight: bold;"><?php if (@$total_valor == '') {
                                                                                                                                    echo 'SEM CREDITO';
                                                                                                                                } else {
                                                                                                                                    echo 'R$ ' . number_format($total_valor, 2, ",", ".");
                                                                                                                                } ?></td>
                                                        <td style="background-color: darkgray !important; font-weight: bold;"></td>

                                                    </tr>
                                                <?php } ?>
                                            </tfoot>


                                        <?php
                                        } ?>

                                    </table>


                                    <?php

                                    $result_resumo = consulta01_retorno_bancario_g2($id_localidade, $periodo_inicial, $periodo_final);
                                    $total_linhas = mysqli_num_rows($result_resumo);
                                    //loop retorno_g
                                    $qty = 0;
                                    $qty1 = 0;
                                    $qty2 = 0;
                                    while ($res = mysqli_fetch_array($result_resumo)) {
                                        $id_sequencial_arquivo = $res["id_sequencial_arquivo"];
                                        $qtde_doc = $res["qtde_doc"];
                                        $valor = $res["valor"];

                                        //var_dump($data_credito_bancario);
                                        $qty += $qtde_doc;
                                        $total_doc = $qty;

                                        $qty1 += $valor;
                                        $total_valor = $qty1;
                                    }


                                    ?>

                                    <table class="table table-sm table-bordered" style="margin-top: 40px; color: #d70000 !important; background-color: #c0c0c0 !important; font-size: 14pt;  font-weight: bold;">
                                        <thead>

                                            <th style="background-color: darkgrey !important;">
                                                QUANTIDADE DE REGISTROS
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                QTDE. DE DOC
                                            </th>
                                            <th style="background-color: darkgrey !important;">
                                                VALOR TOTAL
                                            </th>


                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td><?php echo $total_linhas; ?></td>
                                                <td><?php echo $total_doc; ?></td>
                                                <td>R$ <?php echo number_format($total_valor, 2, ",", "."); ?></td>

                                            </tr>

                                        </tbody>

                                    </table>

                                    <!-- ESPAÇO DE OBSERVAÇÕES -->
                                    <table class="table table-sm table-bordered" style="margin-top: 40px; background-color: #c0c0c0 !important; font-size: 14pt;  font-weight: bold;">
                                        <thead>

                                            <th style="background-color: darkgrey !important;">
                                                OBSERVAÇÕES:
                                            </th>


                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td style="height: 150px;"></td>


                                            </tr>

                                        </tbody>

                                    </table>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

    </body>

    </html>
<?php } ?>
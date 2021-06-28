<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- reconhecer caracteres especiais -->
    <meta charset="utf8_encode">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- adaptação para qualquer tela -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- mecanismos de busca -->
    <meta name="description" content="Descrição das buscas">
    <meta name="author" content="Autores">
    <meta name="keywords" content="palavras chaves de busca, palavra, palavra">

    <title>Teste de Baixa</title>

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
</head>

<body>

    <style>
        #conteudo {
            /*Novamente definimos a largura da div*/
            width: 100%;
            /* altura da div */
            height: auto;
            /* Cor de fundo da div */
            background-color: #0F0;
        }

        #conteudo-left {
            /*Novamente definimos a largura da div*/
            width: 50%;
            /* altura da div */
            height: auto;
            /* O atributo Float é utilizado para fazermos o nosso bloco(div)
  literalmente flutue e se posicione onde queremos na página,
  quando escolhemos left, dizemos que esse bloco irá se posicionar na
  parte esquerda da página */
            float: left;
            /* Cor de fundo da div */
            background-color: #b70000;
        }

        #conteudo-right {
            /*Novamente definimos a largura da div*/
            width: 50%;
            /* altura da div */
            height: auto;
            /* Pode parecer meio estranho usarmos o mesmo atributo left para o bloco
  em que queremos posicionar na direita, mas como sabemos, o CSS é um estilo
  em cascata, nossa div conteúdo definimos a largura de 1000px e na
  conteudo-left 500px, automaticamente ao definirmos o conteudo-right
  com 500px e à esquerda também, ele ficou à direita do conteudo-left,
  pois o máximo que a div filha poderá ter é 1000px, sendo 500+500=1000px */
            float: left;
            /* Cor de fundo da div */
            background-color: #b70000;
        }

        .container {
            background-color: #b70000;
        }

        body {
            background-color: #b70000;
        }
    </style>



    <?php
    include_once('conexao.php');
    ?>



    <div class="container mt-5" style="margin-left: 25%;">
        <div class="row">

            <div class="col-md-6">
                <h3 class="text-center" style="color: #ffffff;">VERIFICAÇÃO DE BAIXAS DO CAIXA</h3>
            </div>

            <div class="col-md-6">
                <form class="form-inline my-2 my-lg-0">
                    <input name="txtpesquisarBaixa" class="form-control mr-sm-2" type="date" placeholder="Pesquisar Bairros" aria-label="Pesquisar">
                    <button name="buttonPesquisar" style="color: #ffffff;" class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>


    <div id="conteudo">
        <!-- abrimos a div conteudo -->
        <div id="conteudo-left">
            <div class="container ml-4">


                <br>


                <div class="content">
                    <div class="row mr-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="col-md-12">
                                            <h5 class="text-center">Boletos Avulsos</h5>
                                        </div>

                                        <!--LISTAR TODOS OS BAIRROS -->
                                        <?php
                                        if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarBaixa'] != '') {

                                            $nome = $_GET['txtpesquisarBaixa'];
                                            $_SESSION['data'] = $nome;
                                            $query = "SELECT * from cx_caixa_permanente where data_recebimento_fatura = '$nome' and tipo_arrecadacao = 4000 order by id_unidade_consumidora desc ";

                                            $result_count = mysqli_query($conexao, $query);


                                            $result = mysqli_query($conexao, $query);

                                            $linha = mysqli_num_rows($result);
                                            $linha_count = mysqli_num_rows($result_count);

                                            if ($linha == '') {
                                                echo "<h4 style='color: red;'> Não há lançamentos para esse tipo de movimento!!! </h4>";
                                            } else {

                                        ?>


                                                <table class="table table-sm">
                                                    <thead class="text-secondary">

                                                        <th>
                                                            Localidade
                                                        </th>
                                                        <th>
                                                            UC
                                                        </th>
                                                        <th>
                                                            Competência
                                                        </th>
                                                        <th>
                                                            Data de Pagamento
                                                        </th>
                                                        <th>
                                                            ID Boleto Avulso
                                                        </th>
                                                        <th>
                                                            Status
                                                        </th>

                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        while ($res = mysqli_fetch_array($result)) {
                                                            $data_recebimento_fatura   = $res["data_recebimento_fatura"];
                                                            $id_localidade           = $res["id_localidade"];
                                                            $id_unidade_consumidora  = $res["id_unidade_consumidora"];
                                                            $valor_total_arrecadacao  = $res["valor_total_arrecadacao"];
                                                            $tipo_arrecadacao    = $res["tipo_arrecadacao"];
                                                            $data_vencimento_fatura    = $res["data_vencimento_fatura"];


                                                            //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                                                            $query_user = "SELECT * from boleto_avulso where id_localidade = '$id_localidade' and id_unidade_consumidora = '$id_unidade_consumidora' and total_geral_faturado = '$valor_total_arrecadacao' and data_vencimento_boleto = '$data_vencimento_fatura' ";
                                                            $result_user = mysqli_query($conexao, $query_user);

                                                            while ($res2 = mysqli_fetch_array($result_user)) {
                                                                $id_boleto_avulso = $res2["id_boleto_avulso"];
                                                                $lista_meses_lancados = $res2["lista_meses_lancados"];

                                                                //echo '<br>' . $id_boleto_avulso;

                                                                $query_hf = "SELECT * from historico_financeiro where id_boleto_avulso = '$id_boleto_avulso' ";
                                                                $result_hf = mysqli_query($conexao, $query_hf);

                                                                $linhas = mysqli_num_rows($result_hf);

                                                                while ($res3 = mysqli_fetch_array($result_hf)) {
                                                                    $data_pagamento_fatura   = $res3["data_pagamento_fatura"];
                                                                    $id_localidade           = $res3["id_localidade"];
                                                                    $id_unidade_consumidora  = $res3["id_unidade_consumidora"];
                                                                    $mes_faturado            = $res3["mes_faturado"];
                                                                    $total_pagamento_fatura  = $res3["total_pagamento_fatura"];
                                                                    $id_banco_arrecadador    = $res3["id_banco_arrecadador"];
                                                                    $id_boleto_avulso         = $res3["id_boleto_avulso"];

                                                                    //echo 'teste' . $id_unidade_consumidora;

                                                                    if ($data_pagamento_fatura == '') {
                                                                        $status = "<span style='color: red;'>Verificar</span>";
                                                                    } elseif ($data_pagamento_fatura == $data_recebimento_fatura) {
                                                                        $status = "<span style='color: green;'>OK</span>";
                                                                    }

                                                        ?>

                                                                    <tr>

                                                                        <td><?php echo $id_localidade; ?></td>
                                                                        <td><?php echo $id_unidade_consumidora; ?></td>
                                                                        <td><?php echo $mes_faturado; ?></td>
                                                                        <td><?php echo $data_pagamento_fatura; ?></td>
                                                                        <td><?php echo $id_boleto_avulso; ?></td>
                                                                        <td><?php echo $status; ?></td>


                                                                    </tr>

                                                        <?php }
                                                            }
                                                        } ?>


                                                    </tbody>
                                                    <tfoot>
                                                        <tr>



                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>

                                                            <td>
                                                                <span class="text-muted">N° Boletos Avulsos: <?php echo $linha_count ?> </span>
                                                            </td>
                                                        </tr>

                                                    </tfoot>
                                                </table>

                                            <?php
                                            }

                                            ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <!-- Parcelas e serviços -->

        <div id="conteudo-right">

            <div class="container ml-4">


                <br>


                <div class="content">
                    <div class="row mr-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="col-md-12">
                                            <h5 class="text-center">Faturas Normais, Acordos e Serviços</h5>
                                        </div>

                                        <!--LISTAR TODOS OS BAIRROS -->
                                        <?php

                                            $query = "SELECT * from cx_caixa_permanente where data_recebimento_fatura = '$nome' and tipo_arrecadacao IN (1000, 2000, 3000) order by id_unidade_consumidora desc ";

                                            $result_count = mysqli_query($conexao, $query);


                                            $result = mysqli_query($conexao, $query);

                                            $linha = mysqli_num_rows($result);
                                            $linha_count = mysqli_num_rows($result_count);

                                            if ($linha == '') {
                                                echo "<h4 style='color: red;'> Não há lançamentos para esse tipo de movimento!!! </h4>";
                                            } else {

                                        ?>


                                            <table class="table table-sm">
                                                <thead class="text-secondary">

                                                    <th>
                                                        Localidade
                                                    </th>
                                                    <th>
                                                        UC
                                                    </th>
                                                    <th>
                                                        Data de Pagamento
                                                    </th>
                                                    <th>
                                                        Tipo de Fatura
                                                    </th>
                                                    <th>
                                                        Mês Fatura
                                                    </th>
                                                    <th>
                                                        Valor
                                                    </th>
                                                    <th>
                                                        Status
                                                    </th>

                                                </thead>
                                                <tbody>

                                                    <?php
                                                    while ($res = mysqli_fetch_array($result)) {
                                                        $data_recebimento_fatura2   = $res["data_recebimento_fatura"];
                                                        $id_localidade2           = $res["id_localidade"];
                                                        $id_unidade_consumidora2  = $res["id_unidade_consumidora"];
                                                        $valor_total_arrecadacao2  = $res["valor_total_arrecadacao"];
                                                        $tipo_arrecadacao2    = $res["tipo_arrecadacao"];
                                                        $data_vencimento_fatura    = $res["data_vencimento_fatura"];
                                                        $mes_fatura_arrecadada    = $res["mes_fatura_arrecadada"];

                                                        if ($tipo_arrecadacao2 == 3000) {
                                                            $tipo_arrecadacao = 'Boleto de Serviço';
                                                        } elseif ($tipo_arrecadacao2 == 2000) {
                                                            $tipo_arrecadacao = 'Entrada de Acordo';
                                                        } elseif ($tipo_arrecadacao2 == 1000) {
                                                            $tipo_arrecadacao = 'Fatura Normal';
                                                        }

                                                        if ($tipo_arrecadacao2 == 2000) {
                                                            //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                                                            $query_a = "SELECT * from acordos where id_localidade = '$id_localidade2' and id_unidade_consumidora = '$id_unidade_consumidora2' and valor_parcela = '$valor_total_arrecadacao2' and numero_parcela = '00/00' ";
                                                            $result_a = mysqli_query($conexao, $query_a);
                                                            $row_a = mysqli_fetch_array($result_a);
                                                            $data_pagamento_parcela = $row_a['data_pagamento_parcela'];

                                                            if ($data_recebimento_fatura2 == $data_pagamento_parcela && $id_banco_arrecadador == 999) {
                                                                $status2 = "<span style='color: green;'>OK</span>";
                                                            } else {
                                                                $status2 = "<span style='color: red;'>Verificar</span>";
                                                            }
                                                        } elseif ($tipo_arrecadacao2 == 3000) {
                                                            //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                                                            $query_a = "SELECT * from controle_boleto_servico where id_unidade_consumidora = '$id_unidade_consumidora2' and valor_boleto = '$valor_total_arrecadacao2' and data_vencimento_boleto = '$data_vencimento_fatura' ";
                                                            $result_a = mysqli_query($conexao, $query_a);
                                                            $row_a = mysqli_fetch_array($result_a);
                                                            $data_pagamento_boleto = $row_a['data_pagamento_boleto'];

                                                            if ($data_recebimento_fatura2 == $data_pagamento_boleto) {
                                                                $status2 = "<span style='color: green;'>OK</span>";
                                                            } else {
                                                                $status2 = "<span style='color: red;'>Verificar</span>";
                                                            }
                                                        } elseif ($tipo_arrecadacao2 == 1000) {
                                                            //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                                                            $query_a = "SELECT * from historico_financeiro where id_localidade = '$id_localidade2' and id_unidade_consumidora = '$id_unidade_consumidora2' and mes_faturado = '$mes_fatura_arrecadada' ";
                                                            $result_a = mysqli_query($conexao, $query_a);
                                                            $row_a = mysqli_fetch_array($result_a);
                                                            $data_pagamento_fatura = $row_a['data_pagamento_fatura'];

                                                            if ($data_pagamento_fatura == '') {
                                                                $status2 = "<span style='color: red;'>Verificar</span>";
                                                            } elseif ($data_pagamento_fatura == $data_recebimento_fatura2) {
                                                                $status2 = "<span style='color: green;'>OK</span>";
                                                            }
                                                        }


                                                    ?>

                                                        <tr>

                                                            <td><?php echo $id_localidade2; ?></td>
                                                            <td><?php echo $id_unidade_consumidora2; ?></td>
                                                            <td><?php echo $data_recebimento_fatura2; ?></td>
                                                            <td><?php echo $tipo_arrecadacao; ?></td>
                                                            <td><?php echo $mes_fatura_arrecadada; ?></td>
                                                            <td><?php echo $valor_total_arrecadacao2; ?></td>
                                                            <td><?php echo $status2; ?></td>





                                                        </tr>

                                                    <?php } ?>


                                                </tbody>
                                                <tfoot>
                                                    <tr>



                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>


                                                        <td>
                                                            <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                                                        </td>
                                                    </tr>

                                                </tfoot>
                                            </table>

                                    <?php
                                            }
                                        }

                                    ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div><!-- aqui fechamos a div conteudo -->


</body>

</html>
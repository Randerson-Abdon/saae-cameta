<?php
@session_start(); # Deve ser a primeira linha do arquivo
include_once('../controller/controller_lancamento_da.php');
include_once('../../conexao.php');


@$excluir       = $_POST['excluir'];
$slBuscar      = $_POST['slBuscar'];
$id_operador   = $_SESSION['id_usuario'];

if ($slBuscar == 'uc') {
    $id_localidade = $_POST['localidade'];
    $id_unidade_consumidora = $_POST['id_unidade_consumidora'];

    //executa o store procedure info consumidor
    $result_sp = mysqli_query(
        $conexao,
        "CALL sp_seleciona_unidade_consumidora($id_localidade,$id_unidade_consumidora);"
    ) or die("Erro na query da procedure: " . mysqli_error($conexao));
    mysqli_next_result($conexao);
    $row_uc = mysqli_fetch_array($result_sp);
    $nome_razao_social        = $row_uc['NOME'];
    $tipo_juridico            = $row_uc['TIPO_JURIDICO'];
    $numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
    $numero_rg                = $row_uc['N.º RG'];
    $orgao_emissor_rg         = $row_uc['ORGAO_EMISSOR'];
    $uf_rg                    = $row_uc['UF'];
    $fone_fixo                = $row_uc['FONE_FIXO'];
    $fone_movel               = $row_uc['CELULAR'];
    $fone_zap                 = $row_uc['ZAP'];
    $email                    = $row_uc['EMAIL'];
    $tipo_consumo             = $row_uc['TIPO_CONSUMO'];
    $faixa_consumo            = $row_uc['FAIXA'];
    $tipo_medicao             = $row_uc['MEDICAO'];
    $id_unidade_hidrometrica  = '';
    $valor_faixa_consumo      = $row_uc['VALOR'];
    $nome_localidade          = $row_uc['LOCALIDADE'];
    $nome_bairro              = $row_uc['BAIRRO'];
    $nome_logradouro          = $row_uc['LOGRADOURO'];
    $numero_logradouro        = $row_uc['NUMERO'];
    $complemento_logradouro   = $row_uc['COMPLEMENTO'];
    $cep_logradouro           = $row_uc['CEP'];
    $tipo_enderecamento       = $row_uc['CORRESPONDENCIA'];
    $status_ligacao           = $row_uc['STATUS'];
    $data_cadastro            = $row_uc['CADASTRO'];
    $observacoes_text         = $row_uc['OBSERVAÇÕES'];
    $id_bairro                = $row_uc['BAIR'];
    $id_logradouro            = $row_uc['LOG'];

?>

    <!DOCTYPE html>
    <html lang="en" style="width: 110%;">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <h1 style="font-size: 30px;">
            <title> Listagem Notificação Extrajudicial </title>
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
                                    include_once('../../conexao.php');

                                    //echo $id_localidade . ', ' . $id_bairro . ', ' . $id_logradouro;


                                    $result_lista = listaNotificacao_uc_sp($id_localidade, $id_unidade_consumidora);

                                    $linha = mysqli_num_rows($result_lista);
                                    $linha_count = mysqli_num_rows($result_lista);

                                    if ($linha_count == '') {
                                        echo "<h3 class='text-danger'> Não foram encontrados registros com esses parametros!!! </h3>";
                                    } else {

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

                                        <table style="margin-bottom: 15px; margin-left: 30px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 36%; height: 100%;"><img width="90%" src="../../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                                                    <th>
                                                        <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                                                            SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                                                            SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                            LISTAGEM DE NOTIFICAÇÃO DE DÉBITOS ‐ Data <?php echo @$data ?><br>
                                                            ENDEREÇO: <?php echo 'BAIRRO ' . $nome_bairro . ', ' . $nome_logradouro . ' N° ' . $numero_logradouro . ', ' . $nome_localidade . ' ' . $complemento_logradouro ?></p>
                                                    </th>
                                                </tr>

                                        </table>

                                        <table class="table table-sm table-bordered table-striped" style="margin-top: -20px;">

                                            <thead>

                                                <th style="background-color: darkgrey !important;">
                                                    Nº Not.
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    N° Mat.
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Nome Consumidor
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Situação
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Qtd.
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Tarifa
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Acordos
                                                </th>
                                                <th class="text-danger" style="background-color: darkgrey !important;">
                                                    ¹Multas
                                                </th>
                                                <th class="text-danger" style="background-color: darkgrey !important;">
                                                    ¹Juros
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Faturado
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    ²Multas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    ²Juros
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Total Geral
                                                </th>

                                            </thead>
                                            <tbody>

                                                <?php
                                                while ($res = mysqli_fetch_array($result_lista)) {
                                                    $id_notificacao         = $res["ID NOT"];
                                                    $nome_razao_social      = $res["NOME DO CLIENTE"];
                                                    $id_unidade_consumidora = $res["N. UC."];
                                                    $status_ligacao         = $res["SIT. LIG."];
                                                    $numero_meses           = $res["N. MESES"];
                                                    $total_tarifas          = $res["TARIFAS"];
                                                    $total_acordos          = $res["ACORDOS"];
                                                    $total_multas           = $res["(*) MULTAS"];
                                                    $total_juros            = $res["(*) JUROS"];
                                                    $total_faturado         = $res["FATURADO"];
                                                    $multas_atualizadas     = $res["(+) MULTAS"];
                                                    $juros_atualizados      = $res["(+) JUROS"];
                                                    $total_geral            = $res["TOTAL"];


                                                ?>

                                                    <tr>

                                                        <td><?php echo $id_notificacao; ?></td>
                                                        <td><?php echo $id_unidade_consumidora; ?></td>
                                                        <td><?php echo $nome_razao_social; ?></td>
                                                        <td><?php echo $status_ligacao; ?></td>
                                                        <td><?php echo $numero_meses; ?></td>
                                                        <td><?php echo $total_tarifas; ?></td>
                                                        <td><?php echo $total_acordos; ?></td>
                                                        <td class="text-danger"><?php echo $total_multas; ?></td>
                                                        <td class="text-danger"><?php echo $total_juros; ?></td>
                                                        <td><?php echo $total_faturado; ?></td>
                                                        <td><?php echo $multas_atualizadas; ?></td>
                                                        <td><?php echo $juros_atualizados; ?></td>
                                                        <td><?php echo $total_geral; ?></td>

                                                    </tr>

                                            <?php }
                                            } ?>

                                            </tbody>




                                        </table>

                                        </form>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8" style="margin-top: 100px;">
                                        <label for="fornecedor">FISCAL/NOTIFICADOR:</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fornecedor">RECEBI AS NOTIFICAÇÕES CONSTANTES NESTA RELAÇÃO EM : ____/____/______</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fornecedor">ASSINATURA: ___________________________________________________________________________</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>


    </body>

    </html>







<?php


} elseif ($slBuscar == 'endereco') {

    $id_localidade = $_POST['id_localidade'];
    $id_bairro     = $_POST['id_bairro'];
    $id_logradouro = $_POST['id_logradouro'];

?>

    <!DOCTYPE html>
    <html lang="en" style="width: 110%;">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <h1 style="font-size: 30px;">
            <title> Listagem Notificação Extrajudicial </title>
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
                                    include_once('../../conexao.php');

                                    //echo $id_localidade . ', ' . $id_bairro . ', ' . $id_logradouro;


                                    $result_lista = listaNotificacao_sp($id_localidade, $id_bairro, $id_logradouro);

                                    $linha = mysqli_num_rows($result_lista);
                                    $linha_count = mysqli_num_rows($result_lista);

                                    if ($linha_count == '') {
                                        echo "<h3 class='text-danger'> Não foram encontrados registros com esses parametros!!! </h3>";
                                    } else {

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

                                        //trazendo info logradouro
                                        $query_ps = "SELECT * FROM enderecamento_logradouro WHERE id_localidade = '$id_localidade' AND id_bairro = '$id_bairro' AND id_logradouro = '$id_logradouro' ";
                                        $result_ps = mysqli_query($conexao, $query_ps);
                                        $row_ps = mysqli_fetch_array($result_ps);
                                        $nome_logradouro = $row_ps['nome_logradouro'];
                                        $tipo_logradouro = $row_ps['tipo_logradouro'];

                                        //trazendo info tipo_logradouro
                                        $query_tipo = "SELECT * FROM tipo_logradouro WHERE id_tipo_logradouro = '$tipo_logradouro' ";
                                        $result_tipo = mysqli_query($conexao, $query_tipo);
                                        $row_tipo = mysqli_fetch_array($result_tipo);
                                        $descricao_tipo_logradouro = $row_tipo['descricao_tipo_logradouro'];

                                    ?>

                                        <table style="margin-bottom: 15px; margin-left: 30px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 36%; height: 100%;"><img width="90%" src="../../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                                                    <th>
                                                        <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                                                            SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                                                            SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                            LISTAGEM DE NOTIFICAÇÃO DE DÉBITOS ‐ Data <?php echo @$data ?><br>
                                                            LOGRADOURO: <?php echo $descricao_tipo_logradouro . ' ' . $nome_logradouro ?></p>
                                                    </th>
                                                </tr>

                                        </table>

                                        <table class="table table-sm table-bordered table-striped" style="margin-top: -20px;">

                                            <thead>

                                                <th style="background-color: darkgrey !important;">
                                                    Nº Not.
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    N° Mat.
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Nome Consumidor
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Situação
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Qtd.
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Tarifa
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Acordos
                                                </th>
                                                <th class="text-danger" style="background-color: darkgrey !important;">
                                                    ¹Multas
                                                </th>
                                                <th class="text-danger" style="background-color: darkgrey !important;">
                                                    ¹Juros
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Faturado
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    ²Multas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    ²Juros
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Total Geral
                                                </th>

                                            </thead>
                                            <tbody>

                                                <?php

                                                $qty = 0;
                                                $qty1 = 0;
                                                $qty2 = 0;
                                                $qty3 = 0;
                                                $qty4 = 0;
                                                $qty5 = 0;
                                                $qty6 = 0;
                                                $qty7 = 0;
                                                while ($res = mysqli_fetch_array($result_lista)) {
                                                    $id_notificacao         = $res["ID NOT"];
                                                    $nome_razao_social      = $res["NOME DO CLIENTE"];
                                                    $id_unidade_consumidora = $res["N. UC."];
                                                    $status_ligacao         = $res["SIT. LIG."];
                                                    $numero_meses           = $res["N. MESES"];
                                                    $total_tarifas          = $res["TARIFAS"];
                                                    $total_acordos          = $res["ACORDOS"];
                                                    $total_multas           = $res["(*) MULTAS"];
                                                    $total_juros            = $res["(*) JUROS"];
                                                    $total_faturado         = $res["FATURADO"];
                                                    $multas_atualizadas     = $res["(+) MULTAS"];
                                                    $juros_atualizados      = $res["(+) JUROS"];
                                                    $total_geral            = $res["TOTAL"];

                                                    //totalização  

                                                    $qty7 += formataMoeda($total_acordos);
                                                    $t_total_acordos = number_format($qty7, 2, ",", ".");

                                                    $qty6 += formataMoeda($total_tarifas);
                                                    $t_total_tarifas = number_format($qty6, 2, ",", ".");

                                                    $qty5 += formataMoeda($total_multas);
                                                    $t_total_multas = number_format($qty5, 2, ",", ".");

                                                    $qty4 += formataMoeda($total_juros);
                                                    $t_total_juros = number_format($qty4, 2, ",", ".");

                                                    $qty3 += formataMoeda($total_faturado);
                                                    $t_total_faturado = number_format($qty3, 2, ",", ".");

                                                    $qty2 += formataMoeda($multas_atualizadas);
                                                    $t_multas_atualizadas = number_format($qty2, 2, ",", ".");

                                                    $qty1 += formataMoeda($juros_atualizados);
                                                    $t_juros_atualizados = number_format($qty1, 2, ",", ".");

                                                    $qty += formataMoeda($total_geral);
                                                    $t_total_geral = number_format($qty, 2, ",", ".");


                                                ?>

                                                    <tr>

                                                        <td><?php echo $id_notificacao; ?></td>
                                                        <td><?php echo $id_unidade_consumidora; ?></td>
                                                        <td><?php echo $nome_razao_social; ?></td>
                                                        <td><?php echo $status_ligacao; ?></td>
                                                        <td><?php echo $numero_meses; ?></td>
                                                        <td><?php echo $total_tarifas; ?></td>
                                                        <td><?php echo $total_acordos; ?></td>
                                                        <td class="text-danger"><?php echo $total_multas; ?></td>
                                                        <td class="text-danger"><?php echo $total_juros; ?></td>
                                                        <td><?php echo $total_faturado; ?></td>
                                                        <td><?php echo $multas_atualizadas; ?></td>
                                                        <td><?php echo $juros_atualizados; ?></td>
                                                        <td><?php echo $total_geral; ?></td>

                                                    </tr>

                                            <?php }
                                            } ?>

                                            </tbody>

                                        </table>

                                        </form>






                                        <table class="table table-sm table-bordered table-striped" style="margin-top: 40px;">
                                            <thead>

                                                <th style="background-color: darkgrey !important;">
                                                    TOTAIS DESTE LOGRADOURO
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Ativas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Inativas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Matrículas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Tarifas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Acordos
                                                </th>
                                                <th class="text-danger" style="background-color: darkgrey !important;">
                                                    ¹Multas
                                                </th>
                                                <th class="text-danger" style="background-color: darkgrey !important;">
                                                    ¹Juros
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Faturado
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    ²Multas
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    ²Juros
                                                </th>
                                                <th style="background-color: darkgrey !important;">
                                                    Total Geral
                                                </th>


                                            </thead>
                                            <tbody>

                                                <tr>

                                                    <td></td>
                                                    <td><?php echo ativasInativas($id_localidade, $id_bairro, $id_logradouro, 'A') ?></td>
                                                    <td><?php echo ativasInativas($id_localidade, $id_bairro, $id_logradouro, 'I') ?></td>
                                                    <td><?php echo $linha_count; ?></td>
                                                    <td>R$ <?php echo $t_total_tarifas; ?></td>
                                                    <td>R$ <?php echo $t_total_acordos; ?></td>
                                                    <td class="text-danger">R$ <?php echo $t_total_multas; ?></td>
                                                    <td class="text-danger">R$ <?php echo $t_total_juros; ?></td>
                                                    <td>R$ <?php echo $t_total_faturado; ?></td>
                                                    <td>R$ <?php echo $t_multas_atualizadas; ?></td>
                                                    <td>R$ <?php echo $t_juros_atualizados; ?></td>
                                                    <td>R$ <?php echo $t_total_geral; ?></td>

                                                </tr>

                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">
                                                        <span class="text-muted">(¹) Multas e Juros Faturados </span>
                                                    </td>

                                                    <td colspan="4">
                                                        <span class="text-muted">(²) Multas e Juros Atualizados </span>
                                                    </td>
                                                </tr>

                                            </tfoot>

                                        </table>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label for="fornecedor">FISCAL/NOTIFICADOR:</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fornecedor">RECEBI AS NOTIFICAÇÕES CONSTANTES NESTA RELAÇÃO EM : ____/____/______</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fornecedor">ASSINATURA: ___________________________________________________________________________</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>




    </body>

    </html>


<?php } ?>
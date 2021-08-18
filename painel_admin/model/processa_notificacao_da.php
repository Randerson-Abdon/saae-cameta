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
            <title> Notificação Extrajudicial </title>
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
            body {
                overflow: hidden;
            }

            img.face {
                float: right;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px 10px 10px 0px;
                max-width: 1386px;
                margin-left: 1270px;
                margin-top: -100px;
            }

            img.face2 {
                float: left;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px -250px 10px 0;
                max-width: 1386px;
                margin-top: 30px;
            }

            span.espaco {
                margin-left: 100px;
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
                                            $data_lançamento        = $res["DTA. LCTO N.E."];
                                            $descricao_meses        = $res["DESCRIÇÃO DE MESES"];
                                            $logradouro             = $res["ENDEREÇO"];
                                            $numero                 = $res["NUMERO"];
                                            $bairro                 = $res["BAIRRO"];
                                            $localidade             = $res["LOCALIDADE"];



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
                                            @$nome_municipio_saae = $row_ps['nome_municipio'];
                                            @$uf_saae = $row_ps['uf_saae'];
                                            @$nome_saae = $row_ps['nome_saae'];
                                            @$email_saae = $row_ps['email_saae'];
                                            @$logo_orgao = $row_ps['logo_orgao'];
                                            @$logo_prefeitura = $row_ps['logo_prefeitura'];

                                            $data = date('d/m/Y');


                                    ?>

                                            <table style="margin-bottom: 15px; margin-left: 30px;">
                                                <thead>
                                                    <tr>
                                                        <th>

                                                            <img class="face2" width="20%" src="../../img/parametros/<?php echo $logo_orgao; ?>" alt="">

                                                            <img class="face" width="20%" src="../../img/parametros/<?php echo $logo_prefeitura; ?>" alt="">

                                                            <p class="text-center" style="margin-top: 18px;">


                                                                <?php echo $nome_prefeitura . ' - ' . $uf_saae; ?> <br>
                                                                <?php echo $nome_saae; ?> <br>
                                                                S DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                                <span style="font-size: 30pt;">NOTIFICAÇÃO EXTRAJUDICIAL</span> <br>
                                                            </p>

                                                        </th>
                                                    </tr>
                                            </table>

                                            <hr>
                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%;">

                                                <tr>
                                                    <th>

                                                        <p class="text-center" style="margin-top: 18px; ">
                                                            N.º do registro: <?php echo $id_notificacao; ?><span class="espaco"></span>
                                                            Data de Lançamento: <?php echo $data_lançamento; ?> <br>
                                                        </p>

                                                    </th>
                                                </tr>
                                            </table>

                                            <hr>
                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%;">

                                                <tr>
                                                    <th>

                                                        <p class="text-center" style="margin-top: 18px; font-size: 15pt; ">
                                                            COMPOSIÇÃO FINANCEIRA DE DÉBITOS
                                                        </p>

                                                        <div class="form-group col-md-12" style="margin-left: -30px;">
                                                            <label for="formControlTextarea">Discrição dos meses:</label>
                                                            <label style="float: right;" for="formControlTextarea">Quantidade de meses: <?php echo $numero_meses; ?></label>
                                                            <textarea style="font-size: 14pt; font-weight: bold;" class="form-control" id="" rows="6"> <?php echo $descricao_meses; ?> </textarea>
                                                        </div>

                                                    </th>
                                                </tr>
                                            </table>

                                            <hr>
                                            <hr>

                                            <table class="table table-sm table-bordered table-striped" style="margin-top: -20px; font-size: 12pt; font-weight: bold;">

                                                <thead>

                                                    <th style="background-color: darkgrey !important; font-size: 14pt;">
                                                        Tarifas
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 14pt;">
                                                        Acordos
                                                    </th>
                                                    <th class="text-danger" style="background-color: darkgrey !important; font-size: 14pt;">
                                                        ¹Multas
                                                    </th>
                                                    <th class="text-danger" style="background-color: darkgrey !important; font-size: 14pt;">
                                                        ¹Juros
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 14pt;">
                                                        Faturado
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 14pt;">
                                                        ²Multas
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 14pt;">
                                                        ²Juros
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 14pt;">
                                                        Total Geral
                                                    </th>

                                                </thead>
                                                <tbody>

                                                    <tr>

                                                        <td style="font-size: 14pt;"><?php echo $total_tarifas; ?></td>
                                                        <td style="font-size: 14pt;"><?php echo $total_acordos; ?></td>
                                                        <td style="font-size: 14pt;" class="text-danger"><?php echo $total_multas; ?></td>
                                                        <td style="font-size: 14pt;" class="text-danger"><?php echo $total_juros; ?></td>
                                                        <td style="font-size: 14pt;"><?php echo $total_faturado; ?></td>
                                                        <td style="font-size: 14pt;"><?php echo $multas_atualizadas; ?></td>
                                                        <td style="font-size: 14pt;"><?php echo $juros_atualizados; ?></td>
                                                        <td style="font-size: 14pt;"><?php echo $total_geral; ?></td>

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

                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%; font-size: 14pt;">

                                                <tr>
                                                    <th>

                                                        <p class="text-justify" style="margin-top: 18px; width: 96%; ">
                                                            <span class="espaco"></span>Prezado (a) Sr.(a), informamos a Vossa Senhoria que constam em nossos registros a pendência de pagamento de valores relativos ao fornecimento de água prestado por esta Autarquia Municipal – <?php echo $nome_saae; ?>, referentes ao(s) período(s) e naturezas indicados, devidamente discriminado(s) nesta NOTIFICAÇÃO DE DÉBITO. Sendo assim, solicitamos o seu comparecimento ao departamento administrativo desta Autarquia, situada na <?php echo $nome_logradouro_saae . ' ' . $numero_imovel_saae . ', Bairro ' . $nome_bairro_saae; ?>, no horário de 8:00 h às 12:00 h e das 13:30 h às 17:00 h, no prazo de até 30 (trinta) dias, contados a partir do recebimento
                                                            desta, com a finalidade de que Vossa Senhoria promova a regularização desta(s) pendência(s) através da quitação total, ou através de parcelamento dos valores demonstrados, ou ainda, através da apresentação escrita de defesa na contestação deste(s) valor(es). Findo o prazo e, não havendo qualquer manifestação de vossa parte no sentido de regularizar esta(s)
                                                            pendência(s), serão adotadas as medidas administrativas (NDA - NOTIFICAÇÃO DE DÍVIDA ATIVA), e posteriormente, ações jurídicas (EXECUÇÃO FISCAL). Por fim, informamos-lhe que os valores estão atualizados com multa, correção
                                                            monetária e juros de mora, nos moldes do art. 4 da Lei Municipal nº 324/2015, até a presente data, sendo passível de atualização nos termos da lei e, em caso de eventual demanda judicial, serão acrescidos ainda, os devidos honorários advocatícios. <br>
                                                            <span class="espaco"></span>No aguardo de seu pronto atendimento a presente , subscrevemos. <br><br><br>

                                                            <span style="float: right;"><?php echo $nome_municipio_saae; ?> (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                                                                                    date_default_timezone_set('America/Sao_Paulo');
                                                                                                                                    echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br>
                                                        </p>



                                                    </th>
                                                </tr>
                                            </table>

                                            <hr>
                                            <img width="100%" src="../img/corte.jpg" alt="">
                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%;">

                                                <tr>
                                                    <th>

                                                        <p class="text-center" style="margin-top: 18px; font-size: 15pt; ">
                                                            RESGISTRO DA NOTIFICAÇÃO
                                                        </p>
                                                        <P>
                                                            N° do registro: <?php echo $id_notificacao; ?>
                                                            <span class="espaco"></span>
                                                            Data do Lançamento: <?php echo $data_lançamento; ?><br>
                                                            Matrícula: <?php echo $id_unidade_consumidora; ?>
                                                            <span class="espaco"></span>
                                                            Situação da ligação: <?php echo $status_ligacao; ?><br>
                                                            Nome: <?php echo $nome_razao_social; ?>
                                                            <span class="espaco"></span>
                                                            Endereço: <?php echo $logradouro . ' N° ' . $numero . ', ' . $localidade; ?><br><br><br>
                                                            EU, ________________________________________________________________________________________________________________, recebi a presente notificação em ___/___/______ às ___:___ horas. <br><br>
                                                            ASSINATURA: _________________________________________________________________________________________________________________ <br><br>
                                                            CPF.:_______________________________________________________________________ <span class="espaco"></span> RG.:_______________________________________________________________________ <br><br><br><br>

                                                        <div class="row">
                                                            <div class="form-group text-center col-md-12" style="margin-top: 50px;">
                                                                <label for="fornecedor">_________________________________________________________</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group text-center col-md-12" style="margin-top: -30px;">
                                                                <label class="ml-20" for="fornecedor">Notificador</label>
                                                            </div>
                                                        </div>

                                                        </P>

                                                    </th>
                                                </tr>
                                            </table>

                                    <?php
                                        }
                                    } ?>

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
            <title> Notificação Extrajudicial </title>
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
            body {
                overflow: hidden;
            }

            img.face {
                float: right;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px 10px 10px 0px;
                max-width: 1386px;
                margin-left: 1270px;
                margin-top: -100px;
            }

            img.face2 {
                float: left;
                border: transparent thin solid;
                padding: 5px;
                margin: 0px -250px 10px 0;
                max-width: 1386px;
                margin-top: 30px;
            }

            span.espaco {
                margin-left: 100px;
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


                                    $result_lista = listaNotificacao_log_sp($id_localidade, $id_bairro, $id_logradouro);

                                    $linha = mysqli_num_rows($result_lista);
                                    $linha_count = mysqli_num_rows($result_lista);

                                    if ($linha_count == '') {
                                        echo "<h3 class='text-danger'> Não foram encontrados registros com esses parametros!!! </h3>";
                                    } else {

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
                                            $data_lançamento        = $res["DTA. LCTO N.E."];
                                            $descricao_meses        = $res["DESCRIÇÃO DE MESES"];
                                            $logradouro             = $res["ENDEREÇO"];
                                            $numero                 = $res["NUMERO"];
                                            $bairro                 = $res["BAIRRO"];
                                            $localidade             = $res["LOCALIDADE"];



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
                                            @$nome_municipio_saae = $row_ps['nome_municipio'];
                                            @$uf_saae = $row_ps['uf_saae'];
                                            @$nome_saae = $row_ps['nome_saae'];
                                            @$email_saae = $row_ps['email_saae'];
                                            @$logo_orgao = $row_ps['logo_orgao'];
                                            @$logo_prefeitura = $row_ps['logo_prefeitura'];

                                            $data = date('d/m/Y');


                                    ?>

                                            <table style="margin-bottom: 15px; margin-left: 30px;">
                                                <thead>
                                                    <tr>
                                                        <th>

                                                            <img class="face2" width="20%" src="../../img/parametros/<?php echo $logo_orgao; ?>" alt="">

                                                            <img class="face" width="20%" src="../../img/parametros/<?php echo $logo_prefeitura; ?>" alt="">

                                                            <p class="text-center" style="margin-top: 18px;">


                                                                <?php echo $nome_prefeitura . ' - ' . $uf_saae; ?> <br>
                                                                <?php echo $nome_saae; ?> <br>
                                                                SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                                <span style="font-size: 30pt;">NOTIFICAÇÃO EXTRAJUDICIAL</span> <br>
                                                            </p>

                                                        </th>
                                                    </tr>
                                            </table>

                                            <hr>
                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%;">

                                                <tr>
                                                    <th>

                                                        <p class="text-center" style="margin-top: 18px; ">
                                                            N.º do registro: <?php echo $id_notificacao; ?><span class="espaco"></span>
                                                            Data de Lançamento: <?php echo $data_lançamento; ?> <br>
                                                        </p>

                                                    </th>
                                                </tr>
                                            </table>

                                            <hr>
                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%;">

                                                <tr>
                                                    <th>

                                                        <p class="text-center" style="margin-top: 18px; font-size: 15pt; ">
                                                            COMPOSIÇÃO FINANCEIRA DE DÉBITOS
                                                        </p>

                                                        <div class="form-group col-md-12" style="margin-left: -30px;">
                                                            <label for="formControlTextarea">Discrição dos meses:</label>
                                                            <label style="float: right;" for="formControlTextarea">Quantidade de meses: <?php echo $numero_meses; ?></label>
                                                            <textarea style="font-size: 14pt; font-weight: bold;" class="form-control" id="" rows="5"> <?php echo $descricao_meses; ?> </textarea>
                                                        </div>

                                                    </th>
                                                </tr>
                                            </table>

                                            <hr>
                                            <hr>

                                            <table class="table table-sm table-bordered table-striped" style="margin-top: -20px; font-size: 12pt; font-weight: bold;">

                                                <thead>

                                                    <th style="background-color: darkgrey !important; font-size: 12pt;">
                                                        Tarifas
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 12pt;">
                                                        Acordos
                                                    </th>
                                                    <th class="text-danger" style="background-color: darkgrey !important; font-size: 12pt;">
                                                        ¹Multas
                                                    </th>
                                                    <th class="text-danger" style="background-color: darkgrey !important; font-size: 12pt;">
                                                        ¹Juros
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 12pt;">
                                                        Faturado
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 12pt;">
                                                        ²Multas
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 12pt;">
                                                        ²Juros
                                                    </th>
                                                    <th style="background-color: darkgrey !important; font-size: 12pt;">
                                                        Total Geral
                                                    </th>

                                                </thead>
                                                <tbody>

                                                    <tr>

                                                        <td style="font-size: 12pt;"><?php echo $total_tarifas; ?></td>
                                                        <td style="font-size: 12pt;"><?php echo $total_acordos; ?></td>
                                                        <td style="font-size: 12pt;" class="text-danger"><?php echo $total_multas; ?></td>
                                                        <td style="font-size: 12pt;" class="text-danger"><?php echo $total_juros; ?></td>
                                                        <td style="font-size: 12pt;"><?php echo $total_faturado; ?></td>
                                                        <td style="font-size: 12pt;"><?php echo $multas_atualizadas; ?></td>
                                                        <td style="font-size: 12pt;"><?php echo $juros_atualizados; ?></td>
                                                        <td style="font-size: 12pt;"><?php echo $total_geral; ?></td>

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

                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%; font-size: 12pt;">

                                                <tr>
                                                    <th>

                                                        <p class="text-justify" style="margin-top: 18px; width: 96%; ">
                                                            <span class="espaco"></span>Prezado (a) Sr.(a), informamos a Vossa Senhoria que constam em nossos registros a pendência de pagamento de valores relativos ao fornecimento de água prestado por esta Autarquia Municipal – <?php echo $nome_saae; ?>, referentes ao(s) período(s) e naturezas indicados, devidamente discriminado(s) nesta NOTIFICAÇÃO DE DÉBITO. Sendo assim, solicitamos o seu comparecimento ao departamento administrativo desta Autarquia, situada na <?php echo $nome_logradouro_saae . ' ' . $numero_imovel_saae . ', Bairro ' . $nome_bairro_saae; ?>, no horário de 8:00 h às 12:00 h e das 13:30 h às 17:00 h, no prazo de até 30 (trinta) dias, contados a partir do recebimento
                                                            desta, com a finalidade de que Vossa Senhoria promova a regularização desta(s) pendência(s) através da quitação total, ou através de parcelamento dos valores demonstrados, ou ainda, através da apresentação escrita de defesa na contestação deste(s) valor(es). Findo o prazo e, não havendo qualquer manifestação de vossa parte no sentido de regularizar esta(s)
                                                            pendência(s), serão adotadas as medidas administrativas (NDA - NOTIFICAÇÃO DE DÍVIDA ATIVA), e posteriormente, ações jurídicas (EXECUÇÃO FISCAL). Por fim, informamos-lhe que os valores estão atualizados com multa, correção
                                                            monetária e juros de mora, nos moldes do art. 4 da Lei Municipal nº 324/2015, até a presente data, sendo passível de atualização nos termos da lei e, em caso de eventual demanda judicial, serão acrescidos ainda, os devidos honorários advocatícios. <br>
                                                            <span class="espaco"></span>No aguardo de seu pronto atendimento a presente , subscrevemos. <br><br><br>

                                                            <span style="float: right;"><?php echo $nome_municipio_saae; ?> (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                                                                                    date_default_timezone_set('America/Sao_Paulo');
                                                                                                                                    echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br>
                                                        </p>



                                                    </th>
                                                </tr>
                                            </table>

                                            <hr>
                                            <img width="100%" src="../img/corte.jpg" alt="">
                                            <hr>

                                            <table style="margin-bottom: 15px; margin-left: 30px; width: 100%; margin-bottom: 150px;">

                                                <tr>
                                                    <th>

                                                        <p class="text-center" style="margin-top: 18px; font-size: 15pt; ">
                                                            RESGISTRO DA NOTIFICAÇÃO
                                                        </p>
                                                        <P>
                                                            N° do registro: <?php echo $id_notificacao; ?>
                                                            <span class="espaco"></span>
                                                            Data do Lançamento: <?php echo $data_lançamento; ?><br>
                                                            Matrícula: <?php echo $id_unidade_consumidora; ?>
                                                            <span class="espaco"></span>
                                                            Situação da ligação: <?php echo $status_ligacao; ?><br>
                                                            Nome: <?php echo $nome_razao_social; ?>
                                                            <span class="espaco"></span>
                                                            Endereço: <?php echo $logradouro . ' N° ' . $numero . ', ' . $localidade; ?><br><br><br>
                                                            EU, ________________________________________________________________________________________________________________, recebi a presente notificação em ___/___/______ às ___:___ horas. <br><br>
                                                            ASSINATURA: _________________________________________________________________________________________________________________ <br><br>
                                                            CPF.:_______________________________________________________________________ <span class="espaco"></span> RG.:_______________________________________________________________________ <br><br><br><br><br><br>

                                                        <div class="row">
                                                            <div class="form-group text-center col-md-12" style="margin-top: 50px;">
                                                                <label for="fornecedor">_________________________________________________________</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group text-center col-md-12" style="margin-top: -30px;">
                                                                <label class="ml-20" for="fornecedor">Notificador</label>
                                                            </div>
                                                        </div>

                                                        </P>

                                                    </th>
                                                </tr>
                                            </table>



                                    <?php
                                        }
                                    } ?>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

    </body>

    </html>







<?php } ?>
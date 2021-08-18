<?php
include_once('../../conexao.php');
include_once('../controller/controller_contas_receber.php');

$id_localidade   = $_POST['id_localidade'];
$mes_competencia = $_POST['mes_competencia'];
$bairro = 0;


if ($mes_competencia == '') {
    echo "<script language='javascript'>window.alert('Informe um Mês de Competência!!!'); </script>";
    echo "<script language='javascript'>window.close(); </script>";
    exit();
}

//echo 'Competencia: ' . $mes_competencia;

//processa
$result_processa = processa_inadimplencia($id_localidade, $bairro, $mes_competencia);

//lista
$result = lista_inadimplencia($id_localidade, $bairro);

$linha_count = mysqli_num_rows($result);

$desc = extencoData($mes_competencia);

$titulo = strtolower($desc);

//echo $id_localidade . ', ' . $mes_competencia;

?>

<!DOCTYPE html>
<html lang="en" style="width: 110%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1 style="font-size: 30px;">
        <title> Relatório <?php echo ucwords($titulo); ?> </title>
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


            #imprimir {
                transform: rotate(90deg);
            }

        }

        td.direita {
            border-right-color: black !important;
        }

        th.direita {
            border-right-color: black !important;
        }

        td.esquerda {
            border-left-color: black !important;
        }

        th.esquerda {
            border-left-color: black !important;
        }

        td.topo {
            border-top-color: black !important;
        }

        th.topo {
            border-top-color: black !important;
        }

        td.fim {
            border-bottom-color: black !important;
        }

        th.fim {
            border-bottom-color: black !important;
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
            margin-left: 150px;
        }
    </style>



    <div class="container ml-4" id="imprimir" style="width: 210%;">

        <br>

        <div class="content" style="width: 110%;">
            <div class="row" style="width: 110%;">
                <div class="col-md-12" style="width: 110%;">

                    <!--TAMANHO DA TABELA -->
                    <div class="card-body" style="width: 130%; margin-left: 50px; margin-top: -250px !important;">
                        <div class="card" style="width: 120%; margin-left: -50px; border-color: black !important;">
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

                                <table style="margin-bottom: 15px; margin-left: 30px; height: 50px !important;">
                                    <thead>
                                        <tr>
                                            <th>

                                                <img class="face2" width="10%" src="../../img/sIzabel/saae.png" alt="">

                                                <img class="face" width="10%" src="../../img/sIzabel/prefeitura.png" alt="">

                                                <p class="text-center" style="margin-top: 40px; margin-left: 600px; position: absolute;">


                                                    <?php echo $nome_prefeitura . ' - ' . $uf_saae; ?> <br>
                                                    <?php echo $nome_saae; ?> <br>
                                                    SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                                                    RELATÓRIO DE CONTAS A RECEBER - <?php echo $data; ?> <br>
                                                    COMPETÊNCIA: <?php echo extencoData($mes_competencia); ?> <br>

                                                </p>

                                            </th>
                                        </tr>
                                </table>



                                <table class="table table-sm table-bordered table-striped" style="font-size: 10pt;">

                                    <thead colspan="2">

                                        <th class="topo direita esquerda" style="background-color: darkgrey !important; border-bottom-color: darkgrey !important;">

                                        </th>
                                        <th class="direita topo" colspan="5" style="background-color: darkgrey !important; border-bottom-color: darkgrey !important; ">

                                        </th>

                                        <th class="direita topo fim text-center" colspan="12" style="background-color: darkgrey !important; ">
                                            CONTAS A RECEBER POR BAIRRO/FAIXA

                                            <thead>

                                                <th class="direita esquerda" style="background-color: darkgrey !important; border-bottom-color: darkgrey !important;">

                                                </th>
                                                <th class="direita" colspan="5" style="background-color: darkgrey !important;">
                                                    <span style="position: absolute; margin-top: -36px !important; margin-left: 80px !important;">SITUAÇÃO CADASTRAL</span>
                                                </th>
                                                <th class="esquerda direita topo text-center" colspan="3" style="background-color: darkgrey !important;">
                                                    FAIXA "A"
                                                </th>
                                                <th class="direita topo text-center" colspan="3" style="background-color: darkgrey !important;">
                                                    FAIXA "B"
                                                </th>
                                                <th class="direita topo text-center" colspan="3" style="background-color: darkgrey !important;">
                                                    FAIXA "C"
                                                </th>
                                                <th class="direita topo text-center" colspan="3" style="background-color: darkgrey !important;">
                                                    FECHAMENTO GERAL
                                                </th>

                                            </thead>

                                        </th>



                                    </thead>

                                    <thead>

                                        <th class="direita esquerda" style="background-color: darkgrey !important;">
                                            <span style="position: absolute; margin-top: -60px !important; margin-left: 60px;">BAIRRO</span>
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important; width: 20px;">
                                            QTDE. ATIVAS
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important; width: 20px;">
                                            % ATIVAS
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important; width: 20px;">
                                            QTDE. INATIVAS
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important; width: 20px;">
                                            % INATIVAS
                                        </th>
                                        <th class="direita text-center" style="background-color: darkgrey !important; width: 20px; border-right-color: black !important;">
                                            TOTAL
                                        </th>

                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            QTDE
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            %
                                        </th>
                                        <th class="direita text-center" style="background-color: darkgrey !important;">
                                            TOTAL
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            QTDE
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            %
                                        </th>
                                        <th class="direita text-center" style="background-color: darkgrey !important;">
                                            TOTAL
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            QTDE
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            %
                                        </th>
                                        <th class="direita text-center" style="background-color: darkgrey !important;">
                                            TOTAL
                                        </th>

                                        <th class="text-center" style="background-color: darkgrey !important; width: 20px;">
                                            QTDE GERAL
                                        </th>
                                        <th class="text-center" style="background-color: darkgrey !important;">
                                            MÉDIA
                                        </th>
                                        <th class="direita text-center" style="background-color: darkgrey !important;">
                                            TOTAL GERAL
                                        </th>


                                    </thead>
                                    <tbody>

                                        <?php
                                        $qty1 = 0;
                                        while ($res = mysqli_fetch_array($result)) {
                                            $nome_bairro            = $res["BAIRRO"];
                                            $total_uc_ativa         = $res["QTDE.ATIVAS"];
                                            $percentual_uc_ativa    = $res["% ATIVAS"];
                                            $total_uc_inativa       = $res["QTDE.INAT"];
                                            $percentual_uc_inativa  = $res["% INAT"];
                                            $total_uc_cadastrada    = $res["CADASTROS"];

                                            $qtde_uc_faixa_a                  = $res["QTDE.FAIXA A"];
                                            $percentual_inadimplencia_faixa_a = $res["% FAIXA A"];
                                            $total_inadimplencia_faixa_a      = $res["TOTAL FAIXA A"];
                                            $qtde_uc_faixa_b                  = $res["QTDE.FAIXA B"];
                                            $percentual_inadimplencia_faixa_b = $res["% FAIXA B"];
                                            $total_inadimplencia_faixa_b      = $res["TOTAL FAIXA B"];
                                            $qtde_uc_faixa_c                  = $res["QTDE.FAIXA C"];
                                            $percentual_inadimplencia_faixa_c = $res["% FAIXA C"];
                                            $total_inadimplencia_faixa_c      = $res["TOTAL FAIXA C"];

                                            $qtde_geral_uc_faixas       = $res["QTDE. GERAL"];
                                            $media_uc_faixas = $res["MÉDIA"];
                                            $total_inadimplencia_faixas = $res["TOTAL GERAL"];

                                            /* $qty1 += $valor02;
                                            $totalGeralDebitos = $qty1; */

                                        ?>

                                            <tr>

                                                <td class="direita esquerda"><?php echo $nome_bairro; ?></td>
                                                <td class="text-right"><?php echo $total_uc_ativa; ?></td>
                                                <td class="text-right"><?php echo $percentual_uc_ativa; ?></td>
                                                <td class="text-right"><?php echo $total_uc_inativa; ?></td>
                                                <td class="text-right"><?php echo $percentual_uc_inativa; ?></td>
                                                <td class="direita text-right"><?php echo $total_uc_cadastrada; ?></td>

                                                <td class="text-right"><?php echo $qtde_uc_faixa_a; ?></td>
                                                <td class="text-right"><?php echo $percentual_inadimplencia_faixa_a; ?></td>
                                                <td class="direita text-right"><?php echo $total_inadimplencia_faixa_a; ?></td>

                                                <td class="text-right"><?php echo $qtde_uc_faixa_b; ?></td>
                                                <td class="text-right"><?php echo $percentual_inadimplencia_faixa_b; ?></td>
                                                <td class="direita text-right"><?php echo $total_inadimplencia_faixa_b; ?></td>

                                                <td class="text-right"><?php echo $qtde_uc_faixa_c; ?></td>
                                                <td class="text-right"><?php echo $percentual_inadimplencia_faixa_c; ?></td>
                                                <td class="direita text-right"><?php echo $total_inadimplencia_faixa_c; ?></td>

                                                <td class="text-right"><?php echo $qtde_geral_uc_faixas; ?></td>
                                                <td class="text-right"><?php echo $media_uc_faixas; ?></td>
                                                <td class="direita text-right"><?php echo $total_inadimplencia_faixas; ?></td>

                                            </tr>

                                        <?php }
                                        ?>

                                    </tbody>

                                    <?php

                                    $result_resumo = resumo_inadimplencia($id_localidade, $bairro);
                                    $row_resumo = mysqli_fetch_array($result_resumo);

                                    $total_ativas         = $row_resumo['QTDE.ATIVAS'];
                                    $total_media_ativas   = $row_resumo['% ATIVAS'];
                                    $total_inativas       = $row_resumo['QTDE.INAT'];
                                    $total_media_inativas = $row_resumo['% INAT'];
                                    $total_geral          = $row_resumo['CADASTROS'];

                                    $qtde_a  = $row_resumo['QTDE.FAIXA A'];
                                    $media_a = $row_resumo['% FAIXA A'];
                                    $total_a = $row_resumo['TOTAL FAIXA A'];

                                    $qtde_b  = $row_resumo['QTDE.FAIXA B'];
                                    $media_b = $row_resumo['% FAIXA B'];
                                    $total_b = $row_resumo['TOTAL FAIXA B'];

                                    $qtde_c  = $row_resumo['QTDE.FAIXA C'];
                                    $media_c = $row_resumo['% FAIXA C'];
                                    $total_c = $row_resumo['TOTAL FAIXA C'];

                                    $qtde_total_geral  = $row_resumo['QTDE. GERAL'];
                                    $media_total_geral = $row_resumo['MÉDIA'];
                                    $total_geral_final = $row_resumo['TOTAL GERAL'];


                                    ?>

                                    <tfoot style="font-weight: bold; color: darkred;">
                                        <tr>
                                            <td class="direita esquerda fim text-center" style="padding-top: 20px;">TOTAIS</td>
                                            <td class="fim text-right" style="padding-top: 20px;"><?php echo $total_ativas; ?></td>
                                            <td class="fim text-center">
                                                MÉDIA <br>
                                                <hr style="margin-bottom: 0px !important; margin-top: 0px !important; background-color: darkred;">
                                                <?php echo $total_media_ativas; ?>
                                            </td>
                                            <td class="fim text-right" style="padding-top: 20px;"><?php echo $total_inativas; ?></td>
                                            <td class="fim text-center">
                                                MÉDIA <br>
                                                <hr style="margin-bottom: 0px !important; margin-top: 0px !important; background-color: darkred;">
                                                <?php echo $total_media_inativas; ?>
                                            </td>
                                            <td class="direita fim text-right" style="padding-top: 20px;"><?php echo $total_geral; ?></td>

                                            <td class="fim text-right" style="padding-top: 20px;"><?php echo $qtde_a; ?></td>
                                            <td class="fim text-center">
                                                MÉDIA <br>
                                                <hr style="margin-bottom: 0px !important; margin-top: 0px !important; background-color: darkred;">
                                                <?php echo $media_a; ?>
                                            </td>
                                            <td class="fim direita text-right" style="padding-top: 20px;"><?php echo $total_a; ?></td>

                                            <td class="fim text-right" style="padding-top: 20px;"><?php echo $qtde_b; ?></td>
                                            <td class="fim text-center">
                                                MÉDIA <br>
                                                <hr style="margin-bottom: 0px !important; margin-top: 0px !important; background-color: darkred;">
                                                <?php echo $media_b; ?>
                                            </td>
                                            <td class="fim direita text-right" style="padding-top: 20px;"><?php echo $total_b; ?></td>

                                            <td class="fim text-right" style="padding-top: 20px;"><?php echo $qtde_c; ?></td>
                                            <td class="fim text-center">
                                                MÉDIA <br>
                                                <hr style="margin-bottom: 0px !important; margin-top: 0px !important; background-color: darkred;">
                                                <?php echo $media_c; ?>
                                            </td>
                                            <td class="fim direita text-right" style="padding-top: 20px;"><?php echo $total_c; ?></td>

                                            <td class="fim text-right" style="padding-top: 20px;"><?php echo $qtde_total_geral; ?></td>
                                            <td class="fim text-center">
                                                MÉDIA <br>
                                                <hr style="margin-bottom: 0px !important; margin-top: 0px !important; background-color: darkred;">
                                                <?php echo $media_total_geral; ?>
                                            </td>
                                            <td class="fim direita text-right" style="padding-top: 20px;"><?php echo $total_geral_final; ?></td>
                                        </tr>
                                    </tfoot>

                                </table>

                                </form>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</body>

</html>
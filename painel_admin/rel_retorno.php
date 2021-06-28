<?php
session_start();
include_once('../conexao.php');

include_once('../verificar_autenticacao.php');

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="pr-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <h1 style="font-size: 30px;">
    <title> Faturamento </title>
  </h1>
  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- LINK DO fontawesome via cdn(navegador) para icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>


  <script>
    window.print();
    window.addEventListener("afterprint", function(event) {
      window.close();
    });
    window.onafterprint();
  </script>

  <style>
    .table-responsive {
      overflow-x: hidden;
    }
  </style>

  <div class="container ml-4" style="width: 200%;">

    <br>
    <div class="content" style="width: 100%;">
      <div class="row mr-3" style="width: 100%;">
        <div class="col-md-12" style="width: 100%;">
          <div class="card" style="width: 100%;">
            <div class="card-body" style="width: 100%;">
              <div class="table-responsive" style="width: 100%;">

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

                <table style="margin-bottom: 15px;">
                  <thead>
                    <tr>
                      <th style="width: 25%;"><img width="95%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                      <th>
                        <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                          SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                          SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                          RELATÓRIO DE PROCESSAMENTO DE RETORNO BANCÁRIO ‐ <?php echo $data ?></p>
                      </th>
                    </tr>
                  </thead>
                </table>

                <?php


                //ler todo o arquivo para um array
                @$dados = $_SESSION['dados'];

                //var_dump($dados);
                foreach ($dados as $linha) {

                  $campo = substr($linha, 0, 1);

                  if ((substr($linha, 0, 1) == 'A')) {
                    $cd_convenio = substr($linha, 2, 19); //codigo do convenio
                    $cd_banco = substr($linha, 42, 3);    //codigo do banco
                    $dt_ret = substr($linha, 65, 8);
                    $dt_ret = date("dmY", strtotime($dt_ret)); //data do retorno
                    $numero_doc = substr($linha, 73, 6);
                  }
                  if ((substr($linha, 0, 1) == 'Z')) {
                    $t_reg = substr($linha, 1, 6);
                    $t_reg = $t_reg - 2;                // total de registros
                    $v_t_r = substr($linha, 7, 17) / 100;      //valor total dos registros
                  }

                  //trazendo info bancos
                  $query_banco = "SELECT * from banco_arrecadador where id_febraban = '$cd_banco' ";
                  $result_banco = mysqli_query($conexao, $query_banco);
                  $row_banco = mysqli_fetch_array($result_banco);
                  @$nome_banco = $row_banco["nome_banco"];

                ?>


                  <table class="table table-bordered" style="width: 100%;">
                    <thead class="text-secondary">

                      <div class="row" style="margin-bottom: -16px;">

                        <?php if (substr($linha, 0, 1) == 'A') { ?>

                          <div class="form-group col-md-3">
                            <label for="id_produto"><strong>Convênio Nº: <?php echo $cd_convenio; ?></strong></label>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="id_produto"><strong>Banco: <?php echo $nome_banco; ?></strong></label>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="id_produto"><strong>Data: <span id="data"><?php echo $dt_ret; ?></span></strong></label>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="id_produto"><strong>Documento Nº: <?php echo $numero_doc; ?></strong></label>
                          </div>

                        <?php } ?>

                      </div>

                      <div class="row" style="margin-top: 0.2px;">

                        <?php if (substr($linha, 0, 1) == 'Z') { ?>

                          <div class="form-group col-md-3">
                            <label for="id_produto"><strong>Total de Registros: <?php echo $t_reg; ?></strong></label>
                          </div>

                          <div class="form-group col-md-4">
                            <label for="id_produto"><strong>Valor Total dos Registros: R$ <?php echo number_format($v_t_r, 2, ",", "."); ?></strong></label>
                          </div>

                        <?php } ?>

                      </div>


                    <?php } ?>

                    <th>
                      Localidade
                    </th>
                    <th>
                      Matrícula
                    </th>
                    <th>
                      Mês Faturado
                    </th>
                    <th>
                      Data Vencimento
                    </th>
                    <th>
                      Data Pagamento
                    </th>
                    <th>
                      Identificador
                    </th>
                    <th>
                      Valor
                    </th>


                    </thead>
                    <tbody>

                      <?php


                      foreach ($dados as $linha) {

                        $campo = substr($linha, 0, 1);

                        if ((substr($linha, 0, 1) == 'A')) {
                          $cd_convenio = substr($linha, 2, 19); //codigo do convenio
                          $cd_banco = substr($linha, 42, 3);    //codigo do banco
                          $dt_ret = substr($linha, 65, 8);
                          $dt_ret = date("dmY", strtotime($dt_ret)); //data do retorno

                          $cabecalho = substr($linha, 0, 81); //cabeçalho do retorno
                          //$cabecalho = str_replace(' ', '&nbsp', $cabecalho2);
                        }
                        if ((substr($linha, 0, 1) == 'Z')) {
                          $t_reg = substr($linha, 1, 6);
                          $t_reg = $t_reg - 2;                // total de registros
                          $v_t_r = substr($linha, 7, 17) / 100;      //valor total dos registros

                          $rodape = substr($linha, 0, 24); //rodapé do retorno

                          $_SESSION['rodape'] = $rodape;
                        }
                        if ((substr($linha, 0, 1) == 'G')) {
                          $dt_pg = substr($linha, 21, 8);
                          $dt_pg2 = date("dmY", strtotime($dt_pg));  //data de pagamento
                          //organizando data de vencimento
                          $ano = substr($dt_pg, 0, 4);
                          $mes = substr($dt_pg, 4, 2);
                          $dia = substr($dt_pg, 6, 2);
                          $dt_pg3 = $ano . '-' . $mes . '-' . $dia;

                          $dt_cred = substr($linha, 29, 8);
                          $dt_cred = date("dmY", strtotime($dt_cred)); //data do credito

                          $id_sequencial = substr($linha, 100, 8); //
                          $id_boleto = substr($linha, 62, 3); // identificação do tipo do boleto   

                          if ($id_boleto == '140') {
                            $tipo = 'Fatura Normal';
                          } else {
                            $id_boleto = substr($linha, 62, 4);

                            $ta2 = substr($id_boleto, 1, 2);
                            if ($ta2 == '2') {
                              $dm2 = ', juros e multas';
                            }

                            $ta3 = substr($id_boleto, 2, 3);
                            if ($ta3 == '3') {
                              $dm3 = ', parcelas de acordos';
                            }

                            $ta4 = substr($id_boleto, 3, 4);
                            if ($ta4 == '4') {
                              $dm4 = ', serviços';
                            }

                            $ta1 = substr($id_boleto, 0, 1);
                            if ($ta1 == '1') {
                              $tipo = 'Fatura normal' . @$dm2 . @$dm3 . @$dm4;
                            } elseif ($ta1 == '2') {
                              $tipo = 'Entrada de acordo';
                            } elseif ($ta1 == '3') {
                              $tipo = 'Valor de serviços';
                            } elseif ($ta1 == '4') {
                              $tipo = 'Fatura avulsa';
                            } elseif ($ta1 == '0') {
                              $tipo = 'Parcela de acordo';
                            }
                          }

                          $cdb = substr($linha, 37, 44); //codigo de barras

                          $localidade_a = substr($linha, 65, 2); //localidade boletos antigos
                          $localidade_n = substr($linha, 66, 2); //localidade boletos novos

                          $data_vencimento = substr($linha, 73, 8);
                          //organizando data de vencimento
                          $dia = substr($data_vencimento, 6, 2);
                          $mes = substr($data_vencimento, 4, 2);
                          $ano = substr($data_vencimento, 0, 4);
                          $data_vencimento2 = $dia . '/' . $mes . '/' . $ano;
                          $data_vencimento3 = $ano . '-' . $mes . '-' . $dia;


                          $mes_faturado = substr($linha, 56, 6);
                          //organizando mes_faturado
                          $mes = substr($mes_faturado, 0, 2);
                          $ano = substr($mes_faturado, 2, 4);
                          $mes_faturado2 = $ano . '/' . $mes;
                          $mes_faturado = $mes . '/' . $ano;

                          $unidade_consumidora = substr($linha, 68, 5);

                          $valor_fatura = substr($linha, 41, 11) / 100;

                          if ($tipo == 'Fatura avulsa') {
                            $mes_faturado = 'Avulso';
                          }
                        }


                      ?>

                        <tr>

                          <?php if (substr($linha, 0, 1) == 'G') { ?>

                            <td><?php if ($id_boleto == '140') {
                                  echo $localidade_a;
                                } else {
                                  echo $localidade_n;
                                } ?></td>
                            <td><?php echo $unidade_consumidora; ?></td>
                            <td><?php echo $mes_faturado; ?></td>
                            <td><?php echo $data_vencimento2; ?></td>
                            <td id="data"><?php echo $dt_pg2; ?></td>
                            <td><?php echo $tipo; ?></td>
                            <td>R$ <?php echo number_format($valor_fatura, 2, ",", "."); ?></td>


                          <?php } ?>

                        </tr>

                      <?php } ?>

                    </tbody>

                  </table>


                  <script type="text/javascript">
                    //post alternativo
                    function submitForm(form, action) {
                      form.action = action;
                      form.submit();
                    }
                  </script>

              </div>
            </div>
          </div>

        </div>
      </div>


      <div class="row" style="margin-top: 100px;">

        <div class="form-group col-md-12 text-center">
          <label for="fornecedor">___________________________________________________</label>
        </div>

        <div class="form-group col-md-12 text-center" style="margin-top: -20px;">
          <label for="fornecedor">Responsável</label>
        </div>

      </div>

      <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
      <script>
        $("input[id*='data']").inputmask({
          mask: ['99/99/9999'],
          keepStatic: true
        });
      </script>

      <script>
        $("span[id*='data']").inputmask({
          mask: ['99/99/9999'],
          keepStatic: true
        });
      </script>

      <script>
        $("td[id*='data']").inputmask({
          mask: ['99/99/9999'],
          keepStatic: true
        });
      </script>

      <script>
        $("input[id*='mf']").inputmask({
          mask: ['99/9999'],
          keepStatic: true
        });
      </script>

      <script>
        $("td[id*='mf']").inputmask({
          mask: ['99/9999'],
          keepStatic: true
        });
      </script>

      <script>
        function cadastro() {
          alert("Processamento Iniciado, Por Favor Aguarde !!!");
          window.close();
        }
      </script>


</body>

</html>
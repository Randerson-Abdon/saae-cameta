<?php
@session_start();
include_once('../conexao.php');
?>
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

              <form method="POST" action="processamento.php" target="_blank">

                <?php
                //Receber os dados do formulário
                //$arquivo = $_FILES['arquivo'];
                //var_dump($arquivo);
                @$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
                @$nome_arquivo = $_FILES['arquivo']['name'];

                $arquivo_destino = "../include/ret_cameta/$nome_arquivo.txt";
                copy($arquivo_tmp, $arquivo_destino);


                //ler todo o arquivo para um array
                @$dados = file($arquivo_tmp);

                $_SESSION['dados'] = $dados;
                $_SESSION['nome'] = $nome_arquivo;

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
                    //$t_reg = $t_reg - 2;                // total de registros
                    $t_reg = $t_reg;                // total de registros
                    $v_t_r = substr($linha, 7, 17) / 100;      //valor total dos registros
                  }

                  //trazendo info bancos
                  $query_banco = "SELECT * from banco_arrecadador where id_febraban = '$cd_banco' ";
                  $result_banco = mysqli_query($conexao, $query_banco);
                  $row_banco = mysqli_fetch_array($result_banco);
                  $nome_banco = $row_banco["nome_banco"];


                ?>


                  <table class="table table-sm">
                    <thead class="text-secondary">

                      <div class="row" style="margin-bottom: -16px;">

                        <?php if (substr($linha, 0, 1) == 'A') { ?>

                          <div class="form-group col-md-2">
                            <label for="id_produto">Convênio Nº</label>
                            <input type="text" class="form-control mr-2" name="convenio" value="<?php echo $cd_convenio; ?>">
                          </div>

                          <div class="form-group col-md-3">
                            <label for="id_produto">Banco</label>
                            <input type="text" class="form-control mr-2" name="banco" style="text-transform:uppercase;" value="<?php echo $nome_banco; ?>">
                          </div>

                          <div class="form-group col-md-2">
                            <label for="id_produto">Data do Arquivo</label>
                            <input type="text" class="form-control mr-2" name="data_ret" id="data" value="<?php echo $dt_ret; ?>">
                          </div>

                          <div class="form-group col-md-2">
                            <label for="id_produto">Documento Nº</label>
                            <input type="text" class="form-control mr-2" name="numero_doc" value="<?php echo $numero_doc; ?>">
                          </div>

                        <?php } ?>

                      </div>

                      <div class="row" style="margin-top: 0.2px;">

                        <?php if (substr($linha, 0, 1) == 'Z') { ?>

                          <div class="form-group col-md-2">
                            <label for="id_produto">Total de Registros</label>
                            <input type="text" class="form-control mr-2" name="total_reg" value="<?php echo $t_reg; ?>">
                          </div>

                          <div class="form-group col-md-2">
                            <label for="id_produto">Valor Total dos Registros</label>
                            <input type="text" class="form-control mr-2" name="data_ret" id="moeda" value="<?php echo number_format($v_t_r, 2, ",", "."); ?>">
                          </div>

                          <div class="form-group col-md-1">
                            <label for="id_produto">Processar</label>
                            <button type="submit" class="btn btn-success form-control mr-2" onclick="cadastro()" name="processar" title="Processar" id=""><i class="fas fa-sync-alt"></i></button>
                          </div>

                          <div class="form-group col-md-2 mr-4" style="margin-top: 23px;">
                            <a style="font-size: 12pt; height: 37px;" class="btn btn-info btn-sm mr-2" href="admin.php?acao=retorno">Novo Processamento</a>
                          </div>

                          <div class="form-group col-md-2" style="margin-top: 23px;">
                            <a style="font-size: 12pt; height: 37px;" class="btn btn-danger btn-sm" target="_blank" href="rel_retorno.php">Imprimir</a>
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
                      Data de Pagamento
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
                          $t_reg = $t_reg;                // total de registros
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

                          $unidade_consumidora = substr($linha, 68, 5);

                          $valor_fatura = substr($linha, 41, 11) / 100;
                        }


                      ?>

                        <tr>

                          <?php if (substr($linha, 0, 1) == 'G') { ?>

                            <td><input type="text" class="form-control mr-2" name="id_localidade[]" value="<?php if ($id_boleto == '140') {
                                                                                                              echo $localidade_a;
                                                                                                            } else {
                                                                                                              echo $localidade_n;
                                                                                                            } ?>" style="text-transform:uppercase;"></td>

                            <td><input type="text" class="form-control mr-2" name="uc[]" value="<?php echo @$unidade_consumidora; ?>" style="text-transform:uppercase;"></td>
                            <td><input type="text" class="form-control mr-2" name="mes_faturado_visual[]" id="mf" value="<?php echo @$mes_faturado; ?>" style="text-transform:uppercase;"></td>
                            <td><input type="text" class="form-control mr-2" name="data_vencimento_visual[]" value="<?php echo @$data_vencimento2; ?>" style="text-transform:uppercase;"></td>
                            <td><input type="text" class="form-control mr-2" name="dt_pagamento_visual[]" id="data" value="<?php echo @$dt_pg2; ?>" style="text-transform:uppercase;"></td>
                            <td><input type="text" class="form-control mr-2" name="" value="<?php echo @$tipo; ?>" style="text-transform:uppercase;"></td>
                            <td><input type="text" class="form-control mr-2" name="valor_fatura[]" value="<?php echo number_format($valor_fatura, 2, ".", "."); ?>" style="text-transform:uppercase;"></td>
                            <td><input type="text" class="form-control mr-2" name="dt_pagamento[]" value="<?php echo @$dt_pg3; ?>" style="text-transform:uppercase; display: none;"></td>
                            <td><input type="text" class="form-control mr-2" name="mes_faturado[]" value="<?php echo @$mes_faturado2; ?>" style="text-transform:uppercase; display: none;"></td>
                            <td><input type="text" class="form-control mr-2" name="data_vencimento[]" value="<?php echo @$data_vencimento3; ?>" style="text-transform:uppercase; display: none;"></td>
                            <td><input type="text" class="form-control mr-2" name="cabecalho" value="<?php echo @$cabecalho; ?>" style="text-transform:uppercase; display: none;"></td>
                            <td><input type="text" class="form-control mr-2" name="rodape" value="<?php echo $_SESSION['rodape']; ?>" style="text-transform:uppercase; display: none;"></td>
                            <td><input type="text" class="form-control mr-2" name="data" value="<?php echo $dt_ret; ?>" style="text-transform:uppercase; display: none;"></td>
                            <td><input type="text" class="form-control mr-2" name="banco" value="<?php echo $cd_banco; ?>" style="text-transform:uppercase; display: none;"></td>

                          <?php } ?>

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

                      </tr>

                    </tfoot>
                  </table>
              </form>

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

    <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>
      $("input[id*='data']").inputmask({
        mask: ['99/99/9999'],
        keepStatic: true
      });
    </script>
    </script>
    <script>
      $("input[id*='mf']").inputmask({
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
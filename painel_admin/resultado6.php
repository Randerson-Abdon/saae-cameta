<!-- BUSCA DI HISTORICO FINANCEIRO POR uc-->
<?php

session_start(); # Deve ser a primeira linha do arquivo

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>
<style>
  section .content {
    margin-top: -150px;
    margin-bottom: -170px;


  }

  p {
    color: #d70000;
    margin-left: 20px;

  }

  .teste::-webkit-input-placeholder {
    /* WebKit browsers */
    color: #3995f0;
  }

  .teste:-moz-placeholder {
    /* Mozilla Firefox 4 to 18 */
    color: #3995f0;
    opacity: 1;
  }

  .teste::-moz-placeholder {
    /* Mozilla Firefox 19+ */
    color: #3995f0;
    opacity: 1;
  }

  .teste:-ms-input-placeholder {
    /* Internet Explorer 10+ */
    color: #3995f0;
  }
</style>

<?php

include_once('../conexao.php');

?>
<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <title>post3</title>
</head>

<body>



  <div class="container ml-4" style="margin-top: -30px;">

    <br>

    <div class="content">
      <div class="row mr-3">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
              <div class="table-responsive">

                <!--LISTAR TODOS OS REQUERIMENTOS -->

                <?php
                $id_unidade_consumidora = $_POST['id_unidade_consumidora'];
                $localidade = $_POST['localidade'];
                $status = $_POST['slStatus3'];

                $_SESSION['id_unidade_consumidora'] = $id_unidade_consumidora;
                $_SESSION['status'] = $status;

                //completando com zeros a esquerda
                $uc = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);

                //se o status fou igual a todos
                if ($status == '1') {
                  //executa o store procedure info devedor
                  $result = mysqli_query(
                    $conexao,
                    "CALL sp_lista_financeiro_devedor($localidade,$uc);"
                  ) or die("Erro na query da procedure 1 : " . $localidade . mysqli_error($conexao));
                  mysqli_next_result($conexao);
                } elseif ($status == '2') {
                  //executa o store procedure info pago
                  $result = mysqli_query(
                    $conexao,
                    "CALL sp_lista_financeiro_pago($localidade,$uc);"
                  ) or die("Erro na query da procedure 2: " . mysqli_error($conexao));
                  mysqli_next_result($conexao);
                } else {
                  //executa o store procedure info pago
                  $result = mysqli_query(
                    $conexao,
                    "CALL sp_lista_financeiro_devedor_vencido($localidade,$uc);"
                  ) or die("Erro na query da procedure 3: " . mysqli_error($conexao));
                  mysqli_next_result($conexao);
                }

                //$result_count = mysqli_query($conexao, $query);
                //$result = mysqli_query($conexao, $query);
                //$result2 = mysqli_query($conexao, $query);

                $linha = mysqli_num_rows($result);
                $linha_count = mysqli_num_rows($result);

                if ($linha == '') {
                  echo "<button type='button' id='ver' class='btn btn-info form-control mr-2' data-toggle='modal' data-target='.bd-example-modal-lg'>Ver Acordos</button>";
                  echo "<h3 class='text-danger'> Não foram encontrados registros com esses parametros. <br>
                          Verifique a possibilidade da existência de acordos no botão acordos!!! </h3>";
                } else {

                ?>

                  <form action="admin.php?acao=fatura" method="POST" target="_blank">
                    <div style="overflow: strcoll; height: 500px;">

                      <table class="table table-sm">

                        <thead class="text-secondary">

                          <ul class="text-secondary">

                            <?php

                            $id = $uc;

                            //trazendo info acordos
                            $query_ac = "SELECT * from acordo_parcelamento where id_unidade_consumidora = '$uc' and data_pagamento_parcela is null order by id_acordo_parcelamento desc ";
                            $result_ac = mysqli_query($conexao, $query_ac);
                            $row_ac = mysqli_fetch_array($result_ac);
                            $linha_acordo = mysqli_num_rows($result_ac);
                            @$id_acordo_firmado = $row_ac['id_acordo_parcelamento'];

                            //executa o store procedure info consumidor
                            $result_sp = mysqli_query(
                              $conexao,
                              "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
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

                            ?>


                            <li>
                              <b>UC:</b> <?php echo $uc; ?>
                              &nbsp;&nbsp;<b>CPF/ CNPJ: </b><?php echo $numero_cpf_cnpj ?>
                              &nbsp;&nbsp;<b>Status da Ligação:</b> <?php echo $status_ligacao ?>
                            </li>

                            <li>
                              <b>Nome /Razão Social:</b> <?php echo $nome_razao_social; ?>
                              &nbsp;&nbsp;<b>Endereço:</b> <?php echo $nome_logradouro . ' Nº ' . $numero_logradouro . ', BAIRRO ' . $nome_bairro ?>
                            </li>

                          </ul>

                          <div id="noprint" class="row">
                            <?php if ($linha_count > 1 and $status == 3 and $linha_acordo == 0) { ?>
                              <div class="form-group col-md-3">
                                <button type="submit" id="acordo" name="acordo" class="btn btn-info form-control mr-2">Gerar Acordo</i></button>
                              </div>
                            <?php } ?>

                            <?php if ($id_acordo_firmado != '') { ?>
                              <div class="form-group col-md-3">
                                <button type="button" id="ver" class="btn btn-info form-control mr-2" data-toggle="modal" data-target=".bd-example-modal-lg">Ver Acordos</button>
                              </div>
                            <?php } ?>

                            <?php if ($linha_count > 1 and $status == 1 or $status == 3) { ?>
                              <div class="form-group col-md-3">
                                <input type="button" class="btn btn-info form-control mr-2" value="Boleto Avulso" onclick="javascript:submitForm(this.form, '../lib/boleto_a/boleto_cef_avulso.php');" />
                              </div>
                            <?php } ?>

                            <?php if ($linha_count != 0) { ?>
                              <div class="form-group col-md-3">
                                <input type="button" class="btn btn-danger form-control mr-2" value="Imprimir" onclick="javascript:submitForm(this.form, 'rel_fatura.php');" />
                              </div>
                            <?php } ?>

                            <!--
                            <div class="form-group col-md-2">
                              <input type="text" name="totalValor" placeholder="Total" class="teste text-danger form-control mr-2 font-weight-bold" id="resultado" value="">
                            </div>
                            -->

                          </div>

                          <div id="noprint" class="row">
                            <?php if ($status == '1') { ?>
                              <div class="form-group col-md-4" style="margin-bottom: -4px;">
                                <label class="text-danger" for="id_produto">* M/J Soma das multas e juros.</label>
                              </div>
                            <?php } ?>
                          </div>


                          <th>
                            <?php if ($status == 1 or $status == 3) { ?>
                              <div class="input-group-text">
                                <input type="checkbox" title="Selecionar Tudo" id="todos" name="all">
                              </div>
                            <?php } ?>
                          </th>
                          <th class="text-danger">
                            Competência
                          </th>
                          <th>
                            Tarifa
                          </th>

                          <?php if ($status == '1') { ?>
                            <th>
                              *M/J
                            </th>
                          <?php } ?>

                          <th>
                            Serviços
                          </th>
                          <th>
                            Parcelas
                          </th>
                          <th>
                            Faturado
                          </th>
                          <th>
                            Vencimento
                          </th>

                          <?php if ($status == '2') { ?>
                            <th>
                              Pagamento
                            </th>
                          <?php } ?>


                          <th>
                            Ações
                          </th>

                        </thead>
                        <tbody>

                          <?php
                          while ($res = mysqli_fetch_array($result)) {
                            $id                        = $res["ID_UC"];
                            $total_geral_tarifa        = $res["TARIFA"];
                            $total_geral_faturado      = $res["TOTAL"];
                            @$total_geral_faturado2    = $res["TOTALII"];
                            $mes_faturado              = $res['COMPETENCIA'];
                            @$mes_faturado2            = $res['COMPETENCIAII'];
                            @$vencimento               = $res["VENCTOII"];
                            @$vencimento2              = $res["VENCTO"];
                            $total_multas_faturadas    = $res["MULTA"];
                            $total_juros_faturados     = $res["JUROS"];
                            $total_servicos_requeridos = $res["SERVICOS"];
                            $total_parcela_acordo      = $res["ACORDO"];
                            $id_localidade             = $res["ID_LOC"];
                            @$total_m_j                = $res["M/J*"];
                            @$data_pagamento           = $res["PGTO"];

                            $_SESSION['id'] = $id;
                            $_SESSION['total_geral_faturado'] = $total_geral_faturado;

                            // Explode a barra e retorna três arrays
                            //$data = explode("/", $mes_faturado);

                            // Cria três variáveis $dia $mes $ano
                            //list($ano, $mes) = $data;

                            // Recria a data invertida
                            //$data = "$mes/$ano";

                          ?>

                            <tr>

                              <td>
                                <?php if ($status == 1 or $status == 3) { ?>
                                  <div class="input-group-text">
                                    <input class="lista" type="checkbox" title="Selecionar Atual" name="fatura[]" value="<?php echo $mes_faturado2; ?>" data-valor="<?php echo $total_geral_faturado2; ?>">
                                  </div>
                                <?php } ?>
                              </td>

                              <td class="text-danger"><?php echo $mes_faturado; ?></td>
                              <td><?php echo $total_geral_tarifa; ?></td>

                              <?php if ($status == '1') { ?>
                                <td><?php echo $total_m_j; ?></td>
                              <?php } ?>

                              <td><?php echo $total_servicos_requeridos; ?></td>
                              <td><?php echo $total_parcela_acordo; ?></td>
                              <td><?php echo $total_geral_faturado; ?></td>
                              <td><?php echo $vencimento2; ?></td>

                              <?php if ($status == '2') { ?>
                                <td><?php echo $data_pagamento; ?></td>
                              <?php } ?>


                              <td>

                                <?php if ($status == 1 or $status == 3) { ?>
                                  <a class="btn btn-success btn-sm" title="Gerar Boleto" target="_blank" href="../lib/boleto/boleto_cef.php?id=<?php echo $id; ?>&mes_faturado=<?php echo $mes_faturado2; ?>&id_localidade=<?php echo $id_localidade; ?>&vencimento=<?php echo $vencimento; ?>&vencimento2=<?php echo $vencimento2; ?>"><i class="fas fa-file-invoice"></i></a>
                                <?php } ?>

                                <?php if ($status == 2) { ?>
                                  <a class="btn btn-success btn-sm" title="Fatura Paga"><i class="fas fa-check-circle"></i></a>
                                <?php } ?>



                              </td>

                              <input type="text" class="form-control mr-2" name="total_fatura[]" value="<?php echo @$total_geral_faturado2; ?>" style="text-transform:uppercase; display: none;">
                              <input type="text" class="form-control mr-2" name="id_localidade" value="<?php echo @$id_localidade; ?>" style="text-transform:uppercase; display: none;">
                              <input type="text" class="form-control mr-2" name="mes_faturado[]" value="<?php echo @$mes_faturado2; ?>" style="text-transform:uppercase; display: none;">
                              <input type="text" name="id" id="id" value="<?php echo $id; ?>" style="display: none;">
                              <input type="text" name="status" id="id" value="<?php echo $status; ?>" style="display: none;">

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
                            <td></td>
                            <td></td>


                            <td>
                              <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                            </td>
                          </tr>

                        </tfoot>

                      </table>
                    </div>


                  </form>

                  <script>
                    //chamando função de soma dinamica de checkbox
                    $('input[type="checkbox"]').on('change', function() {
                      //declarando variaveis
                      var total = 0;
                      var valores = 0;
                      //pegando valores
                      $('input[type="checkbox"]:checked').each(function() {
                        //somando valores inteiros e boleanos
                        total += parseInt($(this).val());
                        valores += parseFloat($(this).data('valor'));
                      });
                      //enviando valores convertendo para moeda brasileira
                      $('input[name="totalValor"]').val(valores.toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                      }));
                      //$('.servicos').html(servicos);
                    });
                  </script>

                  <script type="text/javascript">
                    //post alternativo
                    function submitForm(form, action) {
                      form.action = action;
                      form.submit();
                    }
                  </script>
                  <script>
                    $(document).ready(function() {

                      $('#todos').click(function() {
                        var val = this.checked;
                        //aler(val);
                        $('.lista').each(function() {
                          $(this).prop('checked', val);

                        });

                      });

                    });
                  </script>

              </div>
            </div>
          </div>

        </div>

      </div>

      <table class="table table-sm table-bordered" style="color: #d70000; background-color: #ffffff; width: 97%;">
        <thead class="text-secondary">

          <th>
            Total Tarifa
          </th>
          <th>
            Total Multa
          </th>
          <th>
            Total Juros
          </th>
          <th>
            Total Serviços
          </th>
          <th>
            Total Parcelas
          </th>
          <th>
            Total Faturado
          </th>
          <th>
            Total Selecionado
          </th>


        </thead>
        <tbody>

          <?php
                  //executa o store procedure info totais
                  if ($status == 1) {
                    $result_sp_rd = mysqli_query(
                      $conexao,
                      "CALL sp_resumo_financeiro_devedor($localidade,$id);"
                    ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                    mysqli_next_result($conexao);
                    $row_rd = mysqli_fetch_array($result_sp_rd);
                    $t_tarifas        = $row_rd['TARIFA'];
                    $t_multas         = $row_rd['MULTA'];
                    $t_juros          = $row_rd['JUROS'];
                    $t_servicos       = $row_rd['SERVICOS'];
                    $t_acordos        = $row_rd['ACORDOS'];
                    $t_faturado       = $row_rd['TOTAL_FATURADO'];
                  } elseif ($status == 2) {
                    $result_sp_rd = mysqli_query(
                      $conexao,
                      "CALL sp_resumo_financeiro_pago($localidade,$id);"
                    ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                    mysqli_next_result($conexao);
                    $row_rd = mysqli_fetch_array($result_sp_rd);
                    $t_tarifas        = $row_rd['TARIFA'];
                    $t_multas         = $row_rd['MULTA'];
                    $t_juros          = $row_rd['JUROS'];
                    $t_servicos       = $row_rd['SERVICOS'];
                    $t_acordos        = $row_rd['ACORDOS'];
                    $t_faturado       = $row_rd['TOTAL_FATURADO'];
                  } else {
                    $result_sp_rd = mysqli_query(
                      $conexao,
                      "CALL sp_resumo_financeiro_devedor_vencido($localidade,$id);"
                    ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                    mysqli_next_result($conexao);
                    $row_rd = mysqli_fetch_array($result_sp_rd);
                    $t_tarifas        = $row_rd['TARIFA'];
                    $t_multas         = $row_rd['MULTA'];
                    $t_juros          = $row_rd['JUROS'];
                    $t_servicos       = $row_rd['SERVICOS'];
                    $t_acordos        = $row_rd['ACORDOS'];
                    $t_faturado       = $row_rd['TOTAL_FATURADO'];
                  }



          ?>

          <tr>

            <td><?php echo $t_tarifas; ?></td>
            <td><?php echo $t_multas; ?></td>
            <td><?php echo $t_juros; ?></td>
            <td><?php echo $t_servicos; ?></td>
            <td><?php echo $t_acordos; ?></td>
            <td><?php echo $t_faturado; ?></td>
            <td><input type="text" name="totalValor" placeholder="Total" class="teste text-danger form-control mr-2 font-weight-bold" id="resultado" value=""></td>


          </tr>

        </tbody>
      </table>

    <?php
                }
    ?>

    </div>

  </div>

  <!-- Modal grande -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Acordos</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

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

                      <!--LISTAR TODOS OS ACORDOS -->

                      <?php
                      $id = $_SESSION['id_unidade_consumidora'];
                      $status = 'DEVEDORA';

                      //executa o store procedure
                      $result = mysqli_query(
                        $conexao,
                        "CALL sp_lista_parcelas_acordo('$status','$localidade','$id');"
                      ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                      //liberando para proxima procedure
                      mysqli_next_result($conexao);

                      $linha = mysqli_num_rows($result);
                      $linha_count = mysqli_num_rows($result);

                      if ($linha == '') {
                        echo "<h3 class='text-danger'> Não foram encontrados registros para o consumidor atual!!! </h3>";
                      } else {


                      ?>

                        <form>

                          <table class="table table-sm">
                            <thead class="text-secondary">

                              <th class="text-danger">
                                Acordo Nº
                              </th>
                              <th>
                                Parcela Nº
                              </th>
                              <th>
                                Competência
                              </th>
                              <th>
                                Valor
                              </th>

                            </thead>
                            <tbody>

                              <?php
                              while ($res = mysqli_fetch_array($result)) {
                                $id = $res["N.º UC"];
                                $id_acordo_firmado = $res["N.º CONTRATO"];
                                $numero_parcela = $res["N.º PARC."];
                                $competencia = $res["COMPETÊNCIA"];
                                $valor_parcela = $res["VALOR"];


                              ?>

                                <tr>

                                  <td class="text-danger"><?php echo $id_acordo_firmado; ?></td>
                                  <td><?php echo $numero_parcela; ?></td>
                                  <td><?php echo $competencia; ?></td>
                                  <td><?php echo $valor_parcela; ?></td>

                                </tr>

                              <?php } ?>

                            </tbody>
                            <tfoot>
                              <tr>

                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                  <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                                </td>
                              </tr>

                            </tfoot>

                          </table>
                        </form>

                      <?php
                      }
                      ?>

                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="modal-footer" style="margin-left: -25px; width: 100%;">

              <button type="button" class="btn btn-success mb-3" onclick="window.location.href = 'admin.php?acao=acordos'">Mais Detalhes </button>

              <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
            </div>
          </div>
        </div>
      </div>



      <!--MASCARAS -->

      <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
      <script>
        $("input[id*='numero_cpf_cnpj']").inputmask({
          mask: ['999.999.999-99', '99.999.999/9999-99'],
          keepStatic: true
        });
      </script>
      <script>
        $("label[id*='numero_cpf_cnpj']").inputmask({
          mask: ['999.999.999-99', '99.999.999/9999-99'],
          keepStatic: true
        });
      </script>
      <script>
        $("span[id*='numero_cpf_cnpj']").inputmask({
          mask: ['999.999.999-99', '99.999.999/9999-99'],
          keepStatic: true
        });
      </script>
      <script>
        $("td[id*='numero_cpf_cnpj']").inputmask({
          mask: ['999.999.999-99', '99.999.999/9999-99'],
          keepStatic: true
        });
      </script>
      <script>
        $("label[id*='cel']").inputmask({
          mask: ['(99) 99999-9999'],
          keepStatic: true
        });
      </script>
      <script>
        $("label[id*='fone']").inputmask({
          mask: ['(99) 9999-9999'],
          keepStatic: true
        });
      </script>
      <script>
        $("input[id*='cel']").inputmask({
          mask: ['(99) 99999-9999'],
          keepStatic: true
        });
      </script>
      <script>
        $("td[id*='cel']").inputmask({
          mask: ['(99) 99999-9999'],
          keepStatic: true
        });
      </script>
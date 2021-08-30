<?php

session_start(); # Deve ser a primeira linha do arquivo

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
</style>

<?php

include_once('conexao.php');

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html>
<!--Linguagem -->
<html lang="pt-br">

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

  <title>SAAE Santa Izabel</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <script type="text/javascript" src="js/painel.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript" src="js/javascript.js"></script>
  <script type="text/javascript" src="js/post.js"></script>



  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- LINK DO fontawesome via cdn(navegador) para icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

  <!-- link com a folha de stilos -->
  <link rel="stylesheet" type="text/css" href="css/estilos-site.css">
  <link rel="stylesheet" type="text/css" href="css/estilos-padrao.css">
  <link rel="stylesheet" type="text/css" href="css/cursos.css">
  <link rel="stylesheet" type="text/css" href="css/painel.css">
  <link rel="stylesheet" type="text/css" href="css/cards.css">

  <!-- OS SCRIPTS DEVEM SEMPRE VIM DEPOIS DAS FOLHAS DE ESTILO -->
  <!-- script cdn(pelo navegador) jquery.min.js para menu em resoluções menores -->


  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</head>

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

              <!--LISTAR TODOS OS REQUERIMENTOS -->

              <?php

              $localidade = $_POST['id_localidade'];

              $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
              //tratamento para numero_cpf_cnpj
              $ncc = str_replace("/", "", $numero_cpf_cnpj);
              $ncc2 = str_replace(".", "", $ncc);
              $ncc3 = str_replace("-", "", $ncc2);

              $id_unidade_consumidora = $_POST['uc'];
              //completando com zeros a esquerda
              $uc = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);


              //trazendo info unidade_consumidora
              $query_un = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$uc' AND numero_cpf_cnpj = '$ncc3' ";
              $result_un = mysqli_query($conexao, $query_un);

              //VERIFICAR SE O EMAIL OU SENHA JÁ ESTÁ CADASTRADO                          
              $row_verificar_un = mysqli_num_rows($result_un);
              if ($row_verificar_un == 0) {
                echo "<script language='javascript'>window.alert('Matrícula ou CPF inexistente, verifique os dados digitados ou procure a unidade de atendimento mais próxima!!!'); </script>";
                echo "<script>window.close();</script>";
                exit();
              }

              $result = mysqli_query(
                $conexao,
                "CALL sp_lista_financeiro_devedor($localidade,$uc);"
              ) or die("Erro na query da procedure: " . mysqli_error($conexao));
              mysqli_next_result($conexao);

              $linha = mysqli_num_rows($result);
              $linha_count = mysqli_num_rows($result);

              if ($linha == '') {
                echo "<h3 class='text-danger'> Parabéns você não tem débitos em aberto!!! </h3>";
                echo "<input type='submit' class='btn btn-danger' name='submit' value='Voltar' onClick='window.close();'>";
              } else {


              ?>

                <form action="acordo.php" method="POST" target="_blank">
                  <div style="overflow: strcoll; height: 500px;">
                    <table class="table table-sm table-hover">

                      <thead class="text-secondary">

                        <ul class="text-secondary">

                          <?php

                          $id = $uc;

                          //trazendo info acordos
                          $query_ac = "SELECT * from acordo_parcelamento where id_unidade_consumidora = '$uc' order by id_acordo_parcelamento asc ";
                          $result_ac = mysqli_query($conexao, $query_ac);
                          $row_ac = mysqli_fetch_array($result_ac);
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

                        <div class="row">

                          <?php if ($linha_count > 1) { ?>
                            <div class="form-group col-md-2">
                              <input type="button" class="btn btn-info form-control mr-2" value="Boleto Avulso" onclick="javascript:submitForm(this.form, '../../../lib/boleto_a/boleto_cef_avulso.php');" />
                            </div>
                          <?php } ?>

                          <?php if ($id_acordo_firmado != '') { ?>
                            <div class="form-group col-md-2">
                              <button type="button" class="btn btn-info form-control mr-2" data-toggle="modal" data-target=".bd-example-modal-lg">Ver Acordos</button>
                            </div>
                          <?php } ?>

                          <div class="form-group col-md-2">
                            <button type="button" class="btn btn-danger form-control mr-2" onClick="window.close();">Sair</button>
                          </div>

                        </div>
                        <label class="text-danger" for="" style="font-size: 9pt; margin-bottom: 0;">* Para gerar um boleto avulso de multiplas faturas, selecione as faturas desejadas, logo após clique no botão Boleto Avulso. </label>
                        <label class="text-danger" for="" style="font-size: 9pt; margin-bottom: 0;">* Para emissão de segunda via, selecione a ação correspondente ao boleto desejado. </label>

                        <th>

                          <?php if ($linha_count > 1) { ?>
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
                        <th>
                          Multa
                        </th>
                        <th>
                          Juros
                        </th>
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
                          $vencimento                = $res["VENCTOII"];
                          $vencimento2               = $res["VENCTO"];
                          $total_multas_faturadas    = $res["MULTA"];
                          $total_juros_faturados     = $res["JUROS"];
                          $total_servicos_requeridos = $res["SERVIÇOS"];
                          $total_parcela_acordo      = $res["ACORDO"];
                          $id_localidade             = $res["ID_LOC"];

                          $_SESSION['id'] = $id;
                          $_SESSION['total_geral_faturado'] = $total_geral_faturado;
                          $dir = '2';

                        ?>

                          <tr>

                            <td>
                              <div class="input-group-text">
                                <input class="lista" type="checkbox" title="Selecionar Atual" name="fatura[]" value="<?php echo $mes_faturado2; ?>" data-valor="<?php echo $total_geral_faturado2; ?>">
                              </div>
                            </td>

                            <td class="text-danger"><?php echo $mes_faturado; ?></td>
                            <td><?php echo $total_geral_tarifa; ?></td>
                            <td><?php echo $total_multas_faturadas; ?></td>
                            <td><?php echo $total_juros_faturados; ?></td>
                            <td><?php echo $total_servicos_requeridos; ?></td>
                            <td><?php echo $total_parcela_acordo; ?></td>
                            <td><?php echo $total_geral_faturado; ?></td>




                            <td style="width: 10%;">
                              <a class="btn btn-success btn-sm" title="Gerar Boleto" target="_blank" href="../../../lib/boleto/boleto_cef.php?id=<?php echo $id; ?>&mes_faturado=<?php echo $mes_faturado2; ?>&id_localidade=<?php echo $id_localidade; ?>&vencimento=<?php echo $vencimento; ?>&vencimento2=<?php echo $vencimento2; ?>"><i class="fas fa-file-invoice"></i></a>

                            </td>

                            <input type="text" class="form-control mr-2" name="total_fatura[]" value="<?php echo @$total_geral_faturado; ?>" style="text-transform:uppercase; display: none;">
                            <input type="text" class="form-control mr-2" name="id_localidade" value="<?php echo @$id_localidade; ?>" style="text-transform:uppercase; display: none;">
                            <input type="text" class="form-control mr-2" name="mes_faturado[]" value="<?php echo @$mes_faturado; ?>" style="text-transform:uppercase; display: none;">
                            <input type="text" name="id" value="<?php echo $id; ?>" style="display: none;">
                            <input type="text" name="dir" value="<?php echo $dir; ?>" style="display: none;">


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
                    $id = $_SESSION['id'];
                    $status = 'DEVEDORA';

                    //se o status fou igual a todos

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
                              Vencimento
                            </th>
                            <th>
                              Valor
                            </th>

                            <th>
                              Ações
                            </th>
                          </thead>
                          <tbody>

                            <?php
                            while ($row = mysqli_fetch_array($result)) {

                              $id = $row['N.º UC'];
                              $valor = $row['VALOR'];

                              $id_acordo_firmado = $row['N.º CONTRATO'];
                              $competencia = $row['COMPETÊNCIA'];
                              $numero_parcela = $row['N.º PARC.'];
                              $vencimento = $row['VENCTO'];

                              $dir = '2';


                            ?>

                              <tr>

                                <td class="text-danger"><?php echo $id_acordo_firmado; ?></td>
                                <td><?php echo $numero_parcela; ?></td>
                                <td><?php echo $vencimento; ?></td>
                                <td><?php echo $valor; ?></td>

                                <td>
                                  <a class="btn btn-success btn-sm" title="Gerar Boleto" target="_blank" href="../../../lib/boleto_a/boleto_cef_pcls.php?id=<?php echo $id; ?>&competencia=<?php echo $competencia; ?>&valor=<?php echo $valor; ?>&vencimento=<?php echo $vencimento; ?>&id_acordo_parcelamento=<?php echo $id_acordo_firmado; ?>&numero_parcela=<?php echo $numero_parcela; ?>&dir=<?php echo $dir; ?>"><i class="fas fa-file-invoice"></i></a>
                                </td>

                              </tr>

                            <?php } ?>

                          </tbody>
                          <tfoot>
                            <tr>

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
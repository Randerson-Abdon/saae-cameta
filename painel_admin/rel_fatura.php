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
<html lang="en">

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
                $id_unidade_consumidora = $_POST['id'];
                $status = $_POST['status'];
                //completando com zeros a esquerda
                $uc = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);

                $localidade = '01';

                //se o status fou igual a todos
                if ($status == '1') {
                  //executa o store procedure info devedor
                  $result = mysqli_query(
                    $conexao,
                    "CALL sp_lista_financeiro_devedor($localidade,$uc);"
                  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                  mysqli_next_result($conexao);
                } elseif ($status == '2') {
                  //executa o store procedure info pago
                  $result = mysqli_query(
                    $conexao,
                    "CALL sp_lista_financeiro_pago($localidade,$uc);"
                  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                  mysqli_next_result($conexao);
                } else {
                  //executa o store procedure info pago
                  $result = mysqli_query(
                    $conexao,
                    "CALL sp_lista_financeiro_devedor_vencido($localidade,$uc);"
                  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                  mysqli_next_result($conexao);
                }

                //$result_count = mysqli_query($conexao, $query);
                //$result = mysqli_query($conexao, $query);
                //$result2 = mysqli_query($conexao, $query);

                $linha = mysqli_num_rows($result);
                $linha_count = mysqli_num_rows($result);

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

                  $data = date('d/m/Y');

                ?>

                  <table style="margin-bottom: 15px;">
                    <thead>
                      <tr>
                        <th style="width: 20%;"><img width="80%" src="../img/sIzabel/saae_sIzabel_logo.png" alt=""></th>
                        <th>
                          <p><?php echo $nome_prefeitura ?> <br>
                            SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                            SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                            RELATÓRIO DA COMPOSIÇÃO DO FATURAMENTO <?php if ($status == '1') {
                                                                      echo 'EM ABERTO';
                                                                    } elseif ($status == '2') {
                                                                      echo 'PAGO';
                                                                    } else {
                                                                      echo 'VENCIDO';
                                                                    } ?> ‐ <?php echo $data ?></p>
                        </th>
                      </tr>
                    </thead>
                  </table>

                  <form action="admin.php?acao=fatura" method="POST" target="_blank">

                    <table class="table table-sm">

                      <thead class="text-secondary">

                        <ul class="text-secondary">

                          <?php

                          $id = $uc;

                          $localidade = '01';

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
                          //$id_unidade_hidrometrica  = $row_uc['id_unidade_hidrometrica'];
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
                            Arrecadador
                          </th>
                          <th>
                            Pagamento
                          </th>
                        <?php } ?>



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
                          $vencimento2               = $res["VENCTO"];
                          $total_multas_faturadas    = $res["MULTA"];
                          $total_juros_faturados     = $res["JUROS"];
                          $total_servicos_requeridos = $res["SERVICOS"];
                          $total_parcela_acordo      = $res["ACORDO"];
                          $id_localidade             = $res["ID_LOC"];
                          @$total_m_j                = $res["M/J*"];
                          @$data_pagamento           = $res["PGTO"];
                          @$banco                    = $res["BANCO"];

                          $_SESSION['id'] = $id;
                          $_SESSION['total_geral_faturado'] = $total_geral_faturado;

                        ?>

                          <tr>

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
                              <td><?php echo $banco; ?></td>
                              <td><?php echo $data_pagamento; ?></td>
                            <?php } ?>

                          </tr>

                        <?php } ?>

                      </tbody>




                    </table>

                  </form>


              </div>
            </div>
          </div>

        </div>

      </div>



      <table class="table table-sm table-bordered" style="margin-top: 40px; color: #d70000; background-color: #c0c0c0; width: 97%;">
        <thead class="text-secondary">

          <th>
            Total Geral Tarifa
          </th>
          <th>
            Total Geral Multa
          </th>
          <th>
            Total Geral Juros
          </th>
          <th>
            Total Geral Serviços
          </th>
          <th>
            Total Geral Parcelas
          </th>
          <th>
            Total Geral Faturado
          </th>
          <th>
            Total Registros
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
            <td><?php echo $linha_count; ?></td>


          </tr>

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


        </tfoot>
      </table>
    <?php
                }
    ?>



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


</body>

</html>
<?php
session_start();
include_once('../conexao.php');

include_once('../verificar_autenticacao.php');

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0' && $_SESSION['nivel_usuario'] != '77') {
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
    <title> Acordos </title>
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
                $id_unidade_consumidora = $_POST['id_unidade_consumidora'];
                $status          = $_POST['status'];
                //mudar saae
                $localidade = '01';
                $id_unidade_consumidora = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);

                //executa o store procedure
                $result = mysqli_query(
                  $conexao,
                  "CALL sp_lista_parcelas_acordo('$status','$localidade','$id_unidade_consumidora');"
                ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                //liberando para proxima procedure
                mysqli_next_result($conexao);

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
                  $logo_orgao = $row_ps['logo_orgao'];

                  $data = date('d/m/Y');

                ?>

                  <table style="margin-bottom: 15px;">
                    <thead>
                      <tr>
                        <th style="width: 20%;"><img width="80%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                        <th>
                          <p><?php echo $nome_prefeitura ?> <br>
                            SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                            SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                            RELATÓRIO DA COMPOSIÇÃO DE ACORDOS <?php if ($status == 'DEVEDORA') {
                                                                  echo 'EM ABERTO';
                                                                } else {
                                                                  echo 'PAGOS';
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

                          $id = $id_unidade_consumidora;

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
                            <b>UC:</b> <?php echo $id; ?>
                            &nbsp;&nbsp;<b>CPF/ CNPJ: </b><?php echo $numero_cpf_cnpj ?>
                            &nbsp;&nbsp;<b>Status da Ligação:</b> <?php echo $status_ligacao ?>
                          </li>

                          <li>
                            <b>Nome /Razão Social:</b> <?php echo $nome_razao_social; ?>
                            &nbsp;&nbsp;<b>Endereço:</b> <?php echo $nome_logradouro . ' Nº ' . $numero_logradouro . ', BAIRRO ' . $nome_bairro ?>
                          </li>

                        </ul>

                        <th class="text-danger">
                          N° do Contrato
                        </th>
                        <th>
                          N° da Parcela
                        </th>
                        <th>
                          Vencimento
                        </th>
                        <?php if ($status == 'PAGA') { ?>
                          <th>
                            Data de Pagamneto
                          </th>
                        <?php } ?>



                      </thead>
                      <tbody>

                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                          $id = $row['N.º UC'];
                          $valor = $row['VALOR'];

                          $id_acordo_parcelamento = $row['N.º CONTRATO'];
                          $competencia = $row['COMPETÊNCIA'];
                          $numero_parcela = $row['N.º PARC.'];
                          $vencimento = $row['VENCTO'];
                          $data_pagamento = $row['PGTO'];

                          if (empty($vencimento)) {

                            $update = 'S';

                            $data = date('d-m-Y');
                            $n = explode('/', $numero_parcela);
                            $n = $n[0];

                            if ($n == '00') {
                              $vencimento = date('d/m/Y');
                            } elseif ($n == '01') {
                              $vencimento = date('d/m/Y', strtotime('+3 days', strtotime($data)));
                            } else {
                              $vencimento = date('d/m/Y', strtotime('+' . ($n - 1) . 'month', strtotime($data)));
                            }
                          }

                        ?>

                          <tr>

                            <td class="text-danger"><?php echo $id_acordo_parcelamento; ?></td>
                            <td><?php echo $numero_parcela; ?></td>
                            <td><?php echo $vencimento; ?></td>
                            <?php if ($status == 'PAGA') { ?>
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
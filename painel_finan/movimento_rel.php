<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');
?>


<?php

if ($_SESSION['nivel_usuario'] != '5' && $_SESSION['nivel_usuario'] != '0') {
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
    <title> Movimento de Caixa </title>
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

                @$nome  = $_GET['nome2'];
                @$status  = $_GET['status2'];
                $id_usuario_editor = $_SESSION['id_usuario'];
                $nome_usuario = $_SESSION['nome_usuario'];

                //echo $nome . ', ' . $status;

                if ($nome != '') {
                  //se o status fou igual a todos
                  if ($status == 'T') {
                    $query = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' AND data_cadastro_movimento = '$nome' order by id_historico_movimento_caixa asc";
                  } else {
                    $query = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' AND data_cadastro_movimento = '$nome' AND tipo_movimento = '$status' order by id_historico_movimento_caixa asc";
                  }

                  $result_count = mysqli_query($conexao, $query);
                } else {
                  $query = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' order by id_historico_movimento_caixa desc limit 10";

                  $query_count = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor'";
                  $result_count = mysqli_query($conexao, $query_count);
                }

                $result = mysqli_query($conexao, $query);

                @$linha = mysqli_num_rows($result);
                $linha_count = mysqli_num_rows($result_count);

                if ($linha == '') {
                  echo "<h3> Não existem movimentações para este caixa!!! </h3>";
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
                  @$nome_bairro_saae      = $row_ps['nome_bairro_saae'];
                  @$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
                  @$numero_imovel_saae   = $row_ps['numero_imovel_saae'];
                  @$nome_municipio      = $row_ps['nome_municipio'];
                  @$uf_saae          = $row_ps['uf_saae'];
                  @$nome_saae        = $row_ps['nome_saae'];
                  @$email_saae        = $row_ps['email_saae'];
                  @$logo_orgao        = $row_ps['logo_orgao'];

                ?>

                  <table style="margin-bottom: 15px;">
                    <thead>
                      <tr>
                        <th style="width: 25%;"><img width="95%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                        <th>
                          <p style="margin-top: 15px; text-transform:uppercase;"><?php echo $nome_prefeitura ?> <br>
                            SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                            SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                            RELATÓRIO DE MOVIMENTO <?php if ($status == 'T') {
                                                      echo 'DO CAIXA';
                                                    } elseif ($status == 'E') {
                                                      echo 'DE ENTRADA DO CAIXA';
                                                    } elseif ($status == '') {
                                                      echo 'DO CAIXA';
                                                    } else {
                                                      echo 'DE SAÍDA DO CAIXA';
                                                    } ?> ‐ <?php echo date('d/m/Y'); ?> <br>
                            ATENDENTE <?php echo $nome_usuario; ?></p>


                        </th>
                      </tr>
                    </thead>
                  </table>

                  <form action="admin.php?acao=fatura" method="POST" target="_blank">

                    <table class="table table-sm table-striped" style="font-size: 10pt;">

                      <thead class="text-secondary">

                        <th>
                          Identificação
                        </th>
                        <th>
                          Data
                        </th>
                        <th>
                          Descrição
                        </th>
                        <th>
                          Tipo
                        </th>
                        <th>
                          Valor
                        </th>

                      </thead>
                      <tbody>

                        <?php
                        $qty = 0;
                        $qty1 = 0;
                        while ($res = mysqli_fetch_array($result)) {
                          $id_historico_movimento_caixa   = $res["id_historico_movimento_caixa"];
                          $data_cadastro_movimento        = $res["data_cadastro_movimento"];
                          $descricao_movimento            = $res["descricao_movimento"];
                          $tipo_movimento                 = $res["tipo_movimento"];
                          $valor_entrada                  = $res["valor_entrada"];
                          $valor_saida                    = $res["valor_saida"];
                          $id_termo_abertura_encerramento = $res["id_termo_abertura_encerramento"];

                          $qty += $res["valor_entrada"];
                          $valor_entrada_soma = number_format($qty, 2, ".", "");

                          $qty1 += $res["valor_saida"];
                          $valor_saida_soma = number_format($qty1, 2, ".", "");

                          $data2 = implode('/', array_reverse(explode('-', $data_cadastro_movimento)));

                          //info cx_termo_abertura_encerramento
                          $query_hc = "select * from cx_termo_abertura_encerramento where id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' and id_operador = '$id_usuario_editor' ";
                          $result_hc = mysqli_query($conexao, $query_hc);
                          $res_hc = mysqli_fetch_array($result_hc);
                          $valor_abertura = $res_hc["valor_abertura"];


                        ?>

                          <tr>

                            <td><?php echo $id_historico_movimento_caixa; ?></td>
                            <td><?php echo $data2; ?></td>
                            <td><?php echo $descricao_movimento; ?></td>

                            <td><?php if ($tipo_movimento == 'E') {
                                  echo 'ENTRADA';
                                } else {
                                  echo 'SAIDA';
                                } ?></td>

                            <td><?php if ($tipo_movimento == 'E') {
                                  echo $valor_entrada;
                                } else {
                                  echo $valor_saida;
                                } ?></td>



                          </tr>

                        <?php } ?>


                      </tbody>
                      <tfoot>

                        <?php if ($status == 'T') { ?>
                          <tr style="border-color: #c0c0c0; border-style: outset; border-width: 2px; margin-top: 30px;">

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total Registros: <?php echo $linha_count; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Valor Abertura: <?php echo $valor_abertura; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total Saídas: <?php echo $valor_saida_soma; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total Entradas: <?php echo $valor_entrada_soma; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total Geral: <?php echo number_format($valor_entrada_soma - $valor_saida_soma, 2, ".", ""); ?> </span>
                            </td>
                          </tr>
                        <?php } ?>

                        <?php if ($status == '') { ?>
                          <tr style="border-color: #c0c0c0; border-style: outset; border-width: 2px; margin-top: 30px;">

                            <td></td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Registros: <?php echo $linha_count; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Saídas: <?php echo $valor_saida_soma; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Entradas: <?php echo $valor_entrada_soma; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total Geral: <?php echo number_format($valor_entrada_soma - $valor_saida_soma, 2, ".", ""); ?> </span>
                            </td>
                          </tr>
                        <?php } ?>

                        <?php if ($status == 'E') { ?>
                          <tr style="border-color: #c0c0c0; border-style: outset; border-width: 2px; margin-top: 30px;">

                            <td></td>
                            <td></td>
                            <td></td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Registros: <?php echo $linha_count; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Entradas: <?php echo $valor_entrada_soma; ?> </span>
                            </td>

                          </tr>
                        <?php } ?>

                        <?php if ($status == 'S') { ?>
                          <tr style="border-color: #c0c0c0; border-style: outset; border-width: 2px; margin-top: 30px;">

                            <td></td>
                            <td></td>
                            <td></td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Registros: <?php echo $linha_count; ?> </span>
                            </td>

                            <td style="padding-top: 30px;">
                              <span class="text-danger" style="font-weight: bolder; ">Total de Saídas: <?php echo $valor_saida_soma; ?> </span>
                            </td>

                          </tr>
                        <?php } ?>

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
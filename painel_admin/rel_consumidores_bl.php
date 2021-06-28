<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');
?>


<?php

if ($_SESSION['nivel_usuario'] != '2' && $_SESSION['nivel_usuario'] != '0') {
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
    <title> Consumidor </title>
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

                $id_localidade  = $_POST['id_localidade'];
                $id_logradouro  = $_POST['id_logradouro'];
                $id_bairro      = $_POST['id_bairro'];
                $status         = $_POST['status'];

                //executa o store procedure info corte
                $result_sp = mysqli_query(
                  $conexao,
                  "CALL sp_lista_unidade_consumidora_logradouro($id_localidade,$id_bairro,$id_logradouro,'','$status');"
                ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                mysqli_next_result($conexao);

                //$result_count = mysqli_query($conexao, $query);
                //$result = mysqli_query($conexao, $query);
                //$result2 = mysqli_query($conexao, $query);

                $linha = mysqli_num_rows($result_sp);
                $linha_count = mysqli_num_rows($result_sp);

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

                  <table style="margin-bottom: 15px;">
                    <thead>
                      <tr>
                        <th style="width: 25%;"><img width="95%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                        <th>
                          <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                            SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                            SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                            RELATÓRIO DE CONSUMIDORES POR BAIRRO E LOGRADOURO ‐ <?php echo $data ?></p>
                        </th>
                      </tr>
                    </thead>
                  </table>

                  <form action="admin.php?acao=fatura" method="POST" target="_blank">

                    <table class="table table-sm table-striped" style="font-size: 10pt;">

                      <thead class="text-secondary">

                        <?php

                        //trazendo info localidade
                        $query_lo = "SELECT * from localidade where id_localidade = '$id_localidade' ";
                        $result_lo = mysqli_query($conexao, $query_lo);
                        $row_lo = mysqli_fetch_array($result_lo);
                        @$nome_localidade = $row_lo["nome_localidade"];

                        //trazendo info bairro
                        $query_ba = "SELECT * from bairro where id_localidade = '$id_localidade' and id_bairro = '$id_bairro' ";
                        $result_ba = mysqli_query($conexao, $query_ba);
                        $row_ba = mysqli_fetch_array($result_ba);
                        @$nome_bairro = $row_ba["nome_bairro"];

                        //trazendo info logradouro
                        $query_log = "SELECT * from logradouro where id_bairro = '$id_bairro' and id_logradouro = '$id_logradouro' ";
                        $result_log = mysqli_query($conexao, $query_log);
                        $row_log = mysqli_fetch_array($result_log);
                        @$nome_logradouro = $row_log["nome_logradouro"];
                        @$tipo_logradouro = $row_log["tipo_logradouro"];
                        @$cep = $row_log["cep_logradouro"];

                        //trazendo info tipo_logradouro
                        $query_tp = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$tipo_logradouro' ";
                        $result_tp = mysqli_query($conexao, $query_tp);
                        $row_tp = mysqli_fetch_array($result_tp);
                        @$tipo = $row_tp['abreviatura_tipo_logradouro'];

                        ?>

                        <ul>
                          <li><strong>LOCALIDADE: <?php echo $nome_localidade; ?>, BAIRRO: <?php echo $nome_bairro; ?>, LOGRADOURO: <?php echo $tipo . ' ' . $nome_logradouro ?></strong></li>
                        </ul>

                        <th>
                          Matrícula
                        </th>
                        <th>
                          Nome
                        </th>
                        <th>
                          Complemento
                        </th>
                        <th>
                          N°
                        </th>
                        <th>
                          Data de Cadastro
                        </th>
                        <th>
                          Status
                        </th>

                      </thead>
                      <tbody>

                        <?php
                        while ($res = mysqli_fetch_array($result_sp)) {

                          $uc            = $res["UC"];
                          $nome_razao_social   = $res["NOME"];
                          $numero_cpf_cnpj    = $res["CPF_CNPJ"];
                          $data_cadastro     = $res["CADASTRO"];
                          $complemento       = $res["COMPLEMENTO"];
                          $status_ligacao     = $res["STATUS"];
                          $numero          = $res["NUMERO"];

                          $id_usuario_editor = $_SESSION['id_usuario'];

                        ?>

                          <tr>

                            <td class="text-danger"><?php echo $uc; ?></td>
                            <td><?php echo $nome_razao_social; ?></td>
                            <td><?php echo $complemento; ?></td>
                            <td><?php echo $numero; ?></td>
                            <td><?php echo $data_cadastro; ?></td>
                            <td><?php echo $status_ligacao; ?></td>


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


                          <td>
                            <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                          </td>
                        </tr>

                      </tfoot>


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
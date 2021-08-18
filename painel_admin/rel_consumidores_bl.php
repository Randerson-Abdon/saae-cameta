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

                if ($id_localidade == '---Escolha uma opção---') {
                  echo "<script language='javascript'>window.alert('Selecione a localidade!!!');</script>";
                  echo "<script language='javascript'>window.close();</script>";
                  exit();
                }
                if ($id_logradouro == '---Escolha uma opção---') {
                  $id_logradouro = '0';
                }
                if ($id_bairro == '---Escolha uma opção---') {
                  $id_bairro = '0';
                }

                //executa o store procedure info corte
                $result_sp = mysqli_query(
                  $conexao,
                  "CALL sp_lista_unidade_consumidora_logradouro($id_localidade,$id_bairro,$id_logradouro,'','$status');"
                ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                mysqli_next_result($conexao);

                //$result_count = mysqli_query($conexao, $query);
                //$result = mysqli_query($conexao, $query);
                //$result2 = mysqli_query($conexao, $query);

                //consulta para recuperação do nome do bairro
                $query_ba = "SELECT * FROM enderecamento_bairro WHERE id_localidade = '$id_localidade' AND id_bairro = '$id_bairro' ";
                $result_ba = mysqli_query($conexao, $query_ba);
                $row_ba = mysqli_fetch_array($result_ba);
                //vai para a modal
                $nome_bairro = $row_ba['nome_bairro'];

                //consulta para recuperação do nome do logradouro
                $query_log = "SELECT * FROM enderecamento_logradouro WHERE id_localidade = '$id_localidade' AND id_logradouro = '$id_logradouro' AND id_bairro = '$id_bairro' ";
                $result_log = mysqli_query($conexao, $query_log);
                $row_log = mysqli_fetch_array($result_log);
                //vai para a modal
                $nome_logradouro = $row_log['nome_logradouro'];
                $id_tipo_logradouro = $row_log['tipo_logradouro'];

                //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
                $query_u = "SELECT * FROM tipo_logradouro WHERE id_tipo_logradouro = '$id_tipo_logradouro' ";
                $result_u = mysqli_query($conexao, $query_u);
                $row_u = mysqli_fetch_array($result_u);
                $abreviatura = $row_u['abreviatura_tipo_logradouro'];

                $linha = mysqli_num_rows($result_sp);
                $linha_count = mysqli_num_rows($result_sp);

                if ($linha_count == '') {
                  echo "<h3 class='text-danger'> Não foram encontrados registros com esses parametros!!! </h3>";
                } else {

                  //trazendo info perfil_saae
                  $query_p = "SELECT * from perfil_saae";
                  $result_p = mysqli_query($conexao, $query_p);
                  $row_p = mysqli_fetch_array($result_p);
                  @$nome_prefeitura     = $row_p['nome_prefeitura'];
                  //mascarando cnpj
                  @$cnpj_saae = $row_p['cnpj_saae'];
                  $p1 = substr($cnpj_saae, 0, 2);
                  $p2 = substr($cnpj_saae, 2, 3);
                  $p3 = substr($cnpj_saae, 5, 3);
                  $p4 = substr($cnpj_saae, 8, 4);
                  $p5 = substr($cnpj_saae, 12, 2);
                  $saae_cnpj = $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4 . '-' . $p5;

                  @$nome_bairro_saae      = $row_p['nome_bairro_saae'];
                  @$nome_logradouro_saae  = $row_p['nome_logradouro_saae'];
                  @$numero_imovel_saae    = $row_p['numero_imovel_saae'];
                  @$nome_municipio_saae   = $row_p['nome_municipio_saae'];
                  @$uf_saae               = $row_p['uf_saae'];
                  @$nome_saae             = $row_p['nome_saae'];
                  @$email_saae            = $row_p['email_saae'];

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
                            RELATÓRIO DE CONSUMIDORES DE SANTA IZABEL <br><?php if ($id_bairro != '0') {
                                                                            echo 'BAIRRO ' . $nome_bairro;
                                                                          } ?><?php if ($id_logradouro != '0') {
                                                                                echo ' - ' . $abreviatura . $nome_logradouro;
                                                                              } ?> ‐ <?php echo $data ?></p>
                        </th>
                      </tr>
                    </thead>
                  </table>

                  <form action="admin.php?acao=fatura" method="POST" target="_blank">

                    <table class="table table-sm table-striped" style="font-size: 10pt;">

                      <thead class="text-secondary">

                        <th>
                          N° U.C.
                        </th>
                        <th>
                          Nome
                        </th>
                        <th>
                          CPF/CNPJ
                        </th>
                        <th>
                          Data de Cadastro
                        </th>
                        <th>
                          Contato
                        </th>
                        <th>
                          Status
                        </th>

                      </thead>
                      <tbody>

                        <?php
                        while ($res = mysqli_fetch_array($result_sp)) {

                          $uc                 = $res["UC"];
                          $nome_razao_social  = $res["NOME"];
                          $numero_cpf_cnpj    = $res["CPF_CNPJ"];
                          $data_cadastro      = $res["CADASTRO"];
                          $fone_movel         = $res["CELULAR"];
                          if ($fone_movel == null) {
                            $fone_movel = 'INEXISTENTE';
                          }

                          $status_ligacao     = $res["STATUS"];

                          $id_usuario_editor = $_SESSION['id_usuario'];

                        ?>

                          <tr>

                            <td class="text-danger"><?php echo $uc; ?></td>
                            <td><?php echo $nome_razao_social; ?></td>
                            <td><?php echo $numero_cpf_cnpj; ?></td>
                            <td><?php echo $data_cadastro; ?></td>
                            <td><?php echo $fone_movel; ?></td>
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
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
    <title> Relatório de Débitos </title>
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

  <!-- EXIBIÇÃO PERFIL -->
  <?php
  $id_localidade  = $_POST['id_localidade'];
  $id_bairro      = $_POST['id_bairro'];
  if ($id_bairro == '---Escolha uma opção---') {
    $id_bairro = '0';
  }
  @$id_logradouro  = $_POST['id_logradouro'];
  if ($id_logradouro == '---Escolha uma opção---') {
    $id_logradouro = '0';
  } elseif ($id_logradouro == '') {
    $id_logradouro = '0';
  }
  $fat_atrazo     = $_POST['fat_atrazo'];

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

  //trazendo info localidade
  $query_lo = "SELECT * from enderecamento_localidade where id_localidade = '$id_localidade' ";
  $result_lo = mysqli_query($conexao, $query_lo);
  $row_lo = mysqli_fetch_array($result_lo);
  @$nome_localidade = $row_lo["nome_localidade"];

  //trazendo info bairro
  $query_ba = "SELECT * from enderecamento_bairro where id_localidade = '$id_localidade' and id_bairro = '$id_bairro' ";
  $result_ba = mysqli_query($conexao, $query_ba);
  $row_ba = mysqli_fetch_array($result_ba);
  @$nome_bairro = $row_ba["nome_bairro"];

  //trazendo info logradouro
  $query_log = "SELECT * from enderecamento_logradouro where id_bairro = '$id_bairro' and id_logradouro = '$id_logradouro' ";
  $result_log = mysqli_query($conexao, $query_log);
  $row_log = mysqli_fetch_array($result_log);
  @$nome_logradouro = $row_log["nome_logradouro"];
  @$tipo_logradouro = $row_log["tipo_logradouro"];

  //trazendo info tipo_logradouro
  $query_tp = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$tipo_logradouro' ";
  $result_tp = mysqli_query($conexao, $query_tp);
  $row_tp = mysqli_fetch_array($result_tp);
  @$tipo = $row_tp['abreviatura_tipo_logradouro'];


  //executa o store procedure info corte
  $result_sp = mysqli_query(
    $conexao,
    "CALL sp_lista_corte_debito($id_localidade,$id_bairro,$id_logradouro,$fat_atrazo);"
  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
  mysqli_next_result($conexao);

  $row = mysqli_num_rows($result_sp);


  //executa o store procedure info corte
  $result_total = mysqli_query(
    $conexao,
    "CALL sp_resumo_lista_corte_debito($id_localidade,$id_bairro,$id_logradouro,$fat_atrazo);"
  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
  mysqli_next_result($conexao);
  $row_lo = mysqli_fetch_array($result_total);
  @$total = $row_lo["TOTAL"];
  @$total_j_m = $row_lo["J/M*"];
  @$total_final = $row_lo["TOTAL GERAL"];


  ?>
  <section>
    <?php
    if ($row > 0) {
    ?>

      <div class="content">
        <div class="row mr-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <form action="rel_corte.php" method="POST" target="_blank">
                    <table style="margin-bottom: 15px;">
                      <thead>
                        <tr>
                          <th style="width: 25%;"><img width="95%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
                          <th>
                            <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                              SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                              SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                              RELATÓRIO DE DÉBITOS - LOCALIDADE: <?php echo $nome_localidade; ?>, BAIRRO: <?php echo $nome_bairro; ?> e LOGRADOURO: <?php echo $tipo . ' ' . $nome_logradouro; ?> </p>
                          </th>
                        </tr>
                      </thead>
                    </table>
                    <table class="table table-sm table-hover" style="font-size: 8pt;">
                      <thead class="text-secondary">

                        <div id="noprint" class="row">
                          <div class="form-group col-md-12" style="margin-bottom: -4px; font-size: 8pt;">
                            <label class="text-danger" for="id_produto">M/J* -> Multas e juros estimados e calculados até a data de <?php echo date('d/m/Y'); ?>.</label>
                          </div>
                        </div>

                        <th>
                          Matrícula
                        </th>
                        <th>
                          Nome
                        </th>
                        <th>
                          Logradouro
                        </th>
                        <th>
                          N°
                        </th>
                        <th>
                          Bairro
                        </th>
                        <th>
                          Em atraso
                        </th>
                        <th>
                          Faturado
                        </th>
                        <th>
                          *J/M
                        </th>
                        <th>
                          Total Faturado
                        </th>

                      </thead>
                      <tbody>

                        <?php
                        while ($res = mysqli_fetch_array($result_sp)) {

                          $uc                = $res["N.º UC"];
                          $nome_razao_social = $res["NOME"];
                          $nome_logradouro   = $res["LOGRADOURO"];
                          $numero_logradouro = $res["NÚMERO"];
                          $nome_bairro       = $res["BAIRRO"];
                          $qtde              = $res["QTDE"];
                          $faturado          = $res["TOTAL"];
                          $jurus_multa       = $res["J/M*"];
                          $total_faturado    = $res["TOTAL GERAL"];

                          $id_usuario_editor = $_SESSION['id_usuario'];

                        ?>

                          <tr>

                            <td class="text-danger"><?php echo $uc; ?></td>
                            <td><?php echo $nome_razao_social; ?></td>
                            <td><?php echo $nome_logradouro; ?></td>
                            <td><?php echo $numero_logradouro; ?></td>
                            <td><?php echo $nome_bairro; ?></td>
                            <td><?php echo $qtde; ?></td>
                            <td><?php echo $faturado; ?></td>
                            <td><?php echo $jurus_multa; ?></td>
                            <td><?php echo $total_faturado; ?></td>

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
                            <span class="text-danger">Registros: <?php echo $row; ?> </span>
                          </td>

                          <td>
                            <span class="text-danger">Total: <?php echo $total; ?> </span>
                          </td>

                          <td>
                            <span class="text-danger">*J/M: <?php echo $total_j_m; ?> </span>
                          </td>

                          <td>
                            <span class="text-danger">Total Geral: <?php echo $total_final; ?> </span>
                          </td>
                        </tr>

                      </tfoot>


                    </table>
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
              <?php  } else { ?>

                <p class="h5 text-danger">Nâo foram encontrados registros com esses parametros!</p>

              <?php }
              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

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

</body>

</html>
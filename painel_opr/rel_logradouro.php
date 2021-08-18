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
    <title> Logradouros </title>
  </h1>
  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- LINK DO fontawesome via cdn(navegador) para icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/style.css" media="screen" />
  <script src="js/jquery-2.1.3.js"></script>

  <style>
    @media print {
      #container {
        display: none;
      }

      #imprimir {
        display: none;
      }

      body {
        background: #fff;
      }
    }
  </style>


</head>

<body>

  <script>
    window.print();
    window.addEventListener("afterprint", function(event) {
      window.close();
    });
    window.onafterprint();
  </script>

  <div id="container" style="z-index: 3;">
    <div id="loader"></div>
    <div id="content" style="display: none;">


    </div>
  </div>

  <script type="text/javascript">
    // Este evendo é acionado após o carregamento da página
    jQuery(window).load(function() {
      //Após a leitura da pagina o evento fadeOut do loader é acionado, esta com delay para ser perceptivo em ambiente fora do servidor.
      jQuery("#loader").delay(2000).fadeOut("slow");
    });
  </script>

  <!-- EXIBIÇÃO PERFIL -->

  <div class="container ml-4" id="conteudo">


    <br>


    <div class="content">
      <div class="row mr-3">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
              <div class="table-responsive">

                <!--LISTAR TODOS OS LOGRADOUROS -->
                <?php

                $query_count = "SELECT * from enderecamento_logradouro";
                $result_count = mysqli_query($conexao, $query_count);
                $linha_count = mysqli_num_rows($result_count);

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
                          RELATÓRIO DA COMPOSIÇÃO DE LOGRADOUROS ‐ <?php echo $data ?></p>
                      </th>
                    </tr>
                  </thead>
                </table>

                <table class="table table-sm">
                  <thead class="text-secondary">

                    <th>
                      Nome
                    </th>
                    <th>
                      CEP
                    </th>
                    <th>
                      Localidade
                    </th>
                    <th>
                      Bairro
                    </th>

                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result_count)) {
                      $nome_logradouro = $res["nome_logradouro"];
                      $tipo_logradouro = $res["tipo_logradouro"];
                      $cep_logradouro = $res["cep_logradouro"];
                      $localidade = $res["id_localidade"];
                      $bairro = $res["id_bairro"];
                      $id = $res["id_logradouro"];

                      //$data2 = implode('/', array_reverse(explode('-', $data_ultima_edicao_logradouro)));

                      //trazendo o nome da categoria que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_localidade = "SELECT * from enderecamento_localidade where id_localidade = '$localidade' ";
                      $result_localidade = mysqli_query($conexao, $query_localidade);
                      $row_localidade = mysqli_fetch_array($result_localidade);
                      $nome_localidade = $row_localidade['nome_localidade'];

                      //trazendo o nome do bairro que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_bairro = "SELECT * from enderecamento_bairro where id_bairro = '$bairro' ";
                      $result_bairro = mysqli_query($conexao, $query_bairro);
                      $row_bairro = mysqli_fetch_array($result_bairro);
                      $nome_bairro = $row_bairro['nome_bairro'];

                      //trazendo o nome do tipo logradouro que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_t_log = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$tipo_logradouro' ";
                      $result_t_log = mysqli_query($conexao, $query_t_log);
                      $row_t_log = mysqli_fetch_array($result_t_log);
                      $nome_t_log = $row_t_log['descricao_tipo_logradouro'];

                    ?>

                      <tr>

                        <td><?php echo $nome_t_log; ?> <?php echo $nome_logradouro; ?></td>
                        <td id="cepp"><?php echo $cep_logradouro; ?></td>
                        <td><?php echo $nome_localidade; ?></td>
                        <td><?php echo $nome_bairro; ?></td>

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

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</body>

</html>
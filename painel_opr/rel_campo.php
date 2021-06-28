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
    <title> OS </title>
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
  if (@$_GET['func'] == 'imprime') {
    $id = $_GET['id'];

    $query_cri = "select * from ordem_servico where id_ordem_servico = '$id' ";
    $result_cri = mysqli_query($conexao, $query_cri);

    while ($res = mysqli_fetch_array($result_cri)) {
      $id_requerimento = $res['id_requerimento'];
      $data_inicio_servico = $res['data_inicio_servico'];
      $hora_inicio_servico = $res['hora_inicio_servico'];
      $data_conclusao_servico = $res['data_conclusao_servico'];
      $hora_conclusao_servico = $res['hora_conclusao_servico'];
      $observacoes = $res['observacoes'];
      $status_ordem_servico = $res['status_ordem_servico'];

      //trazendo info do requerimento
      $query_rq = "SELECT * from requerimento where id_requerimento = '$id_requerimento' ";
      $result_rq = mysqli_query($conexao, $query_rq);
      $row_rq = mysqli_fetch_array($result_rq);
      $nome_razao_social = $row_rq['nome_razao_social'];
      $id_unidade_consumidora = $row_rq['id_unidade_consumidora'];
      $numero_cpf_cnpj = $row_rq['numero_cpf_cnpj'];
      $fone_movel = $row_rq['fone_movel'];
      $data_requerimento = $row_rq['data_requerimento'];
      $status_requerimento = $row_rq['status_requerimento'];

      $data2 = implode('/', array_reverse(explode('-', $data_requerimento)));


      //trazendo info endereco_instalacao
      $query_e = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id_unidade_consumidora' ";
      $result_e = mysqli_query($conexao, $query_e);
      $row_e = mysqli_fetch_array($result_e);
      $id_localidade = $row_e['id_localidade'];
      $id_bairro = $row_e['id_bairro'];
      $id_logradouro = $row_e['id_logradouro'];
      $numero_logradouro = $row_e['numero_logradouro'];
      $complemento_logradouro = $row_e['complemento_logradouro'];

      //consulta para recuperação do nome da localidade
      $query_loc = "select * from localidade where id_localidade = '$id_localidade' ";
      $result_loc = mysqli_query($conexao, $query_loc);
      $row_loc = mysqli_fetch_array($result_loc);
      //vai para a modal
      $nome_loc = $row_loc['nome_localidade'];

      //consulta para recuperação do nome do bairro
      $query_ba = "select * from bairro where id_bairro = '$id_bairro' ";
      $result_ba = mysqli_query($conexao, $query_ba);
      $row_ba = mysqli_fetch_array($result_ba);
      //vai para a modal
      $nome_ba = $row_ba['nome_bairro'];

      //consulta para recuperação do nome do logradouro
      $query_log = "select * from logradouro where id_logradouro = '$id_logradouro' ";
      $result_log = mysqli_query($conexao, $query_log);
      $row_log = mysqli_fetch_array($result_log);
      //vai para a modal
      $nome_log = $row_log['nome_logradouro'];
      $id_tipo_logradouro = $row_log['tipo_logradouro'];

      //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
      $query_u = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
      $result_u = mysqli_query($conexao, $query_u);
      $row_u = mysqli_fetch_array($result_u);
      $abreviatura_tipo_logradouro = $row_u['abreviatura_tipo_logradouro'];

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

      <!-- MODAL PERFIL -->

      <table table style="margin-bottom: 15px;">
        <thead>
          <tr>
            <th style="width: 25%;"><img width="95%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
            <th>
              <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                FICHA DE ORDEM DE SERVIÇO EM CAMPO <?php echo $data ?></p>
            </th>
          </tr>
        </thead>
      </table>

      <form>
        <h3 class="modal-title">Ordem de Serviço</h3>
        <hr>
        <h5 class="modal-title">Dados</h5>
        <hr>
        <div class="row">

          <div class="form-group col-md-2">
            <label for="id_produto">Nº OS</label>
            <input type="text" class="form-control mr-2" name="id_ordem_servico" value="<?php echo $id; ?>" readonly>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto">Nº req</label>
            <input type="text" class="form-control mr-2" name="id_requerimento" value="<?php echo $id_requerimento; ?>" readonly>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto">UC</label>
            <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id_unidade_consumidora ?>" readonly>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto">CPF/CNPJ</label>
            <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" value="<?php echo $numero_cpf_cnpj ?>" readonly>
          </div>

          <div class="form-group col-md-5">
            <label for="id_produto">Nome/Razão Social</label>
            <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto">Celular</label>
            <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" readonly>
          </div>

        </div>

        <h5 class="modal-title">Endereçamento</h5>
        <hr>
        <div class="row">

          <div class="form-group col-md-4">
            <label for="id_produto">Localidade</label>
            <input type="text" class="form-control mr-2" name="nome_loc" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $nome_loc ?>" readonly>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto">Bairro</label>
            <input type="text" class="form-control mr-2" name="nome_ba" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $nome_ba ?>" readonly>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto">Logradouro</label>
            <input type="text" class="form-control mr-2" name="nome_ba" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $abreviatura_tipo_logradouro ?> <?php echo $nome_log ?>" readonly>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto">Nº Logradouro</label>
            <input type="text" class="form-control mr-2" name="numero_logradouro" placeholder="Nº" style="text-transform:uppercase;" value="<?php echo $numero_logradouro ?>" readonly>
          </div>

          <div class="form-group col-md-5">
            <label for="id_produto">Complemento</label>
            <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;" value="<?php echo $complemento_logradouro ?>" readonly>
          </div>

        </div>

        <h5 class="modal-title">Serviços Requeridos</h5>
        <hr>
        <div class="row">


          <!--INICIO DA TABELA -->
          <div class="table-responsive ml-3 mr-3">

            <!--LISTAR TODOS OS SERVIÇOS -->
            <?php

            $query = "select * from servico_requerido where id_requerimento = '$id_requerimento' order by id_servico_requerido asc";

            //execução da primeira consulta
            $result = mysqli_query($conexao, $query);

            $linha = mysqli_num_rows($result);


            if ($linha == '') {
              echo "<p> Não há serviços cadastrados para este requerimento!!! </p>";
            } else {

            ?>


              <!--- table-sm= small = menor-->
              <table class="table table-sm">
                <thead class="text-secondary">


                  <th>
                    Serviço
                  </th>

                </thead>
                <tbody>

                  <?php
                  $status_execucao = 'O';
                  while ($res = mysqli_fetch_array($result)) {
                    $id_servico_requerido = $res["id_servico_requerido"];

                    //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                    $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' AND status_execucao = '$status_execucao' ";
                    $result_sv = mysqli_query($conexao, $query_sv);
                    $row_sv = mysqli_fetch_array($result_sv);
                    $descricao_servico = $row_sv['descricao_servico'];
                    $valor_servico = $row_sv['valor_servico'];


                  ?>

                    <tr>


                      <td><?php echo $descricao_servico; ?></td>


                    </tr>

                  <?php } ?>


                </tbody>
                <tfoot>
                  <tr>

                    <td></td>

                  </tr>

                </tfoot>
              </table>

            <?php
            }

            ?>

          </div>


          <div class="form-group col-md-4">
            <label for="id_produto"><b>Data do Req.: </b></label>
            <label for="id_produto"><?php echo $data2 ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Status do Req.: </b></label>
            <label for="id_produto"><?php if ($status_requerimento == 'A') {
                                      echo 'EM ANÁLISE';
                                    } elseif ($status_requerimento == 'D') {
                                      echo 'DEFERIDO';
                                    } else {
                                      echo 'INDEFERIDO';
                                    } ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Status da OS: </b></label>
            <label for="id_produto"><?php if ($status_ordem_servico == '1') {
                                      echo 'EM ANÁLISE';
                                    } elseif ($status_ordem_servico == '2') {
                                      echo 'EM ANDAMENTO';
                                    } elseif ($status_ordem_servico == '3') {
                                      echo 'CONCLUÍDO';
                                    } else {
                                      echo 'INVIÁVEL';
                                    } ?></label>
          </div>

        </div>

        <h5 class="modal-title">Outros</h5>
        <hr>
        <div class="row">

          <div class="form-group col-md-3">
            <label for="fornecedor">Data de Inicio</label>
            <input type="date" class="form-control mr-2" maxlength="10" id="saida" name="data_inicio_servico" value="<?php echo $data_inicio_servico; ?>" readonly />
          </div>

          <div class="form-group col-md-3">
            <label for="fornecedor">Hora de Inicio</label>
            <input type="text" class="form-control mr-2">
          </div>

          <div class="form-group col-md-3">
            <label for="fornecedor">Data de Conclusão</label>
            <input type="text" class="form-control mr-2">
          </div>

          <div class="form-group col-md-3">
            <label for="fornecedor">Hora de Conclusão</label>
            <input type="text" class="form-control mr-2">
          </div>

          <div class="form-group col-md-12">
            <label for="fornecedor">Observações</label>
            <textarea type="text" maxlength="600" class="form-control mr-2" style="width: 100%; height: 150%;"></textarea>
          </div>

        </div>


        <div class="row">
          <div class="form-group text-center col-md-6" style="margin-top: 150px;">
            <label for="fornecedor">_________________________________________________________</label>
          </div>

          <div class="form-group text-center col-md-6" style="margin-top: 150px;">
            <label for="fornecedor">_________________________________________________________</label>
          </div>
        </div>

        <div class="row">
          <div class="form-group text-center col-md-6" style="margin-top: -30px;">
            <label class="ml-20" for="fornecedor"> Operador Responsável</label>
          </div>
          <div class="form-group text-center col-md-6" style="margin-top: -30px;">
            <label class="ml-20" for="fornecedor"> Técnico Responsável</label>
          </div>
        </div>

        </div>


      </form>


  <?php }
  } ?>

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
    $("input[id*='cel']").inputmask({
      mask: ['(99) 99999-9999'],
      keepStatic: true
    });
  </script>
  <script>
    $("input[id*='fone']").inputmask({
      mask: ['(99) 9999-9999'],
      keepStatic: true
    });
  </script>


</body>

</html>
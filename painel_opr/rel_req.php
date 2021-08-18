<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');
?>


<?php

if ($_SESSION['nivel_usuario'] != '2' && $_SESSION['nivel_usuario'] != '0' && $_SESSION['nivel_usuario'] != '77') {
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
    <title> Requerimento </title>
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

    $query = "select * from requerimento_servico where id_requerimento = '$id' ";
    $result = mysqli_query($conexao, $query);

    while ($res = mysqli_fetch_array($result)) {
      $id_requerimento = $res['id_requerimento'];
      $existe_unidade_consumidora = $res['existe_unidade_consumidora'];
      $id_unidade_consumidora = $res['id_unidade_consumidora'];
      $tipo_juridico = $res['tipo_juridico'];
      $numero_cpf_cnpj = $res['numero_cpf_cnpj'];
      $nome_razao_social = $res['nome_razao_social'];
      $numero_rg = $res['numero_rg'];
      $orgao_emissor_rg = $res['orgao_emissor_rg'];
      $uf_rg = $res['uf_rg'];

      $fone_fixo = $res['fone_fixo'];
      $fone_movel = $res['fone_movel'];
      $fone_movel_zap = $res['fone_movel_zap'];
      $email = $res['email'];

      $observacoes = $res['observacoes'];
      $status_requerimento = $res['status_requerimento'];
      $data_requerimento = $res['data_requerimento'];

      $data_requerimento = substr($data_requerimento, 0, 10);

      $data_requerimento2 = implode('/', array_reverse(explode('-', $data_requerimento)));

      //RECUPERAÇÃO DE ENDEREÇAMENTO
      $localidade = '01';

      //executa o store procedure info consumidor
      $result_sp2 = mysqli_query(
        $conexao,
        "CALL sp_seleciona_unidade_consumidora($localidade,$id_unidade_consumidora);"
      ) or die("Erro na query da procedure: " . mysqli_error($conexao));
      mysqli_next_result($conexao);
      $row_uc = mysqli_fetch_array($result_sp2);
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

      <!-- MODAL PERFIL -->

      <table style="margin-bottom: 15px;">
        <thead>
          <tr>
            <th style="width: 20%;"><img width="80%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
            <th>
              <p><?php echo $nome_prefeitura ?> <br>
                SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                SOLICITAÇÃO DE REQUERIMENTO</p>
            </th>
          </tr>
        </thead>
      </table>

      <form>
        <h3 class="modal-title">Requerimento</h3>
        <hr>
        <h5 class="modal-title">Dados Pessoais</h5>
        <hr>
        <div class="row">

          <div class="form-group col-md-2">
            <label for="id_produto"><b>Nº Req: </b></label>
            <label for="id_produto"><?php echo $id_requerimento ?></label>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto"><b><?php if ($existe_unidade_consumidora == 'N') {
                                          echo 'UC Provisória';
                                        } else {
                                          echo 'UC';
                                        } ?>: </b></label>
            <label for="id_produto"><?php echo $id_unidade_consumidora ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Tipo Jurídico: </b></label>
            <label for="id_produto"><?php if ($tipo_juridico == 'F') {
                                      echo 'Pessoa Física';
                                    } else {
                                      echo 'Pessoa Juridica';
                                    } ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>CPF/CNPJ: </b></label>
            <label id="numero_cpf_cnpj" for="id_produto"><?php echo $numero_cpf_cnpj ?></label>
          </div>

          <div class="form-group col-md-5">
            <label for="id_produto"><b>Nome: </b></label>
            <label for="id_produto"><?php echo $nome_razao_social ?></label>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto"><b>RG: </b></label>
            <label for="id_produto"><?php echo $numero_rg ?></label>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto"><b>Orgão Emissor: </b></label>
            <label for="id_produto"><?php echo $orgao_emissor_rg ?></label>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto"><b>UF RG: </b></label>
            <label for="id_produto"><?php echo $uf_rg ?></label>
          </div>

        </div>

        <h5 class="modal-title">Endereçamento</h5>
        <hr>
        <div class="row">

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Localidade: </b></label>
            <label for="id_produto"><?php echo $nome_localidade ?></label>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto"><b>Bairro: </b></label>
            <label for="id_produto"><?php echo $nome_bairro ?></label>
          </div>

          <div class="form-group col-md-5">
            <label for="id_produto"><b>Logradouro: </b></label>
            <label for="id_produto"><?php echo $nome_logradouro ?></label>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto"><b>Número: </b></label>
            <label for="id_produto"><?php echo $numero_logradouro ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Complemento: </b></label>
            <label for="id_produto"><?php echo $complemento_logradouro ?></label>
          </div>

        </div>

        <h5 class="modal-title">Contato</h5>
        <hr>
        <div class="row">

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Telefone Fixo: </b></label>
            <label id="fone" for="id_produto"><?php echo $fone_fixo ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>Celular: </b></label>
            <label id="cel" for="id_produto"><?php echo $fone_movel ?></label>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto"><b>WhatsApp: </b></label>
            <label for="id_produto"><?php if ($fone_movel_zap == 'S') {
                                      echo 'SIM';
                                    } else {
                                      echo 'Não';
                                    } ?></label>
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto"><b>E-mail: </b></label>
            <label for="id_produto"><?php echo $email ?></label>
          </div>

        </div>

        <h5 class="modal-title">Serviços Requeridos</h5>
        <hr>
        <div class="row">


          <!--INICIO DA TABELA -->
          <div class="table-responsive ml-3 mr-3">

            <!--LISTAR TODOS OS CURSOS -->
            <?php

            $query = "select * from servico_requerido where id_requerimento = '$id' order by id_servico_requerido asc";

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
                  <th>
                    Valor
                  </th>

                </thead>
                <tbody>

                  <?php
                  $soma = 0;
                  while ($res = mysqli_fetch_array($result)) {
                    $id_servico_requerido = $res["id_servico_requerido"];

                    //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                    $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' ";
                    $result_sv = mysqli_query($conexao, $query_sv);
                    $row_sv = mysqli_fetch_array($result_sv);
                    $descricao_servico = $row_sv['descricao_servico'];
                    $valor_servico = $row_sv['valor_servico'];

                    $soma = $soma + $row_sv['valor_servico'];

                    $soma2 = number_format($soma, 2, ",", ".");


                  ?>

                    <tr>


                      <td><?php echo $descricao_servico; ?></td>
                      <td><?php echo $valor_servico; ?></td>


                    </tr>

                  <?php } ?>


                </tbody>
                <tfoot>
                  <tr>

                    <td></td>

                    <td>
                      <span class="text-muted">Total: <?php echo $soma2 ?> </span>
                    </td>
                  </tr>

                </tfoot>
              </table>

            <?php
            }

            ?>

          </div>

          <p style="margin-left: 20px;">
            M.D . Sr(a) Diretor(a) do SERVIÇO AUT . DE ÁGUA E ESGOTO DE SANTA IZABEL <br><br>
            Venho nesta data e , através deste , requerer que v.sa . se digne a autorizar a execução dos serviços acima relacionados. <br><br>
            Nestes termos, <br><br>
            Pede deferimento. <br><br><br>
          </p>


          <div class="form-group col-md-4">
            <label for="id_produto"><b>Data do Requerimento: </b></label>
            <label for="id_produto"><?php echo $data_requerimento2 ?></label>
          </div>

          <div class="form-group col-md-5">
            <label for="id_produto"><b>Status do Requerimento: </b></label>
            <label for="id_produto"><?php if ($status_requerimento == 'A') {
                                      echo 'EM ANÁLISE';
                                    } elseif ($status_requerimento == 'D') {
                                      echo 'DEFERIDO';
                                    } else {
                                      echo 'INDEFERIDO';
                                    } ?></label>
          </div>

          <div class="form-group col-md-6">
            <label for="id_produto"><b>Observações: </b></label>
            <label for="id_produto"><?php echo $observacoes ?></label>
          </div>

        </div>

        <div class="row">
          <div class="form-group text-center col-md-6" style="margin-top: 50px;">
            <label for="fornecedor">_________________________________________________________</label>
          </div>

          <div class="form-group text-center col-md-6" style="margin-top: 50px;">
            <label for="fornecedor">_________________________________________________________</label>
          </div>
        </div>

        <div class="row">
          <div class="form-group text-center col-md-6" style="margin-top: -30px;">
            <label class="ml-20" for="fornecedor"> <?php echo $nome_razao_social; ?></label>
          </div>
          <div class="form-group text-center col-md-6" style="margin-top: -30px;">
            <label class="ml-20" for="fornecedor"> Atendente Responsável</label>
          </div>
        </div>

        <div class="row">
          <div class="form-group text-center col-md-6" style="margin-top: -30px;">
            <label class="ml-20" for="fornecedor"> C.P.F.: <?php echo $numero_cpf_cnpj; ?></label>
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
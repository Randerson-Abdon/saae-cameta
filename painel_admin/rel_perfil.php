<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');
?>


<?php

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
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

  <!-- EXIBIÇÃO PERFIL -->
  <?php
  if (@$_GET['func'] == 'imprime') {
    $id = $_GET['id'];

    $localidade = '01';

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

    <!-- MODAL PERFIL -->

    <table style="margin-bottom: 15px;">
      <thead>
        <tr>
          <th style="width: 20%;"><img width="80%" src="../img/sIzabel/saae_sIzabel_logo.png" alt=""></th>
          <th>
            <p><?php echo $nome_prefeitura; ?> <br>
              SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
              SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
              FICHA DE CADASTRO DO CONSUMIDOR
          </th>
        </tr>
      </thead>
    </table>

    <form>
      <h3 class="modal-title">Consumidor</h3>
      <hr>
      <h5 class="modal-title">Dados Pessoais</h5>
      <hr>
      <div class="row">

        <div class="form-group col-md-2">
          <label for="id_produto"><b>UC: </b></label>
          <label for="id_produto"><?php echo $id ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>Tipo Jurídico: </b></label>
          <label for="id_produto"><?php echo $tipo_juridico ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>CPF/CNPJ: </b></label>
          <label id="numero_cpf_cnpj" for="id_produto"><?php echo $numero_cpf_cnpj ?></label>
        </div>

        <div class="form-group col-md-5">
          <label for="id_produto"><b>Nome/Razão Social: </b></label>
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

        <div class="form-group col-md-4">
          <label for="id_produto"><b>Bairro: </b></label>
          <label for="id_produto"><?php echo $nome_bairro ?></label>
        </div>

        <div class="form-group col-md-4">
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

        <div class="form-group col-md-3">
          <label for="id_produto"><b>Telefone Fixo: </b></label>
          <label id="fone" for="id_produto"><?php echo $fone_fixo ?></label>
        </div>

        <div class="form-group col-md-3">
          <label for="id_produto"><b>Celular: </b></label>
          <label id="cel" for="id_produto"><?php echo $fone_movel ?></label>
        </div>

        <div class="form-group col-md-2">
          <label for="id_produto"><b>WhatsApp: </b></label>
          <label for="id_produto"><?php echo $fone_zap ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>E-mail: </b></label>
          <label for="id_produto"><?php echo $email ?></label>
        </div>

      </div>

      <h5 class="modal-title">Dados de Fornecimento</h5>
      <hr>
      <div class="row">

        <div class="form-group col-md-5">
          <label for="id_produto"><b>Tipo de Consumo: </b></label>
          <label for="id_produto"><?php echo $tipo_consumo ?></label>
        </div>

        <div class="form-group col-md-3">
          <label for="id_produto"><b>Faixa de Consumo: </b></label>
          <label for="id_produto"><?php echo $faixa_consumo ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>Tipo de Medição: </b></label>
          <label for="id_produto"><?php echo $tipo_medicao ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>Unidade Hidrométrica: </b></label>
          <label for="id_produto"><?php echo $id_unidade_hidrometrica ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>Valor da Tarifa: </b></label>
          <label for="id_produto"><?php echo $valor_faixa_consumo ?></label>
        </div>

        <div class="form-group col-md-4">
          <label for="id_produto"><b>Status da Ligação: </b></label>
          <label for="id_produto"><?php echo $status_ligacao ?></label>
        </div>

        <div class="form-group col-md-8">
          <label for="id_produto"><b>Observações: </b></label>
          <label for="id_produto"><?php echo $observacoes_text ?></label>
        </div>

      </div>


      </div>


    </form>


  <?php } ?>

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
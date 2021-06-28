<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');

// arquivo  Que contém todas as funções
require "config/funcoes.php";
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
    <title> Decraração de Quitação de Débitos </title>
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


  <!--   <script>
    window.print();
    window.addEventListener("afterprint", function(event) {
      window.close();
    });
    window.onafterprint();
  </script> -->

  <!-- EXIBIÇÃO PERFIL -->
  <?php
  if (@$_GET['func'] == 'imprime') {
    $id         = $_GET['id'];
    $localidade = $_GET['localidade'];
    $id_usuario_editor = $_SESSION['id_usuario'];

    echo $localidade . ', ' . $id;

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
    @$nome_municipio = $row_ps['nome_municipio'];
    @$uf_saae = $row_ps['uf_saae'];
    @$nome_saae = $row_ps['nome_saae'];
    @$email_saae = $row_ps['email_saae'];
    @$logo_orgao = $row_ps['logo_orgao'];
    @$cep_saae = $row_ps['cep_saae'];
    @$fone_saae = $row_ps['fone_saae'];
    @$nome_gestor_saae = $row_ps['nome_gestor_saae'];

    $data = date('d/m/Y');

    //consulta para numeração automatica declaracao_quitacao
    $query_num_dq = "select * from declaracao_quitacao order by id_declaracao_quitacao desc ";
    $result_num_dq = mysqli_query($conexao, $query_num_dq);
    $res_num_dq = mysqli_fetch_array($result_num_dq);
    @$ultimo_dq = $res_num_dq["id_declaracao_quitacao"];
    $id_declaracao_quitacao = $ultimo_dq + 1;

    $data_emissao = date('Y-m-d');

    $lower = implode('', range('a', 'z')); // abcdefghijklmnopqrstuvwxyzy
    $nums = implode('', range(0, 9)); // 0123456789

    //gera codigo randomico aleatorio
    $alphaNumeric = $lower . $nums; // ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789
    $string = '';
    $len = 10; // numero de chars
    for ($i = 0; $i < $len; $i++) {
      $string .= $alphaNumeric[rand(0, strlen($alphaNumeric) - 1)];
    }

    $codigo_autenticacao = ltrim($id_declaracao_quitacao, "0") . $string;

    // insert declaracao_quitacao
    $query_dq = "INSERT INTO declaracao_quitacao (id_declaracao_quitacao, data_emissao, codigo_autenticacao, id_unidade_consumidora, 	id_localidade, id_requerimento, id_usuario_editor_registro) values ('$id_declaracao_quitacao', '$data_emissao', '$codigo_autenticacao', '$id', '$localidade', '0', '$id_usuario_editor')";
    $result_dq = mysqli_query($conexao, $query_dq);

    if ($result_dq == '') {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao gerar a declaração!!!'); </script>";
      exit;
    } else {
      echo "<script language='javascript'>window.alert('Declaração Gerada com Sucesso!!!'); </script>";
    }


  ?>

    <!-- MODAL PERFIL -->


    <div class="modal-body">


      <table style="margin-bottom: 15px;">
        <thead>
          <tr>
            <th style="width: 25%;"><img width="95%" src="../img/parametros/<?php echo $logo_orgao; ?>" alt=""></th>
            <th>
              <p style="margin-top: 18px;"><?php echo $nome_prefeitura ?> <br>
                SERVIÇO AUTÔNOMO DE ÁGUA E ESGOTO ‐ SAAE <br>
                AUTARQUIA PÚBLICA MUNICIPAL <br>
                SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
              </p>
            </th>
          </tr>
        </thead>
      </table>
      <br><br><br><br>

      <p class="text-justify" style="padding-left: 5%; padding-right: 5%; font-size: 10pt;">
        <span style="margin-left: 25%;"><strong>DECLARAÇÃO DE QUITAÇÃO DE DÉBITO</strong></span><br><br>

        <b><u>CONSUMIDOR:</u></b><br>
        <span>NOME: <b><?php echo $nome_razao_social; ?></b></span>
        <span style="margin-left: 20px;">CPF: <b><?php echo $numero_cpf_cnpj; ?></b></span>
        <span style="margin-left: 20px;"> Matrícula: <b><?php echo $id; ?></b></span><br>

        <span>LOCALIDADE: <b><?php echo $nome_localidade; ?></b></span>
        <span style="margin-left: 20px;">BAIRRO: <b><?php echo $nome_bairro; ?></b></span>
        <span style="margin-left: 20px;">LOGRADOURO: <b><?php echo $nome_logradouro; ?></b></span>
        <span style="margin-left: 20px;">Nº: <b><?php echo $numero_logradouro; ?></b></span>
        <span style="margin-left: 20px;">CEP: <b><?php echo $cep_logradouro; ?></b></span><br>

        <span>TARIFA: <b>CONSUMO DE ÁGUA</b></span>
        <span style="margin-left: 20px;">PERÍODO: <b>DATA DE CADASTRO <?php echo $data_cadastro; ?> ATÉ <?php echo date('d/m/Y'); ?></b></span><br><br><br>

        <span style="margin-left: 80px;" />Para fins de direito e em atenção à Lei Federal nº 12.007/09, face às informações preliminares o SAAE (Serviço Autônomo de Água e Esgoto) do Município de <?php echo $nome_municipio; ?>, DECLARA que não consta débito lançado e vencido até a presente data, referente ao consumo de água em nome do consumidor supracitado, ressalvando-se, toda via o direito da Fazenda Municipal de cobrar débitos porventura apurados futuramente, de responsabilidade do requerente. <br>
        <span style="margin-left: 80px;" />Por ser verdade os dados citados acima, dato e assino este documento.<br><br><br><br><br><br><br><br><br>


        <span style="float: right;"><?php echo $nome_municipio; ?> (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                          date_default_timezone_set('America/Sao_Paulo');
                                                                          echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br><br><br><br><br><br><br>

      <div class="row">
        <div class="form-group text-center col-md-12" style="margin-top: 50px;">
          <label for="fornecedor">_________________________________________________________</label>
        </div>
      </div>

      <div class="row">
        <div class="form-group text-center col-md-12" style="margin-top: -30px;">
          <label class="ml-20" for="fornecedor"> <?php echo $nome_gestor_saae; ?></label>
        </div>
      </div>

      <div class="row">
        <div class="form-group text-center col-md-12" style="margin-top: -30px;">
          <label class="" for="fornecedor">DIRETOR GERAL</label>
        </div>
      </div>

      <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

      <div class="text-center" style="font-size: 10pt; margin-top: 10;"><span><?php echo $nome_logradouro_saae; ?>, <?php echo $numero_imovel_saae; ?> <br>
          <?php echo $nome_bairro_saae; ?> - <?php echo $nome_municipio; ?> - <?php echo $uf_saae; ?> CEP.: <?php echo $cep_saae; ?> <br>
          Fone: <?php echo $fone_saae; ?> E-Mail: <?php echo $email_saae; ?> <br>
          CNPJ.: <?php echo $saae_cnpj; ?></span></div><br><br>


      </p>

      <p class="text-center" style="font-size: 9pt;">Para autenticação deste documento entre no endereço eletrônico: www.saaecameta.com.br, no menu AUTENTICAÇÃO DE CERTIDÕES, use o código: <?php echo $codigo_autenticacao; ?> para validação. </p>

    </div>

    </div>

    </div>


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
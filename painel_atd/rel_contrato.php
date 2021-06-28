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
    <title> Contrado de Acordo </title>
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
    $id               = $_GET['id'];
    $soma2            = $_GET['soma2'];
    $extenso          = $_GET['extenso'];
    $valorEntrada     = $_GET['valorEntrada'];
    $extenso_entrada2 = $_GET['extenso_entrada2'];
    $valor_p          = $_GET['valor_p'];
    $valor_total      = $_GET['valor_total'];
    $nParcelas        = $_GET['nParcelas'];
    $localidade       = $_GET['id_localidade'];

    //executa o store procedure info consumidor
    $result_sp = mysqli_query(
      $conexao,
      "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
    ) or die("Erro na query da procedure y: " . mysqli_error($conexao));
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
    @$email_saae = $row_ps['email_saae'];

    $data = date('d/m/Y');


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
                SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL ‐ SAAENET <br>
                CONTRATO DE CONFISSÃO E PARCELAMENTO DE DÍVIDAS - <?php echo $data; ?></p>
            </th>
          </tr>
        </thead>
      </table>


      <p class="text-justify" style="padding-left: 5%; padding-right: 5%; font-size: 10pt;">
        <u><b>IDENTIFICAÇÃO DAS PARTES CONTRATANTES:</b></u><br>

        <b><u>DEVEDOR:</u></b><br>
        <span>NOME: <b><?php echo $nome_razao_social; ?></b></span>
        <span style="margin-left: 20px;">CPF: <b><?php echo $numero_cpf_cnpj; ?></b></span>
        <span style="margin-left: 20px;"> Matrícula: <b><?php echo $id; ?></b></span><br>

        <span>BAIRRO: <b><?php echo $nome_bairro; ?></b></span>
        <span style="margin-left: 20px;">LOGRADOURO: <b><?php echo $nome_logradouro; ?></b></span>
        <span style="margin-left: 20px;">Nº: <b><?php echo $numero_logradouro; ?></b></span>
        <span style="margin-left: 20px;">CEP: <b><?php echo $cep_logradouro; ?></b></span><br>
        <span>CREDOR: <b>SERVIÇO AUT. DE ÁGUA E ESGOTO DE <?php echo $nome_municipio; ?></b><br><br>

          As partes acima identificadas têm, entre sí, justo e acertado o presente <b>Contrato de Confissão e Parcelamento de Dívida</b>, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.<br>

          <br><b><u>OBJETO DO CONTRATO</u></b>:<br><br>

          <u><b>Cláusula 1ª</b></u>: O <b>DEVEDOR</b> através do presente reconhece expressamente que possui uma dívida a ser paga diretamente ao <b>CREDOR</b> consubstanciada no montante total de: <span><b>R$ <?php echo $soma2; ?></b></span> (<?php echo $extenso; ?>). Devidamente discriminada no <b>EXTRATO DE DÉBITO</b> em anexo a este contrato, com a devida anuência do <b>DEVEDOR</b>.<br><br>

          <u><b>Cláusula 2ª</b></u>: O <b>DEVEDOR</b> confessa que é inadimplente da quantia supracitada e que ressarcirá a mesma nas condições previstas neste contrato.<br><br>

          <u><b>DO PARCELAMENTO, INTERRUPÇÃO DO FORNECIMENTO E PENALIDADES:</b></u><br><br>

          <u><b>Cláusula 3ª</b></u>: Em acordo firmado no escritório ou balcão eletrônico do: SERVIÇO AUT. DE ÁGUA E ESGOTO DE <?php echo $nome_municipio; ?> fica acertado entre as partes o parcelamento total da dívida do cliente devedor que é de: <span><b>R$ <?php echo $soma2; ?></b></span> (<?php echo $extenso; ?>). Constituido de:<br>

          - ENTRADA: <b><span>R$ <?php echo $valorEntrada; ?></span> (<?php echo $extenso_entrada2; ?>), à vencer em: <span> <?php echo date("d/m/Y", time() + (5 * 86400)); ?></span>;</b><br>

          - PARCELAMENTO: <b>



            <?php
            $difValor = $valor_p + $valor_total;
            $difParcelas = $nParcelas - 1;

            if ($valor_total == 0) {
              echo $nParcelas . ' parcelas de R$ ' . number_format($valor_p, 2, ",", ".") . '.';
            } else {
              echo $difParcelas . ' parcelas de R$ ' . number_format($valor_p, 2, ",", ".") . ' e 1 parcela de R$ ' . number_format($difValor, 2, ",", ".") . '.';
            }


            ?>

          </b>
      </p>

      <p class="text-justify" style="padding-left: 5%; padding-right: 5%; font-size: 10pt;">
        <b><u>PARÁGRAFO ÚNICO</u></b>:<br>

        Todas as parcelas acordadas neste instrumento serão acrescidas automaticamente nas faturas mensais do <b>DEVEDOR</b>, até que ocorra a total quitação do débito constante neste contrato.<br><br>
        <b><u>Cláusula 4ª</u></b>: <b>CASO HAJA DESCUMPRIMENTO</b> do acordo o fornecimento de água do devedor será interrompido, sendo normalizado somente após a quitação total da dívida.<br><br>

        <b><u>PARÁGRAFO ÚNICO</u></b>:<br>

        No caso de descumprimento do acordo firmado não será permitido ao devedor nova renegociação e seu fornecimento de água só será normalizado nos termos da <b>Cláusula 4ª</b> deste contrato.<br><br>
        <b><u>Cláusula 5ª</u></b>: O <b>DEVEDOR</b> pagará as faturas nos postos de arrecadação devidamente autorizados pelo SAAE, e nos termos acordados na <b>Cláusula 3ª</b>. Excluindo-se desse modo, qualquer outra forma de pagamento.<br><br>
        <b><u>Cláusula 6ª</u></b>: <b>EM CASO DE LIGAÇÃO CLANDESTINA</b> devidamente identificado por um funcionário do SAAE, designado para a fiscalização , fica o cliente ciente da aplicação de multa que varia de 1 (um) a 10 (dez) salários minimos vigentes no país. E na ocorrência de reincidência, aplicação de cobrança judicial e a inclusão do nome do <b>DEVEDOR</b> no sistema <b>SERASA</b>.<br><br>

        <b><u>PARÁGRAFO 1º</u></b>: Além das sansões previstas no Regulamento aprovado pelo Decreto Municipal nº 63 de 11/05/2012, fica o cliente ciente da pena no Art. 157 do Código Penal Brasileiro que diz: "Subtrair coisa móvel alheia, para sí ou para outrem, mediante grave ameaça ou violência a pessoa, ou depois de havê-la, por qualquer meio, de reduzido resistência".<br>
        PENA: Reclusão de 4 (quatro) a 10 (dez) anos, e multa.<br><br>
        <b><u>PARÁGRAFO 2º</u></b>: O Regulamento do SAAE, através do Decreto 63 de 11/05/2012 dá a esta Autarquia Municipal o pleno poder para aplicar as medidas necessárias estabecelidas neste contrato, inclusive no que tange a interrupção do fornecimento de água como prevê o Art. 72, incisos I, IV e VIII, atendendo o prazo estabelecido pelos incisos I e II do do parágrafo 1º do Art. 72.<br><br>
        <b><u>Cláusula 7ª</u></b>: FICA ELEITO O FORO DA COMARCA DE: <?php echo $nome_municipio; ?> para dirimir qualquer assunto referente ao presente contrato.<br><br><br>

        <span style="float: right;"><?php echo $nome_municipio; ?> (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                          date_default_timezone_set('America/Sao_Paulo');
                                                                          echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br>

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

      <div class="text-center" style="font-size: 10pt; margin-top: 10;"><span><?php echo $nome_logradouro_saae; ?>, <?php echo $numero_imovel_saae; ?> <br>
          <?php echo $nome_bairro_saae; ?> - <?php echo $nome_municipio; ?> - <?php echo $uf_saae; ?> CEP.: <?php echo $cep_saae; ?> <br>
          Fone: <?php echo $fone_saae; ?> E-Mail: <?php echo $email_saae; ?> <br>
          CNPJ.: <?php echo $saae_cnpj; ?></span></div>


      </p>

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
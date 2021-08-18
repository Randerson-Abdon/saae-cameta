<?php
//inlimitando memoria usada pelo script
ini_set('memory_limit', '-1');
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>


<div class="modal-body" style="margin-top: -50px;">
  <form method="POST" action="">
    <h5 class="modal-title">Emissão de Certidão de Quitação</h5>

    <hr>
    <div class="row">

      <!-- CONSULTA POR Matrícula-->
      <div id="uc" name="uc">
        <div class="row">

          <div class="form-group col-md-5">
            <label for="fornecedor">Localidade</label>

            <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar(this.value); required>

              <?php

              //monta dados do combo 1
              $sql = "SELECT DISTINCT nome_localidade,id_localidade FROM enderecamento_localidade";

              $resultado = @mysqli_query($conexao, $sql) or die("Problema na Consulta");

              while ($linha = mysqli_fetch_array($resultado)) {
                echo "<option value=" . $linha['id_localidade'] . ">" . $linha['nome_localidade'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto">Matrícula</label>
            <input type="text" class="form-control mr-3" minlength="2" name="id_unidade_consumidora" placeholder="UC" required>
          </div>

          <div class="form-group col-md-3" style="margin-top: 29px;">
            <button class="btn btn-outline-info" name="iniciar"> <i class="fas fa-file-alt"></i> Emitir </button>
          </div>

        </div>

      </div>
      <div class="form-group" id="dados3" style="margin-left: -25px;"></div>

    </div>

    <div class="modal-footer">


  </form>
</div>


<?php
if (isset($_POST['iniciar'])) {
  $uc = $_POST['id_unidade_consumidora'];
  $id_localidade = $_POST['id_localidade'];

  //executa o store procedure info consumidor
  $result_dev = mysqli_query(
    $conexao,
    "CALL sp_lista_financeiro_devedor_vencido($id_localidade,$uc);"
  ) or die("Erro na query da procedure dev: " . mysqli_error($conexao));
  mysqli_next_result($conexao);
  $linha = mysqli_num_rows($result_dev);

  if ($linha == 0) {
    echo "<script language='javascript'>window.location='admin.php?acao=quitacao&func=iniciar&id=$uc&id_localidade=$id_localidade'; </script>";
  } else {
    echo "<script language='javascript'>window.location='admin.php?acao=quitacao&func=valida&id=$uc&id_localidade=$id_localidade'; </script>";
    exit;
  }
}
?>



<!--validação -->
<?php
if (@$_GET['func'] == 'valida') {
  $id         = $_GET['id'];
  $localidade = $_GET['id_localidade'];

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

?>

  <!-- Modal validação -->
  <div class="modal fade" id="modalExemplo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body col-md-12" style="display: flex; justify-content: center; align-items: center;">

          <div class="row ">
            <div class="form-group text-center col-md-12">
              <img src="img/atencao.gif" alt="">
            </div>
          </div>

          <div class="row">
            <div class="form-group text-center col-md-12">
              <h5>Consumidor com débitos em atraso, não é possivel a emissão da certidão de quitação.</h5>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

<?php

} ?>




<!--INICIAR -->
<?php
if (@$_GET['func'] == 'iniciar') {
  $id         = $_GET['id'];
  $localidade = $_GET['id_localidade'];

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
  @$email_saae = $row_ps['email_saae'];

?>

  <!-- MODAL DATAS 01 -->
  <div id="modalExemplo" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width: 200%; margin-left: -50%;">
        <div id="close" class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">


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
            <span style="margin-left: 80px;" />Por ser verdade os dados citados acima, dato e assino este documento. <br><br><br>




            <span style="float: right;"><?php echo $nome_municipio; ?> (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                              date_default_timezone_set('America/Sao_Paulo');
                                                                              echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br>


          </p>


        </div>

        <div class="modal-footer">

          <a class="btn btn-info" target="_blank" href="rel_quitacao.php?func=imprime&id=<?php echo $id; ?>&localidade=<?php echo $localidade; ?>">Imprimir</a>

          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar </button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php

} ?>


<script>
  $("#modalExemplo").modal("show");
</script>

<script>
  $("#modalExemplo2").modal("show");
</script>
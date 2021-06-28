<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

?>

<?php

if ($_SESSION['nivel_usuario'] != '2' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>


<h3>PLANEJAMENTO E EXECUÇÃO DE CORTES</h3>

<form method="" action="">
  <div class="row">

    <div class="form-group col-md-2">
      <label for="fornecedor">Localidade</label>

      <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar(this.value);>
        <option value="">---Escolha uma opção---</option>";
        <?php

        //monta dados do combo 1
        $sql = "SELECT DISTINCT nome_localidade,id_localidade FROM localidade";

        $resultado = @mysqli_query($conexao, $sql) or die("Problema na Consulta");

        while ($linha = mysqli_fetch_array($resultado)) {
          echo "<option value=" . $linha['id_localidade'] . ">" . $linha['nome_localidade'] . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="form-group col-md-3" id="atualiza"></div>

    <div class="form-group col-md-3" id="atualiza2"></div>

  </div>

  <div class="row">

    <div class="form-group col-md-2">
      <label for="id_produto">N° de Faturas em Atraso</label>
      <input type="text" class="form-control mr-2" name="fat_atrazo" placeholder="Somente números" required>
    </div>

    <div class="form-group col-md-2" style="margin-top: 28px;">
      <button type="button" class="btn btn-success mb-3" id="buscar" onclick="myFunction()" name="buscar">Buscar </button>
    </div>

  </div>

</form>

<script>
  $("#buscar").click(function() {
    $.ajax({
      url: "processa_corte.php ",
      type: "POST",
      data: ({
        id_localidade: $("select[name='id_localidade']").val(),
        id_logradouro: $("select[name='id_logradouro']").val(),
        id_bairro: $("select[name='id_bairro']").val(),
        status: $("select[name='status']").val(),
        fat_atrazo: $("input[name='fat_atrazo']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados').html(resposta);
      }

    });
  });
</script>
<script>
  $("#imprimir").click(function() {
    $.ajax({
      url: "rel_corte.php ",
      type: "POST",
      data: ({
        id_localidade: $("select[name='id_localidade']").val(),
        id_logradouro: $("select[name='id_logradouro']").val(),
        id_bairro: $("select[name='id_bairro']").val(),
        fat_atrazo: $("input[name='fat_atrazo']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados2').html(resposta);
      }

    });
  });
</script>
<script>
  function myFunction() {
    document.getElementById("buscar").style.cursor = "wait";
  }
</script>

<div class="form-group" id="dados"></div>



<!-- EXIBIÇÃO PERFIL -->
<?php
if (@$_GET['func'] == 'perfil') {
  $id         = $_GET['id'];
  $localidade = $_GET['id_localidade'];

  //executa o store procedure info consumidor
  $result_sp2 = mysqli_query(
    $conexao,
    "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
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
  <div id="modalPerfil" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h3 class="modal-title">Perfil Consumidor</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">

            <h5 class="modal-title">Dados Pessoais</h5>
            <hr>
            <div class="row">

              <div id="uc" class="form-group col-md-2">
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

              <div class="form-group col-md-3">
                <label for="id_produto"><b>Celular: </b></label>
                <label id="cel" for="id_produto"><?php echo $fone_movel ?></label>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto"><b>WhatsApp: </b></label>
                <label for="id_produto"><?php echo $fone_zap ?></label>
              </div>

              <div class="form-group col-md-4">
                <label for="id_produto"><b>E-mail: </b></label>
                <label for="id_produto"><?php echo $email ?></label>
              </div>

            </div>

            <h5 class="modal-title">Dados de Faturamento</h5>
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

        <div class="modal-footer">
          <div style="margin-top: -16px;">
            <a class="btn btn-info" target="_blank" href="rel_perfil.php?func=imprime&id=<?php echo $id; ?>">Imprimir</a>
          </div>
          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
          </form>

        </div>
      </div>
    </div>
  </div>

<?php } ?>



<script>
  $("#buscar").click(function() {
    $.ajax({
      url: "baixa.php ",
      type: "POST",
      data: ({
        id_unidade_consumidora: $("input[name='id_unidade_consumidora']").val(),
        mes_faturado: $("input[name='mes_faturado']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados').html(resposta);
      }

    });
  });
</script>

<script>
  $("#modalPerfil").modal("show");
</script>
<script>
  $("#modalEditar").modal("show");
</script>


<!--MASCARAS -->
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
  $("input[id*='mes']").inputmask({
    mask: ['99/9999'],
    keepStatic: true
  });
</script>
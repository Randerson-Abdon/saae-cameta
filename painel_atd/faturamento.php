<?php
//inlimitando memoria usada pelo script
ini_set('memory_limit', '-1');
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>

<style>
  #imgpos {
    margin-left: 30%;
    top: 80%;
    /* posiciona a 70px para baixo */
    display: none;
    z-index: 2 !important;

  }
</style>


<div class="modal-body" style="margin-top: -50px;">
  <form method="POST" action="">
    <h5 class="modal-title">Histórico Financeiro</h5>

    <hr>
    <div class="row">

      <div class="form-group col-md-2">
        <label for="fornecedor">Buscar Por...</label>
        <select class="form-control mr-2" id="slBuscar" name="slBuscar" style="text-transform:uppercase;">

          <option value="">selecione</option>
          <option value="uc">Matrícula</option>

        </select>
      </div>

      <!-- CONSULTA POR CPF OU CNPJ-->
      <div id="cpfcnpjd" name="cpfcnpjd" style="display: none;">
        <div class="row">

          <div class="form-group">
            <label for="fornecedor">Localidade</label>

            <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar(this.value); required>
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

          <div class="form-group col-md-8">
            <label for="id_produto">Informe seu CPF/CNPJ</label>
            <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" style="text-transform:uppercase;">
          </div>

          <div class="form-group col-md-4">
            <label for="id_produto">Buscar</label>
            <button type="button" class="btn btn-success form-control mr-2" id="buscar"><i class="fas fa-search"></i></button>
          </div>

        </div>

      </div>
      <div class="form-group" id="dados" style="display: none;"></div>



      <!-- CONSULTA POR NOME-->
      <div id="nome" name="nome" style="display: none;">
        <div class="row">

          <div class="form-group col-md-8">
            <label for="id_produto">Nome/Razão Social</label>
            <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" style="text-transform:uppercase;">
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto">Buscar</label>
            <button type="button" class="btn btn-success form-control mr-2" id="buscar2"><i class="fas fa-search"></i></button>
          </div>

        </div>

      </div>
      <div class="form-group" id="dados2" style="display: none;"></div>





      <!-- CONSULTA POR Matrícula-->
      <div id="uc" name="uc" style="display: none;">
        <div class="row">

          <div class="form-group col-md-4">
            <label for="fornecedor">Localidade</label>
            <select class="form-control mr-2" id="localidade" name="localidade">

              <?php

              //recuperando dados da tabela categoria para o select
              $query = "select * from localidade order by nome_localidade asc";
              $result = mysqli_query($conexao, $query);
              while ($res = mysqli_fetch_array($result)) {

              ?>
                <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
                <option value="<?php echo $res['id_localidade'] ?>"><?php echo $res['nome_localidade'] ?></option>

              <?php
              }
              ?>

            </select>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto">UC</label>
            <input type="text" class="form-control mr-1" minlength="2" name="id_unidade_consumidora" placeholder="UC" required>
          </div>

          <div class="form-group col-md-3">
            <label for="fornecedor">Status</label>
            <select class="form-control mr-1" id="slStatus3" name="slStatus3" style="text-transform:uppercase;">

              <option value="1">Em Aberto</option>
              <option value="2">Pagas</option>
              <option value="3">Vencidas</option>

            </select>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto">Buscar</label>
            <button type="button" class="btn btn-success form-control mr-1" id="buscar3"><i class="fas fa-search"></i></button>
          </div>

        </div>

      </div>
      <div class="form-group" id="dados3" style="display: none; margin-left: -25px; z-index: 1;"></div>






      <!-- CONSULTA POR ENDEREÇO-->
      <div id="endereco" name="endereco" style="display: none;">
        <div class="row">

          <div class="form-group col-md-8">
            <label for="id_produto">Descrição</label>
            <input type="text" class="form-control mr-2" name="enderecamento" placeholder="Endereçamento" style="text-transform:uppercase;">
          </div>

          <div class="form-group col-md-3">
            <label for="id_produto">Buscar</label>
            <button type="button" class="btn btn-success form-control mr-2" id="buscar4"><i class="fas fa-search"></i></button>
          </div>

        </div>
      </div>
      <div class="form-group" id="dados4" style="display: none;"></div>


    </div>

    <div class="modal-footer">


  </form>
</div>

<script>
  $("#buscar").click(function() {
    $.ajax({
      url: "resultado.php ",
      type: "POST",
      data: ({
        numero_cpf_cnpj: $("input[name='numero_cpf_cnpj']").val(),
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados').html(resposta);
      }

    });
  });


  $("#buscar2").click(function() {
    $.ajax({
      url: "resultado2.php ",
      type: "POST",
      data: ({
        nome_razao_social: $("input[name='nome_razao_social']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados2').html(resposta);
      }

    });
  });

  $("#buscar3").click(function() {
    $("#dados3").hide();
    $("#imgpos").show();
    $.ajax({
      url: "resultado6.php ",
      type: "POST",
      data: ({
        localidade: $("select[name='localidade']").val(),
        id_unidade_consumidora: $("input[name='id_unidade_consumidora']").val(),
        slStatus3: $("select[name='slStatus3']").val()

      }), //estamos enviando o valor do input
      success: function(resposta) {
        $("#imgpos").hide();
        $("#dados3").show();
        $('#dados3').html(resposta);
      }

    });
  });

  $("#buscar4").click(function() {
    $.ajax({
      url: "resultado4.php ",
      type: "POST",
      data: ({
        enderecamento: $("input[name='enderecamento']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados4').html(resposta);
      }

    });
  });
</script>


<script>
  $("#modalPerfil").modal("show");
</script>
<script>
  $("#modalCriar").modal("show");
</script>
<script>
  $("#modalServico").modal("show");
</script>
<script>
  $("#modalReq").modal("show");
</script>



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

<img src="../img/load.gif" width="25%" alt="logo do site Maujor" id="imgpos" />
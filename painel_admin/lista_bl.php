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


<h3>RELATÓRIO DE COMSUMIDORES (BAIRRO/LOGRADOURO)</h3>

<form method="post" action="rel_consumidores_bl.php" target="_blank">
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
      <label for="fornecedor">Status</label>
      <select class="form-control mr-2" id="status" name="status" style="text-transform:uppercase;">

        <option value="">Todas</option>
        <option value="A">Ativas</option>
        <option value="I">Inativas</option>

      </select>
    </div>

    <div class="form-group col-md-2" style="margin-top: 30px;">
      <button type="button" class="btn btn-success mb-3" id="buscar" name="buscar">Buscar </button>
    </div>

    <div class="form-group col-md-2" style="margin-left: -100px; margin-top: 30px;">
      <button type="button" class="btn btn-primary mb-3" id="imprimir" onclick="javascript:submitForm(this.form, 'rel_consumidores_bl.php');" name="imprimir" style="display: none">Imprimir </button>
    </div>

  </div>

</form>
<div>
  <script>
    $("#buscar").click(function() {
      //mostrando botão
      $("#imprimir").show();
      $.ajax({
        url: "processa_lista_bl.php ",
        type: "POST",
        data: ({
          id_localidade: $("select[name='id_localidade']").val(),
          id_logradouro: $("select[name='id_logradouro']").val(),
          status: $("select[name='status']").val(),
          id_bairro: $("select[name='id_bairro']").val(),
        }), //estamos enviando o valor do input
        success: function(resposta) {
          $('#dados').html(resposta);
        }

      });
    });
  </script>
  <script>
    function myFunction() {
      document.getElementById("buscar").style.cursor = "wait";
    }
  </script>

  <script type="text/javascript">
    //post segundario
    function submitForm(form, action) {
      form.action = action;
      form.submit();
    }
  </script>

  <div class="form-group" id="dados"></div>
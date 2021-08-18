<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

function calculaValor($valor)
{
  $valor = $valor * 2 / 100;
  return $valor;
}


function decimal($t_valor)
{
  $float_arredondar = round($t_valor * 100) / 100;
  return $float_arredondar;
}

function calculaDias($data_final, $data_inicial, $fatura)
{
  // Calcula a diferença em segundos entre as datas
  $diferenca = strtotime($data_final) - strtotime($data_inicial);

  //Calcula a diferença em dias
  $dias = floor($diferenca / (60 * 60 * 24)) * 0.0033333333333333 * $fatura - 0.12;
  $dias = decimal($dias);
  return $dias;
}
?>

<?php

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>

<h3>CONTROLE DE ACORDOS</h3>

<form method="" action="">
  <div class="row">

    <div class="form-group col-md-3">
      <label for="id_produto">Localidade</label>
      <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar01(this.value); required>

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
      <input type="text" class="form-control mr-2" name="id_unidade_consumidora" placeholder="Matrícula" required>
    </div>

    <div class="form-group col-md-3">
      <label for="id_produto">Situação</label>
      <select class="form-control mr-2" name="status" id="status">
        <option value="DEVEDORA">DEVEDORA</option>
        <option value="PAGA">PAGA</option>
      </select>
    </div>

    <div class="form-group col-md-2" style="margin-top: 28px;">
      <button type="button" class="btn btn-success mb-3" id="buscar" name="buscar">Buscar </button>
    </div>

  </div>

</form>

<div class="form-group" id="dados"></div>


<script>
  $("#buscar").click(function() {
    $.ajax({
      url: "model/processa_acordos.php",
      type: "POST",
      data: ({
        id_unidade_consumidora: $("input[name='id_unidade_consumidora']").val(),
        status: $("select[name='status']").val(),
        id_localidade: $("select[name='id_localidade']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados').html(resposta);
      }

    });
  });
</script>
<?php
//inlimitando memoria usada pelo script
ini_set('memory_limit', '-1');
include_once('../../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>


<div class="container">

  <h4 class="title">Consulta de Contas Arrecadadas</h4>

  <form action="" method="POST" target="_blank">

    <hr>
    <div class="row">

      <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <label for="fornecedor">Escolha o Banco Arrecadador</label>
        <select class="form-control mr-2" id="id_banco" name="id_banco" style="text-transform:uppercase;">

          <?php

          //recuperando dados da tabela bancos para o select
          $query = "SELECT * from banco_conveniado WHERE status_convenio = 'A' ";
          $result = mysqli_query($conexao, $query);
          while ($res = mysqli_fetch_array($result)) {

          ?>
            <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
            <option value="<?php echo $res['id_febraban'] ?>"><?php echo $res['nome_banco'] ?></option>

          <?php
          }
          ?>

        </select>
      </div>

      <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <label for="fornecedor">Data Início</label>
        <input type="date" class="form-control mr-2" maxlength="10" id="periodo_inicial" name="periodo_inicial" />
      </div>

      <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <label for="fornecedor">Data Final</label>
        <input type="date" class="form-control mr-2" maxlength="10" id="periodo_final" name="periodo_final" />
      </div>

    </div>

    <hr>

    <div class="row">

      <div class="form-group col-lg-2 col-md-4 col-sm-12">
        <label for="id_produto">Gerar Consulta</label>
        <button type="button" class="btn btn-info form-control" id="buscar2" onclick="javascript:submitForm(this.form, 'model/processa_contas_recebidas.php',);"><i class="fas fa-clipboard-list"></i></button>
      </div>

    </div>

  </form>
  <script type="text/javascript">
    //post alternativo
    function submitForm(form, action) {
      form.action = action;
      form.submit();
    }
  </script>

</div>
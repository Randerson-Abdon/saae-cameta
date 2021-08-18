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


<div class="container">

  <h4 class="title">Relatório de Contas a Receber</h4>

  <form action="" method="POST" target="_blank">

    <hr>
    <div class="row">

      <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <label for="fornecedor">Localidade</label>
        <select class="form-control mr-2" id="id_localidade" name="id_localidade" style="text-transform:uppercase;">

          <?php

          //recuperando dados da tabela localidade para o select
          $query = "select * from enderecamento_localidade order by nome_localidade asc";
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

      <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <label for="fornecedor">Mês de Competência</label>
        <input type="text" class="form-control mr-2" placeholder="00/0000" id="mes_competencia" name="mes_competencia" />
      </div>

    </div>

    <hr>

    <div class="row">

      <div class="form-group col-lg-2 col-md-4 col-sm-12">
        <label for="id_produto">Gerar Consulta</label>
        <button type="button" class="btn btn-info form-control" id="buscar2" onclick="javascript:submitForm(this.form, 'model/processa_contas_receber.php',);"><i class="fas fa-clipboard-list"></i></button>
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


<!--MASCARAS -->
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
  $("input[id*='mes_competencia']").inputmask({
    mask: ['99/9999'],
    keepStatic: true
  });
</script>
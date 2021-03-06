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
    <h5 class="modal-title">Visualização - Notificações</h5>

    <hr>
    <!-- CONSULTA POR Matrícula-->

  </form>
</div>

<section>
  <div class="row">
    <div class="form-group col-md-12 text-center" style="margin-top: -50px;">
      <a data-toggle="modal" data-target="#modalNotificacao" href=""><img width="500px" src="../img/notificacao.gif" alt="Clique aqui para visualizar as notificações" title="Clique aqui para visualizar as notificações"></a>
    </div>
  </div>
</section>


<!-- Modal Notificacao -->
<div class="modal fade bd-example-modal-lg" id="modalNotificacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visualização de Notificações</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" target="_blank">

          <hr>
          <div class="row">

            <div class="form-group col-md-3">
              <label for="fornecedor">Visualizar Por...</label>
              <select class="form-control mr-2" id="slBuscar" name="slBuscar" style="text-transform:uppercase;">

                <option value="">selecione</option>
                <option value="uc">Matrícula</option>
                <option value="endereco">Logradouro</option>

              </select>
            </div>

          </div>

          <div class="row">

            <!-- CONSULTA POR Matrícula-->
            <div id="uc" name="uc" style="display: none;">
              <div class="row">

                <div class="form-group col-md-6 ml-3">
                  <label for="fornecedor">Localidade</label>

                  <select class="form-control mr-2" id="category" name="localidade">

                    <?php

                    //recuperando dados da tabela localidade para o select
                    $query = "select * from enderecamento_localidade order by id_localidade asc";
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

                <div class="form-group col-md-4">
                  <label for="id_produto">Matrícula</label>
                  <input type="text" class="form-control mr-3" name="id_unidade_consumidora" placeholder="000000">
                </div>

              </div>

            </div>


            <!-- CONSULTA POR ENDEREÇO-->
            <div id="endereco" name="endereco" style="display: none;">
              <div class="row">

                <div class="form-group col-md-4 ml-3">
                  <label for="fornecedor">Localidade</label>

                  <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar(this.value); required>
                    <option value="">---Escolha uma opção---</option>";
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

                <div class=" col-md-4" id="atualiza"></div>

                <div class=" col-md-3" id="atualiza2"></div>

              </div>

            </div>

          </div>


          <div class="modal-footer">

            <div class="form-group col-md-3">
              <label for="id_produto">Gerar Listagem</label>
              <button type="button" class="btn btn-info form-control mr-2" id="buscar2" onclick="javascript:submitForm(this.form, 'model/processa_listagem_da.php',);"><i class="fas fa-clipboard-list"></i></button>
            </div>

            <div class="form-group col-md-3">
              <label for="id_produto">Gerar Notificação</label>
              <button type="button" class="btn btn-danger form-control mr-2" id="buscar2" onclick="javascript:submitForm(this.form, 'model/processa_notificacao_da.php',);"><i class="fas fa-comments-dollar"></i></button>
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
    </div>

  </div>
</div>

<script>
  $("#modalNotificacao").modal("show");
</script>
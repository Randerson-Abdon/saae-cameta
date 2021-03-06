<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>



<div class="container ml-4">
  <div class="row">

    <div class="col-lg-8 col-md-6">
      <h3>LOCALIDADES</h3>
    </div>

    <div class="col-lg-8 col-md-6 col-sm-12">
      <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> LOCALIDADES </i> </button>

    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarLocalidades" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Localidade" aria-label="Pesquisar">
        <button name="buttonPesquisar" class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>
</div>



<div class="container ml-4">


  <br>


  <div class="content">
    <div class="row mr-3">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">

          </div>
          <div class="card-body">
            <div class="table-responsive">

              <!--LISTAR TODOS AS LOCALIDADES -->
              <?php
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarLocalidades'] != '') {


                $nome = '%' . $_GET['txtpesquisarLocalidades'] . '%';
                $query = "SELECT * from enderecamento_localidade where nome_localidade LIKE '$nome' order by nome_localidade asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from enderecamento_localidade order by id_localidade desc limit 10";

                $query_count = "SELECT * from enderecamento_localidade";
                $result_count = mysqli_query($conexao, $query_count);
              }

              $result = mysqli_query($conexao, $query);

              $linha = mysqli_num_rows($result);
              $linha_count = mysqli_num_rows($result_count);

              if ($linha == '') {
                echo "<h3> N??o foram encontrados dados Cadastrados no Banco!! </h3>";
              } else {

              ?>




                <table class="table table-sm">
                  <thead class="text-secondary">

                    <th>
                      Nome
                    </th>
                    <th>
                      Usu??rio Editor
                    </th>
                    <th>
                      ??ltima Edi????o
                    </th>


                    <th>
                      A????es
                    </th>
                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $nome_localidade = $res["nome_localidade"];
                      $id_usuario_editor = $res["id_usuario_editor_registro"];
                      $data_ultima_edicao  = $res["data_edicao_registro"];
                      $id = $res["id_localidade"];

                      $data_ultima_edicao = substr($data_ultima_edicao, 0, 10);
                      $data2 = implode('/', array_reverse(explode('-', $data_ultima_edicao)));

                      //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_user = "SELECT * from usuario_sistema where id_usuario = '$id_usuario_editor' ";

                      $result_user = mysqli_query($conexao, $query_user);
                      $row_user = mysqli_fetch_array($result_user);
                      $nome_user = $row_user['nome_usuario'];


                    ?>

                      <tr>

                        <td><?php echo $nome_localidade; ?></td>
                        <td><?php echo $nome_user; ?></td>
                        <td><?php echo $data2; ?></td>


                        <td>

                          <a class="btn btn-info btn-sm" href="admin.php?acao=localidades&func=edita&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>

                          <a class="btn btn-danger btn-sm" href="admin.php?acao=localidades&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>





                        </td>
                      </tr>

                    <?php } ?>


                  </tbody>
                  <tfoot>
                    <tr>


                      <td></td>
                      <td></td>
                      <td></td>

                      <td>
                        <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                      </td>
                    </tr>

                  </tfoot>
                </table>

              <?php
              }

              ?>

            </div>
          </div>
        </div>
      </div>

    </div>






    <!-- Modal -->


    <?php

    //consulta para numera????o automatica
    $query_num_aula = "select * from enderecamento_localidade order by id_localidade desc ";
    $result_num_aula = mysqli_query($conexao, $query_num_aula);

    $res_num_aula = mysqli_fetch_array($result_num_aula);
    $ultima_aula = $res_num_aula["id_localidade"];
    $ultima_aula = $ultima_aula + 1;

    ?>

    <div id="modalExemplo" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Localidades</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2" name="nome_localidade" placeholder="Nome" style="text-transform:uppercase;" required>
              </div>

          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success mb-3" name="salvar">Salvar </button>


            <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
            </form>
          </div>
        </div>
      </div>
    </div>




    <!--CADASTRO -->
    <?php
    if (isset($_POST['salvar'])) {

      $id_localidade = $ultima_aula;
      $nome_localidade = mb_strtoupper($_POST['nome_localidade']);
      //puxando do login
      $id_usuario_editor = $_SESSION['id_usuario'];


      //VERIFICAR SE A LOCALIDADE J?? EST?? CADASTRADA
      $query_verificar_nome = "SELECT * from enderecamento_localidade where nome_localidade = '$nome_localidade' ";
      $result_verificar_nome = mysqli_query($conexao, $query_verificar_nome);
      $row_verificar_nome = mysqli_num_rows($result_verificar_nome);
      if ($row_verificar_nome > 0) {
        echo "<script language='javascript'>window.alert('Localidade j?? Cadastrada'); </script>";
        exit();
      }

      echo $id_localidade . ', ' . $nome_localidade . ', ' . $id_usuario_editor;

      $query = "INSERT INTO enderecamento_localidade (id_localidade, nome_localidade, id_usuario_editor_registro, data_edicao_registro) values ('$id_localidade', '$nome_localidade', '$id_usuario_editor', curDate())";

      $result = mysqli_query($conexao, $query);


      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
      } else {
        echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
        echo "<script language='javascript'>window.location='admin.php?acao=localidades'; </script>";
      }
    }
    ?>




    <!--EDITAR -->
    <?php
    if (@$_GET['func'] == 'edita') {
      $id = $_GET['id'];

      $query = "select * from enderecamento_localidade where id_localidade = '$id' ";
      $result = mysqli_query($conexao, $query);

      while ($res = mysqli_fetch_array($result)) {
        $nome_localidade = $res["nome_localidade"];
        $id_usuario_editor = $res["id_usuario_editor_registro"];

    ?>

        <!-- Modal Editar -->
        <div id="modalEditar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h5 class="modal-title">Localidades</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <div class="form-group">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control mr-2" name="nome_localidade" value="<?php echo $nome_localidade ?>" placeholder="Nome" style="text-transform:uppercase;">
                  </div>

              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-success mb-3" name="editar">Salvar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
                </form>
              </div>
            </div>
          </div>
        </div>


    <?php


        if (isset($_POST['editar'])) {
          $nome_localidade = mb_strtoupper($_POST['nome_localidade']);
          $id_usuario_editor = $_SESSION['id_usuario'];


          if ($res["nome_localidade"] != $nome_localidade) {
            //VERIFICAR SE O CPF J?? EST?? CADASTRADO
            $query_verificar_loc = "SELECT * from enderecamento_localidade where nome_localidade = '$nome_localidade' ";
            $result_verificar_loc = mysqli_query($conexao, $query_verificar_loc);
            $row_verificar_loc = mysqli_num_rows($result_verificar_loc);
            if ($row_verificar_loc > 0) {
              echo "<script language='javascript'>window.alert('Localidade j?? Cadastrada'); </script>";
              exit();
            }
          }

          $query = "UPDATE enderecamento_localidade SET nome_localidade = '$nome_localidade', id_usuario_editor_registro = '$id_usuario_editor' where id_localidade = '$id' ";

          $result = mysqli_query($conexao, $query);


          //atualiza????o dos alunos
          // if($nivel == 'Aluno'){
          // $query_alunos = "UPDATE alunos SET nome = '$nome', cpf = '$cpf', email = '$usuario', senha = '$senha' where cpf = '$res[cpf]' ";

          // $result_alunos = mysqli_query($conexao, $query_alunos);
          // }



          if ($result == '') {
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
          } else {
            echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
            echo "<script language='javascript'>window.location='admin.php?acao=localidades'; </script>";
          }
        }
      }
    }

    ?>



    <!--EXCLUIR -->
    <?php
    if (@$_GET['func'] == 'excluir') {
      $id = $_GET['id'];

      $query = "DELETE FROM enderecamento_localidade where id_localidade = '$id' ";
      $result = mysqli_query($conexao, $query);
      echo "<script language='javascript'>window.location='admin.php?acao=localidades'; </script>";
    }

    ?>




    <script>
      $("#modalEditar").modal("show");
    </script>


    <!--MASCARAS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
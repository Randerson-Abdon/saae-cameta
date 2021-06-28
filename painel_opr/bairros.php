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



<div class="container ml-4">
  <div class="row">

    <div class="col-lg-8 col-md-6">
      <h3>BAIRROS</h3>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarBairros" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Bairros" aria-label="Pesquisar">
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

              <!--LISTAR TODOS OS BAIRROS -->
              <?php
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarBairros'] != '') {



                $nome = '%' . $_GET['txtpesquisarBairros'] . '%';
                $query = "SELECT * from bairro where nome_bairro LIKE '$nome' order by nome_bairro asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from bairro order by id_bairro desc limit 10";

                $query_count = "SELECT * from bairro";
                $result_count = mysqli_query($conexao, $query_count);
              }

              $result = mysqli_query($conexao, $query);

              $linha = mysqli_num_rows($result);
              $linha_count = mysqli_num_rows($result_count);

              if ($linha == '') {
                echo "<h3> Não foram encontrados dados Cadastrados no Banco!! </h3>";
              } else {

              ?>




                <table class="table table-sm">
                  <thead class="text-secondary">

                    <th>
                      Nome
                    </th>
                    <th>
                      Localidade
                    </th>
                    <th>
                      Tipo Geográfico
                    </th>
                    <th>
                      Usuário Editor
                    </th>
                    <th>
                      Última Edição
                    </th>

                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $nome_bairro = $res["nome_bairro"];
                      $id_localidade = $res["id_localidade"];
                      $tipo_geografico_bairro = $res["tipo_geografico"];
                      $id_usuario_editor = $res["id_usuario_editor_registro"];
                      $data_ultima_edicao_bairro = $res["data_ultima_edicao"];
                      $id = $res["id_bairro"];

                      $data2 = implode('/', array_reverse(explode('-', $data_ultima_edicao_bairro)));


                      //trazendo o nome da categoria que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_localidade = "SELECT * from localidade where id_localidade = '$id_localidade' ";

                      $result_localidade = mysqli_query($conexao, $query_localidade);
                      $row_localidade = mysqli_fetch_array($result_localidade);
                      $nome_localidade = $row_localidade['nome_localidade'];

                      //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_user = "SELECT * from usuario_sistema where id_usuario = '$id_usuario_editor' ";

                      $result_user = mysqli_query($conexao, $query_user);
                      $row_user = mysqli_fetch_array($result_user);
                      $nome_user = $row_user['nome_usuario'];



                    ?>

                      <tr>

                        <td><?php echo $nome_bairro; ?></td>
                        <td><?php echo $nome_localidade; ?></td>

                        <!-- condição para urbano e rural -->
                        <td><?php if ($tipo_geografico_bairro == 'U') {
                              echo 'URBANO';
                            } else {
                              echo 'RURAL';
                            }
                            ?></td>
                        <td><?php echo $nome_user; ?></td>
                        <td><?php echo $data2; ?></td>

                      </tr>

                    <?php } ?>


                  </tbody>
                  <tfoot>
                    <tr>


                      <td></td>
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

    //consulta para numeração automatica
    $query_num_aula = "select * from bairro order by id_bairro desc ";
    $result_num_aula = mysqli_query($conexao, $query_num_aula);

    $res_num_aula = mysqli_fetch_array($result_num_aula);
    $ultima_aula = $res_num_aula["id_bairro"];
    $ultima_aula = $ultima_aula + 1;

    ?>


    <div id="modalExemplo" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Bairros</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2" name="nome_bairro" placeholder="Nome" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group">
                <label for="fornecedor">Localidade</label>

                <select class="form-control mr-2" id="category" name="id_localidade">

                  <?php

                  //recuperando dados da tabela localidade para o select
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

              <div class="form-group">
                <label for="fornecedor">Tipo Geográfico</label>
                <select class="form-control mr-2" id="category" name="tipo_geografico_bairro" style="text-transform:uppercase;">

                  <option value="U">Urbano</option>
                  <option value="R">Rural</option>

                </select>
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

      //puxando do contador
      $id_bairro = $ultima_aula;
      $nome_bairro = mb_strtoupper($_POST['nome_bairro']);
      $id_localidade = mb_strtoupper($_POST['id_localidade']);
      $tipo_geografico_bairro = mb_strtoupper($_POST['tipo_geografico_bairro']);
      //puxando do login
      $id_usuario_editor = $_SESSION['id_usuario'];


      //VERIFICAR SE A BAIRRO JÁ ESTÁ CADASTRADA
      $query_verificar_nome = "SELECT * from bairro where nome_bairro = '$nome_bairro' ";
      $result_verificar_nome = mysqli_query($conexao, $query_verificar_nome);
      $row_verificar_nome = mysqli_num_rows($result_verificar_nome);
      if ($row_verificar_nome > 0) {
        echo "<script language='javascript'>window.alert('Bairro já Cadastrado'); </script>";
        exit();
      }


      $query = "INSERT INTO bairro (id_bairro, nome_bairro, id_localidade, tipo_geografico, id_usuario_editor_registro, data_ultima_edicao) values ('$id_bairro', '$nome_bairro', '$id_localidade', '$tipo_geografico_bairro', '$id_usuario_editor', curDate())";

      $result = mysqli_query($conexao, $query);


      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
      } else {
        echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
        echo "<script language='javascript'>window.location='operacional.php?acao=bairros'; </script>";
      }
    }
    ?>




    <!--EDITAR -->
    <?php
    if (@$_GET['func'] == 'editar') {
      $id = $_GET['id'];

      $query = "select * from bairro where id_bairro = '$id' ";
      $result = mysqli_query($conexao, $query);

      while ($res = mysqli_fetch_array($result)) {

        $nome_bairro = $res["nome_bairro"];
        $id_localidade = $res["id_localidade"];
        $tipo_geografico_bairro = $res["tipo_geografico"];
        $data_ultima_edicao_bairro = $res["data_ultima_edicao"];


        //consulta para recuperação do nome da localidade
        $query_loc = "select * from localidade where id_localidade = '$id_localidade' ";
        $result_loc = mysqli_query($conexao, $query_loc);
        $row = mysqli_fetch_array($result_loc);
        //vai para a modal
        $nome_loc = $row['nome_localidade'];



    ?>

        <!-- Modal Editar -->
        <div id="modalEditar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h5 class="modal-title">Bairros</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <div class="form-group">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control mr-2" name="nome_bairro" value="<?php echo $nome_bairro ?>" placeholder="Nome" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group">
                    <label for="fornecedor">Localidade</label>


                    <select class="form-control mr-2" id="category" name="id_localidade">

                      <option value="<?php echo $id_localidade; ?>"><?php echo $nome_loc; ?></option>

                      <?php

                      $query = "select * from localidade order by nome_localidade asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {


                      ?>

                        <?php

                        //condição para mostrar o option para não se repetir o nome que já esta
                        if ($nome_loc != $res['nome_localidade']) { ?>

                          <option value="<?php echo $res['id_localidade']; ?>"><?php echo $res['nome_localidade']; ?></option>

                      <?php
                        }
                      }

                      ?>

                    </select>
                  </div>

                  <!--select para edição-->
                  <div class="form-group">
                    <label for="inputEstado">Tipo Geográfico</label>
                    <select id="tipo_geografico_bairro" name="tipo_geografico_bairro" class="form-control" style="text-transform:uppercase;">

                      <option value="U" <?php if ($tipo_geografico_bairro == 'U') { ?> selected <?php } ?>>Urbano</option>

                      <option value="R" <?php if ($tipo_geografico_bairro == 'R') { ?> selected <?php } ?>>Rural</option>

                    </select>
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

          $nome_bairro = mb_strtoupper($_POST['nome_bairro']);
          $id_localidade = mb_strtoupper($_POST['id_localidade']);
          $tipo_geografico_bairro = mb_strtoupper($_POST['tipo_geografico_bairro']);
          $id_usuario_editor = $_SESSION['id_usuario'];


          //if($res["usuario"] != $usuario){
          //VERIFICAR SE O USUARIO JÁ ESTÁ CADASTRADO
          //$query_verificar_usu = "SELECT * from usuarios where usuario = '$usuario' and nivel = '$nivel' ";
          //$result_verificar_usu = mysqli_query($conexao, $query_verificar_usu);
          //$row_verificar_usu = mysqli_num_rows($result_verificar_usu);
          //if($row_verificar_usu > 0){
          // echo "<script language='javascript'>window.alert('Usuário já Cadastrado'); </script>";
          // exit();
          //}
          //}


          $query = "UPDATE bairro SET nome_bairro = '$nome_bairro', id_localidade = '$id_localidade', tipo_geografico = '$tipo_geografico_bairro', id_usuario_editor_registro = '$id_usuario_editor', data_ultima_edicao = curDate() where id_bairro = '$id' ";

          $result = mysqli_query($conexao, $query);


          //atualização dos alunos
          // if($nivel == 'Aluno'){
          // $query_alunos = "UPDATE alunos SET nome = '$nome', cpf = '$cpf', email = '$usuario', senha = '$senha' where cpf = '$res[cpf]' ";

          // $result_alunos = mysqli_query($conexao, $query_alunos);
          // }



          if ($result == '') {
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
          } else {
            echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
            echo "<script language='javascript'>window.location='operacional.php?acao=bairros'; </script>";
          }
        }
      }
    }

    ?>



    <!--EXCLUIR -->
    <?php
    if (@$_GET['func'] == 'excluir') {
      $id = $_GET['id'];


      $query = "DELETE FROM bairro where id_bairro = '$id' ";
      $result = mysqli_query($conexao, $query);
      echo "<script language='javascript'>window.location='operacional.php?acao=bairros'; </script>";
    }

    ?>




    <script>
      $("#modalEditar").modal("show");
    </script>


    <!--MASCARAS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
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

    <div class="col-lg-8 col-md-6 col-sm-12">
      <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> FUNÇÕES </i> </button>

    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarFuncoes" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Funções" aria-label="Pesquisar">
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
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarFuncoes'] != '') {



                $nome = $_GET['txtpesquisarFuncoes'] . '%';
                $cpf = $_GET['txtpesquisarFuncoes'];
                $query = "SELECT * from funcoes where nome_funcao LIKE '$nome' order by nome_funcao asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from funcoes order by id desc limit 10";

                $query_count = "SELECT * from funcoes";
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
                      Descrição
                    </th>
                    <th>
                      Usuário Editor
                    </th>
                    <th>
                      Última Edição
                    </th>


                    <th>
                      Ações
                    </th>
                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $nome_funcao = $res["nome_funcao"];
                      $descricao_funcao = $res["descricao_funcao"];
                      $id_usuario_editor = $res["id_usuario_editor"];
                      $data_ultima_edicao_funcao = $res["data_ultima_edicao_funcao"];
                      $id = $res["id"];

                      $data2 = implode('/', array_reverse(explode('-', $data_ultima_edicao_funcao)));

                    ?>

                      <tr>

                        <td><?php echo $nome_funcao; ?></td>
                        <td><?php echo $descricao_funcao; ?></td>
                        <td><?php echo $id_usuario_editor; ?></td>
                        <td><?php echo $data2; ?></td>


                        <td>

                          <a class="btn btn-info btn-sm" href="admin.php?acao=funcoes&func=edita&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>

                          <a class="btn btn-danger btn-sm" href="admin.php?acao=funcoes&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>





                        </td>
                      </tr>

                    <?php } ?>


                  </tbody>
                  <tfoot>
                    <tr>

                      <td></td>
                      <td></td>
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
    <div id="modalExemplo" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Funções</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">

              <div class="form-group">
                <label for="id_produto">Nome</label>
                <input type="text" class="form-control mr-2" name="nome_funcao" placeholder="Nome" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group">
                <label for="id_produto">Descrição</label>
                <input type="text" class="form-control mr-2" name="descricao_funcao" placeholder="Descrição" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group">
                <label for="id_produto">Usuário Editor</label>
                <input type="text" class="form-control mr-2" name="id_usuario_editor" placeholder="Usuário Editor" style="text-transform:uppercase;" required>
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
      $nome_funcao = mb_strtoupper($_POST['nome_funcao']);
      $descricao_funcao = mb_strtoupper($_POST['descricao_funcao']);
      $id_usuario_editor = mb_strtoupper($_POST['id_usuario_editor']);


      //VERIFICAR SE A BAIRRO JÁ ESTÁ CADASTRADA
      $query_verificar_nome = "SELECT * from funcoes where nome_funcao = '$nome_funcao' ";
      $result_verificar_nome = mysqli_query($conexao, $query_verificar_nome);
      $row_verificar_nome = mysqli_num_rows($result_verificar_nome);
      if ($row_verificar_nome > 0) {
        echo "<script language='javascript'>window.alert('Função já Cadastrada'); </script>";
        exit();
      }



      $query = "INSERT INTO funcoes (nome_funcao, descricao_funcao, id_usuario_editor, data_ultima_edicao_funcao) values ('$nome_funcao', '$descricao_funcao', '$id_usuario_editor', curDate())";

      $result = mysqli_query($conexao, $query);


      //INSERINDO NA TABELA DE ALUNOS
      // if($nivel == 'Aluno'){

      // $query_alunos = "INSERT INTO alunos (nome, cpf, email, senha, foto, data) values ('$nome', '$cpf', '$usuario', '$senha', 'sem-perfil.png', curDate())";

      // $result_alunos = mysqli_query($conexao, $query_alunos);


      // }



      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
      } else {
        echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
        echo "<script language='javascript'>window.location='admin.php?acao=funcoes'; </script>";
      }
    }
    ?>




    <!--EDITAR -->
    <?php
    if (@$_GET['func'] == 'edita') {
      $id = $_GET['id'];

      $query = "select * from funcoes where id = '$id' ";
      $result = mysqli_query($conexao, $query);

      while ($res = mysqli_fetch_array($result)) {
        $nome_funcao = $res["nome_funcao"];
        $descricao_funcao = $res["descricao_funcao"];
        $id_usuario_editor = $res["id_usuario_editor"];
        $data_ultima_edicao_funcao = $res["data_ultima_edicao_funcao"];

    ?>

        <!-- Modal Editar -->
        <div id="modalEditar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h5 class="modal-title">Funções</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <div class="form-group">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control mr-2" name="nome_funcao" value="<?php echo $nome_funcao ?>" placeholder="Nome" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group">
                    <label for="id_produto">Descrição</label>
                    <input type="text" class="form-control mr-2" name="descricao_funcao" value="<?php echo $descricao_funcao ?>" placeholder="Descrição" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group">
                    <label for="id_produto">Usuário Editor</label>
                    <input type="text" class="form-control mr-2" name="id_usuario_editor" placeholder="Usuário Editor" value="<?php echo $id_usuario_editor ?>" style="text-transform:uppercase;" required>
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
          $nome_funcao = mb_strtoupper($_POST['nome_funcao']);
          $descricao_funcao = mb_strtoupper($_POST['descricao_funcao']);
          $id_usuario_editor = mb_strtoupper($_POST['id_usuario_editor']);


          if ($res["nome_funcao"] != $nome_funcao) {
            //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
            $query_verificar_fu = "SELECT * from funcoes where nome_funcao = '$nome_funcao' ";
            $result_verificar_fu = mysqli_query($conexao, $query_verificar_fu);
            $row_verificar_fu = mysqli_num_rows($result_verificar_fu);
            if ($row_verificar_fu > 0) {
              echo "<script language='javascript'>window.alert('Função já Cadastrada'); </script>";
              exit();
            }
          }

          $query = "UPDATE funcoes SET nome_funcao = '$nome_funcao', descricao_funcao = '$descricao_funcao', id_usuario_editor = '$id_usuario_editor' where id = '$id' ";

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
            echo "<script language='javascript'>window.location='admin.php?acao=funcoes'; </script>";
          }
        }
      }
    }

    ?>



    <!--EXCLUIR -->
    <?php
    if (@$_GET['func'] == 'excluir') {
      $id = $_GET['id'];



      //recuperar nome do bairro
      $query_fu = "select * from funcoes where id = '$id' ";
      $result_fu = mysqli_query($conexao, $query_fu);

      while ($res = mysqli_fetch_array($result_fu)) {

        $id = $res["id"];
        $nome_funcao = $res["nome_funcao"];



        $query = "DELETE FROM funcoes where id = '$id' ";
        $result = mysqli_query($conexao, $query);
        echo "<script language='javascript'>window.location='admin.php?acao=funcoes'; </script>";
      }
    }

    ?>




    <script>
      $("#modalEditar").modal("show");
    </script>


    <!--MASCARAS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>

<style>
  .numero {
    text-decoration: none;
    background: #2A85B6;
    text-align: center;
    padding: 3px 0;
    display: block;
    margin: 0 2px;
    float: left;
    width: 20px;
    color: #fff;
  }

  .numero:hover,
  .numativo,
  .controle:hover {
    background: #1B3B54;
  }

  .controle {
    text-decoration: none;
    background: #2A85B6;
    text-align: center;
    padding: 3px 8px;
    display: block;
    margin: 0 3px;
    float: left;
    color: #fff;
  }
</style>



<div class="container ml-4" style="margin-top: -25px; margin-bottom: -25px;">
  <div class="row">

    <div class="col-lg-8 col-md-6">
      <h3>LOGRADOUROS</h3>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarLogradouros" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Logradouro" aria-label="Pesquisar">
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

              <!--LISTAR TODOS OS LOGRADOUROS -->
              <?php
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarLogradouros'] != '') {

                //verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
                $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

                $nome = $_GET['txtpesquisarLogradouros'];
                $query = "SELECT * from logradouro where nome_logradouro = '$nome' order by nome_logradouro asc ";

                $result_count = mysqli_query($conexao, $query);

                $registros = mysqli_num_rows($result_count);

                $result = mysqli_query($conexao, $query);

                $linha = mysqli_num_rows($result);
                $linha_count = mysqli_num_rows($result_count);

                //calcula o número de páginas arredondando o resultado para cima 
                $numPaginas = ceil($linha_count / $registros);

                //variavel para calcular o início da visualização com base na página atual 
                $inicio = ($registros * $pagina) - $registros;

                //seleciona os itens por página 
                $query_count2 = "SELECT * from logradouro where nome_logradouro = '$nome' limit $inicio,$registros";
                $result_count2 = mysqli_query($conexao, $query_count2);
                $linha_count2 = mysqli_num_rows($result_count2);
              } else {

                //verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
                $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

                $query = "SELECT * from logradouro order by id_logradouro desc limit 10";



                $query_count = "SELECT * from logradouro";
                $result_count = mysqli_query($conexao, $query_count);

                //seta a quantidade de itens por página
                $registros = 15;

                $result = mysqli_query($conexao, $query);

                $linha = mysqli_num_rows($result);
                $linha_count = mysqli_num_rows($result_count);

                //calcula o número de páginas arredondando o resultado para cima 
                $numPaginas = ceil($linha_count / $registros);

                //variavel para calcular o início da visualização com base na página atual 
                $inicio = ($registros * $pagina) - $registros;

                //seleciona os itens por página 
                $query_count2 = "SELECT * from logradouro limit $inicio,$registros";
                $result_count2 = mysqli_query($conexao, $query_count2);
                $linha_count2 = mysqli_num_rows($result_count2);
              }



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
                      CEP
                    </th>
                    <th>
                      Localidade
                    </th>
                    <th>
                      Bairro
                    </th>

                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result_count2)) {
                      $nome_logradouro = $res["nome_logradouro"];
                      $tipo_logradouro = $res["tipo_logradouro"];
                      $cep_logradouro = $res["cep_logradouro"];
                      $localidade = $res["id_localidade"];
                      $bairro = $res["id_bairro"];
                      $id = $res["id_logradouro"];

                      //$data2 = implode('/', array_reverse(explode('-', $data_ultima_edicao_logradouro)));

                      //trazendo o nome da categoria que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_localidade = "SELECT * from localidade where id_localidade = '$localidade' ";
                      $result_localidade = mysqli_query($conexao, $query_localidade);
                      $row_localidade = mysqli_fetch_array($result_localidade);
                      $nome_localidade = $row_localidade['nome_localidade'];

                      //trazendo o nome do bairro que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_bairro = "SELECT * from bairro where id_bairro = '$bairro' ";
                      $result_bairro = mysqli_query($conexao, $query_bairro);
                      $row_bairro = mysqli_fetch_array($result_bairro);
                      $nome_bairro = $row_bairro['nome_bairro'];

                      //trazendo o nome do tipo logradouro que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_t_log = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$tipo_logradouro' ";
                      $result_t_log = mysqli_query($conexao, $query_t_log);
                      $row_t_log = mysqli_fetch_array($result_t_log);
                      $nome_t_log = $row_t_log['descricao_tipo_logradouro'];

                    ?>

                      <tr>

                        <td><?php echo $nome_t_log; ?> <?php echo $nome_logradouro; ?></td>
                        <td id="cepp"><?php echo $cep_logradouro; ?></td>
                        <td><?php echo $nome_localidade; ?></td>
                        <td><?php echo $nome_bairro; ?></td>

                      </tr>

                    <?php } ?>


                  </tbody>
                  <tfoot>
                    <tr>


                      <td></td>
                      <td></td>
                      <td></td>


                      <td>
                        <span class="text-muted">Registros: <?php echo $linha_count ?> <a class="btn btn-info btn-sm" title="Imprimir Listagem" href="rel_logradouro.php" target="_blank"><i class="fas fa-clipboard-list"></i> Imprimir</a> </span>
                      </td>
                    </tr>

                  </tfoot>
                </table>

                Páginas: <br>
              <?php
                //exibe a paginação
                if ($pagina > 1) {
                  echo "<a href='atendimento.php?acao=logradouros&pagina=" . ($pagina - 1) . "' class='controle'>&laquo; anterior</a>";
                }

                for ($i = 1; $i < $numPaginas + 1; $i++) {
                  $ativo = ($i == $pagina) ? 'numativo' : '';
                  echo "<a href='atendimento.php?acao=logradouros&pagina=" . $i . "' class='numero " . $ativo . "'> " . $i . " </a>";
                }

                if ($pagina < $numPaginas) {
                  echo "<a href='atendimento.php?acao=logradouros&pagina=" . ($pagina + 1) . "' class='controle'>proximo &raquo;</a>";
                }



                //exibe a paginação 
                // for($i = 1; $i < $numPaginas + 1; $i++) { 
                // echo "<a href='atendimento.php?acao=logradouros&pagina=$i'>".$i."</a> "; 
                //} 
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
    $query_num_aula = "select * from logradouro order by id_logradouro desc ";
    $result_num_aula = mysqli_query($conexao, $query_num_aula);

    $res_num_aula = mysqli_fetch_array($result_num_aula);
    $ultima_aula = $res_num_aula["id_logradouro"];
    $ultima_aula = $ultima_aula + 1;

    ?>


    <div id="modalExemplo" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Logradouros</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

            <Body OnLoad='javascript:Atualiza();Atualiza2();'>
              <form method="POST" action="">

                <div class="form-group">
                  <label for="id_produto">Nome</label>
                  <input type="text" class="form-control mr-2" name="nome_logradouro" placeholder="Nome" style="text-transform:uppercase;" required>
                </div>

                <div class="form-group">
                  <label for="fornecedor">Localidade</label>

                  <select class="form-control mr-2" id="category" name=txtpesquisarEndereco onchange=javascript2:Atualiza(this.value);>
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



                <div class="form-group" id="atualiza01"></div>


                <div class="form-group">
                  <label for="id_produto">CEP</label>
                  <input type="text" class="form-control mr-2" name="cep_logradouro" placeholder="CEP" id="cep" style="text-transform:uppercase;" required>
                </div>

                <div class="form-group">
                  <label for="fornecedor">Tipo Logradouro</label>

                  <select class="form-control mr-2" id="category" name="id_tipo_logradouro">
                    <option value="">---Escolha uma opção---</option>

                    <?php

                    //recuperando dados da tabela localidade para o select
                    $query = "select * from tipo_logradouro order by descricao_tipo_logradouro asc";
                    $result = mysqli_query($conexao, $query);
                    while ($res = mysqli_fetch_array($result)) {

                    ?>
                      <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
                      <option value="<?php echo $res['id_tipo_logradouro'] ?>"><?php echo $res['descricao_tipo_logradouro'] ?></option>

                    <?php
                    }
                    ?>

                  </select>
                </div>

          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success mb-3" name="salvar">Salvar </button>


            <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
            </form>
            </body>
          </div>
        </div>
      </div>
    </div>




    <!--CADASTRO -->


    <?php
    if (isset($_POST['salvar'])) {

      $id_logradouro = $ultima_aula;
      $nome_logradouro = mb_strtoupper($_POST['nome_logradouro']);
      $id_localidade = mb_strtoupper($_POST['txtpesquisarEndereco']);
      $id_bairro = mb_strtoupper($_POST['txtpesquisarEndereco2']);
      $cep_logradouro = mb_strtoupper($_POST['cep_logradouro']);
      //puxando do login
      $id_usuario_editor = $_SESSION['id_usuario'];
      $id_tipo_logradouro = mb_strtoupper($_POST['id_tipo_logradouro']);

      //tirando mascara do cep
      $cep_logradouro = str_replace("-", "", $cep_logradouro);


      //VERIFICAR SE A LOCALIDADE JÁ ESTÁ CADASTRADA
      $query_verificar_log = "SELECT * from logradouro where nome_logradouro= '$nome_logradouro' ";
      $result_verificar_log = mysqli_query($conexao, $query_verificar_log);
      $row_verificar_log = mysqli_num_rows($result_verificar_log);
      if ($row_verificar_log > 0) {
        echo "<script language='javascript'>window.alert('Logradouro já Cadastrado'); </script>";
        exit();
      }



      $query = "INSERT INTO logradouro (id_logradouro, nome_logradouro, id_localidade, id_bairro, cep_logradouro, id_usuario_editor_registro, id_tipo_logradouro, data_ultima_edicao) values ('$id_logradouro', '$nome_logradouro', '$id_localidade', '$id_bairro', '$cep_logradouro', '$id_usuario_editor', '$tipo_logradouro', curDate())";

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
        echo "<script language='javascript'>window.location='atendimento.php?acao=logradouros'; </script>";
      }
    }
    ?>




    <!--EDITAR -->
    <?php
    if (@$_GET['func'] == 'edita') {
      $id = $_GET['id'];

      $query = "select * from logradouro where id_logradouro = '$id' ";
      $result = mysqli_query($conexao, $query);

      while ($res = mysqli_fetch_array($result)) {
        $nome_logradouro = $res["nome_logradouro"];
        $id_localidade = $res['id_localidade'];
        $id_bairro = $res['id_bairro'];
        $cep_logradouro = $res['cep_logradouro'];
        $id_tipo_logradouro = $res['id_tipo_logradouro'];

        //consulta para recuperação do nome da localidade
        $query_loc = "select * from localidade where id_localidade = '$id_localidade' ";
        $result_loc = mysqli_query($conexao, $query_loc);
        $row = mysqli_fetch_array($result_loc);
        //vai para a modal
        $nome_loc = $row['nome_localidade'];

        //consulta para recuperação do nome do bairro
        $query_ba = "select * from bairro where id_bairro = '$id_bairro' ";
        $result_ba = mysqli_query($conexao, $query_ba);
        $row = mysqli_fetch_array($result_ba);
        //vai para a modal
        $nome_ba = $row['nome_bairro'];

        //consulta para recuperação do nome do tipo logradouro
        $query_tl = "select * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
        $result_tl = mysqli_query($conexao, $query_tl);
        $row = mysqli_fetch_array($result_tl);
        //vai para a modal
        $nome_tl = $row['descricao_tipo_logradouro'];


    ?>

        <!-- Modal Editar -->
        <div id="modalEditar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h5 class="modal-title">Logradouros</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <div class="form-group">
                    <label for="id_produto">Nome</label>
                    <input type="text" class="form-control mr-2" name="nome_logradouro" value="<?php echo $nome_logradouro ?>" style="text-transform:uppercase;" placeholder="Nome" required>
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

                  <div class="form-group">
                    <label for="fornecedor">Bairro</label>

                    <select class="form-control mr-2" id="category" name="id_bairro">

                      <option value="<?php echo $id_bairro; ?>"><?php echo $nome_ba; ?></option>

                      <?php

                      $query = "select * from bairro order by nome_bairro asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {

                      ?>

                        <?php

                        //condição para mostrar o option para não se repetir o nome que já esta
                        if ($nome_ba != $res['nome_bairro']) { ?>

                          <option value="<?php echo $res['id_bairro']; ?>"><?php echo $res['nome_bairro']; ?></option>

                      <?php
                        }
                      }

                      ?>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="id_produto">CEP</label>
                    <input type="text" class="form-control mr-2" name="cep_logradouro" value="<?php echo $cep_logradouro ?>" placeholder="CEP" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group">
                    <label for="fornecedor">Tipo Logradouro</label>

                    <select class="form-control mr-2" id="category" name="id_tipo_logradouro">

                      <option value="<?php echo $id_tipo_logradouro; ?>"><?php echo $nome_tl; ?></option>

                      <?php

                      $query = "select * from tipo_logradouro order by descricao_tipo_logradouro asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {

                      ?>

                        <?php

                        //condição para mostrar o option para não se repetir o nome que já esta
                        if ($nome_tl != $res['descricao_tipo_logradouro']) { ?>

                          <option value="<?php echo $res['id_tipo_logradouro']; ?>"><?php echo $res['descricao_tipo_logradouro']; ?></option>

                      <?php
                        }
                      }

                      ?>

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
          $nome_logradouro = mb_strtoupper($_POST['nome_logradouro']);
          $id_localidade = mb_strtoupper($_POST['id_localidade']);
          $id_bairro = mb_strtoupper($_POST['id_bairro']);
          $cep_logradouro = mb_strtoupper($_POST['cep_logradouro']);
          $id_tipo_logradouro = mb_strtoupper($_POST['id_tipo_logradouro']);
          $id_usuario_editor = $_SESSION['id_usuario'];

          if ($res["nome_logradouro"] != $nome_logradouro) {
            //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
            $query_verificar_log = "SELECT * from logradouro where nome_logradouro = '$nome_logradouro' ";
            $result_verificar_log = mysqli_query($conexao, $query_verificar_log);
            $row_verificar_log = mysqli_num_rows($result_verificar_log);
            if ($row_verificar_log > 0) {
              echo "<script language='javascript'>window.alert('Logradouro já Cadastrado'); </script>";
              exit();
            }
          }

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


          $query = "UPDATE logradouro SET nome_logradouro = '$nome_logradouro', id_localidade = '$id_localidade', id_bairro = '$id_bairro', cep_logradouro = '$cep_logradouro', id_tipo_logradouro = '$id_tipo_logradouro', id_usuario_editor_registro = '$id_usuario_editor', data_ultima_edicao = curDate() where id_logradouro = '$id' ";

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
            echo "<script language='javascript'>window.location='atendimento.php?acao=logradouros'; </script>";
          }
        }
      }
    }

    ?>



    <!--EXCLUIR -->
    <?php
    if (@$_GET['func'] == 'excluir') {
      $id = $_GET['id'];


      $query = "DELETE FROM logradouro where id_logradouro = '$id' ";
      $result = mysqli_query($conexao, $query);
      echo "<script language='javascript'>window.location='atendimento.php?acao=logradouros'; </script>";
    }

    ?>


    <script>
      $("#modalEditar").modal("show");
    </script>

    <!--MASCARAS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


    <script type="text/javascript">
      $(document).ready(function() {
        $('#cep').mask('99999-999');
      });
    </script>

    <!--MASCARAS 02 -->
    <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <script>
      $("td[id*='cepp']").inputmask({
        mask: ['99999-999'],
        keepStatic: true
      });
    </script>
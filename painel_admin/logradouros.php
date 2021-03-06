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
      <h3>LOGRADOUROS</h3>
    </div>

    <div class="col-lg-8 col-md-6 col-sm-12">
      <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> LOGRADOUROS </i> </button>

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



                $nome = '%' . $_GET['txtpesquisarLogradouros'] . '%';
                $query = "SELECT * from enderecamento_logradouro where nome_logradouro LIKE '$nome' order by nome_logradouro asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from enderecamento_logradouro order by id_logradouro desc limit 10";

                $query_count = "SELECT * from enderecamento_logradouro";
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
                      CEP
                    </th>
                    <th>
                      Localidade
                    </th>
                    <th>
                      Bairro
                    </th>


                    <th>
                      A????es
                    </th>
                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $nome_logradouro = $res["nome_logradouro"];
                      $tipo_logradouro = $res["tipo_logradouro"];
                      $cep_logradouro = $res["cep_logradouro"];
                      $localidade = $res["id_localidade"];
                      $bairro = $res["id_bairro"];
                      $id = $res["id_logradouro"];

                      //$data2 = implode('/', array_reverse(explode('-', $data_ultima_edicao_logradouro)));

                      //trazendo o nome da categoria que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_localidade = "SELECT * from enderecamento_localidade where id_localidade = '$localidade' ";
                      $result_localidade = mysqli_query($conexao, $query_localidade);
                      $row_localidade = mysqli_fetch_array($result_localidade);
                      $nome_localidade = $row_localidade['nome_localidade'];

                      //trazendo o nome do bairro que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_bairro = "SELECT * from enderecamento_bairro where id_bairro = '$bairro' ";
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


                        <td>

                          <a class="btn btn-info btn-sm" href="admin.php?acao=logradouros&func=edita&id=<?php echo $id; ?>&id_bairro=<?php echo $bairro; ?>"><i class="fas fa-edit"></i></a>

                          <a class="btn btn-danger btn-sm" href="admin.php?acao=logradouros&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>





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
    $query_num_log = "select * from enderecamento_logradouro order by id_logradouro desc ";
    $result_num_log = mysqli_query($conexao, $query_num_log);

    $res_num_log = mysqli_fetch_array($result_num_log);
    $ultimo_log = $res_num_log["id_logradouro"];
    $ultimo_log = $ultimo_log + 1;

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
                  <label for="id_produto">CEP</label>
                  <input type="text" class="form-control mr-2" name="cep_logradouro" placeholder="CEP" id="cep" style="text-transform:uppercase;" required>
                </div>

                <div class="form-group">
                  <label for="id_produto">Localidade</label>
                  <input type="text" class="form-control mr-2" name="id_localidade" id="id_localidade" placeholder="Localidade" style="text-transform:uppercase;" required>
                </div>

                <div class="form-group">
                  <label for="fornecedor">Bairro</label>

                  <select class="form-control mr-2" id="category" name="id_bairro">
                    <option value="">---Escolha uma op????o---</option>

                    <?php

                    //recuperando dados da tabela localidade para o select
                    $query = "select * from enderecamento_bairro order by nome_bairro asc";
                    $result = mysqli_query($conexao, $query);
                    while ($res = mysqli_fetch_array($result)) {

                    ?>
                      <!--relacionamento com base no id gravando s?? o mesmo mas visualizando o nome-->
                      <option value="<?php echo $res['id_bairro'] ?>"><?php echo $res['nome_bairro'] ?></option>

                    <?php
                    }
                    ?>

                  </select>
                </div>

                <div class="form-group">
                  <label for="fornecedor">Tipo Logradouro</label>

                  <select class="form-control mr-2" id="category" name="id_tipo_logradouro">
                    <option value="">---Escolha uma op????o---</option>

                    <?php

                    //recuperando dados da tabela localidade para o select
                    $query = "select * from tipo_logradouro order by descricao_tipo_logradouro asc";
                    $result = mysqli_query($conexao, $query);
                    while ($res = mysqli_fetch_array($result)) {

                    ?>
                      <!--relacionamento com base no id gravando s?? o mesmo mas visualizando o nome-->
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

      $id_logradouro = $ultimo_log;
      $nome_logradouro = mb_strtoupper($_POST['nome_logradouro']);

      $nome_localidade = mb_strtoupper($_POST['id_localidade']);
      //consulta para id_localidade
      $query_loc = "SELECT * from enderecamento_localidade where nome_localidade = '$nome_localidade' ";
      $result_loc = mysqli_query($conexao, $query_loc);
      $res_loc = mysqli_fetch_array($result_loc);
      $id_localidade = $res_loc["id_localidade"];

      $id_bairro = mb_strtoupper($_POST['id_bairro']);
      $cep_logradouro = mb_strtoupper($_POST['cep_logradouro']);
      //puxando do login
      $id_usuario_editor = $_SESSION['id_usuario'];
      $id_tipo_logradouro = mb_strtoupper($_POST['id_tipo_logradouro']);

      //tirando mascara do cep
      $cep_logradouro = str_replace("-", "", $cep_logradouro);

      //VERIFICAR SE A LOCALIDADE J?? EST?? CADASTRADA
      $query_verificar_log = "SELECT * from enderecamento_logradouro where nome_logradouro= '$nome_logradouro' ";
      $result_verificar_log = mysqli_query($conexao, $query_verificar_log);
      $row_verificar_log = mysqli_num_rows($result_verificar_log);
      if ($row_verificar_log > 0) {
        echo "<script language='javascript'>window.alert('Logradouro j?? Cadastrado'); </script>";
        exit();
      }

      //echo $id_logradouro . ', ' . $nome_logradouro . ', ' . $id_localidade . ', ' . $id_bairro . ', ' . $cep_logradouro . ', ' . $id_usuario_editor . ', ' . $id_tipo_logradouro;

      $query = "INSERT INTO enderecamento_logradouro (id_logradouro, nome_logradouro, id_localidade, id_bairro, cep_logradouro, id_usuario_editor_registro, tipo_logradouro) values ('$id_logradouro', '$nome_logradouro', '$id_localidade', '$id_bairro', '$cep_logradouro', '$id_usuario_editor', '$id_tipo_logradouro')";

      $result = mysqli_query($conexao, $query);

      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
      } else {
        echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
        // echo "<script language='javascript'>window.location='admin.php?acao=logradouros'; </script>";
      }
    }
    ?>




    <!--EDITAR -->
    <?php
    if (@$_GET['func'] == 'edita') {
      $id = $_GET['id'];
      $id_bairro = $_GET['id_bairro'];

      //echo $id . ', ' . $id_bairro;

      $query = "SELECT * from enderecamento_logradouro where id_logradouro = '$id' and id_bairro = '$id_bairro' ";
      $result = mysqli_query($conexao, $query);

      while ($res = mysqli_fetch_array($result)) {
        $nome_logradouro = $res["nome_logradouro"];
        $id_localidade = $res['id_localidade'];
        $id_bairro = $res['id_bairro'];
        $cep_logradouro = $res['cep_logradouro'];
        $id_tipo_logradouro = $res['tipo_logradouro'];

        //consulta para recupera????o do nome da localidade
        $query_loc = "SELECT * from enderecamento_localidade where id_localidade = '$id_localidade' ";
        $result_loc = mysqli_query($conexao, $query_loc);
        $row = mysqli_fetch_array($result_loc);
        //vai para a modal
        $nome_loc = $row['nome_localidade'];

        //consulta para recupera????o do nome do bairro
        $query_ba = "SELECT * from enderecamento_bairro where id_localidade = '$id_localidade' and id_bairro = '$id_bairro' ";
        $result_ba = mysqli_query($conexao, $query_ba);
        $row = mysqli_fetch_array($result_ba);
        //vai para a modal
        $nome_ba = $row['nome_bairro'];

        //consulta para recupera????o do nome do tipo logradouro
        $query_tl = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
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

                      $query = "select * from enderecamento_localidade order by nome_localidade asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {

                      ?>

                        <?php

                        //condi????o para mostrar o option para n??o se repetir o nome que j?? esta
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

                      $query = "select * from enderecamento_bairro order by nome_bairro asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {

                      ?>

                        <?php

                        //condi????o para mostrar o option para n??o se repetir o nome que j?? esta
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

                        //condi????o para mostrar o option para n??o se repetir o nome que j?? esta
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

          /* if ($res["nome_logradouro"] != $nome_logradouro) {
            //VERIFICAR SE O CPF J?? EST?? CADASTRADO
            $query_verificar_log = "SELECT * from enderecamento_logradouro where nome_logradouro = '$nome_logradouro' ";
            $result_verificar_log = mysqli_query($conexao, $query_verificar_log);
            $row_verificar_log = mysqli_num_rows($result_verificar_log);
            if ($row_verificar_log > 0) {
              echo "<script language='javascript'>window.alert('Logradouro j?? Cadastrado'); </script>";
              exit();
            }
          } */

          //echo $nome_logradouro . ', ' . $id_localidade . ', ' . $id_bairro . ', ' . $cep_logradouro . ', ' . $id_tipo_logradouro . ', ' . $id_usuario_editor;

          $query = "UPDATE enderecamento_logradouro SET nome_logradouro = '$nome_logradouro', id_localidade = '$id_localidade', id_bairro = '$id_bairro', cep_logradouro = '$cep_logradouro', tipo_logradouro = '$id_tipo_logradouro', id_usuario_editor_registro = '$id_usuario_editor' where id_logradouro = '$id' and id_bairro = '$id_bairro' ";

          $result = mysqli_query($conexao, $query);

          if ($result == '') {
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
          } else {
            echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
            echo "<script language='javascript'>window.location='admin.php?acao=logradouros'; </script>";
          }
        }
      }
    }

    ?>

    <!--EXCLUIR -->
    <?php
    if (@$_GET['func'] == 'excluir') {
      $id = $_GET['id'];

      $query = "DELETE FROM enderecamento_logradouro where id_logradouro = '$id' ";
      $result = mysqli_query($conexao, $query);
      echo "<script language='javascript'>window.location='admin.php?acao=logradouros'; </script>";
    }

    ?>


    <script>
      $("#modalEditar").modal("show");
    </script>

    <!--MASCARAS 02 -->
    <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <script>
      $("td[id*='cepp']").inputmask({
        mask: ['99999-999'],
        keepStatic: true
      });
    </script>
    <script>
      $("input[id*='cep']").inputmask({
        mask: ['99999-999'],
        keepStatic: true
      });
    </script>

    <!--Importando Script Jquery-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script type="text/javascript">
      $("#cep").focusout(function() {
        //In??cio do Comando AJAX
        $.ajax({
          //O campo URL diz o caminho de onde vir?? os dados
          //?? importante concatenar o valor digitado no CEP
          url: 'https://viacep.com.br/ws/' + $(this).val() + '/json/unicode/',
          //Aqui voc?? deve preencher o tipo de dados que ser?? lido,
          //no caso, estamos lendo JSON.
          dataType: 'json',
          //SUCESS ?? referente a fun????o que ser?? executada caso
          //ele consiga ler a fonte de dados com sucesso.
          //O par??metro dentro da fun????o se refere ao nome da vari??vel
          //que voc?? vai dar para ler esse objeto.
          success: function(resposta) {
            //Agora basta definir os valores que voc?? deseja preencher
            //automaticamente nos campos acima.
            $("#logradouro").val(resposta.logradouro);
            $("#complemento").val(resposta.complemento);
            $("#bairro").val(resposta.bairro);
            $("#id_localidade").val(resposta.localidade);
            $("#uf").val(resposta.uf);
            //Vamos incluir para que o N??mero seja focado automaticamente
            //melhorando a experi??ncia do usu??rio
            $("#numero").focus();
          }
        });
      });
    </script>
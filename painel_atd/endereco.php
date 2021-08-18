<?php
include_once('../conexao.php');

?>


<div class="container ml-4">
  <div class="row">

    <div class="col-lg-8 col-md-6 col-sm-12">
      <button class="btn btn-outline-secondary" onclick="javascript:window.location.href='admin.php?acao=requerimento'"> <i class="fas fa-arrow-circle-left"> VOLTAR PARA REQUERIMENTO </i> </button>

    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">

    <Body OnLoad='javascript:Atualiza();Atualiza2();'>
      <form class=" my-2 my-lg-0">
        <div class="row">
          <div class="form-group col-md-6">
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



          <div class="form-group col-md-6" id="atualiza01"></div>

          <div class="form-group col-md-6" id="atualiza02"></div>

          <div class="form-group col-md-4">
            <label for="fornecedor">Encontrar</label>
            <button name="buttonPesquisar" class="btn btn-outline-secondary form-control mr-2" type="submit"><i class="fa fa-search"></i></button>
          </div>
        </div>



      </form>
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


              if (isset($_GET['buttonPesquisar']) and ($_GET['txtpesquisarEndereco'] != '') and ($_GET['txtpesquisarEndereco2'] != '') and ($_GET['txtpesquisarEndereco3'] != '')) {

                $bairro = @$_GET['txtpesquisarEndereco2'] . '%';
                $log = @$_GET['txtpesquisarEndereco3'] . '%';
                $nome = $_GET['txtpesquisarEndereco'] . '%';
                $query = "SELECT * from enderecamento_instalacao where id_localidade LIKE '$nome' and id_bairro = '$bairro' and id_logradouro = '$log' order by id_unidade_consumidora asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from enderecamento_instalacao order by id_unidade_consumidora desc limit 10";

                $query_count = "SELECT * from enderecamento_instalacao";
                $result_count = mysqli_query($conexao, $query_count);
              }

              $result = mysqli_query($conexao, $query);

              $linha = mysqli_num_rows($result);
              $linha_count = mysqli_num_rows($result_count);

              if ($linha == '') {
                echo "<h3> Não foram encontrados dados Cadastrados no Banco!! </h3>";
              } else {

              ?>




                <table class="table">
                  <thead class="text-secondary">

                    <th>
                      UC
                    </th>
                    <th>
                      Localidade
                    </th>
                    <th>
                      Nome/Razão Social
                    </th>
                    <th>
                      CPF/CNPJ
                    </th>
                    <th>
                      Data de Cadastro
                    </th>




                    <th>
                      Ações
                    </th>
                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $uc = $res["id_unidade_consumidora"];
                      $localidade = $res["id_localidade"];

                      //trazendo o nome do usuario que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_user = "SELECT * from unidade_consumidora where 	id_unidade_consumidora = '$uc' ";

                      $result_user = mysqli_query($conexao, $query_user);
                      $row_user = mysqli_fetch_array($result_user);
                      $nome_user = $row_user['nome_razao_social'];

                      //trazendo cpf/cnpj que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_cc = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$uc' ";

                      $result_cc = mysqli_query($conexao, $query_cc);
                      $row_cc = mysqli_fetch_array($result_cc);
                      $nome_cc = $row_user['numero_cpf_cnpj'];

                      //trazendo telefone que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_t = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$uc' ";

                      $result_t = mysqli_query($conexao, $query_t);
                      $row_t = mysqli_fetch_array($result_cc);
                      $nome_t = $row_user['data_cadastro'];
                      $data2 = implode('/', array_reverse(explode('-', $nome_t)));

                      //trazendo nome localidade que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_loc = "SELECT * from enderecamento_localidade where id_localidade = ' $localidade' ";

                      $result_loc = mysqli_query($conexao, $query_loc);
                      $row_loc = mysqli_fetch_array($result_loc);
                      $nome_loc = $row_loc['nome_localidade'];






                    ?>

                      <tr>

                        <td><?php echo $uc; ?></td>

                        <td><?php echo  $nome_loc; ?></td>


                        <td><?php echo $nome_user; ?></td>
                        <td><?php echo $nome_cc; ?></td>

                        <td><?php echo $data2; ?></td>


                        <td>


                          <!--chamando modal para envio de mensagem-->
                          <a class="btn btn-warning" title="Enviar Mensagem" data-toggle="modal" data-target="#modalMensagem"><i class="fas fa-sms"></i></a>

                          <a class="btn btn-danger" title="Excluir Curso" href="#"><i class="fa fa-minus-square"></i></a>




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
  </div>
</div>
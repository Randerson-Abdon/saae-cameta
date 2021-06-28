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
      <h3>CONTROLE DE ORDENS DE SERVIÇO</h3>
    </div>
    <div class="pesquisar col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarOs" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
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

              <!--LISTAR TODOS OS REQUERIMENTOS -->
              <?php
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarOs'] != '') {

                $numero_req = '%' . $_GET['txtpesquisarOs'] . '%';
                $nome = $_GET['txtpesquisarOs'] . '%';
                //trazendo info requerimento
                $query_up = "SELECT * from requerimento where nome_razao_social LIKE '%$nome%' ";
                $result_up = mysqli_query($conexao, $query_up);
                $row_up = mysqli_fetch_array($result_up);
                $nome2 = $row_up['id_requerimento'];

                $datap = $_GET['txtpesquisarOs'];
                $datap2 = implode('-', array_reverse(explode('/', $datap)));
                //trazendo info requerimento
                $query_dp = "SELECT * from requerimento where data_requerimento LIKE '%$datap2%' ";
                $result_dp = mysqli_query($conexao, $query_dp);
                $row_dp = mysqli_fetch_array($result_dp);
                @$datap3 = $row_dp['id_requerimento'];

                $query = "SELECT * from ordem_servico where id_requerimento LIKE '$numero_req' OR id_requerimento LIKE '$nome2' OR id_requerimento LIKE '$datap3' order by id_ordem_servico asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from ordem_servico order by id_ordem_servico desc limit 10";

                $query_count = "SELECT * from ordem_servico";
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
                    <ul class="text-secondary">
                      <li>
                        Legenda: &nbsp; <i class="fas fa-square text-primary" title="Em Andamento"></i> = Em Andamento
                        &nbsp;&nbsp;<i class="fas fa-square text-secondary" title="Em Análise"></i> = Em Análise
                        &nbsp;&nbsp;<i class="fas fa-square text-success" title="Concluído"></i> = Concluído
                        &nbsp;&nbsp;<i class="fas fa-square text-danger" title="Inviável"></i> = Inviável
                      </li>
                    </ul>
                    <th class="text-danger">
                      Nº Req
                    </th>
                    <th>
                      Nº OS
                    </th>
                    <th>
                      Requerente
                    </th>
                    <th>
                      Status
                    </th>
                    <th>
                      Data do Pedido
                    </th>

                    <th>
                      Ações
                    </th>
                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $id = $res["id_ordem_servico"];
                      $id_requerimento = $res["id_requerimento"];
                      $status_ordem_servico = $res["status_ordem_servico"];

                      //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
                      $query_u = "SELECT * from requerimento where id_requerimento = '$id_requerimento' ";
                      $result_u = mysqli_query($conexao, $query_u);
                      $row_u = mysqli_fetch_array($result_u);
                      @$nome_razao_social = $row_u['nome_razao_social'];
                      @$data_requerimento = $row_u['data_requerimento'];

                      $data2 = implode('/', array_reverse(explode('-', $data_requerimento)));

                    ?>

                      <tr>

                        <td class="text-danger"><?php echo $id_requerimento; ?></td>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $nome_razao_social; ?></td>

                        <!--condições para status em cores-->
                        <td align="center">

                          <?php if ($status_ordem_servico == '1') { ?>
                            <i class="fas fa-square text-secondary" title="Em Análise"></i>
                          <?php } ?>

                          <?php if ($status_ordem_servico == '2') { ?>
                            <i class="fas fa-square text-primary" title="Em Andamento"></i>
                          <?php } ?>

                          <?php if ($status_ordem_servico == '3') { ?>
                            <i class="fas fa-square text-success" title="Concluído"></i>
                          <?php } ?>

                          <?php if ($status_ordem_servico == '4') { ?>
                            <i class="fas fa-square text-danger" title="Inviável"></i>
                          <?php } ?>

                        </td>

                        <td><?php echo $data2; ?></td>

                        <td>

                          <?php if ($status_ordem_servico == '1') { ?>
                            <a class="btn btn-warning btn-sm" title="Iniciar OS" href="operacional.php?acao=os&func=iniciar&id=<?php echo $id; ?>"><i class="fas fa-chalkboard-teacher"></i></a>
                          <?php } ?>

                          <?php if ($status_ordem_servico == '2') { ?>
                            <a class="btn btn-success btn-sm" title="Finalizar OS" href="operacional.php?acao=os&func=finalizar&id=<?php echo $id; ?>"><i class="fas fa-check-square"></i></a>
                          <?php } ?>

                          <?php if ($status_ordem_servico == '3') { ?>
                            <a class="btn btn-info btn-sm" title="Visualizar OS" href="operacional.php?acao=os&func=ver&id=<?php echo $id; ?>"><i class="fas fa-clipboard-list"></i></a>
                          <?php } ?>

                          <?php if ($status_ordem_servico == '2') { ?>
                            <a class="btn btn-info btn-sm" title="Formulário para campo" target="_blank" href="rel_campo.php?func=imprime&id=<?php echo $id; ?>"><i class="fas fa-share-square"></i></a>
                          <?php } ?>

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




    <!--INICIAR OS -->
    <?php
    if (@$_GET['func'] == 'iniciar') {
      $id = $_GET['id'];

      $query_cri = "select * from ordem_servico where id_ordem_servico = '$id' ";
      $result_cri = mysqli_query($conexao, $query_cri);

      while ($res = mysqli_fetch_array($result_cri)) {
        $id_requerimento = $res['id_requerimento'];
        $status_ordem_servico = $res['status_ordem_servico'];

        //trazendo info do requerimento
        $query_rq = "SELECT * from requerimento where id_requerimento = '$id_requerimento' ";
        $result_rq = mysqli_query($conexao, $query_rq);
        $row_rq = mysqli_fetch_array($result_rq);
        $nome_razao_social = $row_rq['nome_razao_social'];
        $id_unidade_consumidora = $row_rq['id_unidade_consumidora'];
        $numero_cpf_cnpj = $row_rq['numero_cpf_cnpj'];
        $fone_movel = $row_rq['fone_movel'];
        $data_requerimento = $row_rq['data_requerimento'];
        $status_requerimento = $row_rq['status_requerimento'];

        $data2 = implode('/', array_reverse(explode('-', $data_requerimento)));

        //trazendo info endereco_instalacao
        $query_e = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id_unidade_consumidora' ";
        $result_e = mysqli_query($conexao, $query_e);
        $row_e = mysqli_fetch_array($result_e);
        $id_localidade = $row_e['id_localidade'];
        $id_bairro = $row_e['id_bairro'];
        $id_logradouro = $row_e['id_logradouro'];
        $numero_logradouro = $row_e['numero_logradouro'];
        $complemento_logradouro = $row_e['complemento_logradouro'];

        //consulta para recuperação do nome da localidade
        $query_loc = "select * from localidade where id_localidade = '$id_localidade' ";
        $result_loc = mysqli_query($conexao, $query_loc);
        $row_loc = mysqli_fetch_array($result_loc);
        //vai para a modal
        $nome_loc = $row_loc['nome_localidade'];

        //consulta para recuperação do nome do bairro
        $query_ba = "select * from bairro where id_localidade = '$id_localidade' and id_bairro = '$id_bairro' ";
        $result_ba = mysqli_query($conexao, $query_ba);
        $row_ba = mysqli_fetch_array($result_ba);
        //vai para a modal
        $nome_ba = $row_ba['nome_bairro'];

        //consulta para recuperação do nome do logradouro
        $query_log = "select * from logradouro where id_logradouro = '$id_logradouro' and id_bairro = '$id_bairro' ";
        $result_log = mysqli_query($conexao, $query_log);
        $row_log = mysqli_fetch_array($result_log);
        //vai para a modal
        $nome_log = $row_log['nome_logradouro'];
        $id_tipo_logradouro = $row_log['tipo_logradouro'];

        //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
        $query_u = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
        $result_u = mysqli_query($conexao, $query_u);
        $row_u = mysqli_fetch_array($result_u);
        $abreviatura_tipo_logradouro = $row_u['abreviatura_tipo_logradouro'];


    ?>

        <!-- MODAL INICIAR OS -->

        <div id="modalIniciar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h3 class="modal-title">Ordem de Serviço</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <h5 class="modal-title">Dados</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº OS</label>
                      <input type="text" class="form-control mr-2" name="id_ordem_servico" value="<?php echo $id; ?>" readonly>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº req</label>
                      <input type="text" class="form-control mr-2" name="id_requerimento" value="<?php echo $id_requerimento; ?>" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">UC</label>
                      <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id_unidade_consumidora ?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">CPF/CNPJ</label>
                      <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" value="<?php echo $numero_cpf_cnpj ?>" readonly>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto">Nome/Razão Social</label>
                      <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Celular</label>
                      <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" readonly>
                    </div>

                  </div>

                  <h5 class="modal-title">Endereçamento</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="id_produto">Localidade</label>
                      <input type="text" class="form-control mr-2" name="nome_loc" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $nome_loc; ?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">Bairro</label>
                      <input type="text" class="form-control mr-2" name="nome_ba" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $nome_ba; ?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">Logradouro</label>
                      <input type="text" class="form-control mr-2" name="nome_ba" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $abreviatura_tipo_logradouro ?> <?php echo $nome_log; ?>" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Nº Logradouro</label>
                      <input type="text" class="form-control mr-2" name="numero_logradouro" placeholder="Nº" style="text-transform:uppercase;" value="<?php echo $numero_logradouro; ?>" readonly>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto">Complemento</label>
                      <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;" value="<?php echo $complemento_logradouro; ?>" readonly>
                    </div>

                  </div>

                  <h5 class="modal-title">Serviços Requeridos</h5>
                  <hr>
                  <div class="row">


                    <!--INICIO DA TABELA -->
                    <div class="table-responsive ml-3 mr-3">

                      <!--LISTAR TODOS OS SERVIÇOS -->
                      <?php

                      $query = "select * from servico_requerido where id_requerimento = '$id_requerimento' order by id_servico_requerido asc";

                      //execução da primeira consulta
                      $result = mysqli_query($conexao, $query);

                      $linha = mysqli_num_rows($result);


                      if ($linha == '') {
                        echo "<p> Não há serviços cadastrados para este requerimento!!! </p>";
                      } else {

                      ?>


                        <!--- table-sm= small = menor-->
                        <table class="table table-sm">
                          <thead class="text-secondary">


                            <th>
                              Serviço
                            </th>

                          </thead>
                          <tbody>

                            <?php
                            while ($res = mysqli_fetch_array($result)) {
                              $id_servico_requerido = $res["id_servico_requerido"];

                              if ($id_servico_requerido == '07') {
                                $status_execucao = 'A';
                              } else {
                                $status_execucao = 'O';
                              }

                              //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                              $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' AND status_execucao = '$status_execucao' ";
                              $result_sv = mysqli_query($conexao, $query_sv);
                              $row_sv = mysqli_fetch_array($result_sv);
                              $descricao_servico = $row_sv['descricao_servico'];
                              $valor_servico = $row_sv['valor_servico'];


                            ?>

                              <tr>


                                <td><?php echo $descricao_servico; ?></td>


                              </tr>

                            <?php } ?>


                          </tbody>
                          <tfoot>
                            <tr>

                              <td></td>

                            </tr>

                          </tfoot>
                        </table>

                      <?php
                      }

                      ?>

                    </div>


                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Data do Requerimento: </b></label>
                      <label for="id_produto"><?php echo $data2 ?></label>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto"><b>Status do Requerimento: </b></label>
                      <label for="id_produto"><?php if ($status_requerimento == 'A') {
                                                echo 'EM ANÁLISE';
                                              } elseif ($status_requerimento == 'D') {
                                                echo 'DEFERIDO';
                                              } else {
                                                echo 'INDEFERIDO';
                                              } ?></label>
                    </div>

                  </div>

                  <h5 class="modal-title">Outros</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Data de Inicio</label>
                      <input type="date" class="form-control mr-2" maxlength="10" id="saida" name="data_inicio_servico" value="<?php echo date('Y-m-d'); ?>" />
                    </div>

                    <div class="form-group col-md-2">
                      <label for="fornecedor">Hora de Inicio</label>
                      <input type="time" class="form-control mr-2" id="appt" name="hora_inicio_servico" min="07:00" max="18:00" required>
                    </div>

                    <div class="form-group col-md-9">
                      <label for="fornecedor">Observações</label>
                      <input type="text" maxlength="255" class="form-control mr-2" name="observacoes" placeholder="Observações" style="text-transform:uppercase;">
                    </div>

                  </div>


              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-success mb-3" name="iniciar">Iniciar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
                </form>
              </div>
            </div>
          </div>
        </div>


    <?php


        if (isset($_POST['iniciar'])) {

          $data_inicio_servico = $_POST['data_inicio_servico'];
          $hora_inicio_servico = $_POST['hora_inicio_servico'];
          $observacoes = mb_strtoupper($_POST['observacoes']);
          $id_equipe_executora = '01';
          $status_ordem_servico = '2';
          $status_requerimento = 'D';



          // insert requerimento
          $query = "UPDATE ordem_servico set data_inicio_servico = '$data_inicio_servico', hora_inicio_servico = '$hora_inicio_servico', observacoes = '$observacoes', id_equipe_executora = '$id_equipe_executora', status_ordem_servico = '$status_ordem_servico' where id_ordem_servico = '$id'";

          $result = mysqli_query($conexao, $query);


          if ($result == '') {
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao Iniciar!'); </script>";
          } else {

            $query_status = "UPDATE requerimento set status_requerimento = '$status_requerimento' where id_requerimento = '$id_requerimento'";
            mysqli_query($conexao, $query_status);

            $query_sr = "UPDATE servico_requerido set id_ordem_servico = '$id' where id_requerimento = '$id_requerimento' AND id_ordem_servico is null ";
            mysqli_query($conexao, $query_sr);

            echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
            echo "<script language='javascript'>window.location='operacional.php?acao=os'; </script>";
          }
        }
      }
    }

    ?>






    <!--FINALIZAR OS -->
    <?php
    if (@$_GET['func'] == 'finalizar') {
      $id = $_GET['id'];

      $query_cri = "select * from ordem_servico where id_ordem_servico = '$id' ";
      $result_cri = mysqli_query($conexao, $query_cri);

      while ($res = mysqli_fetch_array($result_cri)) {
        $id_requerimento = $res['id_requerimento'];
        $status_ordem_servico = $res['status_ordem_servico'];
        $data_inicio_servico = $res['data_inicio_servico'];
        $hora_inicio_servico = $res['hora_inicio_servico'];
        $observacoes = $res['observacoes'];

        //trazendo info do requerimento
        $query_rq = "SELECT * from requerimento where id_requerimento = '$id_requerimento' ";
        $result_rq = mysqli_query($conexao, $query_rq);
        $row_rq = mysqli_fetch_array($result_rq);
        $nome_razao_social = $row_rq['nome_razao_social'];
        $id_unidade_consumidora = $row_rq['id_unidade_consumidora'];
        $numero_cpf_cnpj = $row_rq['numero_cpf_cnpj'];
        $fone_movel = $row_rq['fone_movel'];
        $data_requerimento = $row_rq['data_requerimento'];
        $status_requerimento = $row_rq['status_requerimento'];


    ?>

        <!-- MODAL INICIAR OS -->

        <div id="modalFinalizar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h3 class="modal-title">Ordem de Serviço</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <h5 class="modal-title">Dados</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº OS</label>
                      <input type="text" class="form-control mr-2" name="id_ordem_servico" value="<?php echo $id; ?>" readonly>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº req</label>
                      <input type="text" class="form-control mr-2" name="id_requerimento" value="<?php echo $id_requerimento; ?>" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">UC</label>
                      <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id_unidade_consumidora ?>" readonly>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto">Nome/Razão Social</label>
                      <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
                    </div>

                  </div>

                  <h5 class="modal-title">Serviços Requeridos</h5>
                  <hr>
                  <div class="row">


                    <!--INICIO DA TABELA -->
                    <div class="table-responsive ml-3 mr-3">

                      <!--LISTAR TODOS OS SERVIÇOS -->
                      <?php

                      $query = "select * from servico_requerido where id_requerimento = '$id_requerimento' order by id_servico_requerido asc";

                      //execução da primeira consulta
                      $result = mysqli_query($conexao, $query);

                      $linha = mysqli_num_rows($result);


                      if ($linha == '') {
                        echo "<p> Não há serviços cadastrados para este requerimento!!! </p>";
                      } else {

                      ?>


                        <!--- table-sm= small = menor-->
                        <table class="table table-sm">
                          <thead class="text-secondary">


                            <th>
                              Serviço
                            </th>

                          </thead>
                          <tbody>

                            <?php

                            while ($res = mysqli_fetch_array($result)) {
                              $id_servico_requerido = $res["id_servico_requerido"];

                              if ($id_servico_requerido == '07') {
                                $status_execucao = 'A';
                              } else {
                                $status_execucao = 'O';
                              }

                              //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                              $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' AND status_execucao = '$status_execucao' ";
                              $result_sv = mysqli_query($conexao, $query_sv);
                              $row_sv = mysqli_fetch_array($result_sv);
                              $descricao_servico = $row_sv['descricao_servico'];
                              $valor_servico = $row_sv['valor_servico'];


                            ?>

                              <tr>


                                <td><?php echo $descricao_servico; ?></td>


                              </tr>

                            <?php } ?>


                          </tbody>
                          <tfoot>
                            <tr>

                              <td></td>

                            </tr>

                          </tfoot>
                        </table>

                      <?php
                      }

                      ?>

                    </div>


                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Data do Requerimento: </b></label>
                      <label for="id_produto"><?php echo $data2 ?></label>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto"><b>Status do Requerimento: </b></label>
                      <label for="id_produto"><?php if ($status_requerimento == 'A') {
                                                echo 'EM ANÁLISE';
                                              } elseif ($status_requerimento == 'D') {
                                                echo 'DEFERIDO';
                                              } else {
                                                echo 'INDEFERIDO';
                                              } ?></label>
                    </div>

                  </div>

                  <h5 class="modal-title">Outros</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Data de Inicio</label>
                      <input type="date" class="form-control mr-2" maxlength="10" id="saida" name="data_inicio_servico" value="<?php echo $data_inicio_servico; ?>" readonly />
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Hora de Inicio</label>
                      <input type="time" class="form-control mr-2" id="appt" name="hora_inicio_servico" min="07:00" max="16:00" value="<?php echo $hora_inicio_servico; ?>">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Data de Conclusão</label>
                      <input type="date" class="form-control mr-2" min="<?php echo $data_inicio_servico; ?>" maxlength="10" id="saida" name="data_conclusao_servico" value="<?php echo $data_inicio_servico; ?>" required />
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Hora de Conclusão</label>
                      <input type="time" class="form-control mr-2" id="appt" name="hora_conclusao_servico" min="07:00" max="18:00" required>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="fornecedor">Observações</label>
                      <textarea type="text" maxlength="355" class="form-control mr-2" name="observacoes" value="<?php echo $observacoes; ?>" style="text-transform:uppercase;"></textarea>
                    </div>

                  </div>


              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-success mb-3" name="finalizar">Finalizar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
                </form>
              </div>
            </div>
          </div>
        </div>


    <?php


        if (isset($_POST['finalizar'])) {

          $data_conclusao_servico = $_POST['data_conclusao_servico'];
          $hora_conclusao_servico = $_POST['hora_conclusao_servico'];
          $observacoes = mb_strtoupper($_POST['observacoes']);
          $status_ordem_servico = '3';

          //trazendo info do serviços
          $query_s = "SELECT * from servico_requerido where id_requerimento = '$id_requerimento' ";
          $result_s = mysqli_query($conexao, $query_s);
          $row_s = mysqli_fetch_array($result_s);
          $sevico = $row_s['id_servico_requerido'];


          // insert requerimento
          $query = "UPDATE ordem_servico set data_inicio_servico = '$data_inicio_servico', hora_inicio_servico = '$hora_inicio_servico', observacoes = '$observacoes', status_ordem_servico = '$status_ordem_servico' where id_ordem_servico = '$id'";

          $result = mysqli_query($conexao, $query);

          if ($sevico == '07') {

            $mensagem = 'O requerimento Nº ' . $id_requerimento . ' requer sua atenção!';

            $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
            mysqli_query($conexao, $query_mensagem);
          }

          if ($sevico == '16') {

            $mensagem = 'O requerimento Nº ' . $id_requerimento . ' requer sua atenção!';

            $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
            mysqli_query($conexao, $query_mensagem);
          }

          if ($sevico == '12') {

            $mensagem = 'O requerimento Nº ' . $id_requerimento . ' requer sua atenção!';

            $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
            mysqli_query($conexao, $query_mensagem);
          }

          if ($sevico == '13') {

            $mensagem = 'O requerimento Nº ' . $id_requerimento . ' requer sua atenção!';

            $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
            mysqli_query($conexao, $query_mensagem);
          }

          if ($sevico == '11') {

            $mensagem = 'O requerimento Nº ' . $id_requerimento . ' requer sua atenção!';

            $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
            mysqli_query($conexao, $query_mensagem);
          }



          if ($result == '') {
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao Iniciar!'); </script>";
          } else {

            echo "<script language='javascript'>window.alert('Finalizado com Sucesso!'); </script>";
            echo "<script language='javascript'>window.location='operacional.php?acao=os'; </script>";
          }
        }
      }
    }

    ?>






    <!--VISUALIZAR OS -->
    <?php
    if (@$_GET['func'] == 'ver') {
      $id = $_GET['id'];

      $query_cri = "select * from ordem_servico where id_ordem_servico = '$id' ";
      $result_cri = mysqli_query($conexao, $query_cri);

      while ($res = mysqli_fetch_array($result_cri)) {
        $id_requerimento = $res['id_requerimento'];
        $data_inicio_servico = $res['data_inicio_servico'];
        $hora_inicio_servico = $res['hora_inicio_servico'];
        $data_conclusao_servico = $res['data_conclusao_servico'];
        $hora_conclusao_servico = $res['hora_conclusao_servico'];
        $observacoes = $res['observacoes'];
        $status_ordem_servico = $res['status_ordem_servico'];

        //trazendo info do requerimento
        $query_rq = "SELECT * from requerimento where id_requerimento = '$id_requerimento' ";
        $result_rq = mysqli_query($conexao, $query_rq);
        $row_rq = mysqli_fetch_array($result_rq);
        $nome_razao_social = $row_rq['nome_razao_social'];
        $id_unidade_consumidora = $row_rq['id_unidade_consumidora'];
        $numero_cpf_cnpj = $row_rq['numero_cpf_cnpj'];
        $fone_movel = $row_rq['fone_movel'];
        $data_requerimento = $row_rq['data_requerimento'];
        $status_requerimento = $row_rq['status_requerimento'];

        $data2 = implode('/', array_reverse(explode('-', $data_requerimento)));


        //trazendo info endereco_instalacao
        $query_e = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id_unidade_consumidora' ";
        $result_e = mysqli_query($conexao, $query_e);
        $row_e = mysqli_fetch_array($result_e);
        $id_localidade = $row_e['id_localidade'];
        $id_bairro = $row_e['id_bairro'];
        $id_logradouro = $row_e['id_logradouro'];
        $numero_logradouro = $row_e['numero_logradouro'];
        $complemento_logradouro = $row_e['complemento_logradouro'];

        //consulta para recuperação do nome da localidade
        $query_loc = "select * from localidade where id_localidade = '$id_localidade' ";
        $result_loc = mysqli_query($conexao, $query_loc);
        $row_loc = mysqli_fetch_array($result_loc);
        //vai para a modal
        $nome_loc = $row_loc['nome_localidade'];

        //consulta para recuperação do nome do bairro
        $query_ba = "select * from bairro where id_bairro = '$id_bairro' ";
        $result_ba = mysqli_query($conexao, $query_ba);
        $row_ba = mysqli_fetch_array($result_ba);
        //vai para a modal
        $nome_ba = $row_ba['nome_bairro'];

        //consulta para recuperação do nome do logradouro
        $query_log = "select * from logradouro where id_logradouro = '$id_logradouro' AND id_bairro = '$id_bairro' ";
        $result_log = mysqli_query($conexao, $query_log);
        $row_log = mysqli_fetch_array($result_log);
        //vai para a modal
        $nome_log = $row_log['nome_logradouro'];
        $id_tipo_logradouro = $row_log['tipo_logradouro'];

        //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
        $query_u = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
        $result_u = mysqli_query($conexao, $query_u);
        $row_u = mysqli_fetch_array($result_u);
        $abreviatura_tipo_logradouro = $row_u['abreviatura_tipo_logradouro'];


    ?>

        <!-- MODAL VISUALIZAR OS -->

        <div id="modalVer" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h3 class="modal-title">Ordem de Serviço</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <h5 class="modal-title">Dados</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº OS</label>
                      <input type="text" class="form-control mr-2" name="id_ordem_servico" value="<?php echo $id; ?>" readonly>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº req</label>
                      <input type="text" class="form-control mr-2" name="id_requerimento" value="<?php echo $id_requerimento; ?>" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">UC</label>
                      <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id_unidade_consumidora ?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">CPF/CNPJ</label>
                      <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" value="<?php echo $numero_cpf_cnpj ?>" readonly>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto">Nome/Razão Social</label>
                      <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Celular</label>
                      <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" readonly>
                    </div>

                  </div>

                  <h5 class="modal-title">Endereçamento</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="id_produto">Localidade</label>
                      <input type="text" class="form-control mr-2" name="nome_loc" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $nome_loc ?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">Bairro</label>
                      <input type="text" class="form-control mr-2" name="nome_ba" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $nome_ba ?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">Logradouro</label>
                      <input type="text" class="form-control mr-2" name="nome_ba" title="Esse campo só pode ser alterado via requerimento" style="text-transform:uppercase;" value="<?php echo $abreviatura_tipo_logradouro ?> <?php echo $nome_log ?>" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Nº Logradouro</label>
                      <input type="text" class="form-control mr-2" name="numero_logradouro" placeholder="Nº" style="text-transform:uppercase;" value="<?php echo $numero_logradouro ?>" readonly>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto">Complemento</label>
                      <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;" value="<?php echo $complemento_logradouro ?>" readonly>
                    </div>

                  </div>

                  <h5 class="modal-title">Serviços Requeridos</h5>
                  <hr>
                  <div class="row">

                    <!--INICIO DA TABELA -->
                    <div class="table-responsive ml-3 mr-3">

                      <!--LISTAR TODOS OS SERVIÇOS -->
                      <?php

                      $query = "select * from servico_requerido where id_requerimento = '$id_requerimento' order by id_servico_requerido asc";

                      //execução da primeira consulta
                      $result = mysqli_query($conexao, $query);

                      $linha = mysqli_num_rows($result);

                      if ($linha == '') {
                        echo "<p> Não há serviços cadastrados para este requerimento!!! </p>";
                      } else {

                      ?>

                        <!--- table-sm= small = menor-->
                        <table class="table table-sm">
                          <thead class="text-secondary">

                            <th>
                              Serviço
                            </th>

                          </thead>
                          <tbody>

                            <?php
                            $status_execucao = 'O';
                            while ($res = mysqli_fetch_array($result)) {
                              $id_servico_requerido = $res["id_servico_requerido"];

                              //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                              $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' AND status_execucao = '$status_execucao' ";
                              $result_sv = mysqli_query($conexao, $query_sv);
                              $row_sv = mysqli_fetch_array($result_sv);
                              $descricao_servico = $row_sv['descricao_servico'];
                              $valor_servico = $row_sv['valor_servico'];

                            ?>

                              <tr>

                                <td><?php echo $descricao_servico; ?></td>

                              </tr>

                            <?php } ?>

                          </tbody>
                          <tfoot>
                            <tr>

                              <td></td>

                            </tr>

                          </tfoot>
                        </table>

                      <?php
                      }

                      ?>

                    </div>


                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Data do Req.: </b></label>
                      <label for="id_produto"><?php echo $data2 ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Status do Req.: </b></label>
                      <label for="id_produto"><?php if ($status_requerimento == 'A') {
                                                echo 'EM ANÁLISE';
                                              } elseif ($status_requerimento == 'D') {
                                                echo 'DEFERIDO';
                                              } else {
                                                echo 'INDEFERIDO';
                                              } ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Status da OS: </b></label>
                      <label for="id_produto"><?php if ($status_ordem_servico == '1') {
                                                echo 'EM ANÁLISE';
                                              } elseif ($status_ordem_servico == '2') {
                                                echo 'EM ANDAMENTO';
                                              } elseif ($status_ordem_servico == '3') {
                                                echo 'CONCLUÍDO';
                                              } else {
                                                echo 'INVIÁVEL';
                                              } ?></label>
                    </div>

                  </div>

                  <h5 class="modal-title">Outros</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Data de Inicio</label>
                      <input type="date" class="form-control mr-2" maxlength="10" id="saida" name="data_inicio_servico" value="<?php echo $data_inicio_servico; ?>" readonly />
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Hora de Inicio</label>
                      <input type="time" class="form-control mr-2" id="appt" name="hora_inicio_servico" min="07:00" max="16:00" value="<?php echo $hora_inicio_servico; ?>" readonly>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Data de Conclusão</label>
                      <input type="date" class="form-control mr-2" maxlength="10" id="saida" name="data_conclusao_servico" value="<?php echo $data_conclusao_servico; ?>" readonly />
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fornecedor">Hora de Conclusão</label>
                      <input type="time" class="form-control mr-2" id="appt" name="hora_conclusao_servico" min="07:00" max="16:00" value="<?php echo $hora_conclusao_servico; ?>" readonly>
                    </div>

                    <div class="form-group col-md-9">
                      <label for="fornecedor">Observações</label>
                      <input type="text" maxlength="255" class="form-control mr-2" name="observacoes" placeholder="Observações" style="text-transform:uppercase;" value="<?php echo $observacoes; ?>" readonly>
                    </div>

                  </div>


              </div>

              <div class="modal-footer">
                <div style="margin-top: -16px;">
                  <a class="btn btn-info" target="_blank" href="rel_os.php?func=imprime&id=<?php echo $id; ?>">Imprimir</a>
                </div>

                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Saír </button>
                </form>
              </div>
            </div>
          </div>
        </div>


    <?php


        if (isset($_POST['iniciar'])) {

          $data_inicio_servico = $_POST['data_inicio_servico'];
          $hora_inicio_servico = $_POST['hora_inicio_servico'];
          $observacoes = mb_strtoupper($_POST['observacoes']);
          $id_equipe_executora = '01';
          $status_ordem_servico = '2';
          $status_requerimento = 'D';



          // insert requerimento
          $query = "UPDATE ordem_servico set data_inicio_servico = '$data_inicio_servico', hora_inicio_servico = '$hora_inicio_servico', observacoes = '$observacoes', id_equipe_executora = '$id_equipe_executora', status_ordem_servico = '$status_ordem_servico' where id_ordem_servico = '$id'";

          $result = mysqli_query($conexao, $query);


          if ($result == '') {
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao Iniciar!'); </script>";
          } else {

            $query_status = "UPDATE requerimento set status_requerimento = '$status_requerimento' where id_requerimento = '$id_requerimento'";

            mysqli_query($conexao, $query_status);

            echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
            echo "<script language='javascript'>window.location='admin.php?acao=os'; </script>";
          }
        }
      }
    }

    ?>








    <script>
      $("#modalIniciar").modal("show");
    </script>
    <script>
      $("#modalFinalizar").modal("show");
    </script>
    <script>
      $("#modalVer").modal("show");
    </script>



    <!--MASCARAS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


    <script type="text/javascript">
      $(document).ready(function() {
        $('#cell').mask('(00) 00000-0000');
        $('#fone').mask('(00) 0000-0000');
        $('#cpf').mask('000.000.000-00');

      });
    </script>


    <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>
      $("input[id*='numero_cpf_cnpj']").inputmask({
        mask: ['999.999.999-99', '99.999.999/9999-99'],
        keepStatic: true
      });
    </script>
    <script>
      $("label[id*='numero_cpf_cnpj']").inputmask({
        mask: ['999.999.999-99', '99.999.999/9999-99'],
        keepStatic: true
      });
    </script>
    <script>
      $("td[id*='numero_cpf_cnpj']").inputmask({
        mask: ['999.999.999-99', '99.999.999/9999-99'],
        keepStatic: true
      });
    </script>
    <script>
      $("label[id*='cel']").inputmask({
        mask: ['(99) 99999-9999'],
        keepStatic: true
      });
    </script>
    <script>
      $("input[id*='cel']").inputmask({
        mask: ['(99) 99999-9999'],
        keepStatic: true
      });
    </script>
    <script>
      $("input[id*='fone']").inputmask({
        mask: ['(99) 9999-9999'],
        keepStatic: true
      });
    </script>
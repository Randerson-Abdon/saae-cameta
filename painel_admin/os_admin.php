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
      <h3>CONTROLE DE PEDIDOS DE SERVIÇOS ADMINISTRATIVOS</h3>
    </div>
    <div class="pesquisar col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarServico" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
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
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarServico'] != '') {

                $numero_req = '%' . $_GET['txtpesquisarServico'] . '%';

                $query = "SELECT * from ordem_servico where id_requerimento LIKE '$numero_req' AND id_servico_requerido =  order by id_requerimento asc ";

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
                      $query_u = "SELECT * from requerimento_servico where id_requerimento = '$id_requerimento' ";
                      $result_u = mysqli_query($conexao, $query_u);
                      $row_u = mysqli_fetch_array($result_u);
                      $nome_razao_social = $row_u['nome_razao_social'];
                      $data_requerimento = $row_u['data_requerimento'];

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
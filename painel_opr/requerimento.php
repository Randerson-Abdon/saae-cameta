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
      <h3>REQUERIMENTOS</h3>
    </div>
    <div class="pesquisar col-lg-4 col-md-6 col-sm-12">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarRequerimento" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
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
              if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarRequerimento'] != '') {


                $nome = '%' . $_GET['txtpesquisarRequerimento'] . '%';
                $numero_cpf_cnpj = $_GET['txtpesquisarRequerimento'];
                $query = "SELECT * from requerimento where nome_razao_social LIKE '$nome' OR numero_cpf_cnpj LIKE '$numero_cpf_cnpj' AND status_requerimento != 'C' order by id_requerimento asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from requerimento where status_requerimento != 'C' order by id_requerimento desc limit 10";

                $query_count = "SELECT * from requerimento";
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
                        Legenda: &nbsp;<i class="fas fa-square text-success" title="Deferido"></i> = Deferido
                        &nbsp;&nbsp;<i class="fas fa-square text-warning" title="Em Análise"></i> = Em Análise
                        &nbsp;&nbsp;<i class="fas fa-square text-danger" title="Indeferido"></i> = Indeferido
                      </li>
                    </ul>
                    <th class="text-danger">
                      Nº
                    </th>
                    <th>
                      UC
                    </th>
                    <th>
                      Nome/Razão Social
                    </th>
                    <th>
                      CPF/CNPJ
                    </th>
                    <th>
                      Status
                    </th>
                    <th>
                      Data
                    </th>

                    <th>
                      Ações
                    </th>
                  </thead>
                  <tbody>

                    <?php
                    while ($res = mysqli_fetch_array($result)) {
                      $id = $res["id_requerimento"];
                      $uc_existe = $res["existe_unidade_consumidora"];
                      $id_unidade_consumidora = $res["id_unidade_consumidora"];
                      $nome_razao_social = $res["nome_razao_social"];
                      $tipo_juridico = $res["tipo_juridico"];
                      $numero_cpf_cnpj = $res["numero_cpf_cnpj"];
                      $numero_rg = $res["numero_rg"];
                      $orgao_emissor_rg = $res["orgao_emissor_rg"];
                      $uf_rg = $res["uf_rg"];
                      $fone_fixo = $res["fone_fixo"];
                      $fone_movel = $res["fone_movel"];
                      $fone_movel_zap = $res["fone_movel_zap"];
                      $email = $res["email"];
                      $id_localidade = $res["id_localidade"];
                      $status_requerimento = $res["status_requerimento"];
                      $data_requerimento = $res["data_requerimento"];
                      $observacoes = $res["observacoes"];

                      $data2 = implode('/', array_reverse(explode('-', $data_requerimento)));

                    ?>

                      <tr>

                        <td><?php echo $id; ?></td>
                        <td><?php echo $id_unidade_consumidora; ?></td>
                        <td><?php echo $nome_razao_social; ?></td>
                        <td id="numero_cpf_cnpj"><?php echo $numero_cpf_cnpj; ?></td>


                        <!--condições para status em cores-->
                        <td align="center">

                          <?php if ($status_requerimento == 'I') { ?>
                            <i class="fas fa-square text-danger" title="Indeferido"></i>
                          <?php } ?>

                          <?php if ($status_requerimento == 'A') { ?>
                            <i class="fas fa-square text-warning" title="Em Análise"></i>
                          <?php } ?>

                          <?php if ($status_requerimento == 'D') { ?>
                            <i class="fas fa-square text-success" title="Deferido"></i>
                          <?php } ?>

                        </td>

                        <td><?php echo $data2; ?></td>

                        <td>
                          <a class="btn btn-info btn-sm" title="Ver Requerimento" href="operacional.php?acao=requerimento&func=req&id=<?php echo $id; ?>"><i class="fas fa-clipboard-list"></i></a>

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




    <!-- EXIBIÇÃO REQUERIMENTO -->
    <?php
    if (@$_GET['func'] == 'req') {
      $id = $_GET['id'];

      $query_req = "select * from requerimento where id_requerimento = '$id' ";
      $result_req = mysqli_query($conexao, $query_req);

      while ($res = mysqli_fetch_array($result_req)) {
        $id_requerimento = $res['id_requerimento'];
        $existe_unidade_consumidora = $res['existe_unidade_consumidora'];
        $id_unidade_consumidora = $res['id_unidade_consumidora'];
        $tipo_juridico = $res['tipo_juridico'];
        $numero_cpf_cnpj = $res['numero_cpf_cnpj'];
        $nome_razao_social = $res['nome_razao_social'];
        $numero_rg = $res['numero_rg'];
        $orgao_emissor_rg = $res['orgao_emissor_rg'];
        $uf_rg = $res['uf_rg'];

        $fone_fixo = $res['fone_fixo'];
        $fone_movel = $res['fone_movel'];
        $fone_movel_zap = $res['fone_movel_zap'];
        $email = $res['email'];

        $observacoes = $res['observacoes'];
        $status_requerimento = $res['status_requerimento'];
        $data_requerimento = $res['data_requerimento'];

        $data_requerimento2 = implode('/', array_reverse(explode('-', $data_requerimento)));

        //RECUPERAÇÃO DE ENDEREÇAMENTO
        //trazendo nome de bairro que esta relacionado com o id , semelhante ao INNER JOIN
        $query_end = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id_unidade_consumidora' ";
        $result_end = mysqli_query($conexao, $query_end);
        $row_end = mysqli_fetch_array($result_end);
        $id_localidade = $row_end["id_localidade"];
        $id_bairro = $row_end["id_bairro"];
        $id_logradouro = $row_end["id_logradouro"];
        $numero_logradouro = $row_end["numero_logradouro"];
        $complemento_logradouro = $row_end["complemento_logradouro"];

        //trazendo info localidade
        $query_lo = "SELECT * from localidade where id_localidade = '$id_localidade' ";
        $result_lo = mysqli_query($conexao, $query_lo);
        $row_lo = mysqli_fetch_array($result_lo);
        $nome_localidade = $row_lo["nome_localidade"];

        //trazendo info bairro
        $query_ba = "SELECT * from bairro where id_bairro = '$id_bairro' ";
        $result_ba = mysqli_query($conexao, $query_ba);
        $row_ba = mysqli_fetch_array($result_ba);
        $nome_bairro = $row_ba["nome_bairro"];

        //trazendo info logradouro
        $query_log = "SELECT * from logradouro where id_logradouro = '$id_logradouro' ";
        $result_log = mysqli_query($conexao, $query_log);
        $row_log = mysqli_fetch_array($result_log);
        $nome_logradouro = $row_log["nome_logradouro"];

        //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
        $query_tp = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
        $result_tp = mysqli_query($conexao, $query_tp);
        $row_tp = mysqli_fetch_array($result_tp);
        $tipo = $row_tp['abreviatura_tipo_logradouro'];


    ?>

        <!-- MODAL REQUERIMENTO -->

        <?php

        //consulta para numeração automatica OS
        $query_num_os = "select * from ordem_servico order by id_ordem_servico desc ";
        $result_num_os = mysqli_query($conexao, $query_num_os);
        $res_num_os = mysqli_fetch_array($result_num_os);
        $ultimo_os = $res_num_os["id_ordem_servico"];
        $ultimo_os = $ultimo_os + 1;

        ?>

        <div id="modalReq" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h3 class="modal-title">Requerimento</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form method="POST" action="">

                  <h5 class="modal-title">Dados Pessoais</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-2">
                      <label for="id_produto"><b>Nº Req: </b></label>
                      <label for="id_produto"><?php echo $id_requerimento ?></label>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto"><b><?php if ($existe_unidade_consumidora == 'N') {
                                                    echo 'UC Provisória';
                                                  } else {
                                                    echo 'UC';
                                                  } ?>: </b></label>
                      <label for="id_produto"><?php echo $id_unidade_consumidora ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Tipo Jurídico: </b></label>
                      <label for="id_produto"><?php if ($tipo_juridico == 'F') {
                                                echo 'Pessoa Física';
                                              } else {
                                                echo 'Pessoa Juridica';
                                              } ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>CPF/CNPJ: </b></label>
                      <label id="numero_cpf_cnpj" for="id_produto"><?php echo $numero_cpf_cnpj ?></label>
                    </div>

                    <div class="form-group col-md-5">
                      <label for="id_produto"><b>Nome: </b></label>
                      <label for="id_produto"><?php echo $nome_razao_social ?></label>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto"><b>RG: </b></label>
                      <label for="id_produto"><?php echo $numero_rg ?></label>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto"><b>Orgão Emissor: </b></label>
                      <label for="id_produto"><?php echo $orgao_emissor_rg ?></label>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto"><b>UF RG: </b></label>
                      <label for="id_produto"><?php echo $uf_rg ?></label>
                    </div>

                  </div>

                  <h5 class="modal-title">Endereçamento</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Localidade: </b></label>
                      <label for="id_produto"><?php echo $nome_localidade ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Bairro: </b></label>
                      <label for="id_produto"><?php echo $nome_bairro ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Logradouro: </b></label>
                      <label for="id_produto"><?php echo $tipo; ?> <?php echo $nome_logradouro ?></label>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="id_produto"><b>Número: </b></label>
                      <label for="id_produto"><?php echo $numero_logradouro ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Complemento: </b></label>
                      <label for="id_produto"><?php echo $complemento_logradouro ?></label>
                    </div>

                  </div>

                  <h5 class="modal-title">Contato</h5>
                  <hr>
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Telefone Fixo: </b></label>
                      <label id="fone" for="id_produto"><?php echo $fone_fixo ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Celular: </b></label>
                      <label id="cel" for="id_produto"><?php echo $fone_movel ?></label>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto"><b>WhatsApp: </b></label>
                      <label for="id_produto"><?php if ($fone_movel_zap == 'S') {
                                                echo 'SIM';
                                              } else {
                                                echo 'Não';
                                              } ?></label>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>E-mail: </b></label>
                      <label for="id_produto"><?php echo $email ?></label>
                    </div>

                  </div>

                  <h5 class="modal-title">Serviços Requeridos</h5>
                  <hr>
                  <div class="row">


                    <!--INICIO DA TABELA -->
                    <div class="table-responsive ml-3 mr-3">

                      <!--LISTAR TODOS OS CURSOS -->
                      <?php

                      $query = "select * from servico_requerido where id_requerimento = '$id' order by id_servico_requerido asc";

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
                            <th>
                              Valor
                            </th>

                          </thead>
                          <tbody>

                            <?php
                            $soma = 0;
                            while ($res = mysqli_fetch_array($result)) {
                              $id_servico_requerido = $res["id_servico_requerido"];

                              //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                              $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' ";
                              $result_sv = mysqli_query($conexao, $query_sv);
                              $row_sv = mysqli_fetch_array($result_sv);
                              $descricao_servico = $row_sv['descricao_servico'];
                              $valor_servico = $row_sv['valor_servico'];

                              $soma = $soma + $row_sv['valor_servico'];

                              $soma2 = number_format($soma, 2, ",", ".");


                            ?>

                              <tr>


                                <td><?php echo $descricao_servico; ?></td>
                                <td><?php echo $valor_servico; ?></td>


                              </tr>

                            <?php } ?>


                          </tbody>
                          <tfoot>
                            <tr>

                              <td></td>

                              <td>
                                <span class="text-muted">Total: <?php echo $soma2 ?> </span>
                              </td>
                            </tr>

                          </tfoot>
                        </table>

                      <?php
                      }

                      ?>

                    </div>


                    <div class="form-group col-md-4">
                      <label for="id_produto"><b>Data do Requerimento: </b></label>
                      <label for="id_produto"><?php echo $data_requerimento2 ?></label>
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

                    <div class="form-group col-md-6">
                      <label for="id_produto"><b>Observações: </b></label>
                      <label for="id_produto"><?php echo $observacoes ?></label>
                    </div>

                  </div>

              </div>


              <div class="modal-footer">
                <div style="margin-top: -16px;">
                  <a class="btn btn-info" target="_blank" href="rel_req.php?func=imprime&id=<?php echo $id; ?>">Imprimir</a>
                </div>

                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
                </form>

              </div>
            </div>
          </div>
        </div>

    <?php

      }
    }

    ?>



    <script>
      $("#modalPerfil").modal("show");
    </script>
    <script>
      $("#modalCriar").modal("show");
    </script>
    <script>
      $("#modalServico").modal("show");
    </script>
    <script>
      $("#modalReq").modal("show");
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
      $("label[id*='fone']").inputmask({
        mask: ['(99) 9999-9999'],
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
<?php
@session_start(); # Deve ser a primeira linha do arquivo
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
      <h3>REQUERIMENTOS</h3>
    </div>
  </div>
  <div class="row">

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
                $numero_requerimento = $_GET['txtpesquisarRequerimento'];
                $query = "SELECT * from requerimento_servico where nome_razao_social LIKE '$nome' OR numero_cpf_cnpj = '$numero_cpf_cnpj' OR id_requerimento = '$numero_requerimento' and status_requerimento != 'C' order by id_requerimento asc ";

                $result_count = mysqli_query($conexao, $query);
              } else {
                $query = "SELECT * from requerimento_servico where status_requerimento != 'C' order by id_requerimento desc limit 10";

                $query_count = "SELECT * from requerimento_servico";
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
                      $mensagem = $res["mensagem"];

                      $data_requerimento = substr($data_requerimento, 0, 10);
                      $data2 = implode('/', array_reverse(explode('-', $data_requerimento)));

                    ?>

                      <tr>

                        <td class="text-danger"><?php echo $id; ?>

                          <?php if ($mensagem != '') { ?>

                            <!--visualização de mensagem do admin via modal-->
                            - <a class="btn btn-warning" title="Mensagem do Administrador" href="admin.php?acao=requerimento&func=mensagem&id=<?php echo $id; ?>"><i class="fas fa-sms"></i></a>

                          <?php } ?>

                        </td>

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
                          <a class="btn btn-info btn-sm" title="Ver Requerimento" href="admin.php?acao=requerimento&func=req&id=<?php echo $id; ?>"><i class="fas fa-clipboard-list"></i></a>

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


    <!-- MODAL PESQUISA -->

    <div id="modalExemplo" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <div class="row">

              <div class="form-group ml-3">
                <h3 class="modal-title">Requerimento</h3>
              </div>

            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">
              <h5 class="modal-title">Dados do Requerente</h5>

              <hr>
              <div class="row">

                <div class="form-group col-md-3">
                  <label for="fornecedor">Buscar Por...</label>
                  <select class="form-control mr-2" id="slBuscar" name="slBuscar" style="text-transform:uppercase;">

                    <option value="">selecione</option>
                    <option value="cpf">Tipo Jurídico</option>
                    <option value="nome">Nome</option>
                    <option value="uc">U. C.</option>
                    <option value="endereco">Endereço</option>

                  </select>
                </div>

                <!-- CONSULTA POR CPF OU CNPJ-->
                <div id="cpfcnpjd" name="cpfcnpjd" style="display: none;">
                  <div class="row">


                    <div class="form-group col-md-8">
                      <label for="id_produto">Informe seu CPF/CNPJ</label>
                      <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" style="text-transform:uppercase;">
                    </div>

                    <div class="form-group col-md-4">
                      <label for="id_produto">Buscar</label>
                      <button type="button" class="btn btn-success form-control mr-2" id="buscar"><i class="fas fa-search"></i></button>
                    </div>

                  </div>

                </div>
                <div class="form-group" id="dados" style="display: none;"></div>



                <!-- CONSULTA POR NOME-->
                <div id="nome" name="nome" style="display: none;">
                  <div class="row">

                    <div class="form-group col-md-8">
                      <label for="id_produto">Nome/Razão Social</label>
                      <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" style="text-transform:uppercase;">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Buscar</label>
                      <button type="button" class="btn btn-success form-control mr-2" id="buscar2"><i class="fas fa-search"></i></button>
                    </div>

                  </div>

                </div>
                <div class="form-group" id="dados2" style="display: none;"></div>



                <!-- CONSULTA POR UNIDADE CONSUMIDORA-->
                <div id="uc" name="uc" style="display: none;">
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="id_produto">UC</label>
                      <input type="text" class="form-control mr-3" minlength="2" name="id_unidade_consumidora" placeholder="UC" required>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Buscar</label>
                      <button type="button" class="btn btn-success form-control mr-2" id="buscar3"><i class="fas fa-search"></i></button>
                    </div>
                  </div>

                </div>
                <div class="form-group" id="dados3" style="display: none;"></div>

                <!-- CONSULTA POR ENDEREÇO-->
                <div id="endereco" name="endereco" style="display: none;">
                  <div class="row">

                    <div class="form-group col-md-8">
                      <label for="id_produto">Descrição</label>
                      <input type="text" class="form-control mr-2" name="enderecamento" placeholder="Endereçamento" style="text-transform:uppercase;">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="id_produto">Buscar</label>
                      <button type="button" class="btn btn-success form-control mr-2" id="buscar4"><i class="fas fa-search"></i></button>
                    </div>

                  </div>
                </div>
                <div class="form-group" id="dados4" style="display: none;"></div>


              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
            </form>
          </div>

          <script>
            $("#buscar").click(function() {
              $.ajax({
                url: "resultado.php ",
                type: "POST",
                data: ({
                  numero_cpf_cnpj: $("input[name='numero_cpf_cnpj']").val()
                }), //estamos enviando o valor do input
                success: function(resposta) {
                  $('#dados').html(resposta);
                }

              });
            });


            $("#buscar2").click(function() {
              $.ajax({
                url: "resultado2.php ",
                type: "POST",
                data: ({
                  nome_razao_social: $("input[name='nome_razao_social']").val()
                }), //estamos enviando o valor do input
                success: function(resposta) {
                  $('#dados2').html(resposta);
                }

              });
            });

            $("#buscar3").click(function() {
              $.ajax({
                url: "resultado3.php ",
                type: "POST",
                data: ({
                  id_unidade_consumidora: $("input[name='id_unidade_consumidora']").val()
                }), //estamos enviando o valor do input
                success: function(resposta) {
                  $('#dados3').html(resposta);
                }

              });
            });

            $("#buscar4").click(function() {
              $.ajax({
                url: "resultado4.php ",
                type: "POST",
                data: ({
                  enderecamento: $("input[name='enderecamento']").val()
                }), //estamos enviando o valor do input
                success: function(resposta) {
                  $('#dados4').html(resposta);
                }

              });
            });
          </script>
        </div>
      </div>
    </div>
  </div>




  <!-- EXIBIÇÃO REQUERIMENTO -->
  <?php
  if (@$_GET['func'] == 'req') {
    $id = $_GET['id'];

    $query_req = "select * from requerimento_servico where id_requerimento = '$id' ";
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

      $data_requerimento = substr($data_requerimento, 0, 10);
      $data_requerimento2 = implode('/', array_reverse(explode('-', $data_requerimento)));

      //RECUPERAÇÃO DE ENDEREÇAMENTO
      //trazendo nome de bairro que esta relacionado com o id , semelhante ao INNER JOIN
      $query_end = "SELECT * from enderecamento_instalacao where id_unidade_consumidora = '$id_unidade_consumidora' ";
      $result_end = mysqli_query($conexao, $query_end);
      $row_end = mysqli_fetch_array($result_end);
      $id_localidade = $row_end["id_localidade"];
      $id_bairro = $row_end["id_bairro"];
      $id_logradouro = $row_end["id_logradouro"];
      $numero_logradouro = $row_end["numero_logradouro"];
      $complemento_logradouro = $row_end["complemento_logradouro"];

      //trazendo info localidade
      $query_lo = "SELECT * from enderecamento_localidade where id_localidade = '$id_localidade' ";
      $result_lo = mysqli_query($conexao, $query_lo);
      $row_lo = mysqli_fetch_array($result_lo);
      $nome_localidade = $row_lo["nome_localidade"];

      //trazendo info bairro
      $query_ba = "SELECT * from enderecamento_bairro where id_bairro = '$id_bairro' ";
      $result_ba = mysqli_query($conexao, $query_ba);
      $row_ba = mysqli_fetch_array($result_ba);
      $nome_bairro = $row_ba["nome_bairro"];

      //trazendo info logradouro
      $query_log = "SELECT * from enderecamento_logradouro where id_logradouro = '$id_logradouro' AND id_bairro = '$id_bairro' ";
      $result_log = mysqli_query($conexao, $query_log);
      $row_log = mysqli_fetch_array($result_log);
      $nome_logradouro = $row_log["nome_logradouro"];
      $id_tipo_logradouro = $row_log["tipo_logradouro"];

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

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b><?php if ($existe_unidade_consumidora == 'N') {
                                                  echo 'UC Provisória';
                                                } else {
                                                  echo 'UC';
                                                } ?>: </b></label>
                    <label for="id_produto"><?php echo $id_unidade_consumidora ?></label>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b>Tipo Jurídico: </b></label>
                    <label for="id_produto"><?php if ($tipo_juridico == 'F') {
                                              echo 'Física';
                                            } else {
                                              echo 'Juridica';
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

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b>Bairro: </b></label>
                    <label for="id_produto"><?php echo $nome_bairro ?></label>
                  </div>

                  <div class="form-group col-md-5">
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


      if (isset($_POST['gerar'])) {

        $id_requerimento2 = $id;
        $id_ordem_servico = $ultimo_os;

        //trazendo info unidade_consumidora
        $query_ucon = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id_unidade_consumidora' ";
        $result_ucon = mysqli_query($conexao, $query_ucon);
        $row_ucon = mysqli_fetch_array($result_ucon);
        $status_ligacao = $row_ucon["status_ligacao"];


        // insert requerimento
        $query_r2 = "INSERT INTO ordem_servico (id_requerimento, id_ordem_servico) values ('$id_requerimento2', '$id_ordem_servico')";

        $result_r2 = mysqli_query($conexao, $query_r2);


        if ($result_r2 == '') {
          echo "<script language='javascript'>window.alert('Ocorreu um erro ao gerar!'); </script>";
        } else {

          echo "<script language='javascript'>window.alert('Gerado com Sucesso!'); </script>";
          echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
        }
      }
    }
  }

  ?>





  <!-- EXIBIÇÃO PERFIL -->
  <?php
  if (@$_GET['func'] == 'perfil') {
    $id = $_GET['id'];

    $query = "select * from unidade_consumidora where id_unidade_consumidora = '$id' ";
    $result = mysqli_query($conexao, $query);

    while ($res = mysqli_fetch_array($result)) {
      $id_unidade_consumidora = $res['id_unidade_consumidora'];
      $tipo_juridico = $res['tipo_juridico'];
      $numero_cpf_cnpj = $res['numero_cpf_cnpj'];
      $nome_razao_social = $res['nome_razao_social'];
      $numero_rg = $res['numero_rg'];
      $orgao_emissor_rg = $res['orgao_emissor_rg'];
      $uf_rg = $res['uf_rg'];
      $fone_fixo = $res['fone_fixo'];
      $fone_movel = $res['fone_movel'];
      $fone_zap = $res['fone_zap'];
      $email = $res['email'];
      $classificacao_consumo = $res['classificacao_consumo'];
      $faixa_consumo = $res['faixa_consumo'];
      $tipo_medicao = $res['tipo_medicao'];
      $id_unidade_hidrometrica = $res['id_unidade_hidrometrica'];
      $tipo_enderecamento = $res['tipo_enderecamento'];
      $status_ligacao = $res["status_ligacao"];
      $observacoes = $res["observacoes"];
      $data_cadastro = $res["data_cadastro"];


      //RECUPERAÇÃO DE ENDEREÇAMENTO
      //trazendo nome de bairro que esta relacionado com o id , semelhante ao INNER JOIN
      $query_en = "SELECT * from enderecamento_instalacao where id_unidade_consumidora = '$id' ";
      $result_en = mysqli_query($conexao, $query_en);
      $row_en = mysqli_fetch_array($result_en);
      $id_localidade = $row_en["id_localidade"];
      $id_bairro = $row_en["id_bairro"];
      $id_logradouro = $row_en["id_logradouro"];
      $numero_logradouro = $row_en["numero_logradouro"];
      $complemento_logradouro = $row_en["complemento_logradouro"];

      //trazendo info localidade
      $query_lo = "SELECT * from enderecamento_localidade where id_localidade = '$id_localidade' ";
      $result_lo = mysqli_query($conexao, $query_lo);
      $row_lo = mysqli_fetch_array($result_lo);
      $nome_localidade = $row_lo["nome_localidade"];

      //trazendo info bairro
      $query_ba = "SELECT * from enderecamento_bairro where id_bairro = '$id_bairro' ";
      $result_ba = mysqli_query($conexao, $query_ba);
      $row_ba = mysqli_fetch_array($result_ba);
      $nome_bairro = $row_ba["nome_bairro"];

      //trazendo info logradouro
      $query_log = "SELECT * from enderecamento_logradouro where id_logradouro = '$id_logradouro' ";
      $result_log = mysqli_query($conexao, $query_log);
      $row_log = mysqli_fetch_array($result_log);
      $nome_logradouro = $row_log["nome_logradouro"];
      $id_tipo_logradouro = $row_log["id_tipo_logradouro"];

      //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
      $query_tp = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
      $result_tp = mysqli_query($conexao, $query_tp);
      $row_tp = mysqli_fetch_array($result_tp);
      $tipo = $row_tp['abreviatura_tipo_logradouro'];


  ?>

      <!-- MODAL PERFIL -->
      <div id="modalPerfil" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">

              <h3 class="modal-title">Perfil Consumidor</h3>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="POST" action="">

                <h5 class="modal-title">Dados Pessoais</h5>
                <hr>
                <div class="row">

                  <div id="uc" class="form-group col-md-2">
                    <label for="id_produto"><b>UC: </b></label>
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
                    <label for="id_produto"><b>Nome/Razão Social: </b></label>
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

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b>Bairro: </b></label>
                    <label for="id_produto"><?php echo $nome_bairro ?></label>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto"><b>Logradouro: </b></label>
                    <label for="id_produto"><?php echo $tipo ?> <?php echo $nome_logradouro ?></label>
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

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b>Celular: </b></label>
                    <label id="cel" for="id_produto"><?php echo $fone_movel ?></label>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b>WhatsApp: </b></label>
                    <label for="id_produto"><?php if ($fone_zap == 'S') {
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

                <h5 class="modal-title">Dados de Faturamento</h5>
                <hr>
                <div class="row">

                  <div class="form-group col-md-5">
                    <label for="id_produto"><b>Classificação de Consumo: </b></label>
                    <label for="id_produto"><?php if ($classificacao_consumo == '1') {
                                              echo 'RESIDENCIAL';
                                            } elseif ($classificacao_consumo == '2') {
                                              echo 'COMERCIAL';
                                            } elseif ($classificacao_consumo == '3') {
                                              echo 'INDUSTRIAL';
                                            } else {
                                              echo 'PÚBLICA';
                                            } ?></label>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto"><b>Faixa de Consumo: </b></label>
                    <label for="id_produto"><?php echo $faixa_consumo ?></label>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto"><b>Tipo de Medição: </b></label>
                    <label for="id_produto"><?php if ($tipo_medicao == 'E') {
                                              echo 'ESTIMADO';
                                            } else {
                                              echo 'MEDIDO';
                                            } ?></label>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto"><b>Unidade Hidrométrica: </b></label>
                    <label for="id_produto"><?php echo $id_unidade_hidrometrica ?></label>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto"><b>Status da Ligação: </b></label>
                    <label for="id_produto"><?php if ($status_ligacao == 'A') {
                                              echo 'ATIVO';
                                            } elseif ($status_ligacao == 'I') {
                                              echo 'INATIVO';
                                            } elseif ($status_ligacao == 'P') {
                                              echo 'PROVISÓRIO';
                                            } else {
                                              echo 'FACTÍVEL';
                                            } ?></label>
                  </div>

                  <div class="form-group col-md-8">
                    <label for="id_produto"><b>Observações: </b></label>
                    <label for="id_produto"><?php echo $observacoes ?></label>
                  </div>

                </div>


            </div>

            <div class="modal-footer">
              <div style="margin-top: -16px;">
                <a class="btn btn-info" target="_blank" href="rel_perfil.php?func=imprime&id=<?php echo $id; ?>">Imprimir</a>
              </div>
              <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
              </form>

            </div>
          </div>
        </div>
      </div>

  <?php }
  } ?>




  <!--REQUERIMENTO COM UC EXISTENTE -->
  <?php
  if (@$_GET['func'] == 'criar') {
    $id = $_GET['id'];

    $query_cri = "select * from unidade_consumidora where id_unidade_consumidora = '$id' ";
    $result_cri = mysqli_query($conexao, $query_cri);

    while ($res = mysqli_fetch_array($result_cri)) {

      $numero_cpf_cnpj = $res['numero_cpf_cnpj'];
      $nome_razao_social = $res['nome_razao_social'];
      $numero_rg = $res['numero_rg'];
      $orgao_emissor_rg = $res['orgao_emissor_rg'];
      $uf_rg = $res['uf_rg'];
      $fone_fixo = $res['fone_fixo'];
      $fone_movel = $res['fone_movel'];
      $fone_zap = $res['fone_zap'];
      $email = $res['email'];
      $tipo_juridico = $res['tipo_juridico'];


      //trazendo id_unidade_consumidora de unidade_consumidora que esta relacionado com o cpf/cnpj, semelhante ao INNER JOIN
      $query_e = "SELECT * from enderecamento_instalacao where id_unidade_consumidora = '$id' ";
      $result_e = mysqli_query($conexao, $query_e);
      $row_e = mysqli_fetch_array($result_e);
      $id_localidade = $row_e['id_localidade'];
      $id_bairro = $row_e['id_bairro'];
      $id_logradouro = $row_e['id_logradouro'];
      $numero_logradouro = $row_e['numero_logradouro'];
      $complemento_logradouro = $row_e['complemento_logradouro'];

      //consulta para recuperação do nome da localidade
      $query_loc = "select * from enderecamento_localidade where id_localidade = '$id_localidade' ";
      $result_loc = mysqli_query($conexao, $query_loc);
      $row_loc = mysqli_fetch_array($result_loc);
      //vai para a modal
      $nome_loc = $row_loc['nome_localidade'];

      //consulta para recuperação do nome do bairro
      $query_ba = "select * from enderecamento_bairro where id_bairro = '$id_bairro' ";
      $result_ba = mysqli_query($conexao, $query_ba);
      $row_ba = mysqli_fetch_array($result_ba);
      //vai para a modal
      $nome_ba = $row_ba['nome_bairro'];

      //consulta para recuperação do nome do logradouro
      $query_log = "select * from enderecamento_logradouro where id_logradouro = '$id_logradouro' ";
      $result_log = mysqli_query($conexao, $query_log);
      $row_log = mysqli_fetch_array($result_log);
      //vai para a modal
      $nome_log = $row_log['nome_logradouro'];
      $id_tipo_logradouro = $row_log['tipo_logradouro'];

      $id_tipo_logradouro = $row_log['id_tipo_logradouro'];
      //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
      $query_u = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
      $result_u = mysqli_query($conexao, $query_u);
      $row_u = mysqli_fetch_array($result_u);
      $abreviatura_tipo_logradouro = $row_u['abreviatura_tipo_logradouro'];


  ?>

      <!-- MODAL REQUERIMENTO COM UC EXISTENTE -->

      <?php

      //consulta para numeração automatica
      $query_num_req = "select * from requerimento_servico order by id_requerimento desc ";
      $result_num_req = mysqli_query($conexao, $query_num_req);
      $res_num_req = mysqli_fetch_array($result_num_req);
      $ultimo_req = $res_num_req["id_requerimento"];
      $ultimo_req = $ultimo_req + 1;


      ?>


      <div id="modalCriar" class="modal fade" role="dialog">
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
                    <label for="id_produto">Nº req</label>
                    <input type="text" class="form-control mr-2" name="id_requerimento" value="<?php echo $ultimo_req; ?>" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">UC</label>
                    <input type="text" class="form-control mr-2" name="id_unidade_consumidora" placeholder="UC" value="<?php echo $id ?>">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Tipo Jurídico</label>
                    <select class="form-control mr-2" id="category" name="tipo_juridico" style="text-transform:uppercase;">
                      <option value="" <?php if ($tipo_juridico == '') { ?> selected <?php } ?>>selecione</option>
                      <option value="J" <?php if ($tipo_juridico == 'J') { ?> selected <?php } ?>>Pessoa Jurídica</option>
                      <option value="P" <?php if ($tipo_juridico == 'P') { ?> selected <?php } ?>>Pessoa Física</option>

                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">Informe seu CPF/CNPJ</label>
                    <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" value="<?php echo $numero_cpf_cnpj ?>" required>
                  </div>

                  <div class="form-group col-md-8">
                    <label for="id_produto">Nome/Razão Social</label>
                    <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">RG</label>
                    <input type="text" class="form-control mr-2" name="numero_rg" placeholder="RG" id="rg" value="<?php echo $numero_rg ?>" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Orgão Emissor</label>
                    <input type="text" class="form-control mr-2" name="orgao_emissor_rg" placeholder="Orgão Emissor" style="text-transform:uppercase;" value="<?php echo $orgao_emissor_rg ?>" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">UF RG</label>
                    <select class="form-control mr-2" id="category" name="uf_rg" style="text-transform:uppercase;">

                      <option value="" <?php if ($uf_rg == '') { ?> selected <?php } ?>>SELECIONE</option>
                      <option value="MG" <?php if ($uf_rg == 'MG') { ?> selected <?php } ?>>MG</option>
                      <option value="SP" <?php if ($uf_rg == 'SP') { ?> selected <?php } ?>>SP</option>
                      <option value="PA" <?php if ($uf_rg == 'PA') { ?> selected <?php } ?>>PA</option>
                      <option value="AP" <?php if ($uf_rg == 'AP') { ?> selected <?php } ?>>AP</option>

                    </select>
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
                    <input type="text" class="form-control mr-2" name="numero_logradouro" placeholder="Nº" style="text-transform:uppercase;" value="<?php echo $numero_logradouro ?>" required>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto">Complemento</label>
                    <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;" value="<?php echo $complemento_logradouro ?>">
                  </div>

                </div>

                <h5 class="modal-title">Contato</h5>
                <hr>
                <div class="row">

                  <div class="form-group col-md-3">
                    <label for="id_produto">Telefone Fixo</label>
                    <input type="text" class="form-control mr-2" name="fone_fixo" placeholder="Telefone" id="fone" value="<?php echo $fone_fixo ?>" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Celular</label>
                    <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cell" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">WhatsApp</label>
                    <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;">

                      <option value="" <?php if ($fone_zap == '') { ?> selected <?php } ?>>SELECIONE</option>
                      <option value="S" <?php if ($fone_zap == 'S') { ?> selected <?php } ?>>SIM</option>
                      <option value="N" <?php if ($fone_zap == 'N') { ?> selected <?php } ?>>NÃO</option>

                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="id_produto">E-mail</label>
                    <input type="email" class="form-control mr-2" name="email" placeholder="E-mail" value="<?php echo $email ?>">
                  </div>

                </div>

                <h5 class="modal-title">Outros</h5>
                <hr>
                <div class="row">

                  <div class="form-group col-md-9">
                    <label for="fornecedor">Observações</label>
                    <input type="text" maxlength="255" class="form-control mr-2" name="observacoes" placeholder="Observações" style="text-transform:uppercase;">
                  </div>

                </div>


            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success mb-3" name="btn_editar">Salvar </button>


              <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
              </form>
            </div>
          </div>
        </div>
      </div>


  <?php


      if (isset($_POST['btn_editar'])) {
        $n_req = $ultimo_req;
        $uc = $id;
        $existe_unidade_consumidora = 'S';
        $tipo_juridico = mb_strtoupper($_POST['tipo_juridico']);
        $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
        $nome_razao_social = mb_strtoupper($_POST['nome_razao_social']);
        $numero_rg = mb_strtoupper($_POST['numero_rg']);
        $orgao_emissor_rg = mb_strtoupper($_POST['orgao_emissor_rg']);
        $uf_rg = mb_strtoupper($_POST['uf_rg']);

        $id_localidade = $row_e['id_localidade'];
        $id_bairro = $row_e['id_bairro'];
        $id_logradouro = $row_e['id_logradouro'];
        $numero_logradouro = mb_strtoupper($_POST['numero_logradouro']);
        $complemento_logradouro = mb_strtoupper($_POST['complemento_logradouro']);
        $fone_fixo = mb_strtoupper($_POST['fone_fixo']);
        $fone_movel = mb_strtoupper($_POST['fone_movel']);
        $fone_zap = mb_strtoupper($_POST['fone_zap']);
        $email = $_POST['email'];

        $observacoes = mb_strtoupper($_POST['observacoes']);

        //tratamento para numero_cpf_cnpj
        $ncc = str_replace("/", "", $numero_cpf_cnpj);
        $ncc2 = str_replace(".", "", $ncc);
        $ncc3 = str_replace("-", "", $ncc2);

        //tratamento para telefone
        $tel = preg_replace("/[^0-9]/", "", $fone_fixo);

        //tratamento para celular
        $cel = preg_replace("/[^0-9]/", "", $fone_movel);


        // insert requerimento
        $query2 = "INSERT INTO requerimento_servico (id_localidade, id_requerimento, existe_unidade_consumidora, id_unidade_consumidora, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, fone_fixo, fone_movel, fone_movel_zap, email, observacoes) values ('$id_localidade', '$n_req', '$existe_unidade_consumidora', '$uc', '$tipo_juridico', '$ncc3', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$tel', '$cel', '$fone_zap', '$email', '$observacoes')";

        $result2 = mysqli_query($conexao, $query2);


        if ($result2 == '') {
          echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
        } else {

          $query_status = "UPDATE unidade_consumidora set tipo_juridico = '$tipo_juridico', numero_cpf_cnpj = '$ncc3', nome_razao_social = '$nome_razao_social', numero_rg = '$numero_rg', orgao_emissor_rg = '$orgao_emissor_rg', uf_rg = '$uf_rg', fone_fixo = '$tel', fone_movel = '$cel', fone_zap = '$fone_zap', email = '$email' where id_unidade_consumidora = '$uc'";

          mysqli_query($conexao, $query_status);

          echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
          echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
        }
      }
    }
  }

  ?>





  <!-- MODAL CADASTRO NOVO -->

  <?php

  //consulta para numeração automatica
  $query_num_cad = "select * from unidade_consumidora order by id_unidade_consumidora desc ";
  $result_num_cad = mysqli_query($conexao, $query_num_cad);

  $res_num_cad = mysqli_fetch_array($result_num_cad);
  $ultimo_cad = $res_num_cad["id_unidade_consumidora"];
  $ultimo_cad = $ultimo_cad + 1;

  //consulta para numeração automatica
  $query_num_req = "select * from requerimento_servico order by id_requerimento desc ";
  $result_num_req = mysqli_query($conexao, $query_num_req);

  $res_num_req = mysqli_fetch_array($result_num_req);
  $ultimo_req = $res_num_req["id_requerimento"];
  $ultimo_req = $ultimo_req + 1;

  ?>


  <div id="modalNovo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h3 class="modal-title">Novo Consumidor</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">
            <div class="row">
              <div class="form-group col-md-2">
                <label for="id_produto">Nº Rec.</label>
                <input type="number" class="form-control mr-2" name="id_requerimento" value="<?php echo $ultimo_req; ?>" readonly>
              </div>

              <div class="form-group col-md-2">
                <label for="id_produto">UC Provisória</label>
                <input type="number" class="form-control mr-2" name="id_requerimento" value="<?php echo $ultimo_cad; ?>" readonly>
              </div>
            </div>

            <h5 class="modal-title">Endereçamento</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-4">
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

              <div class="form-group col-md-4" id="atualiza"></div>

              <div class="form-group col-md-4" id="atualiza2"></div>

              <div class="form-group col-md-3">
                <label for="id_produto">Nº</label>
                <input type="text" class="form-control mr-2" name="numero_logradouro" placeholder="Número" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group col-md-5">
                <label for="id_produto">Complemento</label>
                <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-2">
                <label for="id_produto">Consultar</label>
                <button type="button" class="btn btn-success form-control mr-2" id="consultar"><i class="fas fa-search"></i></button>
              </div>

              <div class="form-group" id="dados5"></div>

            </div>

            <h5 class="modal-title">Dados Pessoais</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="fornecedor">Tipo Jurídico</label>
                <select class="form-control mr-2" id="category" name="tipo_juridico" style="text-transform:uppercase;" required>

                  <option value="P">Pessoa Física</option>
                  <option value="J">Pessoa Jurídica</option>

                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="id_produto">Informe seu CPF/CNPJ</label>
                <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" required>
              </div>

              <div class="form-group col-md-8">
                <label for="id_produto">Nome/Razão Social</label>
                <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">RG</label>
                <input type="text" class="form-control mr-2" name="numero_rg" placeholder="RG" id="rg" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Orgão Emissor</label>
                <input type="text" class="form-control mr-2" name="orgao_emissor_rg" placeholder="Orgão Emissor" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">UF RG</label>
                <select class="form-control mr-2" id="category" name="uf_rg" style="text-transform:uppercase;" required>

                  <option value="PA">PA</option>
                  <option value="MG">MG</option>
                  <option value="AP">AP</option>
                  <option value="MA">MA</option>

                </select>
              </div>

            </div>

            <h5 class="modal-title">Contato</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="id_produto">Telefone Fixo</label>
                <input type="text" class="form-control mr-2" name="fone_fixo" placeholder="Telefone" id="fone">
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Celular</label>
                <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel">
              </div>

              <div class="form-group col-md-2">
                <label for="fornecedor">WhatsApp</label>
                <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;">

                  <option value="N">Não</option>
                  <option value="S">Sim</option>

                </select>
              </div>

              <div class="form-group col-md-5">
                <label for="id_produto">E-mail</label>
                <input type="email" class="form-control mr-2" name="email" placeholder="E-mail">
              </div>

            </div>

            <h5 class="modal-title">Outros</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-9">
                <label for="fornecedor">Observações</label>
                <input type="text" maxlength="255" class="form-control mr-2" name="observacoes" placeholder="Observações" style="text-transform:uppercase;">
              </div>

            </div>


        </div>


        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="salvar">Salvar </button>

          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>

          </form>

          <script>
            $("#consultar").click(function() {
              $.ajax({
                url: "resultado5.php ",
                type: "POST",
                data: ({
                  id_logradouro: $("select[name='id_logradouro']").val(),
                  id_bairro: $("select[name='id_bairro']").val()
                }), //estamos enviando o valor do input
                success: function(resposta) {
                  $('#dados5').html(resposta);
                }

              });
            });
          </script>

        </div>

      </div>
    </div>
  </div>

  <!--CADASTRO -->

  <?php
  if (isset($_POST['salvar'])) {
    $numero_rec = $ultimo_req;
    $existe_unidade_consumidora = 'N';
    $id_unidade_consumidora = $ultimo_cad;
    $tipo_juridico = $_POST['tipo_juridico'];
    $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
    $nome_razao_social = mb_strtoupper($_POST['nome_razao_social']);
    $numero_rg = $_POST['numero_rg'];
    $orgao_emissor_rg = mb_strtoupper($_POST['orgao_emissor_rg']);
    $uf_rg = mb_strtoupper($_POST['uf_rg']);

    $id_localidade = mb_strtoupper($_POST['id_localidade']);
    $id_bairro = mb_strtoupper($_POST['id_bairro']);
    $id_logradouro = mb_strtoupper($_POST['id_logradouro']);
    $numero_logradouro = mb_strtoupper($_POST['numero_logradouro']);
    $complemento_logradouro = mb_strtoupper($_POST['complemento_logradouro']);

    $fone_fixo = mb_strtoupper($_POST['fone_fixo']);
    $fone_movel = mb_strtoupper($_POST['fone_movel']);
    $fone_zap = mb_strtoupper($_POST['fone_zap']);
    $email = $_POST['email'];
    $observacoes = mb_strtoupper($_POST['observacoes']);

    //tratamento para numero_cpf_cnpj
    $ncc = str_replace("/", "", $numero_cpf_cnpj);
    $ncc2 = str_replace(".", "", $ncc);
    $ncc3 = str_replace("-", "", $ncc2);

    //tratamento para telefone
    $tel = preg_replace("/[^0-9]/", "", $fone_fixo);

    //tratamento para celular
    $cel = preg_replace("/[^0-9]/", "", $fone_movel);


    $query = "INSERT INTO requerimento_servico (id_localidade, id_requerimento, existe_unidade_consumidora, id_unidade_consumidora, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, fone_fixo, fone_movel, fone_movel_zap, email, observacoes) values ('$id_localidade', '$numero_rec', '$existe_unidade_consumidora', '$id_unidade_consumidora', '$tipo_juridico', '$ncc3', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$tel', '$cel', '$fone_zap', '$email', '$observacoes')";

    $result = mysqli_query($conexao, $query);

    //INSERINDO NA TABELA DE unidade_consumidora
    if ($existe_unidade_consumidora == 'N') {

      $query_con = "INSERT INTO unidade_consumidora (id_unidade_consumidora, status_ligacao, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, id_localidade, fone_fixo, fone_movel, fone_zap, email) values ('$id_unidade_consumidora', 'P', '$tipo_juridico', '$numero_cpf_cnpj', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$id_localidade', '$tel', '$cel', '$fone_zap', '$email')";

      $result_con = mysqli_query($conexao, $query_con);
    }

    //INSERINDO NA TABELA DE endereçamento
    if ($existe_unidade_consumidora == 'N') {

      $query_end = "INSERT INTO enderecamento_instalacao (id_unidade_consumidora, id_localidade, id_bairro, id_logradouro, numero_logradouro, complemento_logradouro) values ('$id_unidade_consumidora', '$id_localidade', '$id_bairro', '$id_logradouro', '$numero_logradouro', '$complemento_logradouro')";

      $result_end = mysqli_query($conexao, $query_end);
    }


    if ($result == '') {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
    } else {
      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
    }
  }
  ?>





  <!--ADICIONANDO SERVIÇOS AO REQUERIMENTO--->
  <?php
  //se func for igual a servico recupere o id
  if (@$_GET['func'] == 'servico') {
    $id = $_GET['id'];

  ?>

    <!-- Modal serviço -->
    <div id="modalServico" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Adicionar Serviço</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">

              <div class="row">

                <div class="form-group col-md-3">
                  <label for="id_produto">Nº Requerimento</label>
                  <input type="number" class="form-control" name="num_aula" value="<?php echo $id; ?>" />
                </div>

                <div class="form-group col-md-6">
                  <label for="id_produto">Serviço</label>
                  <select class="form-control mr-2" id="category" name="id_servico">

                    <?php

                    //recuperando dados da tabela servico para o select
                    $query = "select * from servico_disponivel order by descricao_servico asc";
                    $result = mysqli_query($conexao, $query);
                    while ($res = mysqli_fetch_array($result)) {

                    ?>
                      <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
                      <option value="<?php echo $res['id_servico'] ?>"><?php echo $res['descricao_servico'] ?></option>

                    <?php
                    }
                    ?>

                  </select>
                </div>


                <div class="form-group col-md-2" style="margin-top: 30px;">
                  <label for="id_produto"></label>
                  <button type="submit" class="btn btn-info" name="salvar_sevico">Adicionar</button>
                </div>

            </form>


            <!--INICIO DA TABELA -->
            <div class="table-responsive ml-3 mr-3">

              <!--LISTAR TODOS OS CURSOS -->
              <?php

              $query = "select * from servico_requerido where id_requerimento = '$id' order by id_servico_requerido asc";

              //execução da primeira consulta
              $result = mysqli_query($conexao, $query);

              $linha = mysqli_num_rows($result);


              if ($linha == '') {
                echo "<p> Cadastre serviços para este requerimento!!! </p>";
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


                    <th>
                      Ações
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

                        <td>
                          <!--- botão com função dupla na modal, sem isso não fica na mesma tela-->
                          <a class="text-info" title="Editar" href="#"><i class="fas fa-edit"></i></a>

                          <a class="text-danger" title="Excluir" href="#"><i class="fa fa-minus-square"></i></a>

                        </td>
                      </tr>

                    <?php } ?>

                  </tbody>
                  <tfoot>
                    <tr>

                      <td></td>
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

            <!--fim da linha-->
          </div>

        </div>

      </div>
    </div>
</div>


<?php

    //salvando seviços do requerimento, se tiver post no botão salvar aula, recupera o nome e o link
    if (isset($_POST['salvar_sevico'])) {

      $id_servico_requerido = $_POST['id_servico'];
      $id_requerimento = $id;

      $query = "INSERT INTO servico_requerido (id_servico_requerido, id_requerimento) values ('$id_servico_requerido', '$id_requerimento')";
      $result = mysqli_query($conexao, $query);

      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
      } else {
        echo "<script language='javascript'>window.location='admin.php?acao=requerimento&func=servico&id=$id'; </script>";
      }
    }

?>
<?php } ?>



<!--Modal Mensagem -->
<?php
//se func for igual a mensagem recupere o id
if (@$_GET['func'] == 'mensagem') {
  $id = $_GET['id'];

  //consulta para recuperação da mensagem no while
  $query = "select * from requerimento_servico where id_requerimento = '$id' ";
  $result = mysqli_query($conexao, $query);

  while ($res = mysqli_fetch_array($result)) {
    $mensagem = $res["mensagem"];
    $unidade_consumidora = $res["id_unidade_consumidora"];

?>


    <!-- Modal Mensagem -->
    <div id="modalMensagem" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Mensagem</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

            <p> <?php echo $mensagem; ?> </p>

            <!--- table-sm= small = menor-->
            <table class="table table-sm">
              <thead class="text-secondary">


                <th>
                  Serviços solicitados
                </th>

              </thead>
              <tbody>

                <?php
                //trazendo info servico_disponivel
                $query_sm = "SELECT * from servico_requerido where id_requerimento = '$id' ";
                $result_sm = mysqli_query($conexao, $query_sm);
                while ($res = mysqli_fetch_array($result_sm)) {
                  $id_servico_requerido = $res["id_servico_requerido"];

                  //trazendo info servico_disponivel 
                  $query_smd = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' ";
                  $result_smd = mysqli_query($conexao, $query_smd);
                  while ($res = mysqli_fetch_array($result_smd)) {
                    $descricao_servico = $res["descricao_servico"];

                ?>

                    <tr>

                      <td><?php echo $descricao_servico; ?></td>

                    </tr>

                <?php }
                } ?>

              </tbody>
              <tfoot>
                <tr>

                  <td></td>
                  <td></td>
                  <td></td>

                </tr>

              </tfoot>
            </table>


          </div>

          <form method="post" action="">
            <div class="modal-footer">

              <?php if ($id_servico_requerido == '04') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&func=editar&id=<?php echo $unidade_consumidora; ?>&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '17') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&func=editar&id=<?php echo $unidade_consumidora; ?>&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '01') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&func=edita2&id=<?php echo $unidade_consumidora; ?>&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '07') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&txtpesquisarConsumidores=<?php echo $unidade_consumidora; ?>&buttonPesquisar=&temp=s&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '16') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&txtpesquisarConsumidores=<?php echo $unidade_consumidora; ?>&buttonPesquisar=&temp=s&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '13') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&txtpesquisarConsumidores=<?php echo $unidade_consumidora; ?>&buttonPesquisar=&temp=s&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '12') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&txtpesquisarConsumidores=<?php echo $unidade_consumidora; ?>&buttonPesquisar=&temp=s&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

              <?php if ($id_servico_requerido == '11') { ?>
                <a class="btn btn-info btn-sm" href="admin.php?acao=consumidores&txtpesquisarConsumidores=<?php echo $unidade_consumidora; ?>&buttonPesquisar=&temp=s&rec=<?php echo $id; ?>">Atender</a>
              <?php } ?>

            </div>
          </form>

        </div>
      </div>
    </div>

<?php }
} ?>




<!--EXCLUIR -->
<?php
if (@$_GET['func'] == 'excluir') {
  $id = $_GET['id'];



  //recuperar dados
  $query_uc = "select * from consumidores where id = '$id' ";
  $result_uc = mysqli_query($conexao, $query_uc);

  while ($res = mysqli_fetch_array($result_uc)) {

    $id = $res["id"];
    $nome_razao_social = $res["nome_razao_social"];

    $query = "DELETE FROM consumidores where id = '$id' ";
    $result = mysqli_query($conexao, $query);
    echo "<script language='javascript'>window.location='admin.php?acao=consumidor'; </script>";
  }
}

?>


<!--ATIVAR O USUÁRIO-->
<?php if (@$_GET['func'] == 'ativa') {
  $id = $_GET['id'];
  $sql = "UPDATE consumidores SET status_ligacao = 'ATIVO' WHERE id = '$id'";
  mysqli_query($conexao, $sql);

  echo "<script language='javascript'>window.alert('Ativado Sucesso!'); </script>";
  echo "<script language='javascript'>window.location='admin.php?acao=consumidores'; </script>";
} ?>


<!--INATIVAR O USUÁRIO-->
<?php if (@$_GET['func'] == 'inativa') {
  $id = $_GET['id'];
  $sql = "UPDATE consumidores SET status_ligacao = 'INATIVO' WHERE id = '$id'";
  mysqli_query($conexao, $sql);

  echo "<script language='javascript'>window.alert('Inativado com Sucesso!'); </script>";
  echo "<script language='javascript'>window.location='admin.php?acao=consumidores'; </script>";
} ?>


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
<script>
  $("#modalMensagem").modal("show");
</script>



<!--MASCARAS -->

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
  $("td[id*='cel']").inputmask({
    mask: ['(99) 99999-9999'],
    keepStatic: true
  });
</script>
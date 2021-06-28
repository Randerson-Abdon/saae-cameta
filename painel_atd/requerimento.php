<?php
@session_start();
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

// função para codificação de caracteres
function limparTexto($conteudo)
{ //Declara a função recebendo o parâmetro $conteudo.
  //$conteudo = strtolower($conteudo); //Passa todo o texto para minúsculo.
  $conteudo = preg_replace('/[áàãâä]/ui', 'a', $conteudo); //troca todas os possíveis acentos de "a" pela letra não acentuada.
  //No final da expressão regular é passado "ui", onde o "u" significa unicode e o "i" case insensitive para evitar possíveis erros.
  $conteudo = preg_replace('/[éèêë]/ui', 'e', $conteudo); //Aqui e abaixo faz o mesmo feito para "a" em todas as vogais e para letra "c".
  $conteudo = preg_replace('/[íìîï]/ui', 'i', $conteudo);
  $conteudo = preg_replace('/[óòõôö]/ui', 'o', $conteudo);
  $conteudo = preg_replace('/[úùûü]/ui', 'u', $conteudo);
  $conteudo = preg_replace('/[ç]/ui', 'c', $conteudo);
  //$conteudo = preg_replace('/[^a-z0-9]/i', '_', $conteudo); //Aqui pega tudo o que não for letra ou número e troca por underline.
  //Usei  o underline pois um dos usos dessa função é limpar texto para url.
  $conteudo = mb_strtoupper($conteudo); //Passa todo o texto para maiusculas.
  return $conteudo; //Retorna o conteúdo passado no parâmetro.
}

?>



<div class="container ml-4">
  <div class="row">

    <div class="col-lg-8 col-md-6">
      <h3>REQUERIMENTOS</h3>
    </div>

    <div class="col-lg-8 col-md-6 col-sm-12">
      <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalExemplo"> <i class="fas fa-user-plus"> REQUERIMENTO </i> </button>
      <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalNovo"> <i class="fas fa-plus-circle"> NOVA LIGAÇÃO </i> </button>

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

                $query = "SELECT * from requerimento where nome_razao_social LIKE '$nome' OR numero_cpf_cnpj LIKE '$numero_cpf_cnpj' and status_requerimento != 'C' order by id_requerimento asc ";

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
                echo "<h3 class='text-danger'> Não foram encontrados dados Cadastrados!!! </h3>";
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

                        <td class="text-danger"><?php echo $id; ?></td>
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
                          <a class="btn btn-info btn-sm" title="Ver Requerimento" href="atendimento.php?acao=requerimento&func=req&id=<?php echo $id; ?>"><i class="fas fa-clipboard-list"></i></a>

                          <a class="btn btn-success btn-sm" title="Adicionar Serviço" href="atendimento.php?acao=requerimento&func=servico&id=<?php echo $id; ?>"><i class="fas fa-tools"></i></a>

                          <a class="btn btn-danger btn-sm" href="atendimento.php?acao=requerimento&func4=ativa&id=<?php echo $id; ?>"><i title="Cancelar Requerimento" class="fa fa-minus-square"></i></a>

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
                    <option value="uc">Matrícula</option>
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



                <!-- CONSULTA POR Matrícula-->
                <div id="uc" name="uc" style="display: none;">
                  <div class="row">

                    <div class="form-group col-md-4">
                      <label for="id_produto">UC</label>
                      <input type="text" class="form-control mr-3" name="id_unidade_consumidora" placeholder="UC">
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

                    <div class="form-group col-md-3 ml-3">
                      <label for="fornecedor">Localidade</label>

                      <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar(this.value); required>
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

                    <div class="form-group col-md-3" id="atualiza"></div>

                    <div class="form-group col-md-3" id="atualiza2"></div>

                    <div class="form-group col-md-2">
                      <label for="id_produto">Nº</label>
                      <input type="text" class="form-control mr-2" id="numero_logradouro" name="numero_logradouro" placeholder="Número" required>
                    </div>

                    <div class="form-group col-md-2 ml-3">
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
                  id_localidade: $("select[name='id_localidade']").val(),
                  id_logradouro: $("select[name='id_logradouro']").val(),
                  id_bairro: $("select[name='id_bairro']").val(),
                  numero_logradouro: $("input[name='numero_logradouro']").val()
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
      $localidade = $res['id_localidade'];

      $fone_fixo = $res['fone_fixo'];
      $fone_movel = $res['fone_movel'];
      $fone_movel_zap = $res['fone_movel_zap'];
      $email = $res['email'];

      $observacoes = $res['observacoes'];
      $status_requerimento = $res['status_requerimento'];
      $data_requerimento = $res['data_requerimento'];

      $data_requerimento2 = implode('/', array_reverse(explode('-', $data_requerimento)));

      //executa o store procedure info consumidor
      $result_sp = mysqli_query(
        $conexao,
        "CALL sp_seleciona_unidade_consumidora($localidade,$id_unidade_consumidora);"
      ) or die("Erro na query da procedure: " . mysqli_error($conexao));
      mysqli_next_result($conexao);
      $row_uc = mysqli_fetch_array($result_sp);

      $nome_localidade          = $row_uc['LOCALIDADE'];
      $nome_bairro              = $row_uc['BAIRRO'];
      $nome_logradouro          = $row_uc['LOGRADOURO'];
      $numero_logradouro        = $row_uc['NUMERO'];
      $complemento_logradouro   = $row_uc['COMPLEMENTO'];
      $cep_logradouro           = $row_uc['CEP'];
      $tipo_enderecamento       = $row_uc['CORRESPONDENCIA'];

  ?>

      <!-- MODAL REQUERIMENTO -->

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
                    <label for="id_produto"><?php echo $nome_logradouro ?></label>
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
                            @$id_servico_requerido = $res["id_servico_requerido"];

                            //trazendo dados de serviços que esta relacionado com o id, semelhante ao INNER JOIN
                            $query_sv = "SELECT * from servico_disponivel where id_servico = '$id_servico_requerido' ";
                            $result_sv = mysqli_query($conexao, $query_sv);
                            $row_sv = mysqli_fetch_array($result_sv);
                            @$descricao_servico = $row_sv['descricao_servico'];
                            @$valor_servico = $row_sv['valor_servico'];
                            @$status_execucao = $row_sv['status_execucao'];

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

              <?php if (@$soma2 > 0 and @$status_requerimento != 'D') { ?>
                <div style="margin-top: -16px;">
                  <a class="btn btn-info" target="_blank" href="../lib/boleto_s/boleto_cef_servico.php?func=boleto&id=<?php echo $id_unidade_consumidora; ?>&id_localidade=<?php echo $localidade; ?>&total_fatura=<?php echo $soma2; ?>&id_requerimento=<?php echo $id_requerimento; ?>">Boleto de Pagamento</a>
                </div>
              <?php } ?>

              <div style="margin-top: -16px;">
                <a class="btn btn-info" target="_blank" href="rel_req.php?func=imprime&id=<?php echo $id; ?>">Imprimir</a>
              </div>

              <?php if (@$status_requerimento == 'A' and @$status_execucao == 'O') { ?>
                <button type="submit" class="btn btn-success mb-3" title="Gerar Ordem de Serviço" name="gerar">Gerar OS </button>
              <?php } ?>

              <?php if (@$status_requerimento == 'A' and @$id_servico_requerido == '07' && '16') { ?>
                <button type="submit" class="btn btn-success mb-3" title="Gerar Ordem de Serviço" name="gerar">Gerar OS </button>
              <?php } ?>

              <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
              </form>

            </div>
          </div>
        </div>
      </div>

  <?php


      if (isset($_POST['gerar'])) {

        $id_requerimento2 = $id;
        //consulta para numeração automatica
        $query_num_os = "select * from ordem_servico order by id_ordem_servico desc ";
        $result_num_os = mysqli_query($conexao, $query_num_os);
        $res_num_os = mysqli_fetch_array($result_num_os);
        $ultimo_os = $res_num_os["id_ordem_servico"];
        $id_ordem_servico = $ultimo_os + 1;


        //trazendo info unidade_consumidora
        $query_ucon = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id_unidade_consumidora' ";
        $result_ucon = mysqli_query($conexao, $query_ucon);
        $row_ucon = mysqli_fetch_array($result_ucon);
        $status_ligacao = $row_ucon["status_ligacao"];
        $id_localidade = $row_ucon["id_localidade"];

        //VERIFICAR SE JÁ EXISTE OS
        $query_verificar_os = "SELECT * from ordem_servico where id_requerimento = '$id_requerimento2' ";
        $result_verificar_os = mysqli_query($conexao, $query_verificar_os);
        $row_verificar_os = mysqli_num_rows($result_verificar_os);
        if ($row_verificar_os > 0) {
          echo "<script language='javascript'>window.alert('Ordem de Serviço já Gerada!!!'); </script>";
          exit();
        }

        // insert requerimento
        $query_r2 = "INSERT INTO ordem_servico (id_requerimento, id_ordem_servico) values ('$id_requerimento2', '$id_ordem_servico')";
        $result_r2 = mysqli_query($conexao, $query_r2);

        if ($result_r2 == '') {
          echo "<script language='javascript'>window.alert('Ocorreu um erro ao gerar!'); </script>";
        } else {

          $mes_lancamento = date('Y/m', strtotime('+30 days'));

          $valor_lancamento_servico = str_replace(',', '.', $soma2);

          $id_usuario_editor = $_SESSION['id_usuario'];

          // insert servico_faturado
          $query_sf = "INSERT INTO servico_faturado (id_localidade, id_unidade_consumidora, mes_lancamento_servico, id_requerimento, data_lancamento_servico, valor_lancamento_servico, id_usuario_editor_registro) values ('$id_localidade', '$id_unidade_consumidora', '$mes_lancamento', '$id_requerimento2', curDate(), '$valor_lancamento_servico', '$id_usuario_editor')";
          $result_sf = mysqli_query($conexao, $query_sf);

          echo "<script language='javascript'>window.alert('Gerado com Sucesso!'); </script>";
          echo "<script language='javascript'>window.location='atendimento.php?acao=requerimento'; </script>";
        }
      }
    }
  }

  ?>





  <!-- EXIBIÇÃO PERFIL -->
  <?php
  if (@$_GET['func'] == 'perfil') {
    $id         = $_GET['id'];
    $localidade =  $_GET['id_localidade'];

    //executa o store procedure info consumidor
    $result_sp2 = mysqli_query(
      $conexao,
      "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
    ) or die("Erro na query da procedure: " . mysqli_error($conexao));
    mysqli_next_result($conexao);
    $row_uc = mysqli_fetch_array($result_sp2);
    $nome_razao_social        = $row_uc['NOME'];
    $tipo_juridico            = $row_uc['TIPO_JURIDICO'];
    $numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
    $numero_rg                = $row_uc['N.º RG'];
    $orgao_emissor_rg         = $row_uc['ORGAO_EMISSOR'];
    $uf_rg                    = $row_uc['UF'];
    $fone_fixo                = $row_uc['FONE_FIXO'];
    $fone_movel               = $row_uc['CELULAR'];
    $fone_zap                 = $row_uc['ZAP'];
    $email                    = $row_uc['EMAIL'];
    $tipo_consumo             = $row_uc['TIPO_CONSUMO'];
    $faixa_consumo            = $row_uc['FAIXA'];
    $tipo_medicao             = $row_uc['MEDICAO'];
    $id_unidade_hidrometrica  = '';
    $valor_faixa_consumo      = $row_uc['VALOR'];
    $nome_localidade          = $row_uc['LOCALIDADE'];
    $nome_bairro              = $row_uc['BAIRRO'];
    $nome_logradouro          = $row_uc['LOGRADOURO'];
    $numero_logradouro        = $row_uc['NUMERO'];
    $complemento_logradouro   = $row_uc['COMPLEMENTO'];
    $cep_logradouro           = $row_uc['CEP'];
    $tipo_enderecamento       = $row_uc['CORRESPONDENCIA'];
    $status_ligacao           = $row_uc['STATUS'];
    $data_cadastro            = $row_uc['CADASTRO'];
    $observacoes_text         = $row_uc['OBSERVAÇÕES'];



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
                  <label for="id_produto"><?php echo $id ?></label>
                </div>

                <div class="form-group col-md-4">
                  <label for="id_produto"><b>Tipo Jurídico: </b></label>
                  <label for="id_produto"><?php echo $tipo_juridico ?></label>
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
                  <label for="id_produto"><?php echo $nome_logradouro ?></label>
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
                  <label for="id_produto"><?php echo $fone_zap ?></label>
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
                  <label for="id_produto"><b>Tipo de Consumo: </b></label>
                  <label for="id_produto"><?php echo $tipo_consumo ?></label>
                </div>

                <div class="form-group col-md-3">
                  <label for="id_produto"><b>Faixa de Consumo: </b></label>
                  <label for="id_produto"><?php echo $faixa_consumo ?></label>
                </div>

                <div class="form-group col-md-4">
                  <label for="id_produto"><b>Tipo de Medição: </b></label>
                  <label for="id_produto"><?php echo $tipo_medicao ?></label>
                </div>

                <div class="form-group col-md-4">
                  <label for="id_produto"><b>Unidade Hidrométrica: </b></label>
                  <label for="id_produto"><?php echo $id_unidade_hidrometrica ?></label>
                </div>

                <div class="form-group col-md-4">
                  <label for="id_produto"><b>Valor da Tarifa: </b></label>
                  <label for="id_produto"><?php echo $valor_faixa_consumo ?></label>
                </div>

                <div class="form-group col-md-4">
                  <label for="id_produto"><b>Status da Ligação: </b></label>
                  <label for="id_produto"><?php echo $status_ligacao ?></label>
                </div>

                <div class="form-group col-md-8">
                  <label for="id_produto"><b>Observações: </b></label>
                  <label for="id_produto"><?php echo $observacoes_text ?></label>
                </div>

              </div>

          </div>

          <div class="modal-footer">
            <div style="margin-top: -16px;">
              <a class="btn btn-info" target="_blank" href="rel_perfil.php?func=imprime&id=<?php echo $id; ?>&id_localidade=<?php echo $localidade; ?>">Imprimir</a>
            </div>
            <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
            </form>

          </div>
        </div>
      </div>
    </div>

  <?php } ?>




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
      $status_ligacao = $res['status_ligacao'];



      //trazendo id_unidade_consumidora de unidade_consumidora que esta relacionado com o cpf/cnpj, semelhante ao INNER JOIN
      $query_e = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id' ";
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
      $query_log = "select * from logradouro where id_localidade = '$id_localidade' and id_logradouro = '$id_logradouro' and id_bairro = '$id_bairro' ";
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

      <!-- MODAL REQUERIMENTO COM UC EXISTENTE -->

      <?php

      //consulta para numeração automatica
      $query_num_req = "select * from requerimento order by id_requerimento desc ";
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
                    <input type="text" class="form-control mr-2" name="id_requerimento" value="<?php echo $ultimo_req; ?>" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">UC</label>
                    <input type="text" class="form-control mr-2" name="id_unidade_consumidora" placeholder="UC" value="<?php echo $id ?>" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Tipo Jurídico</label>
                    <select class="form-control mr-2" id="category" name="tipo_juridico" style="text-transform:uppercase;" readonly>
                      <option value="" <?php if ($tipo_juridico == '') { ?> selected <?php } ?>>selecione</option>
                      <option value="J" <?php if ($tipo_juridico == 'J') { ?> selected <?php } ?>>Pessoa Jurídica</option>
                      <option value="P" <?php if ($tipo_juridico == 'P') { ?> selected <?php } ?>>Pessoa Física</option>

                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">Informe seu CPF/CNPJ</label>
                    <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" value="<?php echo $numero_cpf_cnpj ?>" readonly>
                  </div>

                  <div class="form-group col-md-8">
                    <label for="id_produto">Nome/Razão Social</label>
                    <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">RG</label>
                    <input type="text" class="form-control mr-2" name="numero_rg" placeholder="RG" id="rg" value="<?php echo $numero_rg ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Orgão Emissor</label>
                    <input type="text" class="form-control mr-2" name="orgao_emissor_rg" placeholder="Orgão Emissor" style="text-transform:uppercase;" value="<?php echo $orgao_emissor_rg ?>" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">UF RG</label>
                    <select class="form-control mr-2" id="category" name="uf_rg" style="text-transform:uppercase;" readonly>

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
                    <input type="text" class="form-control mr-2" name="numero_logradouro" placeholder="Nº" style="text-transform:uppercase;" value="<?php echo $numero_logradouro ?>" readonly>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto">Complemento</label>
                    <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;" value="<?php echo $complemento_logradouro ?>" readonly>
                  </div>

                </div>

                <h5 class="modal-title">Contato</h5>
                <hr>
                <div class="row">

                  <div class="form-group col-md-3">
                    <label for="id_produto">Telefone Fixo</label>
                    <input type="text" class="form-control mr-2" name="fone_fixo" placeholder="Telefone" id="fone" value="<?php echo $fone_fixo ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Celular</label>
                    <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">WhatsApp</label>
                    <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;" readonly>

                      <option value="N" <?php if ($fone_zap == '') { ?> selected <?php } ?>>NÃO</option>
                      <option value="S" <?php if ($fone_zap == 'S') { ?> selected <?php } ?>>SIM</option>
                      <option value="N" <?php if ($fone_zap == 'N') { ?> selected <?php } ?>>NÃO</option>

                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="id_produto">E-mail</label>
                    <input type="email" class="form-control mr-2" name="email" placeholder="E-mail" value="<?php echo $email ?>" readonly>
                  </div>

                </div>

                <h5 class="modal-title">Outros</h5>
                <hr>
                <div class="row">

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Status da Ligação</label>
                    <input type="text" maxlength="255" class="form-control mr-2" name="status_ligacao" style="text-transform:uppercase;" value="<?php if ($status_ligacao == 'I') {
                                                                                                                                                  echo 'Inativo';
                                                                                                                                                } else {
                                                                                                                                                  echo 'Ativo';
                                                                                                                                                }  ?>" readonly>
                  </div>

                  <div class="form-group col-md-9">
                    <label for="fornecedor">Observações</label>
                    <input type="text" maxlength="255" class="form-control mr-2" name="observacoes" placeholder="Observações" style="text-transform:uppercase;">
                  </div>

                </div>


            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success mb-3" name="btn_editar">Criar </button>


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
        $id_usuario_editor = $_SESSION['id_usuario'];

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

        //echo $tipo_juridico;


        // insert requerimento
        $query2 = "INSERT INTO requerimento (id_localidade, id_requerimento, existe_unidade_consumidora, id_unidade_consumidora, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, fone_fixo, fone_movel, fone_movel_zap, email, observacoes, id_usuario_editor_registro) values ('$id_localidade', '$n_req', '$existe_unidade_consumidora', '$uc', '$tipo_juridico', '$ncc3', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$tel', '$cel', '$fone_zap', '$email', '$observacoes', '$id_usuario_editor')";

        $result2 = mysqli_query($conexao, $query2);


        if ($result2 == '') {
          echo "<script language='javascript'>window.alert('Ocorreu um erro ao Criar!'); </script>";
        } else {

          //$query_status = "UPDATE unidade_consumidora set tipo_juridico = '$tipo_juridico', numero_cpf_cnpj = '$ncc3', nome_razao_social = '$nome_razao_social', numero_rg = '$numero_rg', orgao_emissor_rg = '$orgao_emissor_rg', uf_rg = '$uf_rg', fone_fixo = '$tel', fone_movel = '$cel', fone_zap = '$fone_zap', email = '$email', id_usuario_editor = '$id_usuario_editor' where id_unidade_consumidora = '$uc'";

          //$result_status = mysqli_query($conexao, $query_status);

          echo "<script language='javascript'>window.alert('Criado com Sucesso, você já pode adicionar serviços a este requerimento!!!'); </script>";
          echo "<script language='javascript'>window.location='atendimento.php?acao=requerimento'; </script>";
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
  $query_num_req = "select * from requerimento order by id_requerimento desc ";
  $result_num_req = mysqli_query($conexao, $query_num_req);
  $res_num_req = mysqli_fetch_array($result_num_req);
  @$ultimo_req = $res_num_req["id_requerimento"];
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
                <input type="number" class="form-control mr-2" name="id_requerimento" value="<?php echo str_pad($ultimo_req, 6, '0', STR_PAD_LEFT); ?>" readonly>
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

                <select class="form-control mr-2" id="category" name="id_localidade2" onchange=javascript:Atualizar01(this.value); required>
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

              <div class="form-group col-md-4" id="atualiza0"></div>

              <div class="form-group col-md-4" id="atualiza02"></div>

              <div class="form-group col-md-3">
                <label for="id_produto">Nº</label>
                <input type="text" class="form-control mr-2" id="numero_logradouro" name="numero_logradouro2" placeholder="Número" required>
              </div>

              <div class="form-group col-md-5">
                <label for="id_produto">Complemento</label>
                <input type="text" class="form-control mr-2" name="complemento_logradouro" placeholder="Complemento" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-2">
                <label for="id_produto">Consultar</label>
                <button type="button" class="btn btn-success form-control mr-2" name="consultar2" id="consultar2"><i class="fas fa-search"></i></button>
              </div>

              <div class="form-group" id="dados5"></div>

            </div>

            <h5 class="modal-title">Dados Pessoais</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="fornecedor">Tipo Jurídico</label>
                <select class="form-control mr-2" id="category" name="tipo_juridico" style="text-transform:uppercase;" required>

                  <option value="F">Pessoa Física</option>
                  <option value="J">Pessoa Jurídica</option>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Informe seu CPF/CNPJ</label>
                <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" placeholder="CPF/CNPJ" required>
              </div>

              <div class="form-group col-md-6">
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

                  <option value="">Selecione</option>
                  <option value="PA">Pará</option>
                  <option value="AC">Acre</option>
                  <option value="AL">Alagoas</option>
                  <option value="AP">Amapá</option>
                  <option value="AM">Amazonas</option>
                  <option value="BA">Bahia</option>
                  <option value="CE">Ceará</option>
                  <option value="DF">Distrito Federal</option>
                  <option value="ES">Espirito Santo</option>
                  <option value="GO">Goiás</option>
                  <option value="MA">Maranhão</option>
                  <option value="MS">Mato Grosso do Sul</option>
                  <option value="MT">Mato Grosso</option>
                  <option value="MG">Minas Gerais</option>
                  <option value="PB">Paraíba</option>
                  <option value="PR">Paraná</option>
                  <option value="PE">Pernambuco</option>
                  <option value="PI">Piauí</option>
                  <option value="RJ">Rio de Janeiro</option>
                  <option value="RN">Rio Grande do Norte</option>
                  <option value="RS">Rio Grande do Sul</option>
                  <option value="RO">Rondônia</option>
                  <option value="RR">Roraima</option>
                  <option value="SC">Santa Catarina</option>
                  <option value="SP">São Paulo</option>
                  <option value="SE">Sergipe</option>
                  <option value="TO">Tocantins</option>

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
                <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" required>
              </div>

              <div class="form-group col-md-2">
                <label for="fornecedor">WhatsApp</label>
                <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;">

                  <option value="N">Não</option>
                  <option value="S">Sim</option>

                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="id_produto">E-mail</label>
                <input type="email" class="form-control mr-2" name="email" placeholder="E-mail">
              </div>

            </div>

            <h5 class="modal-title">Dados de Faturamento</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="fornecedor">Tipo de Consumo</label>
                <select class="form-control mr-2" id="tipo_consumo" name="tipo_consumo" style="text-transform:uppercase;" required>

                  <option value="">SELECIONE</option>
                  <option value="01">RESIDENCIAL</option>
                  <option value="02">COMERCIAL</option>
                  <option value="03">INDUSTRIAL</option>
                  <option value="04">PÚBLICA</option>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Faixa de Consumo</label>
                <select class="form-control mr-2" id="faixa_consumo" name="faixa_consumo" style="text-transform:uppercase;" required>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Tipo de Medição</label>
                <select class="form-control mr-2" id="category" name="tipo_medicao" style="text-transform:uppercase;" required>

                  <option value="">SELECIONE</option>
                  <option value="E">ESTIMADA</option>
                  <option value="M">HIDROMETRADA</option>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Unidade Hidrométrica</label>
                <input type="text" class="form-control mr-2" name="id_unidade_hidrometrica" placeholder="U.H." style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-9">
                <label for="fornecedor">Observações</label>
                <input type="text" maxlength="255" class="form-control mr-2" name="observacoes" placeholder="Observações" style="text-transform:uppercase;">
              </div>

            </div>



        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="salvar">Salvar </button>

          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
        </div>

        </form>

      </div>

      <!-- PROCESSAMENTO PARA FAIXA DE CONSUMO-->
      <script>
        $("#tipo_consumo").change(function() {
          var estadoSelecionado = $(this).children("option:selected").val();

          $.ajax({
            url: "processa_faixa_consumo.php",
            method: "GET",
            dataType: "HTML",
            data: {
              id: estadoSelecionado
            }
          }).done(function(resposta) {
            $("#faixa_consumo").html(resposta);
          }).fail(function(resposta) {
            alert(resposta)
          });
        });
      </script>

      <script>
        $("#consultar2").click(function() {
          $.ajax({
            url: "resultado5.php",
            type: "POST",
            data: ({
              id_localidade2: $("select[name='id_localidade2']").val(),
              id_logradouro2: $("select[name='id_logradouro']").val(),
              id_bairro2: $("select[name='id_bairro']").val(),
              numero_logradouro2: $("input[name='numero_logradouro2']").val()
            }), //estamos enviando o valor do input
            success: function(resposta) {
              $('#dados5').html(resposta);
            }

          });
        });
      </script>

    </div>
  </div>

  <!--CADASTRO -->

  <?php
  if (isset($_POST['salvar'])) {
    $numero_rec                 = $ultimo_req;
    $existe_unidade_consumidora = 'N';
    $id_unidade_consumidora     = $ultimo_cad;
    $tipo_juridico              = mb_strtoupper($_POST['tipo_juridico']);
    $numero_cpf_cnpj            = $_POST['numero_cpf_cnpj'];
    $nome_razao_social          = mb_strtoupper($_POST['nome_razao_social']);
    //tirando acentos
    $nome_razao_social = limparTexto($nome_razao_social);

    $numero_rg                  = $_POST['numero_rg'];
    $orgao_emissor_rg           = mb_strtoupper($_POST['orgao_emissor_rg']);
    $uf_rg                      = mb_strtoupper($_POST['uf_rg']);

    $id_localidade              = $_POST['id_localidade2'];
    $id_bairro                  = $_POST['id_bairro'];
    $id_logradouro              = $_POST['id_logradouro'];
    $numero_logradouro          = $_POST['numero_logradouro2'];
    $complemento_logradouro     = mb_strtoupper($_POST['complemento_logradouro']);

    $fone_fixo                  = $_POST['fone_fixo'];
    $fone_movel                 = $_POST['fone_movel'];
    $fone_zap                   = $_POST['fone_zap'];
    $email                      = $_POST['email'];

    $tipo_consumo               = mb_strtoupper($_POST['tipo_consumo']);
    $faixa_consumo              = mb_strtoupper($_POST['faixa_consumo']);
    $tipo_medicao                = mb_strtoupper($_POST['tipo_medicao']);
    $observacoes                = mb_strtoupper($_POST['observacoes']);

    $id_usuario_editor = $_SESSION['id_usuario'];

    //tratamento para numero_cpf_cnpj
    $ncc = str_replace("/", "", $numero_cpf_cnpj);
    $ncc2 = str_replace(".", "", $ncc);
    $ncc3 = str_replace("-", "", $ncc2);

    //tratamento para telefone
    $tel = preg_replace("/[^0-9]/", "", $fone_fixo);

    //tratamento para celular
    $cel = preg_replace("/[^0-9]/", "", $fone_movel);

    $query = "INSERT INTO requerimento (id_localidade, id_requerimento, existe_unidade_consumidora, id_unidade_consumidora, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, fone_fixo, fone_movel, fone_movel_zap, email, observacoes, id_usuario_editor_registro) values ('$id_localidade', '$numero_rec', '$existe_unidade_consumidora', '$id_unidade_consumidora', '$tipo_juridico', '$ncc3', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$tel', '$cel', '$fone_zap', '$email', '$observacoes', '$id_usuario_editor')";

    $result = mysqli_query($conexao, $query);

    $query_con = "INSERT INTO unidade_consumidora (id_unidade_consumidora, status_ligacao, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, id_localidade, fone_fixo, fone_movel, fone_zap, email, tipo_consumo, faixa_consumo, tipo_medicao, tipo_enderecamento, id_usuario_editor_registro) values ('$id_unidade_consumidora', 'P', '$tipo_juridico', '$ncc3', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$id_localidade', '$tel', '$cel', '$fone_zap', '$email', '$tipo_consumo', '$faixa_consumo', '$tipo_medicao', 'I', '$id_usuario_editor')";
    $result_con = mysqli_query($conexao, $query_con);

    //inserindo serviço para nova ligação
    $query_serv = "INSERT INTO servico_requerido (id_servico_requerido, id_requerimento) values ('11', '$numero_rec')";
    $result_serv = mysqli_query($conexao, $query_serv);

    $query_end = "INSERT INTO endereco_instalacao (id_unidade_consumidora, id_localidade, id_bairro, id_logradouro, numero_logradouro, complemento_logradouro) values ('$id_unidade_consumidora', '$id_localidade', '$id_bairro', '$id_logradouro', '$numero_logradouro', '$complemento_logradouro')";
    $result_end = mysqli_query($conexao, $query_end);



    echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
    echo "<script language='javascript'>window.location='atendimento.php?acao=requerimento'; </script>";
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
                  <input type="number" class="form-control" name="num_aula" value="<?php echo $id; ?>" readonly />
                </div>

                <div class="form-group col-md-6">
                  <label for="id_produto">Serviço</label>
                  <select class="form-control mr-2" id="category" name="id_servico">

                    <?php

                    //Info tabela serviços requeridos
                    $query_servreq = "select * from servico_requerido where id_requerimento = '$id' ";
                    $result_servreq = mysqli_query($conexao, $query_servreq);
                    $res_servreq = mysqli_fetch_array($result_servreq);
                    $sev = $res_servreq["id_servico_requerido"];

                    //Info tabela servico_disponivel
                    $query_st = "select * from servico_disponivel where id_servico = '$sev' ";
                    $result_st = mysqli_query($conexao, $query_st);
                    $res_st = mysqli_fetch_array($result_st);
                    $status_execucao = $res_st["status_execucao"];

                    if ($status_execucao == '') {
                      //recuperando dados da tabela servico para o select
                      $query = "select * from servico_disponivel order by descricao_servico asc";
                      $result = mysqli_query($conexao, $query);
                    } else {
                      //recuperando dados da tabela servico para o select
                      $query = "select * from servico_disponivel where status_execucao = '$status_execucao' order by descricao_servico asc";
                      $result = mysqli_query($conexao, $query);
                    }


                    while ($res = mysqli_fetch_array($result)) {

                    ?>
                      <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
                      <option value="<?php echo $res['id_servico'] ?>"><?php echo $res['descricao_servico'] ?></option>

                    <?php
                    }
                    ?>

                  </select>
                </div>


                <div class="form-group col-md-2" style="margin-top: 20px;">
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

      //trazendo info REQUERIMENTO
      $query_rec_uc = "SELECT * from requerimento where id_requerimento = '$id_requerimento' ";
      $result_rec_uc = mysqli_query($conexao, $query_rec_uc);
      $row_rec_uc = mysqli_fetch_array($result_rec_uc);
      $id_unidade_consumidora = $row_rec_uc['id_unidade_consumidora'];

      //VERIFICAR SE ATIVO OU NÃO
      $query_verificar_uc = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id_unidade_consumidora' ";
      $result_verificar_uc = mysqli_query($conexao, $query_verificar_uc);
      $row_verificar_uc = mysqli_fetch_array($result_verificar_uc);
      $status_ligacao = $row_verificar_uc['status_ligacao'];
      if (($id_servico_requerido == '12') and ($status_ligacao == 'A')) {
        echo "<script language='javascript'>window.alert('Matrícula Ativa !!!'); </script>";
        exit();
      } elseif (($id_servico_requerido == '13') and ($status_ligacao == 'A')) {
        echo "<script language='javascript'>window.alert('Matrícula Ativa !!!'); </script>";
        exit();
      } elseif (($id_servico_requerido == '07') and ($status_ligacao == 'I')) {
        echo "<script language='javascript'>window.alert('Matrícula Inativa !!!'); </script>";
        exit();
      } elseif (($id_servico_requerido == '16') and ($status_ligacao == 'I')) {
        echo "<script language='javascript'>window.alert('Matrícula Inativa !!!'); </script>";
        exit();
      }

      $mensagem = 'O requerimento Nº ' . $id_requerimento . ' requer sua atenção!';

      //VERIFICAR SE JÁ EXISTE OS
      $query_verificar_os = "SELECT * from ordem_servico where id_requerimento = '$id_requerimento' ";
      $result_verificar_os = mysqli_query($conexao, $query_verificar_os);
      $row_verificar_os = mysqli_num_rows($result_verificar_os);
      if ($row_verificar_os > 0) {
        echo "<script language='javascript'>window.alert('Ordem de Serviço já Gerada, crie um novo requerimento para este serviço!!!'); </script>";
        exit();
      }


      if ($id_servico_requerido == '01') {

        $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
        mysqli_query($conexao, $query_mensagem);
      }

      if ($id_servico_requerido == '04') {

        $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
        mysqli_query($conexao, $query_mensagem);
      }


      if ($id_servico_requerido == '17') {

        $query_mensagem = "UPDATE requerimento set mensagem = '$mensagem' where id_requerimento = '$id_requerimento'";
        mysqli_query($conexao, $query_mensagem);
      }



      $query = "INSERT INTO servico_requerido (id_servico_requerido, id_requerimento) values ('$id_servico_requerido', '$id_requerimento')";

      $result = mysqli_query($conexao, $query);

      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
      } else {

        echo "<script language='javascript'>window.location='atendimento.php?acao=requerimento&func=servico&id=$id'; </script>";
      }
    }

?>


<?php } ?>



<!--EDITAR AULAS-->
<?php
//se func for igual a aulas recupere o id
if (@$_GET['func2'] == 'editar') {
  $id = $_GET['id_aula'];
  $id_curso = $_GET['id_curso'];

  $query = "select * from aulas where id = '$id' ";
  $result = mysqli_query($conexao, $query);

  while ($res = mysqli_fetch_array($result)) {
    $nome = $res["nome"];
    $num_aula = $res["num_aula"];
    $link = $res["link"];

?>


    <!-- Modal Editar Aulas -->
    <div id="modalEditarAulas" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Editar Aulas</h5>

          </div>
          <div class="modal-body">
            <form method="POST" action="">

              <div class="row">

                <div class="form-group col-md-2">
                  <label for="id_produto">Aula</label>
                  <input type="number" class="form-control" name="num_aula" value="<?php echo $num_aula; ?>" required />
                </div>

                <div class="form-group col-md-3">
                  <label for="id_produto">Nome</label>
                  <input type="text" class="form-control" name="nome" maxlength="35" value="<?php echo $nome; ?>" required />
                </div>

                <div class="form-group col-md-7">
                  <label for="id_produto">Link</label>
                  <input type="text" class="form-control" name="link" maxlength="300" value="<?php echo $link; ?>" required />
                </div>




                <!--fim da linha-->
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-success mb-3" name="editar_aulas">Editar </button>


                <button type="submit" class="btn btn-info mb-3" name="fechar_editar_aulas">Fechar</button>
            </form>
          </div>

        </div>
      </div>
    </div>


    <?php
    //se tiver click no botão editar aulas faça a atualização nos campos
    if (isset($_POST['editar_aulas'])) {
      $nome = $_POST['nome'];
      $num_aula = $_POST['num_aula'];
      $link = $_POST['link'];

      $query = "UPDATE aulas SET nome = '$nome', num_aula = '$num_aula', link = '$link' where id = '$id' ";

      $result = mysqli_query($conexao, $query);

      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
      } else {
        //redirecionamento para modal
        echo "<script language='javascript'>window.location='professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";
      }
    }

    ?>


    <?php
    //se tiver click no botão fechar aulas faça a atualização nos campos
    if (isset($_POST['fechar_editar_aulas'])) {

      echo "<script language='javascript'>window.location='professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";
    }
    ?>



<?php }
} ?>


<!--EXCLUSÃO DE AULAS DA MODAL AULAS-->
<?php
//se func for igual a aulas recupere o id
if (@$_GET['func2'] == 'excluir') {
  $id = $_GET['id_aula'];
  $id_curso = $_GET['id_curso'];


  //RECUPERAR QUANTIDADE DE AULAS DO CURSO PARA EXCLUSÃO
  $query_quant_aula = "select * from cursos where id = '$id_curso' ";
  $result_quant_aula = mysqli_query($conexao, $query_quant_aula);

  //conferindo linhas
  $res_quant_aula = mysqli_fetch_array($result_quant_aula);
  $quant_aula = $res_quant_aula["aulas"];




  $query = "delete from aulas where id = '$id'";
  $result = mysqli_query($conexao, $query);

  if ($result == '') {
    echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
  } else {


    //altere cursos onde o campo aulas receba a variavel aulas onde o id do curso seja igual ao id acima, atualização no campo de numero de aulas no curso, DECREMENTANDO UMA
    $quant_aula = $quant_aula - 1;
    $query_aulas = "UPDATE cursos set aulas = '$quant_aula' where id = '$id_curso'";

    mysqli_query($conexao, $query_aulas);


    //redirecionamento para modal
    echo "<script language='javascript'>window.location='professor.php?acao=cursos&func=aulas&id=$id_curso'; </script>";
  }
}

?>







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



    //exclusao dos alunos
    //if($nivel == 'Aluno'){
    // $query_alunos = "DELETE FROM alunos where cpf = '$cpf' ";

    // $result_alunos = mysqli_query($conexao, $query_alunos);
    // } 

    //} 



    $query = "DELETE FROM consumidores where id = '$id' ";
    $result = mysqli_query($conexao, $query);
    echo "<script language='javascript'>window.location='atendimento.php?acao=consumidor'; </script>";
  }
}

?>


<!--ATIVAR O USUÁRIO-->
<?php if (@$_GET['func4'] == 'ativa') {
  $id = $_GET['id'];

  $sql = "UPDATE requerimento SET status_requerimento = 'C' WHERE id_requerimento = '$id'";
  mysqli_query($conexao, $sql);

  echo "<script language='javascript'>window.alert('Requerimento Cancelado com Sucesso!'); </script>";
  echo "<script language='javascript'>window.location='atendimento.php?acao=requerimento'; </script>";
} ?>




<!--INATIVAR O USUÁRIO-->
<?php if (@$_GET['func'] == 'inativa') {
  $id = $_GET['id'];
  $sql = "UPDATE consumidores SET status_ligacao = 'INATIVO' WHERE id = '$id'";
  mysqli_query($conexao, $sql);

  echo "<script language='javascript'>window.alert('Inativado com Sucesso!'); </script>";
  echo "<script language='javascript'>window.location='atendimento.php?acao=consumidores'; </script>";
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
  $("input[id*='fone']").inputmask({
    mask: ['(99) 9999-9999'],
    keepStatic: true
  });
</script>
<script>
  $("td[id*='cel']").inputmask({
    mask: ['(99) 99999-9999'],
    keepStatic: true
  });
</script>
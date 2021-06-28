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



<div class="container">
  <div class="row">

    <div class="col-lg-7 col-md-6">
      <h3>CONSUMIDOR</h3>
    </div>

    <div class="pesquisar col-lg-5 col-md-6">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarConsumidores" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Consumidores" aria-label="Pesquisar">
        <button name="buttonPesquisar" class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>
</div>



<div class="container" style="width: 100%;">


  <br>


  <div class="content">
    <div class="row mr-3">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">

          </div>
          <div class="card-body">


            <!--LISTAR TODOS AS LOCALIDADES -->
            <?php

            @$temp = $_GET['temp'];
            @$id_requerimento = $_GET['rec'];

            if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarConsumidores'] != '') {


              $nome = '%' . $_GET['txtpesquisarConsumidores'] . '%';
              $cpf = $_GET['txtpesquisarConsumidores'];
              $unidade_consumidora = $_GET['txtpesquisarConsumidores'];
              $unidade_consumidora = str_pad($unidade_consumidora, 5, '0', STR_PAD_LEFT);

              //pesquisa por uc add
              $query = "SELECT * from unidade_consumidora where nome_razao_social LIKE '$nome' OR numero_cpf_cnpj = '$cpf' OR id_unidade_consumidora = '$unidade_consumidora' order by nome_razao_social asc ";

              $result_count = mysqli_query($conexao, $query);
            } else {
              $query = "SELECT * from unidade_consumidora order by id_unidade_consumidora desc limit 10";

              $query_count = "SELECT * from unidade_consumidora";
              $result_count = mysqli_query($conexao, $query_count);
            }

            $result = mysqli_query($conexao, $query);

            $linha = mysqli_num_rows($result);
            $linha_count = mysqli_num_rows($result_count);

            if ($linha == '') {
              echo "<h3> Não foram encontrados dados Cadastrados no Banco!! </h3>";
            } else {

            ?>




              <table class="table table-sm table-hover">
                <thead class="text-secondary">

                  <th class="text-danger">
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
                    Ações
                  </th>
                </thead>
                <tbody>

                  <?php
                  while ($res = mysqli_fetch_array($result)) {
                    $nome_razao_social = $res["nome_razao_social"];
                    $id = $res["id_unidade_consumidora"];
                    $numero_cpf_cnpj = $res["numero_cpf_cnpj"];
                    $fone_movel = $res["fone_movel"];
                    $status_ligacao = $res["status_ligacao"];
                    $data_cadastro = $res["data_cadastro"];

                    $data2 = implode('/', array_reverse(explode('-', $data_cadastro)));

                    //trazendo info endereco_instalação
                    $query_eu = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id' ";
                    $result_eu = mysqli_query($conexao, $query_eu);
                    $row_eu = mysqli_fetch_array($result_eu);
                    @$id_unidade_consumidora_e = $row_eu['id_unidade_consumidora'];

                  ?>

                    <tr>

                      <td class="text-danger"> <?php echo $id; ?></td>

                      <td><?php echo $nome_razao_social; ?></td>
                      <td id="numero_cpf_cnpj"><?php echo $numero_cpf_cnpj; ?></td>

                      <!-- condição para status -->
                      <td><?php if ($status_ligacao == 'A') {
                            echo 'ATIVO';
                          } elseif ($status_ligacao == 'I') {
                            echo 'INATIVO';
                          } elseif ($status_ligacao == 'P') {
                            echo 'PROVISÓRIO';
                          } else {
                            echo 'FACTIVEL';
                          }

                          ?></td>


                      <td>

                        <?php if ($status_ligacao == 'I' and $temp != '') { ?>
                          <a class="btn btn-success btn-sm" href="admin.php?acao=consumidores&func=ativa&id=<?php echo $id; ?>&rec=<?php echo $id_requerimento; ?>"><i title="Ativar Usuário(a)" class="fas fa-check-square"></i></a>
                        <?php } ?>

                        <?php if ($status_ligacao == 'P' and $temp != '') { ?>
                          <a class="btn btn-success btn-sm" href="admin.php?acao=consumidores&func=ativa&id=<?php echo $id; ?>&rec=<?php echo $id_requerimento; ?>"><i title="Ativar Usuário(a)" class="fas fa-check-square"></i></a>
                        <?php } ?>

                        <?php if ($status_ligacao == 'F' and $temp != '') { ?>
                          <a class="btn btn-success btn-sm" href="admin.php?acao=consumidores&func=ativa&id=<?php echo $id; ?>&rec=<?php echo $id_requerimento; ?>"><i title="Ativar Usuário(a)" class="fas fa-check-square"></i></a>
                        <?php } ?>

                        <?php if ($status_ligacao == 'A' and $temp != '') { ?>
                          <a class="btn btn-danger btn-sm" href="admin.php?acao=consumidores&func=inativa&id=<?php echo $id; ?>&rec=<?php echo $id_requerimento; ?>"><i title="Inativar Usuário(a)" class="fa fa-minus-square"></i></a>
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




<!--EDITAR -->
<?php
if (@$_GET['func'] == 'editar') {
  $id              = $_GET['id'];
  $id_requerimento = $_GET['rec'];
  $localidade      = $_GET['id_localidade'];

  //executa o store procedure info consumidor
  $result_sp = mysqli_query(
    $conexao,
    "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
  mysqli_next_result($conexao);
  $row_uc = mysqli_fetch_array($result_sp);
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

  $id_usuario_editor        = $_SESSION['id_usuario'];

  if ($tipo_consumo == 'RESIDENCIAL') {
    $id_tipo_consumo = '1';
  } elseif ($tipo_consumo == 'COMERCIAL') {
    $id_tipo_consumo = '2';
  } elseif ($tipo_consumo == 'INDUSTRIAL') {
    $id_tipo_consumo = '3';
  } elseif ($tipo_consumo == 'PUBLICA') {
    $id_tipo_consumo = '4';
  }

?>

  <!-- Modal Editar -->
  <div id="modalEditar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h3 class="modal-title">Consumidor</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">

            <h5 class="modal-title">Dados Pessoais</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="id_produto">UC</label>
                <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id ?>" style="text-transform:uppercase;" readonly>
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
                <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" value="<?php echo $numero_cpf_cnpj ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="id_produto">Nome/Razão Social</label>
                <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group col-md-2">
                <label for="id_produto">RG</label>
                <input type="text" class="form-control mr-2" name="numero_rg" placeholder="RG" value="<?php echo $numero_rg ?>" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-2">
                <label for="id_produto">Orgão Emissor</label>
                <input type="text" class="form-control mr-2" name="orgao_emissor_rg" placeholder="Orgão Emissor" style="text-transform:uppercase;" value="<?php echo $orgao_emissor_rg ?>">
              </div>

              <div class="form-group col-md-2">
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

            <h5 class="modal-title">Contato</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="id_produto">Telefone Fixo</label>
                <input type="text" class="form-control mr-2" name="fone_fixo" id="fone" value="<?php echo $fone_fixo ?>" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Celular</label>
                <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" required>
              </div>

              <div class="form-group col-md-2">
                <label for="fornecedor">WhatsApp</label>
                <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;">

                  <option value="" <?php if ($fone_zap == '') { ?> selected <?php } ?>>SELECIONE</option>
                  <option value="S" <?php if ($fone_zap == 'S') { ?> selected <?php } ?>>SIM</option>
                  <option value="N" <?php if ($fone_zap == 'N') { ?> selected <?php } ?>>NÃO</option>

                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="id_produto">E-mail</label>
                <input type="email" class="form-control mr-2" name="email" placeholder="E-mail" value="<?php echo $email ?>">
              </div>

            </div>

            <h5 class="modal-title">Dados de Faturamento</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="fornecedor">Tipo de Consumo</label>
                <select class="form-control mr-2" id="tipo_consumo" name="tipo_consumo" style="text-transform:uppercase;">

                  <option value="" <?php if ($tipo_consumo == '') { ?> selected <?php } ?>>SELECIONE</option>
                  <option value="01" <?php if ($tipo_consumo == 'RESIDENCIAL') { ?> selected <?php } ?>>RESIDENCIAL</option>
                  <option value="02" <?php if ($tipo_consumo == 'COMERCIAL') { ?> selected <?php } ?>>COMERCIAL</option>
                  <option value="03" <?php if ($tipo_consumo == 'INDUSTRIAL') { ?> selected <?php } ?>>INDUSTRIAL</option>
                  <option value="04" <?php if ($tipo_consumo == 'PUBLICA') { ?> selected <?php } ?>>PÚBLICA</option>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Faixa de Consumo</label>
                <select class="form-control mr-2" id="faixa_consumo" name="faixa_consumo" style="text-transform:uppercase;" required>

                  <?php
                  $query_valor = "SELECT * FROM tarifa_estimada WHERE tipo_consumo = '$id_tipo_consumo' and faixa_consumo = '$faixa_consumo' ";
                  $result_valor = mysqli_query($conexao, $query_valor);
                  $row_valor = mysqli_fetch_array($result_valor);
                  $valor = $row_valor['valor_faixa_consumo'];
                  ?>

                  <option value="<?php echo $faixa_consumo; ?>">R$ <?php echo $valor; ?></option>

                  <?php
                  $query_tc = "SELECT * FROM tarifa_estimada WHERE tipo_consumo = '$id_tipo_consumo' ";
                  $result_tc = mysqli_query($conexao, $query_tc);
                  //executa o store procedure info consumidor
                  while ($res = mysqli_fetch_array($result_tc)) {

                  ?>

                    <?php

                    //condição para mostrar o option para não se repetir o nome que já esta
                    if ($valor != $res['valor_faixa_consumo']) { ?>

                      <option value="<?php echo $res['faixa_consumo']; ?>">R$ <?php echo $res['valor_faixa_consumo']; ?></option>

                  <?php
                    }
                  }

                  ?>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Tipo de Medição</label>
                <select class="form-control mr-2" id="category" name="tipo_medicao" style="text-transform:uppercase;">

                  <option value="" <?php if ($tipo_medicao == '') { ?> selected <?php } ?>>SELECIONE</option>
                  <option value="E" <?php if ($tipo_medicao == 'ESTIMADA') { ?> selected <?php } ?>>ESTIMADA</option>
                  <option value="M" <?php if ($tipo_medicao == 'HIDROMETRADA') { ?> selected <?php } ?>>HIDROMETRADA</option>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Unidade Hidrométrica</label>
                <input type="text" class="form-control mr-2" name="id_unidade_hidrometrica" placeholder="U.H." value="<?php echo $id_unidade_hidrometrica ?>" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-3">
                <label for="fornecedor">Valor da Tarifa</label>
                <input type="text" class="form-control mr-2" name="valor_faixa_consumo" value="<?php echo $valor_faixa_consumo ?>" style="text-transform:uppercase;" readonly>
              </div>

            </div>

            <h5 class="modal-title">Outros</h5>
            <hr>
            <div class="row">

              <div class="form-group col-md-3">
                <label for="fornecedor">Status da Ligação</label>
                <input type="text" class="form-control mr-2" name="status_ligacao" value="<?php echo $status_ligacao ?>" style="text-transform:uppercase;" readonly>
              </div>

              <div class="form-group col-md-9">
                <label for="fornecedor">Observações</label>
                <input type="text" class="form-control mr-2" name="observacoes" placeholder="Observações" value="<?php echo $observacoes_text ?>" style="text-transform:uppercase;">
              </div>

            </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="editar">Salvar </button>


          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
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

      </div>
    </div>
  </div>


<?php


  if (isset($_POST['editar'])) {
    $tipo_juridico = mb_strtoupper($_POST['tipo_juridico']);
    $nome_razao_social = mb_strtoupper($_POST['nome_razao_social']);
    $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
    $numero_rg = mb_strtoupper($_POST['numero_rg']);
    $orgao_emissor_rg = mb_strtoupper($_POST['orgao_emissor_rg']);
    $uf_rg = mb_strtoupper($_POST['uf_rg']);
    $fone_fixo = $_POST['fone_fixo'];
    $fone_movel = $_POST['fone_movel'];
    $fone_zap = $_POST['fone_zap'];
    $email = $_POST['email'];
    $tipo_consumo = $_POST['tipo_consumo']; //ver
    $faixa_consumo = $_POST['faixa_consumo'];
    $tipo_medicao = $_POST['tipo_medicao'];
    $id_unidade_hidrometrica = $_POST['id_unidade_hidrometrica'];
    $observacoes = mb_strtoupper($_POST['observacoes']);
    $id_usuario_editor = $_SESSION['id_usuario'];

    //tratamento para numero_cpf_cnpj
    $ncc = str_replace("/", "", $numero_cpf_cnpj);
    $ncc2 = str_replace(".", "", $ncc);
    $ncc3 = str_replace("-", "", $ncc2);

    //tratamento para telefone
    $tel = preg_replace("/[^0-9]/", "", $fone_fixo);

    //tratamento para celular
    $cel = preg_replace("/[^0-9]/", "", $fone_movel);

    //echo $tipo_juridico . ', ' . $ncc3 . ', ' . $nome_razao_social . ', ' . $numero_rg . ', ' . $orgao_emissor_rg . ', ' . $uf_rg . ', ' . $tel . ', ' . $cel . ', ' . $fone_zap . ', ' . $email . ', ' . $tipo_consumo . ', ' . $faixa_consumo . ', ' . $tipo_medicao . ', ' . $id_unidade_hidrometrica . ', ' . $observacoes . ', ' . $id_usuario_editor . ', ' . $id;


    $query_consum = "UPDATE unidade_consumidora set tipo_juridico = '$tipo_juridico', numero_cpf_cnpj = '$ncc3', nome_razao_social = '$nome_razao_social', numero_rg = '$numero_rg', orgao_emissor_rg = '$orgao_emissor_rg', uf_rg = '$uf_rg', fone_fixo = '$tel', fone_movel = '$cel', fone_zap = '$fone_zap', email = '$email', tipo_consumo = '$tipo_consumo', faixa_consumo = '$faixa_consumo', tipo_medicao = '$tipo_medicao', id_unidade_hidrometrica = '$id_unidade_hidrometrica', observacoes = '$observacoes', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$id'";

    $result_consum = mysqli_query($conexao, $query_consum);

    if ($result_consum == '') {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
    } else {

      $query_mensagem = "UPDATE requerimento set mensagem = '', status_requerimento = 'D' where id_requerimento = '$id_requerimento'";
      mysqli_query($conexao, $query_mensagem);

      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
    }
  }
}

?>


<!--EDITAR/VISUALIZAR ENDEREÇAMENTO -->

<?php
if (@$_GET['func'] == 'edita2') {
  $id              = $_GET['id'];
  $id_requerimento = $_GET['rec'];
  $localidade      = $_GET['id_localidade'];

  //executa o store procedure info consumidor
  $result_sp3 = mysqli_query(
    $conexao,
    "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
  mysqli_next_result($conexao);
  $row_uc = mysqli_fetch_array($result_sp3);
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
  $id_localidade            = $row_uc['LOC'];
  $id_bairro                = $row_uc['BAIR'];
  $id_logradouro            = $row_uc['LOG'];





?>

  <!-- Modal Editar2 -->
  <div id="modalEdita2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h3 class="modal-title">Endereçamento</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">


            <h5 class="modal-title">Endereço de instalação</h5>
            <hr>
            <div id="instal" class="row">

              <div class="form-group col-md-2">
                <label for="id_produto">UC</label>
                <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id ?>" style="text-transform:uppercase;" readonly>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Localidade</label>
                <input type="text" class="form-control mr-2" name="nome_localidade" value="<?php echo $nome_localidade ?>" style="text-transform:uppercase;" readonly>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Bairro</label>
                <input type="text" class="form-control mr-2" name="nome_bairro" value="<?php echo $nome_bairro ?>" style="text-transform:uppercase;" readonly>
              </div>

              <div class="form-group col-md-4">
                <label for="fornecedor">Logradouro</label>

                <select class="form-control mr-2" id="category" name="id_logradouro">

                  <option value="<?php echo $id_logradouro; ?>"><?php echo $nome_logradouro; ?></option>

                  <?php

                  //executa o store procedure info consumidor
                  $result_sp_log = mysqli_query(
                    $conexao,
                    "CALL sp_lista_logradouros($id_localidade,$id_bairro);"
                  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
                  mysqli_next_result($conexao);

                  while ($res = mysqli_fetch_array($result_sp_log)) {

                  ?>

                    <?php

                    //condição para mostrar o option para não se repetir o nome que já esta
                    if ($nome_logradouro != $res['NOME DO LOGRADOURO']) { ?>

                      <option value="<?php echo $res['LOG']; ?>"><?php echo $res['NOME DO LOGRADOURO']; ?></option>

                  <?php
                    }
                  }

                  ?>

                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">CEP</label>
                <input type="text" class="form-control mr-2" name="cep_logradouro" value="<?php echo $cep_logradouro ?>" style="text-transform:uppercase;" readonly>
              </div>

              <div class="form-group col-md-3">
                <label for="id_produto">Nº Logradouro</label>
                <input type="text" class="form-control mr-2" name="numero_logradouro" value="<?php echo $numero_logradouro ?>" placeholder="Nº" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-5">
                <label for="id_produto">Complemento</label>
                <input type="text" class="form-control mr-2" name="complemento_logradouro" value="<?php echo $complemento_logradouro ?>" placeholder="Complemento" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-5">
                <label for="fornecedor">Indicação para Correspondência</label>
                <select class="form-control mr-2" id="tipo_enderecamento_e" name="tipo_enderecamento_e" style="text-transform:uppercase;" disabled>

                  <option value="I" <?php if ($tipo_enderecamento == 'IMÓVEL') { ?> selected <?php } ?>>Endereço de Instalação</option>
                  <option value="L" <?php if ($tipo_enderecamento == 'LOCAL') { ?> selected <?php } ?>>Correspondência Local</option>
                  <option value="E" <?php if ($tipo_enderecamento == 'EXTERNO') { ?> selected <?php } ?>>Correspondência Externa</option>


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
    // recuperação p/ upgrade endereço de instalação
    $id_logradouro = mb_strtoupper($_POST['id_logradouro']);
    $numero_logradouro = mb_strtoupper($_POST['numero_logradouro']);
    $complemento_logradouro = mb_strtoupper($_POST['complemento_logradouro']);

    // upgrade endereço de instalação
    $query = "UPDATE endereco_instalacao SET id_logradouro = '$id_logradouro', numero_logradouro = '$numero_logradouro', complemento_logradouro = '$complemento_logradouro' where id_unidade_consumidora = '$id' ";

    $result = mysqli_query($conexao, $query);


    // upgrade correspondencia local
    // if ($tipo_enderecamento == 'L') {
    //  $query_lo = "UPDATE alunos SET id_localidade = $id_localidade2, id_bairro = $id_bairro2, id_logradouro = $id_logradouro2, numero_logradouro = $numero_logradouro2, complemento_logradouro = $complemento_logradouro where id_unidade_consumidora = '$id' ";

    // $result_lo = mysqli_query($conexao, $query_lo);
    // }

    // upgrade correspondencia externa
    // if ($tipo_enderecamento == 'E') {
    //  $query_ex = "UPDATE alunos SET nome_cidade = $nome_cidade_ex, nome_bairro = $nome_bairro_ex, nome_logradouro = $nome_logradouro_ex, tipo_logradouro = $tipo_logradouro_ex, numero_logradouro = $numero_logradouro_ex, complemento_logradouro = $complemento_logradouro_ex, cep_logradouro = $cep_logradouro_ex, uf_logradouro = $uf_logradouro_ex where id_unidade_consumidora = '$id' ";

    // $result_ex = mysqli_query($conexao, $query_ex);
    // }


    if ($result == '') {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
    } else {

      $query_mensagem = "UPDATE requerimento set mensagem = '', status_requerimento = 'D' where id_requerimento = '$id_requerimento'";
      mysqli_query($conexao, $query_mensagem);

      echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
    }
  }
}

?>





<!--STATUS DO USUÁRIO-->

<!--ATIVAR O USUÁRIO-->
<?php if (@$_GET['func'] == 'ativa') {
  $id = $_GET['id'];

  $sql = "UPDATE unidade_consumidora SET status_ligacao = 'A' WHERE id_unidade_consumidora = '$id'";
  mysqli_query($conexao, $sql);

  $query_mensagem = "UPDATE requerimento set mensagem = '', status_requerimento = 'D' where id_requerimento = '$id_requerimento'";
  mysqli_query($conexao, $query_mensagem);

  echo "<script language='javascript'>window.alert('Ativado Sucesso!'); </script>";
  echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
} ?>



<!--INATIVAR O USUÁRIO-->
<?php if (@$_GET['func'] == 'inativa') {
  $id = $_GET['id'];

  $sql = "UPDATE unidade_consumidora SET status_ligacao = 'I' WHERE id_unidade_consumidora = '$id'";
  mysqli_query($conexao, $sql);

  $query_mensagem = "UPDATE requerimento set mensagem = '', status_requerimento = 'D' where id_requerimento = '$id_requerimento'";
  mysqli_query($conexao, $query_mensagem);


  echo "<script language='javascript'>window.alert('Inativado com Sucesso!'); </script>";
  echo "<script language='javascript'>window.location='admin.php?acao=requerimento'; </script>";
} ?>



<script>
  $("#modalEditar").modal("show");
</script>
<script>
  $("#modalEndereco").modal("show");
</script>
<script>
  $("#modalEdita2").modal("show");
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
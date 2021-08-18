<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0' && $_SESSION['nivel_usuario'] != '77') {
  header('Location: ../login.php');
  exit();
}

?>


<div class="container">
  <div class="row">

    <div class="col-lg-6 col-md-6" style="margin-left: 3%;">
      <h3>CONSUMIDOR</h3>
    </div>

    <div class="pesquisar col-lg-5 col-md-6 col-sm-12" style="margin-left: 5%;">
      <form class="form-inline my-2 my-lg-0">
        <input name="txtpesquisarConsumidores" class="form-control mr-sm-2" type="search" placeholder="Pesquisar Consumidores" aria-label="Pesquisar">
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

              <!--LISTAR TODOS AS LOCALIDADES -->
              <?php
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




                <table class="table table-sm">
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
                      $id_localidade = $res["id_localidade"];

                      $data2 = implode('/', array_reverse(explode('-', $data_cadastro)));

                    ?>

                      <tr>

                        <td class="text-danger"><?php echo $id; ?></td>

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
                          <a class="btn btn-info btn-sm" title="Ver Consumidor" href="atendimento.php?acao=consumidores&func=editar&id=<?php echo $id; ?>&id_localidade=<?php echo $id_localidade; ?>"><i class="fas fa-user-friends"></i></a>

                          <a class="btn btn-info btn-sm" title="Ver Endereçamento" href="atendimento.php?acao=consumidores&func=edita2&id=<?php echo $id; ?>&id_localidade=<?php echo $id_localidade; ?>"><i class="fas fa-list-alt"></i></a>


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




    <!--VER -->
    <?php
    if (@$_GET['func'] == 'editar') {
      $id = $_GET['id'];
      $localidade = $_GET['id_localidade'];

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
                    <select class="form-control mr-2" id="category" name="tipo_juridico" style="text-transform:uppercase;" disabled>
                      <option value="" <?php if ($tipo_juridico == '') { ?> selected <?php } ?>>selecione</option>
                      <option value="J" <?php if ($tipo_juridico == 'PESSOA JURÍDICA') { ?> selected <?php } ?>>Jurídica</option>
                      <option value="P" <?php if ($tipo_juridico == 'PESSOA FÍSICA') { ?> selected <?php } ?>>Física</option>

                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">CPF/CNPJ</label>
                    <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj" value="<?php echo $numero_cpf_cnpj ?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="id_produto">Nome/Razão Social</label>
                    <input type="text" class="form-control mr-2" name="nome_razao_social" placeholder="Nome/Razão Social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-2">
                    <label for="id_produto">RG</label>
                    <input type="text" class="form-control mr-2" name="numero_rg" placeholder="RG" value="<?php echo $numero_rg ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-2">
                    <label for="id_produto">Orgão Emissor</label>
                    <input type="text" class="form-control mr-2" name="orgao_emissor_rg" placeholder="Orgão Emissor" style="text-transform:uppercase;" value="<?php echo $orgao_emissor_rg ?>" readonly>
                  </div>

                  <div class="form-group col-md-2">
                    <label for="fornecedor">UF RG</label>
                    <select class="form-control mr-2" id="category" name="uf_rg" style="text-transform:uppercase;" disabled>

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
                    <input type="text" class="form-control mr-2" name="fone_fixo" id="fone" value="<?php echo $fone_fixo ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Celular</label>
                    <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" value="<?php echo $fone_movel ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-2">
                    <label for="fornecedor">WhatsApp</label>
                    <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;" disabled>

                      <option value="" <?php if ($fone_zap == '') { ?> selected <?php } ?>>SELECIONE</option>
                      <option value="S" <?php if ($fone_zap == 'SIM') { ?> selected <?php } ?>>SIM</option>
                      <option value="N" <?php if ($fone_zap == 'NÃO') { ?> selected <?php } ?>>NÃO</option>

                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">E-mail</label>
                    <input type="email" class="form-control mr-2" name="email" placeholder="E-mail" value="<?php echo $email ?>" readonly>
                  </div>

                </div>

                <h5 class="modal-title">Dados de Faturamento</h5>
                <hr>
                <div class="row">

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Tipo de Consumo</label>
                    <select class="form-control mr-2" id="category" name="tipo_consumo" style="text-transform:uppercase;" disabled>

                      <option value="" <?php if ($tipo_consumo == '') { ?> selected <?php } ?>>SELECIONE</option>
                      <option value="01" <?php if ($tipo_consumo == 'RESIDENCIAL') { ?> selected <?php } ?>>RESIDENCIAL</option>
                      <option value="02" <?php if ($tipo_consumo == 'COMERCIAL') { ?> selected <?php } ?>>COMERCIAL</option>
                      <option value="03" <?php if ($tipo_consumo == 'INDUSTRIAL') { ?> selected <?php } ?>>INDUSTRIAL</option>
                      <option value="04" <?php if ($tipo_consumo == 'PUBLICA') { ?> selected <?php } ?>>PÚBLICA</option>

                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Faixa de Consumo</label>
                    <select class="form-control mr-2" id="category" name="faixa_consumo" style="text-transform:uppercase;" disabled>

                      <option value="" <?php if ($faixa_consumo == '') { ?> selected <?php } ?>>SELECIONE</option>
                      <option value="01" <?php if ($faixa_consumo == '01') { ?> selected <?php } ?>>01</option>
                      <option value="02" <?php if ($faixa_consumo == '02') { ?> selected <?php } ?>>02</option>
                      <option value="03" <?php if ($faixa_consumo == '03') { ?> selected <?php } ?>>03</option>
                      <option value="04" <?php if ($faixa_consumo == '04') { ?> selected <?php } ?>>04</option>

                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Tipo de Medição</label>
                    <select class="form-control mr-2" id="category" name="tipo_medicao" style="text-transform:uppercase;" disabled>

                      <option value="" <?php if ($tipo_medicao == '') { ?> selected <?php } ?>>SELECIONE</option>
                      <option value="E" <?php if ($tipo_medicao == 'ESTIMADA') { ?> selected <?php } ?>>ESTIMADA</option>
                      <option value="M" <?php if ($tipo_medicao == 'HIDROMETRADA') { ?> selected <?php } ?>>HIDROMETRADA</option>

                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Unidade Hidrométrica</label>
                    <input type="text" class="form-control mr-2" name="id_unidade_hidrometrica" placeholder="U.H." value="<?php echo $id_unidade_hidrometrica ?>" style="text-transform:uppercase;" readonly>
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
                    <input type="text" class="form-control mr-2" name="observacoes" placeholder="Observações" value="<?php echo $observacoes_text ?>" style="text-transform:uppercase;" readonly>
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


    <?php

    }

    ?>




    <!--VISUALIZAR ENDEREÇAMENTO -->

    <?php
    if (@$_GET['func'] == 'edita2') {
      $id = $_GET['id'];

      $localidade = $_GET['id_localidade'];

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

                  <div class="form-group col-md-4">
                    <label for="id_produto">Localidade</label>
                    <input type="text" class="form-control mr-2" name="nome_localidade" value="<?php echo $nome_localidade ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto">Bairro</label>
                    <input type="text" class="form-control mr-2" name="nome_bairro" value="<?php echo $nome_bairro ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="id_produto">Logradouro</label>
                    <input type="text" class="form-control mr-2" name="nome_logradouro" value="<?php echo $nome_logradouro ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">CEP</label>
                    <input type="text" class="form-control mr-2" name="cep_logradouro" value="<?php echo $cep_logradouro ?>" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Nº Logradouro</label>
                    <input type="text" class="form-control mr-2" name="numero_logradouro" value="<?php echo $numero_logradouro ?>" placeholder="Nº" style="text-transform:uppercase;" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="id_produto">Complemento</label>
                    <input type="text" class="form-control mr-2" name="complemento_logradouro" value="<?php echo $complemento_logradouro ?>" placeholder="Complemento" style="text-transform:uppercase;" readonly>
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



                <!-- PARTE LOCAL -->

                <hr>

                <div id="local_e" class="row" style="display: none;">

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Bairro</label>

                    <select class="form-control mr-2" id="category" name="id_bairro2">

                      <option value="<?php echo $id_bairro2; ?>"><?php echo $nome_ba; ?></option>

                      <?php

                      $query = "select * from enderecamento_bairro where id_localidade = '$id_localidade2' order by nome_bairro asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {

                      ?>

                        <?php

                        //condição para mostrar o option para não se repetir o nome que já esta
                        if ($nome_ba2 != $res['nome_bairro']) { ?>

                          <option value="<?php echo $res['id_bairro']; ?>"><?php echo $res['nome_bairro']; ?></option>

                      <?php
                        }
                      }

                      ?>

                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Logradouro</label>

                    <select class="form-control mr-2" id="category" name="id_logradouro2">

                      <option value="<?php echo $id_logradouro2; ?>"><?php echo $nome_log; ?></option>

                      <?php

                      $query = "select * from enderecamento_logradouro where id_bairro = '$id_bairro2' order by nome_logradouro asc";
                      $result = mysqli_query($conexao, $query);

                      while ($res = mysqli_fetch_array($result)) {

                      ?>

                        <?php

                        //condição para mostrar o option para não se repetir o nome que já esta
                        if ($nome_log2 != $res['nome_logradouro']) { ?>

                          <option value="<?php echo $res['id_logradouro']; ?>"><?php echo $res['nome_logradouro']; ?></option>

                      <?php
                        }
                      }

                      ?>

                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">Nº Logradouro</label>
                    <input type="text" class="form-control mr-2" name="numero_logradouro2" value="<?php echo $numero_logradouro2; ?>" placeholder="Nº" style="text-transform:uppercase;">
                  </div>

                  <div class="form-group col-md-8">
                    <label for="id_produto">Complemento</label>
                    <input type="text" class="form-control mr-2" name="complemento_logradouro2" value="<?php echo $complemento_logradouro2; ?>" placeholder="Complemento" style="text-transform:uppercase;">
                  </div>
                </div>



                <!-- PARTE EXTERNA -->

                <hr>
                <div id="externa_e" class="row" style="display: none;">

                  <div class="form-group col-md-4">
                    <label for="id_produto">Cidade</label>
                    <input type="text" class="form-control mr-2" name="nome_cidade_ex" value="<?php echo $nome_cidade_ex ?>" placeholder="Cidade" style="text-transform:uppercase;">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">Bairro</label>
                    <input type="text" class="form-control mr-2" name="nome_bairro_ex" placeholder="Bairro" value="<?php echo $nome_bairro_ex ?>" style="text-transform:uppercase;">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">Logradouro</label>
                    <input type="text" class="form-control mr-2" name="nome_logradouro_ex" value="<?php echo $nome_logradouro_ex ?>" placeholder="Logradouro" style="text-transform:uppercase;">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="fornecedor">Tipo Logradouro</label>

                    <select class="form-control mr-2" id="category" name="tipo_logradouro_ex">

                      <option value="<?php echo $tipo_logradouro_ex; ?>"><?php echo $nome_tl; ?></option>

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

                  <div class="form-group col-md-2">
                    <label for="id_produto">Número</label>
                    <input type="text" class="form-control mr-2" name="numero_logradouro_ex" value="<?php echo $numero_logradouro_ex; ?>" placeholder="Número" style="text-transform:uppercase;">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="id_produto">Complemento</label>
                    <input type="text" class="form-control mr-2" name="complemento_logradouro_ex" value="<?php echo $complemento_logradouro_ex; ?>" placeholder="Complemento" style="text-transform:uppercase;">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="id_produto">CEP</label>
                    <input type="text" class="form-control mr-2" name="cep_logradouro_ex" value="<?php echo $cep_logradouro_ex; ?>" placeholder="CEP">
                  </div>

                  <div class="form-group col-md-2">
                    <label for="fornecedor">UF</label>
                    <select class="form-control mr-2" id="uf_logradouro_ex" name="uf_logradouro_ex" style="text-transform:uppercase;">

                      <option value="PA" <?php if ($uf_logradouro_ex == 'PA') { ?> selected <?php } ?>>PA</option>
                      <option value="MA" <?php if ($uf_logradouro_ex == 'MA') { ?> selected <?php } ?>>MA</option>
                      <option value="AP" <?php if ($uf_logradouro_ex == 'AP') { ?> selected <?php } ?>>AP</option>

                    </select>
                  </div>
                </div>


                <div class="modal-footer">
                  <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair</button>
              </form>
            </div>
          </div>
        </div>
      </div>


    <?php

    }

    ?>





    <!--STATUS DO USUÁRIO-->

    <!--ATIVAR O USUÁRIO-->
    <?php if (@$_GET['func'] == 'ativa') {
      $id = $_GET['id'];
      $sql = "UPDATE consumidores SET status_ligacao = 'A' WHERE id = '$id'";
      mysqli_query($conexao, $sql);

      echo "<script language='javascript'>window.alert('Ativado Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='atendimento.php?acao=consumidores'; </script>";
    } ?>




    <!--INATIVAR O USUÁRIO-->
    <?php if (@$_GET['func'] == 'inativa') {
      $id = $_GET['id'];
      $sql = "UPDATE consumidores SET status_ligacao = 'I' WHERE id = '$id'";
      mysqli_query($conexao, $sql);

      echo "<script language='javascript'>window.alert('Inativado com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='atendimento.php?acao=consumidores'; </script>";
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


    <script type="text/javascript">
      $(document).ready(function() {
        $('#cell').mask('(00) 00000-0000');
        $('#zap').mask('(00) 00000-0000');
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
      $("td[id*='cel']").inputmask({
        mask: ['(99) 99999-9999'],
        keepStatic: true
      });
    </script>
<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

function calculaValor($valor)
{
  $valor = $valor * 2 / 100;
  return $valor;
}


function decimal($t_valor)
{
  $float_arredondar = round($t_valor * 100) / 100;
  return $float_arredondar;
}

function calculaDias($data_final, $data_inicial, $fatura)
{
  // Calcula a diferença em segundos entre as datas
  $diferenca = strtotime($data_final) - strtotime($data_inicial);

  //Calcula a diferença em dias
  $dias = floor($diferenca / (60 * 60 * 24)) * 0.0033333333333333 * $fatura - 0.12;
  $dias = decimal($dias);
  return $dias;
}
?>

<?php

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>




<h3>BAIXA MANUAL DE FATURAS</h3>

<form method="" action="">
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

    <div class="form-group col-md-3">
      <label for="id_produto">Matrícula</label>
      <input type="text" class="form-control mr-2" name="id_unidade_consumidora" placeholder="Matrícula" required>
    </div>

    <div class="form-group col-md-3">
      <label for="id_produto">Competência</label>
      <input type="text" class="form-control mr-2" id="mes" name="mes_faturado" placeholder=" Mês Faturado" required>
    </div>

    <div class="form-group col-md-2" style="margin-top: 28px;">
      <button type="button" class="btn btn-success mb-3" id="buscar" name="buscar">Buscar </button>
    </div>

  </div>

</form>

<div class="form-group" id="dados"></div>



<!-- EXIBIÇÃO PERFIL -->
<?php
if (@$_GET['func'] == 'perfil') {
  $id         = $_GET['id'];
  $localidade = $_GET['id_localidade'];

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
            <a class="btn btn-info" target="_blank" href="rel_perfil.php?func=imprime&id=<?php echo $id; ?>">Imprimir</a>
          </div>
          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Sair </button>
          </form>

        </div>
      </div>
    </div>
  </div>

<?php } ?>




<!--baixa -->
<?php
if (@$_GET['func'] == 'baixa') {

  $id           = $_GET['id'];
  $mes_faturado = $_GET['mes_faturado'];

  $query = "select * from historico_financeiro where id_unidade_consumidora = '$id' AND mes_faturado = '$mes_faturado' ";
  $result = mysqli_query($conexao, $query);

  while ($res = mysqli_fetch_array($result)) {

    $data_vencimento_fatura = $res["data_vencimento_fatura"];
    $data_vencimento_fatura2 = date("d/m/Y", strtotime($data_vencimento_fatura));
    $total_geral_faturado = $res["total_geral_faturado"];
    $mes_faturado = $res["mes_faturado"];
    $id_localidade = $res["id_localidade"];
    $id_usuario_editor = $_SESSION['id_usuario'];

    $rData = explode("/", $mes_faturado);
    $rData = $rData[1] . '/' . $rData[0];


?>

    <!-- Modal baixa -->
    <div id="modalEditar" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">

            <h5 class="modal-title">Finalizar Baixa Manual</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">

              <div class="row">

                <div class="form-group col-md-3">
                  <label for="id_produto">Competência</label>
                  <input type="text" class="form-control mr-2" name="mes_faturado" value="<?php echo $rData ?>" required>
                </div>

                <div class="form-group col-md-3">
                  <label for="id_produto">Data de Vencimento</label>
                  <input type="text" class="form-control mr-2" name="data_vencimento_fatura" value="<?php echo $data_vencimento_fatura2 ?>" required>
                </div>

                <div class="form-group col-md-3">
                  <label for="id_produto">Total Faturado</label>
                  <input type="text" class="form-control mr-2" name="total_geral_faturado" value="<?php echo $total_geral_faturado ?>" required>
                </div>

              </div>

              <div class="row">

                <div class="form-group col-md-4">
                  <label for="id_produto">Data de Pagamento da Fatura</label>
                  <input type="date" class="form-control mr-2" name="data_pagamento_fatura" required>
                </div>

                <div class="form-group col-md-3">
                  <label for="fornecedor">Arrecadador</label>

                  <select class="form-control mr-2" id="category" name="id_banco_arrecadador">

                    <?php

                    //recuperando dados da tabela bancos para o select
                    $query = "select * from banco_arrecadador order by nome_banco asc";
                    $result = mysqli_query($conexao, $query);
                    while ($res = mysqli_fetch_array($result)) {

                    ?>
                      <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
                      <option value="<?php echo $res['id_banco'] ?>"><?php echo $res['nome_banco'] ?></option>

                    <?php
                    }
                    ?>

                  </select>
                </div>

                <div class="form-group col-md-3">
                  <label for="id_produto">Número do Documento</label>
                  <input type="text" class="form-control mr-2" name="id_sequencial_documento" placeholder="N° Boleto" required>
                </div>

              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-success mb-3" name="editar">Quitar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
            </form>
          </div>
        </div>
      </div>
    </div>


<?php


    if (isset($_POST['editar'])) {

      $data_pagamento_fatura = $_POST['data_pagamento_fatura'];
      $id_banco_arrecadador = $_POST['id_banco_arrecadador'];
      $id_sequencial_documento = $_POST['id_sequencial_documento'];

      $mes_gerador = date("Y/m");
      $mes_lancamento = date('Y/m', strtotime('+30 days'));

      echo $data_pagamento_fatura . ', ' . $total_geral_faturado . ', ' . $id_banco_arrecadador . ', ' . $id_sequencial_documento . ', ' . $id_usuario_editor;

      //baixa na tabela de historico_financeiro
      $query = "UPDATE historico_financeiro SET data_pagamento_fatura = '$data_pagamento_fatura', total_pagamento_fatura = '$total_geral_faturado', id_banco_arrecadador = '$id_banco_arrecadador', id_sequencial_arquivo = '$id_sequencial_documento', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$id' AND mes_faturado = '$mes_faturado' ";
      $result = mysqli_query($conexao, $query);

      //inserção na tabela de baixa_provisoria_arrecadacao
      $query_bpa = "INSERT INTO baixa_provisoria_arrecadacao (id_unidade_consumidora, mes_faturado, id_banco_arrecadador, data_pagamento_fatura, valor_pagamento_fatura, id_usuario_editor_registro) values ('$id', '$mes_faturado', '$id_banco_arrecadador', '$data_pagamento_fatura', '$total_geral_faturado', '$id_usuario_editor')";
      $result_bpa = mysqli_query($conexao, $query_bpa);


      // apenas de a data de pagamento for mair que o vencimento
      //if ($data_pagamento_fatura > $data_vencimento_fatura) {
      //inserindo multas
      //$query_in_multa = "INSERT INTO multa_faturada (id_usuario_editor, id_localidade, id_unidade_consumidora, mes_lancamento_multa, mes_gerador_multa, data_lancamento_multa, valor_lancamento_multa) values ('$id_usuario_editor', '$id_localidade', '$id', '$mes_lancamento', '$mes_gerador', curDate(), '" . calculaValor($total_geral_faturado) . "')";
      //$result_in_multa = mysqli_query($conexao, $query_in_multa);

      //inserindo juros
      //$query_in_juros = "INSERT INTO juros_faturados (id_usuario_editor, id_localidade, id_unidade_consumidora, mes_lancamento_juros, mes_gerador_juros, data_lancamento_juros, valor_lancamento_juros) values ('$id_usuario_editor', '$id_localidade', '$id', '$mes_lancamento', '$mes_gerador', curDate(), '" . calculaDias($data_pagamento_fatura, $data_vencimento_fatura, $total_geral_faturado) . "')";
      //$result_in_juros = mysqli_query($conexao, $query_in_juros);
      //}

      if ($result == '') {
        echo "<script language='javascript'>window.alert('Ocorreu um erro ao faturar, favor verificar os dados informados!'); </script>";
      } else {
        echo "<script language='javascript'>window.alert('Baixa Realizada com Sucesso!'); </script>";
        echo "<script language='javascript'>window.location='admin.php?acao=baixa'; </script>";
      }
    }
  }
}

?>


<script>
  $("#buscar").click(function() {
    $.ajax({
      url: "baixa.php ",
      type: "POST",
      data: ({
        id_unidade_consumidora: $("input[name='id_unidade_consumidora']").val(),
        mes_faturado: $("input[name='mes_faturado']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados').html(resposta);
      }

    });
  });
</script>

<script>
  $("#modalPerfil").modal("show");
</script>
<script>
  $("#modalEditar").modal("show");
</script>


<!--MASCARAS -->
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
  $("input[id*='mes']").inputmask({
    mask: ['99/9999'],
    keepStatic: true
  });
</script>
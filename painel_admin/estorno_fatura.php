<?php
//inlimitando memoria usada pelo script
ini_set('memory_limit', '-1');
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>


<div class="modal-body" style="margin-top: -50px;">
  <form method="POST" action="">
    <h5 class="modal-title">Estorno e Faturamento</h5>

    <hr>
    <div class="row">

      <!-- CONSULTA POR Matrícula-->
      <div id="uc" name="uc">
        <div class="row">

          <div class="form-group col-md-4">
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

          <div class="form-group col-md-2">
            <label for="id_produto">Matrícula</label>
            <input type="text" class="form-control mr-3" minlength="2" name="id_unidade_consumidora" placeholder="UC" required>
          </div>

          <div class="form-group col-md-3">
            <label for="fornecedor">Ação</label>
            <select class="form-control mr-2" id="acao" name="acao" style="text-transform:uppercase;">

              <option value="">Selecione</option>
              <option value="E">Estornar</option>
              <option value="F">Faturar</option>

            </select>
          </div>

          <div class="form-group col-md-3" style="margin-top: 35px;">
            <button class="btn btn-outline-info" name="iniciar"> <i class="fas fa-file-invoice-dollar"> INICIAR </i> </button>
          </div>

        </div>

      </div>
      <div class="form-group" id="dados3" style="margin-left: -25px;"></div>

    </div>

    <div class="modal-footer">


  </form>
</div>

<script>
  $("#buscar3").click(function() {
    $.ajax({
      url: "resultado6.php ",
      type: "POST",
      data: ({
        id_unidade_consumidora: $("input[name='id_unidade_consumidora']").val(),
        slStatus3: $("select[name='slStatus3']").val()
      }), //estamos enviando o valor do input
      success: function(resposta) {
        $('#dados3').html(resposta);
      }

    });
  });
</script>



<?php
if (isset($_POST['iniciar'])) {
  $uc = $_POST['id_unidade_consumidora'];
  $acao = $_POST['acao'];
  $id_localidade = $_POST['id_localidade'];

  echo "<script language='javascript'>window.location='admin.php?acao=faturando&func=iniciar&id=$uc&iniciar=$acao&id_localidade=$id_localidade'; </script>";
}
?>



<!--INICIAR -->
<?php
if (@$_GET['func'] == 'iniciar') {
  $id         = $_GET['id'];
  $iniciar    = $_GET['iniciar'];
  $localidade = $_GET['id_localidade'];

  //executa o store procedure info consumidor
  $result_sp = mysqli_query(
    $conexao,
    "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
  ) or die("Erro na query da procedure: " . mysqli_error($conexao));
  mysqli_next_result($conexao);
  $row_uc = mysqli_fetch_array($result_sp);
  $uc                       = $row_uc['UC'];
  $nome_razao_social        = $row_uc['NOME'];
  $numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
  $nome_bairro              = $row_uc['BAIRRO'];
  $nome_logradouro          = $row_uc['LOGRADOURO'];
  $numero_logradouro        = $row_uc['NUMERO'];
  $status_ligacao           = $row_uc['STATUS'];
  $tipo_consumo             = $row_uc['TIPO_CONSUMO'];
  $faixa_consumo            = $row_uc['FAIXA'];
  $valor_faixa_consumo      = $row_uc['VALOR'];

?>

  <!-- MODAL DATAS 01 -->
  <div id="modalExemplo" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title"><?php if ($iniciar == 'E') {
                                    echo "Estorno";
                                  } else {
                                    echo 'Faturamento';
                                  } ?></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">

            <div class="form-group">
              <label for="id_produto">Nome</label>
              <input type="text" class="form-control mr-2" name="nome" value="<?php echo $nome_razao_social ?>" readonly>
            </div>

            <div class="form-group">
              <label for="id_produto">CPF</label>
              <input type="text" class="form-control mr-2" name="cpf" id="cpf" value="<?php echo $numero_cpf_cnpj ?>" readonly>
            </div>

            <div class="form-group">
              <label for="id_produto">Status da Ligação</label>
              <input type="text" class="form-control mr-2" name="status" value="<?php echo $status_ligacao ?>" readonly>
            </div>

            <p style="font-size: 12pt; margin-bottom: -12px;"> <b> Selecione abaixo os meses para <?php if ($iniciar == 'E') {
                                                                                                    echo "estorno";
                                                                                                  } else {
                                                                                                    echo 'faturamento';
                                                                                                  } ?>: </b> </p>
            <hr>

            <div class="row">

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="01"> Jan
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="02"> Fev
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="03"> Mar
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="04"> Abr
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="05"> Mai
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="06"> Jun
              </div>

            </div>

            <div class="row">

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="07"> Jul
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="08"> Ago
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="09"> Set
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="10"> Out
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="11"> Nov
              </div>

              <div class="form-group col-md-2">
                <input class="lista" type="checkbox" name="fatura[]" value="12"> Dez
              </div>

            </div>




        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="salvar">Processar </button>


          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php

  if (isset($_POST['salvar'])) {

    $fatura = $_POST['fatura'];

    $valor_consumo     = substr($valor_faixa_consumo, 3);
    $valor_consumo     = str_replace(',', '.', $valor_consumo);
    $mes_gerador       = date("Y-m-d");
    //$vencimento        = date('Y-m-d', strtotime('+30 days'));
    //$corte             = date('Y-m-d', strtotime('+40 days'));
    $id_usuario_editor = $_SESSION['id_usuario'];

    if ($tipo_consumo == 'RESIDENCIAL') {
      $tipo = 'total_tarifa_residencial';
    } elseif ($tipo_consumo == 'COMERCIAL') {
      $tipo = 'total_tarifa_comercial';
    } elseif ($tipo_consumo == 'INDUSTRIAL') {
      $tipo = 'total_tarifa_industrial';
    } elseif ($tipo_consumo == 'PÚBLICA') {
      $tipo = 'total_tarifa_publica';
    }

    foreach ($fatura as $value) {

      //vencimento e corte
      $Y = date('Y');
      $m = $value + 1;
      $m2 = $value + 1;
      if ($m2 == '13') {
        $me = '01';
        @$Ye = $Y + 1;
      } else {
        $me = $m;
        $Ye = $Y;
      }
      $d = date('d');
      $vencimento = $Ye . '-' . $me . '-' . $d;
      $d = $d + 10;
      if ($d > 20) {
        $dc = $d - 30;
      } else {
        $dc = $d;
      }
      $corte =  $Ye . '-' . $me . $dc;

      //fatura
      $ano = date('Y') . '/';
      $value = $ano . $value;

      //echo $localidade . ', ' . $uc . ', ' . $value . ', ' . $mes_gerador . ', ' . $vencimento . ', ' . $corte . ', ' . $valor_consumo . ', ' . $id_usuario_editor . '<br>';

      if ($iniciar == 'F') {

        //trazendo info financeiro devedor
        $query_hf = "SELECT * from historico_financeiro where id_unidade_consumidora = '$uc' and mes_faturado = '$value' and status_estorno_tarifa = 'S' ";
        $result_hf = mysqli_query($conexao, $query_hf);
        $linha = mysqli_num_rows($result_hf);

        if ($linha == 0) {
          $query = "INSERT INTO historico_financeiro (id_localidade, id_unidade_consumidora, mes_faturado, data_lancamento_fatura, data_vencimento_fatura, data_prevista_corte, $tipo, total_geral_tarifa, total_geral_faturado, id_usuario_editor_registro) values ('$localidade', '$uc', '$value', '$mes_gerador', '$vencimento', '$corte', '$valor_consumo', '$valor_consumo', '$valor_consumo', '$id_usuario_editor')";
          $result = mysqli_query($conexao, $query);
        } else {
          $query = "UPDATE historico_financeiro SET status_estorno_tarifa = 'N', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$uc' AND mes_faturado = '$value' ";
          $result = mysqli_query($conexao, $query);
        }
      } else {
        $query = "UPDATE historico_financeiro SET status_estorno_tarifa = 'S', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$uc' AND mes_faturado = '$value' ";
        $result = mysqli_query($conexao, $query);
      }
    }

    if ($result == '') {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao Processar, verifique se a fatuara selecionada já existe!'); </script>";
    } else {
      echo "<script language='javascript'>window.alert('Processado com Sucesso!'); </script>";
      echo "<script language='javascript'>window.location='admin.php?acao=faturando'; </script>";
    }
  }
} ?>


<script>
  $("#modalExemplo").modal("show");
</script>
<?php
//inlimitando memoria usada pelo script
ini_set('memory_limit', '-1');
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');


function finalDeSemana($aData)
{
  $dia = substr($aData, 8, 10);
  $mes = substr($aData, 5, 7);
  $ano = substr($aData, 0, 4);
  $date = date('w', mktime(0, 0, 0, $mes, $dia, $ano));



  if ($date == 6) :
    echo '6' . '<br>';
  elseif ($date == 0) :
    echo '7' . '<br>';
  else :
    echo 'Não é final de semana' . '<br>';
  endif;
}


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

      <!-- CONSULTA POR UNIDADE CONSUMIDORA-->
      <div id="uc" name="uc">
        <div class="row">

          <div class="form-group col-md-4">
            <label for="id_produto">Unidade Consumidora</label>
            <input type="text" class="form-control mr-3" minlength="2" name="id_unidade_consumidora" placeholder="UC" required>
          </div>

          <div class="form-group col-md-4">
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

  echo "<script language='javascript'>window.location='admin.php?acao=faturando&func=iniciar&id=$uc&iniciar=$acao'; </script>";
}
?>



<!--INICIAR -->
<?php
if (@$_GET['func'] == 'iniciar') {
  $id      = $_GET['id'];
  $iniciar = $_GET['iniciar'];

  $localidade = '01';

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

            <p style="font-size: 12pt; margin-bottom: -12px;"> <b> Selecione abaixo o ano e os meses para <?php if ($iniciar == 'E') {
                                                                                                            echo "estorno";
                                                                                                          } else {
                                                                                                            echo 'faturamento';
                                                                                                          } ?>: </b> </p>
            <hr>
            <div class="row">
              <div class="form-group col-md-5">
                <label for="id_produto">Selecione o ano:</label>
                <select name="ano" id="ano">
                  <?php
                  $anoInicio = intval(date('Y'));
                  for ($i = 0; $i < 10; $i++, $anoInicio--) {
                    echo '<option value="' . $anoInicio . '">' . $anoInicio . '</option>';
                  } ?>


                </select>
              </div>

              <div class="form-group col-md-4">
                Todos os Mêses <input type="checkbox" title="Selecionar Tudo" id="todos" name="all">
              </div>

            </div>

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

          <script>
            // função selecionat todos
            $(document).ready(function() {

              $('#todos').click(function() {
                var val = this.checked;
                //aler(val);
                $('.lista').each(function() {
                  $(this).prop('checked', val);

                });

              });

            });
          </script>

        </div>
      </div>
    </div>
  </div>

<?php

  if (isset($_POST['salvar'])) {

    $fatura = $_POST['fatura'];
    $select_ano = $_POST['ano'];
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

      //var_dump($value);

      //vencimento e corte
      $Y = $select_ano; //2021
      $m = $value + 1; //4
      $m2 = $value + 1; //4
      if ($m2 == 13) {
        $me = 01;
        $Ye = $Y + 1;
      } else {
        $me = $m; //4
        $Ye = $Y; //2021
      }
      $d = 05; //24
      $vencimento = $Ye . '-' . $me . '-' . $d;
      $d = $d + 10;
      if ($d > 20) {
        $dc = $d - 30;
      } else {
        $dc = $d;
      }
      $corte =  $Ye . '-' . $me . '-' . $dc;

      //vencimento e corte
      $Y = $select_ano; //2021
      $m = $value + 1; //4
      $m2 = $value + 1; //4
      if ($m2 == 13) {
        $me = 01;
        $Ye = $Y + 1;
      } else {
        $me = $m; //4
        $Ye = $Y; //2021
      }
      $d = 05; //24



      $vencimento = $Ye . '-' . str_pad($me, 2, '0', STR_PAD_LEFT) . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);

      $dia = substr($vencimento, 8, 10);
      $mes = substr($vencimento, 5, 7);
      $ano = substr($vencimento, 0, 4);
      $date = date('w', mktime(0, 0, 0, intval($mes), intval($dia), intval($ano)));

      if ($date == 6) {
        $vencimento = $Ye . '-' . $me . '-' . ($d + 2);
      } elseif ($date == 0) {
        $vencimento = $Ye . '-' . $me . '-' . ($d + 1);
      }


      $d = $d + 10;
      if ($d > 30) {
        $dc = $d - 30;
        $mec = $me + 1;
      } else {
        $dc = $d;
        $mec = $me;
      }

      if ($mec == 13) {
        $mec = 01;
        $Ye = $Y + 1;
      } else {
        $mec = $mec; //4
        $Ye = $Y; //2021
      }

      $corte =  $Ye . '-' . $mec . '-' . $dc;

      //fatura
      $ano = $select_ano . '/';
      $value = $ano . $value;

      //echo '<br>' . $localidade . ', ' . $uc . ', ' . $value . ', ' . $mes_gerador . ', ' . $vencimento . ', ' . $corte . ', ' . $valor_consumo . ', ' . $id_usuario_editor . ', ' . $date . '<br>';

      if ($iniciar == 'F') {

        //trazendo info financeiro devedor
        $query_hf = "SELECT * from historico_financeiro where id_unidade_consumidora = '$uc' and mes_faturado = '$value' and data_pagamento_fatura is null ";
        $result_hf = mysqli_query($conexao, $query_hf);
        $linha = mysqli_num_rows($result_hf);

        if ($linha == 0) {
          $query = "INSERT INTO historico_financeiro (id_localidade, id_unidade_consumidora, mes_faturado, data_lancamento_fatura, data_vencimento_fatura, data_prevista_corte, $tipo, total_geral_tarifa, total_geral_faturado, id_usuario_editor_registro) values ('$localidade', '$uc', '$value', '$mes_gerador', '$vencimento', '$corte', '$valor_consumo', '$valor_consumo', '$valor_consumo', '$id_usuario_editor')";
          $result = mysqli_query($conexao, $query);
        } else {
          $query = "UPDATE historico_financeiro SET total_geral_tarifa = '$valor_consumo', total_geral_faturado = '$valor_consumo', $tipo = '$valor_consumo', status_estorno_tarifa = 'N', id_usuario_editor_registro = '$id_usuario_editor' where id_unidade_consumidora = '$uc' AND mes_faturado = '$value' ";
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
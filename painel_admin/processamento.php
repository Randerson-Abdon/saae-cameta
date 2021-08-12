<bady>
  <?php
  @session_start();

  include_once('../conexao.php');


  if (isset($_POST['processar'])) {


    $uc              = $_POST['uc'];
    $mes_faturado    = $_POST['mes_faturado'];
    $dt_pagamento    = $_POST['dt_pagamento'];
    $data_vencimento = $_POST['data_vencimento'];
    $valor_fatura    = $_POST['valor_fatura'];
    $cabecalho       = $_POST['cabecalho'];
    $data            = $_POST['data'];

    $total_reg = $_POST['total_reg'];

    $dados              = $_SESSION['dados'];
    $nome_retorno       = $_SESSION['nome'];
    $rodape             = $_SESSION['rodape'];
    $id_usuario_editor  = $_SESSION['id_usuario'];

    $pasta_banco = $_POST['banco'];
    $pasta_data = substr($data, 4, 4) . '-' . substr($data, 2, 2);


    //echo $pasta_banco . ', ' . $pasta_data;

    $arquivo = "../include/ret_cameta/$nome_retorno.txt";

    $arquivo_destino = "../include/ret_cameta_processado/$pasta_banco/$pasta_data/$nome_retorno.txt";

    if (file_exists("../include/ret_cameta_processado/$pasta_banco/$pasta_data/$nome_retorno.txt")) {
      echo "<script language='javascript'>window.alert('Arquivo ja processado, selecione um arquivo diferente!'); </script>";
      unlink($arquivo);
      echo "<script language='javascript'>window.location='admin.php?acao=retorno'; </script>";
    }


    //executa o store procedure info manutencao_retorno_bancario_az
    $result_az = mysqli_query(
      $conexao,
      "CALL sp_manutencao_retorno_bancario_az('$nome_retorno','$cabecalho','$rodape');"
    ) or die("Erro na query da procedure AZ: " . mysqli_error($conexao));
    mysqli_next_result($conexao);

    $value = count($dados);
    $x = 0;

    foreach ($dados as $linha) {

      if ((substr($linha, 0, 1) == 'G')) {

        $cdb = substr($linha, 0, 111); //codigo de barras
        //$cdb = str_replace(' ', '&nbsp', $cdb);
        //@$total_reg = count($cdb);

        //echo $cabecalho . ', ' . $nome_retorno . ', ' . $cdb . ', ' . $id_usuario_editor . '<br>';

        $x++;

        if ($x == $value - 2) {
          //executa o store procedure info manutencao_retorno_bancario_g
          $result_g = mysqli_query(
            $conexao,
            "CALL sp_processa_arrecadacao_g('$cabecalho','$nome_retorno','$cdb','$id_usuario_editor');"
          ) or die("Erro na query da procedure G: " . mysqli_error($conexao));
          mysqli_next_result($conexao);
        }

        //executa o store procedure info manutencao_retorno_bancario_g
        $result_g = mysqli_query(
          $conexao,
          "CALL sp_processa_arrecadacao_g('$cabecalho','$nome_retorno','$cdb','$id_usuario_editor');"
        ) or die("Erro na query da procedure G: " . mysqli_error($conexao));
        mysqli_next_result($conexao);
      }
    }
    if (($result_az == '') || ($result_g == '')) {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao processar !'); </script>";
    } else {
      echo "<script language='javascript'>window.alert('Arquivo Processado com Sucesso!'); </script>";
      @mkdir('../include/ret_cameta_processado/' . $pasta_banco . '/' . $pasta_data, 0777, true);
      copy($arquivo, $arquivo_destino);
      unlink($arquivo);
      echo "<script language='javascript'>window.location='admin.php?acao=retorno'; </script>";
    }
  }


  ?>


</bady>
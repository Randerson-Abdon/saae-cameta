<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');

date_default_timezone_set('America/Sao_Paulo');

if ($_SESSION['nivel_usuario'] != '5' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

$data = date('d/m/Y');

$query_perfil = "SELECT * from perfil_saae";
$result_perfil = mysqli_query($conexao, $query_perfil);
$row_perfil = mysqli_fetch_array($result_perfil);
$nome_municipio           = $row_perfil["nome_municipio"];
$logo_orgao               = $row_perfil["logo_orgao"];
$email_saae               = $row_perfil["email_saae"];
$fone_saae                = $row_perfil["fone_saae"];
$nome_logradouro_saae     = $row_perfil["nome_logradouro_saae"];
$numero_imovel_saae       = $row_perfil["numero_imovel_saae"];
$nome_bairro_saae         = $row_perfil["nome_bairro_saae"];
$cep_saae                 = $row_perfil["cep_saae"];
$uf_saae                  = $row_perfil["uf_saae"];

?>

<script language="javascript">
  var timerID = null;
  var timerRunning = false;

  function stopclock() {
    if (timerRunning)
      clearTimeout(timerID)
    timerRunning = false;
  }

  function startclock() {
    stopclock();
    showtime();
  }

  function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    timeValue += (hours >= 12) ? " PM" : " AM";
    document.clock.face.value = timeValue;
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true;
  }
</script>


<style>
  .cor {
    color: #ffffff;
  }

  .cor2 {
    color: #c4bbbb;
  }
</style>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html>
<!--Linguagem -->
<html lang="pt-br">

<head>
  <!-- reconhecer caracteres especiais -->
  <meta charset="utf8_encode">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- adaptação para qualquer tela -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- mecanismos de busca -->
  <meta name="description" content="Descrição das buscas">
  <meta name="author" content="Autores">
  <meta name="keywords" content="palavras chaves de busca, palavra, palavra">

  <title>FRENTE DE CAIXA</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <script type="text/javascript" src="../js/painel.js"></script>
  <script type="text/javascript" src="../js/script.js"></script>
  <script type="text/javascript" src="../js/javascript.js"></script>
  <script type="text/javascript" src="../js/post.js"></script>



  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- LINK DO fontawesome via cdn(navegador) para icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

  <!-- link com a folha de stilos -->
  <link rel="stylesheet" type="text/css" href="../css/estilos-site.css">
  <link rel="stylesheet" type="text/css" href="../css/estilos-padrao.css">
  <link rel="stylesheet" type="text/css" href="../css/cursos.css">
  <link rel="stylesheet" type="text/css" href="../css/painel.css">
  <link rel="stylesheet" type="text/css" href="../css/cards.css">

  <!-- OS SCRIPTS DEVEM SEMPRE VIM DEPOIS DAS FOLHAS DE ESTILO -->
  <!-- script cdn(pelo navegador) jquery.min.js para menu em resoluções menores -->


  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>






</head>


<!-- body com id para link interno -->

<body id="page-top" onLoad='document.clock.codigo_barras.focus();'>

  <!-- configuração do navbar preto e fixado ao topo -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <!-- redirecionamento para link interno -->
      <a style="margin-left: -200px;" class="navbar-brand js-scroll-trigger" href="../index.php" target="_blank">
        <!-- personalização da logo -->
        <img src="../img/logo.png" class="img_logo">
        <span class="texto_logo">PORTAL SAAE NET</span>
      </a>

      <div class="collaps navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto nav-flex-icons">

          <li class="nav-item avatar mt-1 mr-1">
            <a class="nav-link p-0" href="#">
              <img src="../img/administrador.jpg" class="rounded-circle z-depth-0" alt="avatar image" height="35">
            </a>
          </li>
          <li class="nav-item avatar mt-2">
            <!--recuperando nome de usuario do login-->
            <span class="text-muted nome_usuario"><?php echo $_SESSION['nome_usuario']; ?> </span>
          <li class="nav-item avatar">

        </ul>

      </div>

    </div>
  </nav>

  <?php

  $id_usuario_editor = $_SESSION['id_usuario'];
  $data = date('Y-m-d');

  $query_hc = "SELECT * from cx_termo_abertura_encerramento where id_operador = '$id_usuario_editor' AND data_encerramento is null";
  $result_hc = mysqli_query($conexao, $query_hc);
  $res_hc = mysqli_fetch_array($result_hc);
  $id_termo_abertura_encerramento = $res_hc["id_termo_abertura_encerramento"];
  $valor_abertura     = $res_hc["valor_abertura"];
  $total_entradas     = $res_hc["total_entradas"];
  $total_saidas     = $res_hc["total_saidas"];

  $row_hc = mysqli_num_rows($result_hc);

  if ($row_hc < 1) {
    echo "<script language='javascript'>window.alert('Realize a abertura de caixa antes de continuar!!!'); </script>";
    echo "<script language='javascript'>window.close(); </script>";
  } else {
    $id_caixa = ltrim($id_usuario_editor, "0") . ltrim($id_termo_abertura_encerramento, "0");
  }

  ?>


  <div class="page-wrapper chiller-theme toggled">

    <nav id="sidebar" class="sidebar-wrapper bg-dark" style="width: 30%; margin-left: 72%;">

      <h4 class="cor" style="font-size: 16pt; margin-bottom: 50px; margin-left: 50px; margin-top: 5px;">MOVIMENTO DE ARRECADAÇÃO</h4>

      <div class="form-group" id="dados2" style="width: 115%; margin-top: -30px;"></div>

      <div class="row ml-5" style="margin-top: 20px;">

        <div class="form-group col-md-10">
          <button type="button" name="finalizar" id="finalizar" class="btn btn-success btn-block"><i class="fas fa-check-double"></i> Finalizar Operação</button>
        </div>

        <div class="form-group col-md-10">
          <button type="button" name="cancelar" id="cancelar" class="btn btn-warning btn-block"><i class="fas fa-window-close"></i> Cancelar Operação</button>
        </div>

        <div class="form-group col-md-10">
          <button type="button" name="sair" id="sair" class="btn btn-danger btn-block"><i class="fas fa-sign-out-alt"></i> Sair</button>
        </div>

      </div>

      <div class="row ml-5" style="margin-top: 20px;">

        <div class="form-group col-md-10" align="center">
          <img width="100%" height="150px" src="../img/parametros/<?php echo $logo_orgao; ?>" alt="">
        </div>

      </div>

      <!-- sidebar-content  -->
    </nav>


    <!-- sidebar-wrapper  -->
    <main class="page-content" style="width: 70%; margin-left: 0;">

      <!-- adaptação aos tamanhos de tela/ grande/medio/pequena -->


      <h3 style="margin-left: -60px;">Caixa Rápido N° <?php echo $id_caixa; ?></h3>

      <form method="" action="" name="clock" onSubmit="0" style="margin-left: -60px;">
        <div class="row">

          <div class="form-group col-md-2">
            <label for="id_produto">(+) Entradas</label>
            <input type="text" class="form-control mr-2" name="entradas" value="<?php if ($total_entradas == '') {
                                                                                  echo number_format(0, 2, ".", ",");
                                                                                } else {
                                                                                  echo number_format($total_entradas, 2, ".", "");
                                                                                }
                                                                                ?>">
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto">(-) Saídas</label>
            <input type="text" class="form-control mr-2" id="mes" name="saidas" value="<?php if ($total_saidas == '') {
                                                                                          echo number_format(0, 2, ".", ",");
                                                                                        } else {
                                                                                          echo number_format($total_saidas, 2, ".", "");
                                                                                        }
                                                                                        ?>">
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto">(=) Saldo Total</label>
            <input type="text" class="form-control mr-2" id="mes" name="saldo" value="<?php echo number_format($total_entradas - $total_saidas, 2, ".", ""); ?>">
          </div>



          <div class="form-group col-md-3">
            <label for="id_produto">Data</label>
            <input type="date" class="form-control mr-2" name="data" value="<?php echo date('Y-m-d'); ?>" readonly>
          </div>

          <div class="form-group col-md-2">
            <label for="id_produto">Hora</label>
            <input type="text" class="form-control mr-2" name="face" readonly>
          </div>

        </div>

        <div class="row">

          <div class="form-group col-md-2">
            <label for="fornecedor">Juros e Multa</label>
            <select class="form-control mr-2" id="juros_multas" name="juros_multas">

              <option value="S">Sim</option>
              <option value="N">Não</option>

            </select>
          </div>

          <div class="form-group col-md-6">
            <label for="id_produto">Leitura do Código de Barras</label>
            <input type="text" class="form-control mr-2" name="codigo_barras" id="codigo_barras" placeholder="Seu código de barras aqui" required>
            <input type="text" class="form-control mr-2" name="id_termo_abertura_encerramento" value="<?php echo $id_termo_abertura_encerramento; ?>" style="display: none;">
            <input type="text" class="form-control mr-2" name="id_caixa" value="<?php echo $id_caixa; ?>" style="display: none;">
          </div>

          <div class="form-group col-md-3" style="margin-top: 28px;">
            <button type="button" class="btn btn-success mb-3" id="buscar" name="buscar">Confirmar </button>
            <button type="button" class="btn btn-danger ml-3 mb-3" onClick="limpa()" id="limpar" name="limpar">Limpar </button>
          </div>

        </div>

      </form>

      <script>
        $(document).keypress(function(e) {
          if (e.which == 13) $('#buscar').click();
        });
      </script>

      <div class="form-group" id="dados" style="width: 115%; margin-left: -10%; margin-top: -30px;"></div>

      <script>

      </script>

      <script>
        $("#buscar").click(function() {
          $.ajax({
            url: "lista_caixa.php",
            type: "POST",
            data: ({
              codigo_barras: $("input[name='codigo_barras']").val(),
              id_termo_abertura_encerramento: $("input[name='id_termo_abertura_encerramento']").val(),
              id_caixa: $("input[name='id_caixa']").val(),
              juros_multas: $("select[name='juros_multas']").val()
            }), //estamos enviando o valor do input
            success: function(resposta) {
              $('#dados').html(resposta);
            }
          });


          if (document.getElementById('codigo_barras').value != "") {
            document.getElementById('codigo_barras').value = "";
          }

        });
      </script>

      <script>
        $("#buscar").click(function() {
          $.ajax({
            url: "desc.php",
            type: "POST",
            data: ({
              id_termo_abertura_encerramento: $("input[name='id_termo_abertura_encerramento']").val(),
              id_caixa: $("input[name='id_caixa']").val()
            }), //estamos enviando o valor do input
            success: function(resposta) {
              $('#dados2').html(resposta);
            }

          });
        });
      </script>

      <script>
        $("#cancelar").click(function() {
          $.ajax({
            url: "cancela.php",
            type: "POST",
            data: ({
              codigo_barras: $("input[name='codigo_barras']").val(),
              id_caixa: $("input[name='id_caixa']").val()
            }), //estamos enviando o valor do input  
            success: function(resposta) {
              $('#dados').html(resposta);
            }

          });
        });
      </script>

      <script>
        $("#finalizar").click(function() {
          $.ajax({
            url: "finalizar.php",
            type: "POST",
            data: ({
              codigo_barras: $("input[name='codigo_barras']").val(),
              id_termo_abertura_encerramento: $("input[name='id_termo_abertura_encerramento']").val(),
              id_caixa: $("input[name='id_caixa']").val(),
              v_pago: $("input[name='v_pago']").val()
            }), //estamos enviando o valor do input  
            success: function(resposta) {
              $('#dados').html(resposta);
            }

          });
        });
      </script>

      <script>
        $("#sair").click(function() {
          $.ajax({
            url: "sair.php",
            type: "POST",
            data: ({
              codigo_barras: $("input[name='codigo_barras']").val()
            }), //estamos enviando o valor do input  
            success: function(resposta) {
              $('#dados').html(resposta);
            }

          });
        });
      </script>

      <script>
        startclock();
      </script>

    </main>
    <!-- page-content" -->
  </div>

  <?php


  if (isset($_POST['cancelar'])) {

    $codigo_barras = $_POST['codigo_barras'];
    $id_caixa = $_POST['id_caixa'];

    $codigo_barras = preg_replace("/[^0-9]/", "", $codigo_barras);

    $uc = substr($codigo_barras, 33, 2) . substr($codigo_barras, 36, 3); //Matrícula
    $query_del = "DELETE FROM cx_caixa_temporario WHERE id_caixa = '$id_caixa' ";
    $result_del = mysqli_query($conexao, $query_del);


    if ($result_del == '') {
      echo "<script language='javascript'>window.alert('Ocorreu um erro ao cancelar!'); </script>";
    } else {
      echo "<script language='javascript'>window.alert('Operação Cancelada!'); </script>";
      echo "<script language='javascript'>window.location='operacao.php'; </script>";
    }
  }


  ?>

</body>

</html>
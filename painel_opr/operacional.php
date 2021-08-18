<?php
include_once('../conexao.php');
session_start();
include_once('../verificar_autenticacao.php');
?>


<?php

if ($_SESSION['nivel_usuario'] != '2' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

?>

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

  <title>Portal Operacional</title>

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

<body id="page-top">

  <!-- configuração do navbar preto e fixado ao topo -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <!-- redirecionamento para link interno -->
      <a class="navbar-brand js-scroll-trigger" href="../index.php" target="_blank">
        <!-- personalização da logo -->
        <img src="../img/logo.png" class="img_logo">
        <span class="texto_logo">PORTAL SAAE</span></a>

      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle Navigation">
        Menu <i class="fas fa-bars"></i>
      </button>

      <div class="collaps navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav ml-auto nav-flex-icons">

          <li class="nav-item dropdown mr-3">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
              <a class="dropdown-item" href="../logout.php">Sair</a>
              <?php if ($_SESSION['nivel_usuario'] == '0') { ?>
                <a class="dropdown-item" href="../painel_admin/admin.php">Administrativo</a>
                <a class="dropdown-item" href="../painel_atd/atendimento.php">Atendimento</a>
                <a class="dropdown-item" href="../painel_caixa/caixa.php">Caixa</a>
              <?php }  ?>
            </div>
          </li>

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


  <div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark fa-2x" href="#">
      <i class="fas fa-bars "></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper bg-dark">
      <div class="sidebar-content">
        <div class="sidebar-brand">
          <a href="operacional.php">Painel Operacional</a>
          <div id="close-sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div>

        <!-- sidebar-header  -->

        <div class="sidebar-menu">
          <ul>

            <li class="header-menu">
              <span>Módulo Operacional</span>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fas fa-user-tag"></i>
                <span>Atendimento</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="operacional.php?acao=consumidores">Consumidor</a>
                  </li>
                  <li>
                    <a href="operacional.php?acao=requerimento">Requerimentos</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fas fa-map-marked-alt"></i>
                <span>Endereçamento</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="operacional.php?acao=localidades">Localidades</a>
                    </a>
                  </li>
                  <li>
                    <a href="operacional.php?acao=bairros">Bairros</a>
                  </li>
                  <li>
                    <a href="operacional.php?acao=logradouros">Logradouros</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fas fa-tools"></i>
                <span>Gerenciamento de O.S</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="operacional.php?acao=os">Controle de O.S</a>
                  </li>
                  <li>
                    <a href="operacional.php?acao=corte">Plano e Execução de Cortes</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fas fa-tasks"></i>
                <span>Gerenciamento de U.C.H</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Leitura em Campo</a>
                  </li>
                  <li>
                    <a href="#">Lançamento no Sistema</a>
                  </li>
                  <li>
                    <a href="#">Executadas</a>
                  </li>
                  <li>
                    <a href="#">Pendentes</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="header-menu">
              <span>Extra</span>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Documentação</span>
                <span class="badge badge-pill badge-primary">Beta</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-calendar"></i>
                <span>Calendario</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-folder"></i>
                <span>Examplos</span>
              </a>
            </li>
            <br>
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-content  -->
    </nav>
    <!-- sidebar-wrapper  -->
    <main class="page-content">

      <!-- adaptação aos tamanhos de tela/ grande/medio/pequena -->
      <div class="col-lg-10 col-md-9 col-sm-12">

        <!--CARREGAMENTO DAS DEMAIS PÁGINAS DO PAINÉL -->
        <?php
        if (@$_GET['acao'] == 'usuarios' or isset($_GET['txtpesquisarUsuarios'])) {
          include_once('usuarios.php');
        } elseif (@$_GET['acao'] == 'bairros' or isset($_GET['txtpesquisarBairros'])) {
          include_once('bairros.php');
        } elseif (@$_GET['acao'] == 'consumidores' or isset($_GET['txtpesquisarConsumidores'])) {
          include_once('consumidores.php');
        } elseif (@$_GET['acao'] == 'localidades' or isset($_GET['txtpesquisarLocalidades'])) {
          include_once('localidades.php');
        } elseif (@$_GET['acao'] == 'logradouros' or isset($_GET['txtpesquisarLogradouros'])) {
          include_once('logradouros.php');
        } elseif (@$_GET['acao'] == 'funcoes' or isset($_GET['txtpesquisarFuncoes'])) {
          include_once('funcoes.php');
        } elseif (@$_GET['acao'] == 'requerimento' or isset($_GET['txtpesquisarRequerimento'])) {
          include_once('requerimento.php');
        } elseif (@$_GET['acao'] == 'endereco' or isset($_GET['txtpesquisarEndereco'])) {
          include_once('endereco.php');
        } elseif (@$_GET['acao'] == 'consumidor' or isset($_GET['txtpesquisarConsumidores'])) {
          include_once('consumidor.php');
        } elseif (@$_GET['acao'] == 'requerimentob' or isset($_GET['txtpesquisarRequerimentob'])) {
          include_once('requerimentob.php');
        } elseif (@$_GET['acao'] == 'os' or isset($_GET['txtpesquisarOs'])) {
          include_once('os.php');
        } elseif (@$_GET['acao'] == 'corte') {
          include_once('corte.php');
        } else {
          include_once('home.php');
        }

        ?>

      </div>

    </main>
    <!-- page-content" -->
  </div>


</body>

</html>
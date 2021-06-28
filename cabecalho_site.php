<!DOCTYPE html>
<!--Linguagem -->
<html lang="pt-br">
<head>
	<!-- reconhecer caracteres especiais -->
	<meta charset="utf-8">
    <!-- adaptação para qualquer tela -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- mecanismos de busca -->
    <meta name="description" content="Descrição das buscas">
    <meta name="author" content="Autores">
    <meta name="keywords" content="palavras chaves de busca, palavra, palavra">

<title>Portal SAAE</title>

<!-- LINK DO BOOTSTRAP via cdn(navegador) -->     
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!-- LINK DO fontawesome via cdn(navegador) para icones -->  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

<!-- link com a folha de stilos --> 
<link rel="stylesheet" type="text/css" href="css/estilos-site.css">
<link rel="stylesheet" type="text/css" href="css/estilos-padrao.css">
<link rel="stylesheet" type="text/css" href="css/cursos.css">

<!-- OS SCRIPTS DEVEM SEMPRE VIM DEPOIS DAS FOLHAS DE ESTILO --> 
<!-- script cdn(pelo navegador) jquery.min.js para menu em resoluções menores --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>


<!-- body com id para link interno -->
<body id="page-top">

<!-- configuração do navbar preto e fixado ao topo -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
    	<!-- redirecionamento para link interno -->
    	<a class="navbar-brand js-scroll-trigger" href="index.php#page-top">
        <!-- personalização da logo -->
        <img src="img/logo.png" class="img_logo">
        <span class="texto_logo">Portal SAAE</span></a>
        <!-- botão posicionado a direita, some qundo esta em uma tela menor, sem expanção alem dos objetos, menu com icocole quando em tela menor -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle Navigation">
        Menu <i class="fas fa-bars"></i> 
        </button>
        
        <!--menu, que recolhe em tela menor, ul com letra maiuscula e margin left auto -->
        <div class="collaps navbar-collapse" id="navbarResponsive">
        	
            <ul class="navbar-nav text-uppercase ml-auto texto_menu">
                <!-- itens do menu -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php">Home</a>
                </li> 
                 <!-- itens do menu -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#cursos">Nossas Soluções</a>
                </li>
                 <!-- itens do menu -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#sobre">Quem Somos</a>
                </li>
                 <!-- itens do menu -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#alunos">Parceiros</a>
                </li> 
                 <!-- itens do menu -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#contatos">contato</a>
                </li>  
                  <!-- itens do menu -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="login.php" target="_blank">Login</a>
                </li>         
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                <button class="btn btn-outline-danger my-2 my-sm-0 botao_lupa" type="submit"> <i class="fas fa-search"></i></button>
    		</form>
         </div>
        
    </div>
</nav>
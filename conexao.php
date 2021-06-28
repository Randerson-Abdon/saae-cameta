<!-- CONEXÃO COM O BD-->
<?php

//LOCAL PADRÃO DA APLICAÇÃO BRASIL
date_default_timezone_set('America/Sao_Paulo');


//CONEXAO REMOTA
//OBJETO QUE SE MANTEM, CONSTANTE COM DADOS PARA CONEXÃO AO BD
//define('HOST', 'cameta-pa.cvpyiyze5epg.sa-east-1.rds.amazonaws.com');
//define('USUARIO', 'provider');
//define('SENHA', 'Jp?20061965');
//define('BD', 'cameta-pa');



//CONEXAO LOCAL
//OBJETO QUE SE MANTEM, CONSTANTE COM DADOS PARA CONEXÃO AO BD
define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '');
define('BD', 'saae-cametapa-local');

//VARIAVEL PARA GUARDAR A EXECUÇÃO DA CONEXÃO
$conexao = mysqli_connect(HOST, USUARIO, SENHA, BD) or die('Não Conectou');
mysqli_set_charset($conexao, "utf8");

?>
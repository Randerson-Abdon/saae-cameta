<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contatos</title>
</head>
<body>

<?php

$nome = $_POST['nome'];
$email = $_POST['email'];
$fone = $_POST['fone'];
$mensagem = $_POST['mensagem'];
$titulo = 'Contato Portal SAAE';
$dest = 'suporte_saaesiza@saaenet.com.br';
//$dest = 'randerson.ab@hotmail.com';

$mensagem = utf8_decode($mensagem);;
$nome = utf8_decode($nome);

// usando o PHP_EOL para quebrar a linha
$dados = '- Nome: '.$nome.PHP_EOL.PHP_EOL.'- Email: '.$email.PHP_EOL.PHP_EOL.'- Telefone: '.$fone.PHP_EOL.PHP_EOL.'- A mensagem: '.$mensagem;

mail($dest, $titulo, $dados);

?>

<script>
alert('Obrigado! Mensagem enviada com sucesso. Por favor, pressione OK para retornar!!!');
</script>

<meta http-equiv="refresh" content="0; url=http://datapremium.com.br/s-izabel/web/home/" />

</body>
</html>


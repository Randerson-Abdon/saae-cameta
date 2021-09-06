<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contatos</title>
</head>

<body>

    <?php

    $name = 'teste';
    $email = 'teste@tese';
    $fone = '91980877159';
    $mensagem = 'teste';
    $titulo = 'Contato';
    //$dest = 'atendimento@tecnoinforeparos.com.br';
    $from = "suporte@saaecameta.com.br";
    $dest = 'randerson.ab@hotmail.com, alexandre.brito@bcinformatica-pa.com.br';
    $headers = "From:" . $from;

    $message = utf8_decode($mensagem);;
    $name = utf8_decode($name);

    // usando o PHP_EOL para quebrar a linha
    $dados = '- Nome: ' . $name . PHP_EOL . PHP_EOL . '- Email: ' . $email . PHP_EOL . PHP_EOL . '- Telefone: ' . $fone . PHP_EOL . PHP_EOL . '- A mensagem: ' . $message;

    mail($dest, $titulo, $dados, $headers);

    ?>

    <script>
        alert('Obrigado! Mensagem enviada com sucesso. Por favor, pressione OK para retornar!!!');
    </script>


</body>

</html>
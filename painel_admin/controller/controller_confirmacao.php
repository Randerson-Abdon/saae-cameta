<?php


function confirmaUsuario($login, $senha)
{
    @require('../../conexao.php');
    //consulta historico_financeiro
    $query = "SELECT * from usuario_sistema where login_usuario = '$login' and senha_usuario = '$senha' ";

    $result = mysqli_query($conexao, $query);

    $numero = mysqli_num_rows($result);


    return $numero;
}

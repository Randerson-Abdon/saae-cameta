<?php

include_once('conexao.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Cadastro</title>
</head>

<body>

  <?php
  /**
   * Função para gerar senhas aleatórias

   * @param integer $tamanho Tamanho da senha a ser gerada
   * @param boolean $maiusculas Se terá letras maiúsculas
   * @param boolean $numeros Se terá números
   * @param boolean $simbolos Se terá símbolos
   *
   * @return string A senha gerada
   */
  function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
  {
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';

    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;

    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
      $rand = mt_rand(1, $len);
      $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
  }

  ?>


  <!--CADASTRO ACESSO -->
  <?php

  $id_localidade = $_POST['id_localidade'];
  $senha = $_POST['senha'];
  $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
  $email_contato = $_POST['email_contato'];

  $fone_movel = $_POST['fone_movel'];
  //tratamento para celular
  $fone_movel = preg_replace("/[^0-9]/", "", $fone_movel);
  $numero_cpf_cnpj = preg_replace("/[^0-9]/", "", $numero_cpf_cnpj);

  //validação cadastro
  $query_un = "SELECT * FROM acesso_seguro_web WHERE numero_cpf_cnpj = '$numero_cpf_cnpj'";
  $result_un = mysqli_query($conexao, $query_un);

  //VERIFICAR SE O EMAIL OU SENHA JÁ ESTÁ CADASTRADO                          
  $row_verificar_un = mysqli_num_rows($result_un);
  if ($row_verificar_un > 0) {
    echo "<script language='javascript'>window.alert('Usuário já cadastrado!!!'); </script>";
    echo "<script language='javascript'>window.location='index.php'; </script>";
    exit();
  }

  //validação cadastro
  $query_ex = "SELECT * FROM unidade_consumidora WHERE numero_cpf_cnpj = '$numero_cpf_cnpj'";
  $result_ex = mysqli_query($conexao, $query_ex);

  //VERIFICAR SE O EMAIL OU SENHA JÁ ESTÁ CADASTRADO                          
  $row_verificar_ex = mysqli_num_rows($result_ex);
  if ($row_verificar_ex == 0) {
    echo "<script language='javascript'>window.alert('Não exite Unidade Consumidora vinculada a este CPF!'); </script>";
    echo "<script language='javascript'>window.location='index.php'; </script>";
    exit();
  }

  $query = "INSERT INTO acesso_seguro_web (numero_cpf_cnpj, fone_movel, email_contato, senha_acesso_permanente) values ('$numero_cpf_cnpj', '$fone_movel', '$email_contato', '$senha')";

  $result = mysqli_query($conexao, $query);

  echo "<script language='javascript'>window.location='http://datapremium.com.br/sendMail.php?email=$email_contato&doc=$numero_cpf_cnpj'; </script>";
  ?>


</body>

</html>
<?php
include_once('../conexao.php');

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
    echo "<script language='javascript'>window.location='../index.php'; </script>";
    exit();
}

//validação cadastro
$query_ex = "SELECT * FROM unidade_consumidora WHERE numero_cpf_cnpj = '$numero_cpf_cnpj'";
$result_ex = mysqli_query($conexao, $query_ex);

//VERIFICAR SE O EMAIL OU SENHA JÁ ESTÁ CADASTRADO                          
$row_verificar_ex = mysqli_num_rows($result_ex);
if ($row_verificar_ex == 0) {
    echo "<script language='javascript'>window.alert('Não exite Unidade Consumidora vinculada a este CPF!'); </script>";
    echo "<script language='javascript'>window.location='../index.php'; </script>";
    exit();
}

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

$codigo = geraSenha(6, false, true);

$query = "INSERT INTO acesso_seguro_web (numero_cpf_cnpj, fone_movel, email_contato, senha_acesso_permanente) values ('$numero_cpf_cnpj', '$fone_movel', '$email_contato', '$senha')";

$result_boleto = mysqli_query($conexao, $query);


$curl = curl_init();

$mensagem = urlencode("Obrigado por se cadastrar no SaaeNet, seu código de confirmação é: *$codigo*.\nSe este contato não foi autorizado por você, por favor informar neste mesmo número.");


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api-whats.com/api/v1/message/send/?instance=C84F414606&phone=55' . $fone_movel . '&message=' . $mensagem,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'Access-token: APP-USER-5876655-18F6023DC3CA5B6DA5FF3048E0362DF1FC763107'
    ),
));

$response = curl_exec($curl);

curl_close($curl);

$codigo_post = md5($codigo);



echo "<script language='javascript'>window.location='../cameta/web/home/index.php?acao=confirmar&codigo=$codigo_post&doc=$numero_cpf_cnpj'; </script>";

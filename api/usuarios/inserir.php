<?php
include_once('../conexao.php');

$data     = $_POST['data'];
$email    = $_POST['email'];
$cpf      = $_POST['cpf'];
$telefone = $_POST['telefone'];
$senha    = $_POST['senha'];

if ($data == '' || $email == '' || $cpf == '' || $telefone == '' || $senha == '') {
    echo (json_encode(array('mensagem' => 'Preencha todos os campos!')));
    exit();
}

//CONSULTA PARA VERIFICAR DADOS JÁ EXISTENTES
$res = $pdo->query("SELECT * FROM acesso_seguro_web WHERE numero_cpf_cnpj = '$cpf' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);

if ($linhas > 0) {
    echo (json_encode(array('mensagem' => 'Usuário já cadastrado!')));
    exit();
}

//CONSULTA PARA VERIFICAR DADOS JÁ EXISTENTES
$res = $pdo->query("SELECT * FROM unidade_consumidora WHERE numero_cpf_cnpj = '$cpf' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);

if ($linhas == 0) {
    echo (json_encode(array('mensagem' => 'Não exite Unidade Consumidora vinculada a este CPF!')));
    exit();
}

$res = $pdo->prepare("INSERT into acesso_seguro_web (numero_cpf_cnpj, fone_movel, email_contato, senha_acesso_permanente) values (:numero_cpf_cnpj, :fone_movel, :email_contato, :senha_acesso_permanente)");

$res->bindValue(":email_contato", $email);
$res->bindValue(":numero_cpf_cnpj", $cpf);
$res->bindValue(":senha_acesso_permanente", $senha);
$res->bindValue(":fone_movel", $telefone);

$res->execute();

if ($res) {
    echo (json_encode(array('mensagem' => 'Cadastrado com Sucesso!')));
}

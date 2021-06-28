<?php
include_once('conexao.php');
session_start();
?>

<?php
//verificação de login
if (empty($_POST['login_usuario']) || empty($_POST['senha_usuario'])) {
	//se estiver vazio redireciona para login
	header('location:login.php');
	//finalizando
	exit();
}


//validação de tipos de caracteres recebidos nos campos
$login_usuario = mysqli_real_escape_string($conexao, $_POST['login_usuario']);
$senha_usuario = mysqli_real_escape_string($conexao, $_POST['senha_usuario']);
//$senha_usuario = password_hash($senha_usuario, PASSWORD_DEFAULT);

//consulta para validação de login
$query = "select * from usuario_sistema where login_usuario = '$login_usuario' and senha_usuario = '$senha_usuario'";
$result = mysqli_query($conexao, $query);
$dado = mysqli_fetch_array($result);
$linha = mysqli_num_rows($result);
$id = $dado['id_usuario'];


if ($linha > 0) {
	//armazenamento de dados no memonto que o usuario fizer acesso
	$_SESSION['login_usuario'] 	= $login_usuario;
	$_SESSION['nome_usuario']  	= $dado['nome_usuario'];
	$_SESSION['nivel_usuario'] 	= $dado['nivel_usuario'];
	$_SESSION['cpf_usuario']   	= $dado['cpf_usuario'];
	$_SESSION['id_usuario']    	= $dado['id_usuario'];
	$_SESSION['status_usuario'] = $dado['status_usuario'];
	$_SESSION['localidade'] 	= '01';

	//trazendo info perfil_saae
	$result_perfil = mysqli_query(
		$conexao,
		"CALL sp_lista_perfil_saae();"
	) or die("Erro na query da procedure a: " . mysqli_error($conexao));
	mysqli_next_result($conexao);
	$row_perfil = mysqli_fetch_array($result_perfil);
	$_SESSION['nome_prefeitura'] 	  = $row_perfil['PREFEITURA'];
	$_SESSION['saae_cnpj'] 			  = $row_perfil['CNPJ'];
	$_SESSION['nome_bairro_saae'] 	  = $row_perfil['BAIRRO'];
	$_SESSION['nome_logradouro_saae'] = $row_perfil['LOGRADOURO'];
	$_SESSION['numero_imovel_saae']   = $row_perfil['NÚMERO'];
	$_SESSION['nome_municipio'] 	  = $row_perfil['MUNICÍPIO'];
	$_SESSION['uf_saae'] 			  = $row_perfil['UF'];
	$_SESSION['nome_saae'] 			  = $row_perfil['SAAE'];
	$_SESSION['email_saae'] 		  = $row_perfil['EMAIL'];
	$_SESSION['fone_saae'] 			  = $row_perfil["FONE"];


	if ($_SESSION['status_usuario'] == 'I') {
		$_SESSION['inativado'] = true;
		header('location:login.php');
	} else {

		//se o nivel de usuario for admin ir para painel admin
		if ($_SESSION['nivel_usuario'] == '1') {
			header('location:painel_admin/admin.php');
			exit();
		}

		//se o nivel de usuario for professor ir para painel professor
		if ($_SESSION['nivel_usuario'] == '2') {
			header('location:painel_opr/operacional.php');
			exit();
		}

		//se o nivel de usuario for aluno ir para painel aluno
		if ($_SESSION['nivel_usuario'] == '3') {
			header('location:painel_atd/atendimento.php');
			exit();
		}

		//se o nivel de usuario for aluno ir para painel aluno
		if ($_SESSION['nivel_usuario'] == '4') {
			header('location:painel_caixa/caixa.php');
			exit();
		}

		//se o nivel de usuario for aluno ir para painel aluno
		if ($_SESSION['nivel_usuario'] == '5') {
			header('location:painel_finan/financeiro.php');
			exit();
		}

		//se o nivel de usuario for aluno ir para painel aluno
		if ($_SESSION['nivel_usuario'] == '0') {
			header('location:painel_atd/atendimento.php');
			exit();
		}
	}
} else {
	//
	$_SESSION['nao_autenticado'] = true;
	header('location:login.php');
}


?>
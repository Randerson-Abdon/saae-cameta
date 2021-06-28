<?php 
//se a secão for diferente do usuario faça:
if(!$_SESSION['login_usuario']){
		header('Location: ../login.php');
		exit();
	}
 ?>

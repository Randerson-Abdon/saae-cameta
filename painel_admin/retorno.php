<?php
@session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Processamento Bancário</title>
</head>

<body>
	<h3>Importar dados</h3>
	<?php
	if (isset($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<form method="POST" action="admin.php?acao=processa_ret" enctype="multipart/form-data">
		<label>Arquivo</label>
		<input type="file" name="arquivo"><br><br>

		<div class="form-group col-md-2" style="margin-left: -15px;">
			<input type="submit" class="btn btn-success form-control" value="Importar">
		</div>
	</form>
</body>

</html>
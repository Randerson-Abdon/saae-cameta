<style>
	section .content {
		margin-top: -170px;
		margin-bottom: -170px;
	}


	p {
		color: #d70000;
		margin-left: 20px;

	}
</style>

<?php
session_start(); # Deve ser a primeira linha do arquivo

include_once('../conexao.php');

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
	header('Location: ../login.php');
	exit();
}

?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>corte</title>
</head>

<body>

	<?php

	@$id_localidade  = $_POST['id_localidade'];
	@$id_logradouro  = $_POST['id_logradouro'];
	@$id_bairro	    = $_POST['id_bairro'];
	@$status	   		= $_POST['status'];

	//executa o store procedure info corte
	$result_sp = mysqli_query(
		$conexao,
		"CALL sp_lista_unidade_consumidora_logradouro($id_localidade,$id_bairro,$id_logradouro,'','$status');"
	) or die("<p class='h5 text-danger'>Verifique se a seleção dos dados para consulta esta correta!!!</p>");
	mysqli_next_result($conexao);

	$row = mysqli_num_rows($result_sp);

	?>
	<section>
		<?php
		if ($row > 0) {
		?>

			<div class="content">
				<div class="row mr-3">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-sm table-hover">
										<thead class="text-secondary">

											<th>
												Matrícula
											</th>
											<th>
												Nome
											</th>
											<th>
												Complemento
											</th>
											<th>
												N°
											</th>
											<th>
												Data de Cadastro
											</th>
											<th>
												Status
											</th>

										</thead>
										<tbody>

											<?php
											while ($res = mysqli_fetch_array($result_sp)) {

												$uc				 	 = $res["UC"];
												$nome_razao_social	 = $res["NOME"];
												$numero_cpf_cnpj 	 = $res["CPF_CNPJ"];
												$data_cadastro		 = $res["CADASTRO"];
												$complemento 	 	 = $res["COMPLEMENTO"];
												$status_ligacao		 = $res["STATUS"];
												$numero		 		 = $res["NUMERO"];

												$id_usuario_editor = $_SESSION['id_usuario'];

											?>

												<tr>

													<td class="text-danger"><?php echo $uc; ?></td>
													<td><?php echo $nome_razao_social; ?></td>
													<td><?php echo $complemento; ?></td>
													<td><?php echo $numero; ?></td>
													<td><?php echo $data_cadastro; ?></td>
													<td><?php echo $status_ligacao; ?></td>

													<td>
														<!--
														
														<a class="text-primary" title="Ver Perfil" href="operacional.php?acao=corte&func=perfil&id=<?php echo $uc; ?>"><i class="fas fa-id-card"></i></a>

														
														<a class="text-success" title="Iniciar Processamento" href="admin.php?acao=baixa&func=baixa&id=<?php echo $uc; ?>&mes_faturado=<?php echo $rData; ?>"> <i class="fas fa-play"></i></a>
														-->
													</td>
												</tr>
												</tr>


											<?php } ?>
										</tbody>
									</table>


								</div>
							<?php  } else { ?>

								<p class="h5 text-danger">Nâo foram encontrados registros com esses parametros!</p>

							<?php }
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>

	<!--MASCARAS -->

	<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
	<script>
		$("input[id*='numero_cpf_cnpj']").inputmask({
			mask: ['999.999.999-99', '99.999.999/9999-99'],
			keepStatic: true
		});
	</script>
	<script>
		$("label[id*='numero_cpf_cnpj']").inputmask({
			mask: ['999.999.999-99', '99.999.999/9999-99'],
			keepStatic: true
		});
	</script>
	<script>
		$("span[id*='numero_cpf_cnpj']").inputmask({
			mask: ['999.999.999-99', '99.999.999/9999-99'],
			keepStatic: true
		});
	</script>
	<script>
		$("td[id*='numero_cpf_cnpj']").inputmask({
			mask: ['999.999.999-99', '99.999.999/9999-99'],
			keepStatic: true
		});
	</script>
	<script>
		$("label[id*='cel']").inputmask({
			mask: ['(99) 99999-9999'],
			keepStatic: true
		});
	</script>
	<script>
		$("label[id*='fone']").inputmask({
			mask: ['(99) 9999-9999'],
			keepStatic: true
		});
	</script>
	<script>
		$("input[id*='cel']").inputmask({
			mask: ['(99) 99999-9999'],
			keepStatic: true
		});
	</script>
	<script>
		$("td[id*='cel']").inputmask({
			mask: ['(99) 99999-9999'],
			keepStatic: true
		});
	</script>

</body>

</html>
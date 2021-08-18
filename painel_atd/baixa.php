<style>
	section .content {
		margin-top: -150px;
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

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0' && $_SESSION['nivel_usuario'] != '77') {
	header('Location: ../login.php');
	exit();
}

?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>baixa</title>
</head>

<body>

	<?php

	$id_unidade_consumidora = $_POST['id_unidade_consumidora'];
	$mes_faturado			= $_POST['mes_faturado'];
	$id_unidade_consumidora = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);

	$rData = explode("/", $mes_faturado);
	$rData = $rData[1] . '/' . $rData[0];

	$query_hfd = "SELECT * FROM historico_financeiro WHERE id_unidade_consumidora = '$id_unidade_consumidora' AND mes_faturado = '$rData' ";
	$result_hfd = mysqli_query($conexao, $query_hfd);
	$row_hfd = mysqli_fetch_array($result_hfd);
	@$id_acordo_parcelamento = $row_hfd['id_acordo_parcelamento'];


	if ($id_acordo_parcelamento = null) { ?>
		<p class="h5 text-danger">Fatura <?php echo $mes_faturado; ?> não se encontra em aberto !!!</p>

	<?php } elseif ($id_acordo_parcelamento != null) { ?>
		<p class="h5 text-danger">Fatura <?php echo $mes_faturado; ?> em acordo sob N° <?php echo $id_acordo_parcelamento; ?> !!!</p>

	<?php } else {

		$sql = "SELECT * FROM unidade_consumidora WHERE id_unidade_consumidora LIKE '$id_unidade_consumidora' ";
		$query = mysqli_query($conexao, $sql);
		$row = mysqli_num_rows($query);

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
										<table class="table table-striped table-sm">
											<thead class="text-secondary">

												<th>
													Nome/Razão Social
												</th>
												<th>
													CPF/CNPJ
												</th>
												<th>
													RG
												</th>
												<th>
													Localiade
												</th>

												<th>
													Ações
												</th>
											</thead>
											<tbody>

												<?php
												while ($sqlline = mysqli_fetch_array($query)) {

													$uc = $sqlline["id_unidade_consumidora"];
													$id_localidade = $sqlline["id_localidade"];
													$cpfcnpj = $sqlline["numero_cpf_cnpj"];
													$nome_razao_social = $sqlline['nome_razao_social'];
													$numero_rg = $sqlline['numero_rg'];
													$id_usuario_editor = $_SESSION['id_usuario'];

													//consulta para recuperação do nome da localidade
													$query_loc = "select * from enderecamento_localidade where id_localidade = '$id_localidade' ";
													$result_loc = mysqli_query($conexao, $query_loc);
													$row = mysqli_fetch_array($result_loc);
													//vai para a modal
													$nome_loc = $row['nome_localidade'];


												?>

													<tr>

														<td><?php echo $nome_razao_social; ?></td>
														<td id="numero_cpf_cnpj"><?php echo $cpfcnpj; ?></td>
														<td><?php echo $numero_rg; ?></td>
														<td><?php echo $nome_loc; ?></td>

														<td>
															<!--chamando modal para envio de mensagem-->
															<a class="text-primary" title="Ver Perfil" href="atendimento.php?acao=baixa&func=perfil&id=<?php echo $uc; ?>&id_localidade=<?php echo $id_localidade; ?>"><i class="fas fa-id-card"></i>&nbsp;&nbsp;</a>

															<a class="text-success" title="Iniciar Baixa" href="atendimento.php?acao=baixa&func=baixa&id=<?php echo $uc; ?>&mes_faturado=<?php echo $rData; ?>&id_localidade=<?php echo $id_localidade; ?>"> <i class="fas fa-play"></i></a>
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
						} ?>
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
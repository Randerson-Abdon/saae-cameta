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

include_once('../conexao.php');

?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>post2</title>
</head>

<body>

	<?php

	$nome_razao_social = $_POST['nome_razao_social'] . '%';

	?>

	<?php


	?>



	<?php

	$sql = "SELECT * FROM unidade_consumidora WHERE nome_razao_social LIKE '$nome_razao_social' ";
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
									<table class="table table-striped">
										<thead class="text-secondary">

											<th>
												UC
											</th>
											<th>
												Nome/Razão Social
											</th>
											<th>
												CPF/CNPJ
											</th>
											<th>
												Data Cad
											</th>




											<th>
												Ações
											</th>
										</thead>
										<tbody>

											<?php
											while ($sqlline = mysqli_fetch_array($query)) {

												$uc = $sqlline["id_unidade_consumidora"];
												$localidade = $sqlline["id_localidade"];
												$cpfcnpj = $sqlline["numero_cpf_cnpj"];
												$nome_user = $sqlline['nome_razao_social'];
												$nome_rg = $sqlline['numero_rg'];
												$nome_om = $sqlline['orgao_emissor_rg'];
												$nome_ufrg = $sqlline['uf_rg'];
												$nome_tf = $sqlline['fone_fixo'];
												$nome_tfm = $sqlline['fone_movel'];
												$nome_tfz = $sqlline['fone_zap'];
												$nome_email = $sqlline['email'];
												$data = $sqlline['data_cadastro'];

												//trabalhando a data
												$data2 = implode('/', array_reverse(explode('-', $data)));



											?>

												<tr>

													<td><?php echo $uc; ?></td>


													<td><?php echo $nome_user; ?></td>
													<td><?php echo $cpfcnpj; ?></td>

													<td><?php echo $data2; ?></td>


													<td>
														<!--chamando modal para envio de mensagem-->
														<a class="text-primary" title="Ver Perfil" href="admin.php?acao=requerimento&func=perfil&id=<?php echo $uc; ?>"><i class="fas fa-id-card"></i></a>

														<a class="text-secondary" title="Criar Requerimento" href="admin.php?acao=requerimento&func=criar&id=<?php echo $uc; ?>"><i class="fas fa-plus-square"></i></a>
													</td>
												</tr>
												</tr>


											<?php } ?>
										</tbody>
									</table>


								</div>
							<?php } else { ?>

								<p class="danger">Não foram encontrados registros com esses parametros!</p>

							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>

</body>

</html>
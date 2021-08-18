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
	<title>post3</title>
</head>

<body>

	<?php

	$id_unidade_consumidora = $_POST['id_unidade_consumidora'];
	$localidade = 01;
	//completando com zeros a esquerda
	$id_unidade_consumidora = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);



	$result_sp3 = mysqli_query(
		$conexao,
		"CALL sp_seleciona_unidade_consumidora($localidade,$id_unidade_consumidora);"
	) or die("Erro na query da procedure: " . mysqli_error($conexao));
	mysqli_next_result($conexao);
	$row = mysqli_num_rows($result_sp3);
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
											while ($row_uc = mysqli_fetch_array($result_sp3)) {

												$nome_razao_social        = $row_uc['NOME'];
												$numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
												$data_cadastro            = $row_uc['CADASTRO'];


												//trabalhando a data
												//$data2 = implode('/', array_reverse(explode('-', $data)));

											?>

												<tr>

													<td><?php echo $id_unidade_consumidora; ?></td>
													<td><?php echo $nome_razao_social; ?></td>
													<td><?php echo $numero_cpf_cnpj; ?></td>
													<td><?php echo $data_cadastro; ?></td>


													<td>
														<!--chamando modal para envio de mensagem-->
														<a class="text-primary" title="Ver Perfil" href="admin.php?acao=requerimento&func=perfil&id=<?php echo $id_unidade_consumidora; ?>"><i class="fas fa-id-card"></i></a>

														<a class="text-secondary" title="Criar Requerimento" href="admin.php?acao=requerimento&func=criar&id=<?php echo $id_unidade_consumidora; ?>"><i class="fas fa-plus-square"></i></a>
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
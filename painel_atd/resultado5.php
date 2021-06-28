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
	<title>Busca poe endereço dinamica2</title>
</head>

<body>

	<?php

	$id_localidade		= $_POST['id_localidade2'];
	$id_bairro			= $_POST['id_bairro2'];
	$id_logradouro		= $_POST['id_logradouro2'];
	$numero_logradouro  = $_POST['numero_logradouro2'];

	//executa o store procedure info endereço
	$result = mysqli_query(
		$conexao,
		"CALL sp_lista_unidade_consumidora_logradouro($id_localidade,$id_bairro,$id_logradouro,'$numero_logradouro','');"
	) or die("Erro na query da procedure5: " . mysqli_error($conexao));
	mysqli_next_result($conexao);
	$row = mysqli_num_rows($result);

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
												N°
											</th>



											<th>
												Ações
											</th>
										</thead>
										<tbody>

											<?php
											while ($row_u = mysqli_fetch_array($result)) {

												$uc 				= $row_u["UC"];
												$id_localidade		= $row_u["LOCALIDADE"];
												$id_bairro 			= $row_u['BAIRRO'];
												$nome_razao_social  = $row_u['NOME'];
												$numero_cpf_cnpj	= $row_u['CPF_CNPJ'];
												$id_logradouro	    = $row_u['LOGRADOURO'];
												$numero_logradouro  = $row_u['NUMERO'];

											?>

												<tr>

													<td><?php echo $uc; ?></td>
													<td><?php echo $nome_razao_social; ?></td>
													<td><?php echo $numero_cpf_cnpj; ?></td>
													<td><?php echo $numero_logradouro; ?></td>

													<td>
														<!--chamando modal para envio de mensagem-->
														<a class="text-primary" title="Ver Perfil" href="atendimento.php?acao=requerimento&func=perfil&id=<?php echo $uc; ?>&id_localidade=<?php echo $id_localidade; ?>"><i class="fas fa-id-card"></i></a>

														<a class="text-secondary" title="Criar Requerimento" href="atendimento.php?acao=requerimento&func=criar&id=<?php echo $uc; ?>"><i class="fas fa-plus-square"></i></a>
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
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

if ($_SESSION['nivel_usuario'] != '2' && $_SESSION['nivel_usuario'] != '0') {
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

	$id_localidade  = $_POST['id_localidade'];
	$id_bairro	    = $_POST['id_bairro'];
	if ($id_bairro == '---Escolha uma opção---') {
		$id_bairro = '0';
	}
	@$id_logradouro  = $_POST['id_logradouro'];
	if ($id_logradouro == '---Escolha uma opção---') {
		$id_logradouro = '0';
	} elseif ($id_logradouro == '') {
		$id_logradouro = '0';
	}

	$fat_atrazo 	= $_POST['fat_atrazo'];
	if ($fat_atrazo == '') {
		echo "<script language='javascript'>window.alert('Prencha a quantidade de faturas!!!'); </script>";
		exit;
	}

	//executa o store procedure info corte
	$result_sp = mysqli_query(
		$conexao,
		"CALL sp_lista_corte_debito($id_localidade,$id_bairro,$id_logradouro,$fat_atrazo);"
	) or die("Erro na query da procedure sp: " . mysqli_error($conexao));
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
									<form action="rel_corte.php" method="POST" target="_blank">
										<table class="table table-sm table-hover">
											<thead class="text-secondary">

												<ul>
													<div class="row" style="margin-left: -50px;">

														<div class="form-group col-md-2">
															<label for="fornecedor">Tipo de Relatório</label>
															<select class="form-control mr-2" id="tipo" name="tipo" style="text-transform:uppercase;">

																<option value="01">Interno</option>
																<option value="02">Externo</option>

															</select>
														</div>

														<div class="form-group col-md-2">
															<label for="fornecedor">Status</label>
															<select class="form-control mr-2" id="tipo_status" name="tipo_status" style="text-transform:uppercase;">

																<option value="T">Todos</option>
																<option value="A">Ativa</option>
																<option value="I">Inativa</option>

															</select>
														</div>

														<div class="form-group col-md-2" style="top: 22px;">
															<input type="button" class="btn btn-danger form-control" value="Imprimir" onclick="javascript:submitForm(this.form, 'rel_corte.php');" />
														</div>

													</div>

												</ul>

												<th>
													Matrícula
												</th>
												<th>
													Nome
												</th>
												<th>
													Logradouro
												</th>
												<th>
													N°
												</th>
												<th>
													Bairro
												</th>
												<th>
													Em atraso
												</th>
												<th>
													Total Faturado
												</th>

												<th>
													Ações
												</th>
											</thead>
											<tbody>

												<?php
												while ($res = mysqli_fetch_array($result_sp)) {

													$uc				 	 = $res["N.º UC"];
													$nome_razao_social	 = $res["NOME"];
													$total_faturado	 	 = $res["TOTAL"];
													$nome_logradouro 	 = $res["LOGRADOURO"];
													$numero_logradouro	 = $res["NÚMERO"];
													$nome_bairro	 	 = $res["BAIRRO"];
													$qtde				 = $res["QTDE"];

													$id_usuario_editor = $_SESSION['id_usuario'];

												?>

													<tr>

														<td class="text-danger"><?php echo $uc; ?></td>
														<td><?php echo $nome_razao_social; ?></td>
														<td><?php echo $nome_logradouro; ?></td>
														<td><?php echo $numero_logradouro; ?></td>
														<td><?php echo $nome_bairro; ?></td>
														<td><?php echo $qtde; ?></td>
														<td><?php echo $total_faturado; ?></td>

														<td>
															<!--chamando modal para envio de mensagem-->
															<a class="text-success" title="Ordem de Serviço para Corte" target="_blank" href="processa_os_corte.php?acao=corte&func=perfil&id=<?php echo $uc; ?>&id_localidade=<?php echo $id_localidade; ?>"><i class="fas fa-id-card"></i></a>

															<input type="text" name="id_localidade" id="id_localidade" value="<?php echo $id_localidade; ?>" style="display: none;">

															<input type="text" name="id_logradouro" id="id_logradouro" value="<?php echo $id_logradouro; ?>" style="display: none;">

															<input type="text" name="id_bairro" id="id_bairro" value="<?php echo $id_bairro; ?>" style="display: none;">

															<input type="text" name="fat_atrazo" id="fat_atrazo" value="<?php echo $fat_atrazo; ?>" style="display: none;">

															<input type="text" name="status" id="status" value="<?php echo $status; ?>" style="display: none;">



															<!--
														<a class="text-success" title="Iniciar Processamento" href="admin.php?acao=baixa&func=baixa&id=<?php echo $uc; ?>&mes_faturado=<?php echo $rData; ?>"> <i class="fas fa-play"></i></a>
														-->
														</td>
													</tr>
													</tr>


												<?php } ?>
											</tbody>
										</table>
									</form>

									<script>
										//chamando função de soma dinamica de checkbox
										$('input[type="checkbox"]').on('change', function() {
											//declarando variaveis
											var total = 0;
											var valores = 0;
											//pegando valores
											$('input[type="checkbox"]:checked').each(function() {
												//somando valores inteiros e boleanos
												total += parseInt($(this).val());
												valores += parseFloat($(this).data('valor'));
											});
											//enviando valores convertendo para moeda brasileira
											$('input[name="totalValor"]').val(valores.toLocaleString('pt-br', {
												style: 'currency',
												currency: 'BRL'
											}));
											//$('.servicos').html(servicos);
										});
									</script>

									<script type="text/javascript">
										//post alternativo
										function submitForm(form, action) {
											form.action = action;
											form.submit();
										}
									</script>
									<script>
										$(document).ready(function() {

											$('#todos').click(function() {
												var val = this.checked;
												//aler(val);
												$('.lista').each(function() {
													$(this).prop('checked', val);

												});

											});

										});
									</script>


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
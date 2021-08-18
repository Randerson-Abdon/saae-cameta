<?php
session_start();
include_once('../../conexao.php');
include_once('../controller/controller_acordos.php');

?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<title>Acordos</title>
</head>

<body>

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

	$id_unidade_consumidora = $_POST['id_unidade_consumidora'];
	$status					= $_POST['status'];
	$localidade 			= $_POST['id_localidade'];

	$id_unidade_consumidora = str_pad($id_unidade_consumidora, 5, '0', STR_PAD_LEFT);
	$result = listaAcordos($status, $localidade, $id_unidade_consumidora);

	$linha_count = mysqli_num_rows($result);
	$row = mysqli_num_rows($result);

	?>
	<section>
		<?php
		if ($row > 0) {

			//executa o store procedure info consumidor
			$result_sp2 = listaConsumidor($localidade, $id_unidade_consumidora);
			mysqli_next_result($conexao);
			$row_uc = mysqli_fetch_array($result_sp2);
			$nome_razao_social        = $row_uc['NOME'];
			$tipo_juridico            = $row_uc['TIPO_JURIDICO'];
			$numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
			$numero_rg                = $row_uc['N.º RG'];
			$orgao_emissor_rg         = $row_uc['ORGAO_EMISSOR'];
			$uf_rg                    = $row_uc['UF'];
			$fone_fixo                = $row_uc['FONE_FIXO'];
			$fone_movel               = $row_uc['CELULAR'];
			$fone_zap                 = $row_uc['ZAP'];
			$email                    = $row_uc['EMAIL'];
			$tipo_consumo             = $row_uc['TIPO_CONSUMO'];
			$faixa_consumo            = $row_uc['FAIXA'];
			$tipo_medicao             = $row_uc['MEDICAO'];
			$id_unidade_hidrometrica  = '';
			$valor_faixa_consumo      = $row_uc['VALOR'];
			$nome_localidade          = $row_uc['LOCALIDADE'];
			$nome_bairro              = $row_uc['BAIRRO'];
			$nome_logradouro          = $row_uc['LOGRADOURO'];
			$numero_logradouro        = $row_uc['NUMERO'];
			$complemento_logradouro   = $row_uc['COMPLEMENTO'];
			$cep_logradouro           = $row_uc['CEP'];
			$tipo_enderecamento       = $row_uc['CORRESPONDENCIA'];
			$status_ligacao           = $row_uc['STATUS'];
			$data_cadastro            = $row_uc['CADASTRO'];
			$observacoes_text         = $row_uc['OBSERVAÇÕES'];

			$id_acordo = $_SESSION['id_acordo_firmado'];

			$valida_botao = validaBotao($id_acordo);


		?>

			<div class="content">
				<div class="row mr-3">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<form action="rel_acordo.php" method="POST" target="_blank">
										<table class="table table-striped table-sm">
											<thead class="text-secondary">

												<ul class="text-secondary">

													<li>
														<b>UC:</b> <?php echo $id_unidade_consumidora; ?>
														&nbsp;&nbsp;<b>CPF/ CNPJ: </b> <?php echo $numero_cpf_cnpj; ?>
														&nbsp;&nbsp;<b>Status da Ligação:</b> <?php echo $status_ligacao; ?>
													</li>

													<li>
														<b>Nome /Razão Social:</b> <?php echo $nome_razao_social; ?>
														&nbsp;&nbsp;<b>Endereço:</b> <?php echo $nome_logradouro; ?> <?php echo $numero_logradouro; ?>, BAIRRO <?php echo $nome_bairro; ?>
													</li>

												</ul>

												<ul>
													<div class="row">
														<?php if ($linha_count != 0) { ?>
															<div class="form-group col-md-2" style="margin-left: -50px;">
																<input type="button" class="btn btn-info form-control ml-3 mr-4" value="Imprimir" onclick="javascript:submitForm(this.form, 'rel_acordo.php');" />
															</div>
														<?php } ?>

														<?php

														if ($valida_botao > 0) { ?>
															<div class="form-group col-md-3">
																<a style="height: 100%;" class="btn btn-danger" title="Cancelar Acordo" href="atendimento.php?acao=cancela_acordos&id=<?php echo $id_acordo; ?>"> Cancelar Acordo</a>
															</div>
														<?php } ?>
													</div>
												</ul>

												<th>
													N° do Contrato
												</th>
												<th>
													N° da Parcela
												</th>
												<th>
													Competência
												</th>

												<?php if ($status == 'PAGA') { ?>
													<th>
														Data de Pagamento
													</th>
												<?php } ?>


												<th>
													Ações
												</th>

											</thead>
											<tbody>

												<?php
												while ($row = mysqli_fetch_array($result)) {

													$id = $row['N.º UC'];
													$valor = $row['VALOR'];

													$id_acordo_firmado = $row['N.º CONTRATO'];
													$id_acordo_firmado = str_pad($id_acordo_firmado, 6, '0', STR_PAD_LEFT);
													$_SESSION['id_acordo_firmado'] = $id_acordo_firmado;

													$competencia = $row['COMPETÊNCIA'];
													$numero_parcela = $row['N.º PARC.'];
													$vencimento = $row['VENCTO'];
													$data_pagamento = $row['PGTO'];

													//consulta para recuperação do nome da localidade
													//$query_loc = "select * from localidade where id_localidade = '$id_localidade' ";
													//$result_loc = mysqli_query($conexao, $query_loc);
													//$row = mysqli_fetch_array($result_loc);
													//vai para a modal
													//$nome_loc = $row['nome_localidade'];


												?>

													<tr>

														<td><?php echo $id_acordo_firmado; ?></td>
														<td><?php echo $numero_parcela; ?></td>

														<td><?php if ($competencia == '') {
																echo 'ENTRADA';
															} else {
																echo $competencia;
															} ?></td>

														<?php if ($status == 'PAGA') { ?>
															<td><?php echo $data_pagamento; ?></td>
														<?php } ?>

														<td>

															<?php if ($numero_parcela == '00/00') { ?>
																<a class="btn btn-success btn-sm" title="Gerar Boleto" target="_blank" href="../lib/boleto/boleto_cef_entrada.php?id=<?php echo $id; ?>&competencia=<?php echo $competencia; ?>&valor=<?php echo $valor; ?>&vencimento=<?php echo $vencimento; ?>&acordo=<?php echo $id_acordo_firmado; ?>&numero_parcela=<?php echo $numero_parcela; ?>&id_localidade=<?php echo $localidade; ?>"><i class="fas fa-file-invoice"></i></a>
															<?php } ?>

															<?php if ($numero_parcela != '00/00') { ?>
																<a class="btn btn-danger btn-sm" href="javascript:alert('Parcela lançada na próxima fatura!!!')" ;><i class="fas fa-ban"></i></a>
															<?php } ?>

															<input type="text" name="id_unidade_consumidora" id="id" value="<?php echo $id_unidade_consumidora; ?>" style="display: none;">
															<input type="text" name="status" id="id" value="<?php echo $status; ?>" style="display: none;">
															<input type="text" name="id_localidade" id="id" value="<?php echo $localidade; ?>" style="display: none;">
														</td>
													</tr>
													</tr>


												<?php } ?>
											</tbody>
										</table>
									</form>
									<script type="text/javascript">
										function submitForm(form, action) {
											form.action = action;
											form.submit();
										}
									</script>
									<script></script>


								</div>
							<?php  } else { ?>

								<p class="h5 text-danger">Nâo foram encontrados registros com esses parametros!</p>

							<?php } ?>
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
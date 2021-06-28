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

if ($_SESSION['nivel_usuario'] != '4' && $_SESSION['nivel_usuario'] != '0') {
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

	$codigo_barras = $_POST['codigo_barras'];
	$id_termo_abertura_encerramento = $_POST['id_termo_abertura_encerramento'];
	$id_caixa = $_POST['id_caixa'];
	$juros_multas = $_POST['juros_multas'];
	$id_usuario_editor  = $_SESSION['id_usuario'];

	//echo $juros_multas;


	if ($codigo_barras == '') {

		echo "<script language='javascript'>window.alert('Campo CÓDIGO DE BARRAS está vazio!!!'); </script>";
		exit;
	}

	$codigo_barras = preg_replace("/[^0-9]/", "", $codigo_barras);

	// 826300000005112805650721017140120134494201708109 

	// 826200000006119105650129020 100001187022202101022	novo localidade no 31
	// 826100000007234305650223018 140010051689201803053  antigo localidade no 30

	// 826800000000238205651223020400001184022202012310    avulso novo 31
	// 826000000016567505650166434400010022345202012273

	$tipo_antigo = substr($codigo_barras, 27, 3);
	$localidade_antigo = substr($codigo_barras, 29, 2);

	$uc = substr($codigo_barras, 33, 2) . substr($codigo_barras, 36, 3); //Matrícula
	$data_recebimento_fatura = date('Y-m-d');

	if ($tipo_antigo == '140') {
		$localidade = substr($codigo_barras, 30, 2);
	} else {
		$localidade = substr($codigo_barras, 31, 2);
	}

	if ($tipo_antigo == '140') {
		$tipo_arrecadacao = '1000';
	} else {
		$tipo_arrecadacao = substr($codigo_barras, 27, 4);
	}

	if ($tipo_arrecadacao == '4000') {
		$mes_fatura_arrecadada = '0000/00';
	} else {
		$mes_fatura_arrecadada = substr($codigo_barras, 22, 1) . substr($codigo_barras, 24, 3) . '/' . substr($codigo_barras, 20, 2);
	}


	$valor_arrecadacao = substr($codigo_barras, 4, 7) . substr($codigo_barras, 12, 4);
	$valor_arrecadacao = number_format($valor_arrecadacao, 2, ".", "") / 100;



	$data_vencimento_fatura = strtotime(substr($codigo_barras, 45, 2) . '-' . substr($codigo_barras, 43, 2) . '-' . substr($codigo_barras, 39, 4));
	$data_vencimento_fatura = date('Y-m-d', $data_vencimento_fatura);

	// CALCULO DOS DIAS VENCIDOS
	// converte as datas para o formato timestamp
	$d1 = strtotime($data_recebimento_fatura);
	$d2 = strtotime($data_vencimento_fatura);

	// verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
	$numero_dias_atraso = ($d2 - $d1) / 86400;

	// caso a data 2 seja menor que a data 1, multiplica o resultado por -1
	if ($numero_dias_atraso < 0)
		$numero_dias_atraso *= -1;

	if ($d1 < $d2) {
		$numero_dias_atraso = 0;
	}

	// CALCULO DOS MESES VENCIDOS
	// verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
	$numero_meses_atraso = ($d2 - $d1) / 2592000;

	// caso a data 2 seja menor que a data 1, multiplica o resultado por -1
	if ($numero_meses_atraso < 0)
		$numero_meses_atraso *= -1;

	if ($d1 < $d2) {
		$numero_meses_atraso = 0;
	} else {
		$numero_meses_atraso = floor($numero_meses_atraso);
	}

	// CALCULANDO VALOR DA MULTA
	if ($numero_dias_atraso > 0) {
		$valor_multa2 = round($valor_arrecadacao * 0.02, 2);
	} else {
		$valor_multa2 = 0;
	}

	// CALCULANDO VALOR DA JUROS
	if ($numero_dias_atraso > 0) {
		$valor_juros2 = round($valor_arrecadacao * 0.0033333 * $numero_dias_atraso, 2);
	} else {
		$valor_juros2 = 0;
	}

	if ($juros_multas == 'N') {
		$valor_multa = 0.00;
		$valor_juros = 0.00;
	} else {
		$valor_multa = $valor_multa2;
		$valor_juros = $valor_juros2;
	}

	$valor_total_arrecadacao = $valor_arrecadacao + $valor_multa + $valor_juros;

	//echo $numero_dias_atraso . ' dias e ' . $numero_meses_atraso . ' meses de atraso e valor: ' . $valor_arrecadacao . ' + multa de ' . $valor_multa . ' + juros de ' . $valor_juros . ' seu valor total é ' . $valor_total_arrecadacao;


	//trazendo info cx_caixa_permanente
	$query_cp = "SELECT * from cx_caixa_permanente where id_unidade_consumidora = '$uc' and mes_fatura_arrecadada = '$mes_fatura_arrecadada' and tipo_arrecadacao = '$tipo_arrecadacao' and valor_total_arrecadacao = '$valor_total_arrecadacao' and data_vencimento_fatura = '$data_vencimento_fatura' ";
	$result_cp = mysqli_query($conexao, $query_cp);
	$res_cp = mysqli_fetch_array($result_cp);

	$row_cp = mysqli_num_rows($result_cp);

	if ($row_cp > 0) {
		echo "<script language='javascript'>window.alert('Fatura já se encontra paga!'); </script>";
		exit;
	}

	//trazendo info cx_caixa_temporario
	$query_ct = "SELECT * from cx_caixa_temporario where id_unidade_consumidora = '$uc' and mes_fatura_arrecadada = '$mes_fatura_arrecadada' ";
	$result_ct = mysqli_query($conexao, $query_ct);
	@$res_ct = mysqli_fetch_array($result_ct);

	$row_ct = mysqli_num_rows($result_ct);
	if ($row_ct > 0) {
		echo "<script language='javascript'>window.alert('Fatura já se encontra na lista de pagamento!'); </script>";

		//trazendo info cx_caixa_temporario
		$query = "SELECT * from cx_caixa_temporario where id_unidade_consumidora = '$uc' ";
		$result = mysqli_query($conexao, $query);
	} else {
		// Insert na tabela de temporaria
		$query_temp = "INSERT INTO cx_caixa_temporario (id_termo_abertura_encerramento, data_recebimento_fatura, id_caixa, id_localidade, id_unidade_consumidora, tipo_arrecadacao, mes_fatura_arrecadada, data_vencimento_fatura, numero_dias_atraso, numero_meses_atraso, valor_arrecadacao, valor_multa, valor_juros, valor_total_arrecadacao) values ('$id_termo_abertura_encerramento', '$data_recebimento_fatura', '$id_caixa', '$localidade', '$uc', '$tipo_arrecadacao', '$mes_fatura_arrecadada', '$data_vencimento_fatura', '$numero_dias_atraso', '$numero_meses_atraso', '$valor_arrecadacao', '$valor_multa', '$valor_juros', '$valor_total_arrecadacao')";

		$result_temp = mysqli_query($conexao, $query_temp);

		if ($result_temp == '') {
			echo "<script language='javascript'>window.alert('Ocorreu um erro ao incluir!'); </script>";
		} else {
			echo "<script language='javascript'>window.alert('Incluido com Sucesso!'); </script>";
		}

		//trazendo info cx_caixa_temporario
		$query = "SELECT * from cx_caixa_temporario where id_caixa = '$id_caixa' ";
		$result = mysqli_query($conexao, $query);
	}


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
									<table class="table table-striped table-sm" style="font-size: 10pt;">
										<thead class="text-secondary">

											<th>
												Matrícula
											</th>
											<th>
												Nome/Razão Social
											</th>
											<th>
												Status
											</th>
											<th>
												Tipo
											</th>
											<th>
												Competência
											</th>
											<th>
												Vencimento
											</th>
											<th>
												Fatura
											</th>
											<th>
												Multa
											</th>
											<th>
												Juros
											</th>
											<th>
												Total Geral
											</th>

										</thead>
										<tbody>

											<?php

											while ($res = mysqli_fetch_array($result)) {
												$tipo_arrecadacao        = $res["tipo_arrecadacao"];
												$mes_faturado      		 = $res["mes_fatura_arrecadada"];
												$id_unidade_consumidora      		 = $res["id_unidade_consumidora"];

												$vencimento   			 = $res["data_vencimento_fatura"];
												@$vencimento = explode("-", $vencimento);
												@$vencimento = $vencimento[2] . '/' . $vencimento[1] . '/' . $vencimento[0];

												$mes_faturado            = $res['mes_fatura_arrecadada'];
												$valor_arrecadacao       = $res['valor_arrecadacao'];
												$valor_multa             = $res["valor_multa"];
												$valor_juros             = $res["valor_juros"];
												$valor_total_arrecadacao = $res["valor_total_arrecadacao"];

												$id_usuario_editor        = $_SESSION['id_usuario'];

												$result_sp = mysqli_query(
													$conexao,
													"CALL sp_seleciona_unidade_consumidora($localidade,$id_unidade_consumidora);"
												) or die("Matrícula inexistente: " . mysqli_error($conexao));
												mysqli_next_result($conexao);
												while ($row_uc = mysqli_fetch_array($result_sp)) {
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
													$observacoes              = $row_uc['OBSERVAÇÕES'];

													$ta2 = substr($tipo_arrecadacao, 1, 2);
													if ($ta2 == '2') {
														$dm2 = ', juros e multas';
													}

													$ta3 = substr($tipo_arrecadacao, 2, 3);
													if ($ta3 == '3') {
														$dm3 = ', parcelas de acordos';
													}

													$ta4 = substr($tipo_arrecadacao, 3, 4);
													if ($ta4 == '4') {
														$dm4 = ', serviços';
													}

													$ta1 = substr($tipo_arrecadacao, 0, 1);
													if ($ta1 == '1') {
														$descricao_movimento = 'Fatura normal' . @$dm2 . @$dm3 . @$dm4;
													} elseif ($ta1 == '2') {
														$descricao_movimento = 'Entrada de acordo';
													} elseif ($ta1 == '3') {
														$descricao_movimento = 'Valor de serviços';
													} elseif ($ta1 == '4') {
														$descricao_movimento = 'Fatura avulsa';
													} elseif ($ta1 == '0') {
														$descricao_movimento = 'Parcela de acordo';
													}

													//echo $ta1 . ', ' . $tipo_arrecadacao;

													if ($ta1 == '4') {
														$mes_faturado = 'Avulso';
													}


											?>

													<tr>

														<td><?php echo $id_unidade_consumidora ?></td>
														<td><?php echo $nome_razao_social ?></td>
														<td><?php echo $status_ligacao ?></td>
														<td><?php echo $descricao_movimento; ?></td>
														<td><?php echo $mes_faturado ?></td>
														<td><?php echo $vencimento ?></td>
														<td><?php echo $valor_arrecadacao ?></td>
														<td><?php echo $valor_multa ?></td>
														<td><?php echo $valor_juros ?></td>
														<td><?php echo $valor_total_arrecadacao ?></td>

													</tr>
													</tr>


											<?php }
											} ?>
										</tbody>
									</table>


								</div>
							<?php } else {

							echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!!!'); </script>";
						}
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
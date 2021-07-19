<?php
session_start(); # Deve ser a primeira linha do arquivo   
include_once('../conexao.php');
// arquivo  Que contém todas as funções
require "config/funcoes.php";

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
	header('Location: ../login.php');
	exit();
}
?>

<style>
	@media print {
		#noprint {
			display: none;
		}

		#close {
			display: none;
		}

		#myModal {
			overflow: hidden;
		}

		body {
			background: #fff;
		}
	}

	#imgpos {
		margin-left: -140%;
		top: 30%;
		/* posiciona a 70px para baixo */
		display: none;
		z-index: 10 !important;
		position: absolute;
	}
</style>

<bady>

	<?php
	if (isset($_POST['acao']) && $_POST['acao'] == "gerarParcelas") {
		$parcela	    = intval($_POST['parcela']); // nr. parcelas
		$valorTotal		= $_POST['valorTotal']; // valor a ser parcelado
		$valorEntrada   = $_POST['valorEntrada']; // valor da entrada

		$data 		    = $_POST['data']; // data

		$dataVencimentoParcela	= calcularVencimentoParcelas($data, $parcela);
		$dataVencimentoParcela2	= calcularVencimentoParcelas2($data, $parcela);
		$valorParcela	= calcularValorParcelas($valorTotal, $valorEntrada, $parcela);
		$valor_p = $_SESSION['valor'];
		$valor_total = @$_SESSION['valor_total'];
		$nParcelas = @$_SESSION['nParcelas'];

	?>
		<table class="table table-sm" style="width: 400px; margin-left: -200px;">
			<thead class="text-secondary">

				<th>
					Parcela
				</th>
				<th>
					Valor (R$)
				</th>
				<th>
					Vencimento
				</th>

			</thead>
			<tbody>

				<?php
				for ($i = 1; $i <= $nParcelas; $i++) {
					if ($i == $nParcelas) $valor_p = $valor_p + $valor_total;


				?>

					<tr>

						<td class="bg-primary text-white"><?php echo $i; ?></td>

						<td>
							<div class="form-group">
								<input style="margin-bottom: -15px;" class="bg-primary text-white" type="text" class="form-control vlrParcela" id="valorParcela" name="valorParcela[]" value="<?= number_format($valor_p, 2, ",", "."); ?>" />
							</div>
						</td>

						<td>
							<input style="margin-bottom: -15px;" class="bg-primary text-white" type="text" class="form-control" id="dataVencimentoParcela" name="dataVencimentoParcela[]" maxlength="10" value="<?= $dataVencimentoParcela[$i] ?>" />
						</td>



					</tr>

				<?php } ?>


			</tbody>
			<tfoot>
				<tr>

					<td></td>
					<td colspan="3" align="right">

						<input type="button" value="VOLTAR" class="btn btn-primary" onclick="window.close();">
						<input type="submit" value="ENVIAR" id="myP" onclick="myFunction();" class="btn btn-success">
					</td>


				</tr>

				<script>
					function myFunction() {

						$('#imgpos').show();

					}
				</script>

			</tfoot>

		</table>
		<div id="consulta5" class="toggle div-inline">
			<label class="text-justify text-danger" for="id_produto" style="margin-left: -200px;">Para a efetivação do contrato de parcelamento e confissão de dívida é necessário que o mesmo seja lido e assinado, pelo consumidor, em duas vias. Para visualizar/imprimir o contrato <a data-toggle="modal" data-target="#myModal"><span class="text-success" style="cursor: pointer;"><u>CLIQUE AQUI.</u></span></a><br><br></label>
		</div>

		<?php if ($nParcelas > 10) { ?>
			<style>
				#imgpos {
					margin-left: -140%;
					top: 40%;
					/* posiciona a 70px para baixo */
					display: none;
					z-index: 10 !important;
					position: absolute;
				}
			</style>
		<?php } ?>
		<?php if ($nParcelas > 20) { ?>
			<style>
				#imgpos {
					margin-left: -140%;
					top: 50%;
					/* posiciona a 70px para baixo */
					display: none;
					z-index: 10 !important;
					position: absolute;
				}
			</style>
		<?php } ?>
		<?php if ($nParcelas > 30) { ?>
			<style>
				#imgpos {
					margin-left: -140%;
					top: 60%;
					/* posiciona a 70px para baixo */
					display: none;
					z-index: 10 !important;
					position: absolute;
				}
			</style>
		<?php } ?>
		<?php if ($nParcelas > 40) { ?>
			<style>
				#imgpos {
					margin-left: -140%;
					top: 70%;
					/* posiciona a 70px para baixo */
					display: none;
					z-index: 10 !important;
					position: absolute;
				}
			</style>
		<?php } ?>
		<?php if ($nParcelas > 50) { ?>
			<style>
				#imgpos {
					margin-left: -140%;
					top: 80%;
					/* posiciona a 70px para baixo */
					display: none;
					z-index: 10 !important;
					position: absolute;
				}
			</style>
		<?php } ?>




	<?php } ?>


	<?php
	if (isset($_POST['acao']) && $_POST['acao'] == "recalcularParcelas") {
		$parcela	    = intval($_POST['parcela']); // nr. parcelas
		$valorTotal     = $_POST['valorTotal']; // valor a ser parcelado
		$valorEntrada   = $_POST['valorEntrada']; // valor da entrada

		$data 		    = $_POST['data']; // data

		// array
		$valoresParcelas = $_POST['valoresParcelas'];

		$dataVencimentoParcela	= calcularVencimentoParcelas($data, $parcela);
		$valorParcela	= recalcularValorParcelas($valorTotal, $valorEntrada, $valoresParcelas, $parcela);
	?>
		<table class="table table-bordered">
			<tbody>
				<!-- parcelas -->
				<tr>
					<td>Parcela</td>
					<td>Valor (R$)</td>
					<td>Data Vencimento</td>
				</tr>
				<?php
				for ($i = 1; $i <= $parcela; $i++) {
				?>
					<tr class="tr_<?= $i ?>">
						<td align="center"><?= $i ?></td>
						<td>
							<input type="text" class="form-control vlrParcela center" id="valorParcela" name="valorParcela[]" value="<?= $valorParcela[$i] ?>" />
						</td>
						<td>
							<input type="text" class="form-control center" id="dataVencimentoParcela" name="dataVencimentoParcela[]" maxlength="10" value="<?= $dataVencimentoParcela[$i] ?>" />
						</td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="3" align="right"><input type="submit" id="myP" onclick="myFunction()" value="ENVIAR" class="btn btn-primary">

					</td>
				</tr>

			</tbody>
		</table>
	<?php } ?>




	<?php
	if (isset($_POST['acao']) && $_POST['acao'] == "enviarDados") {

		$id_localidade 		= $_POST['id_localidade'];
		$id_acordo_firmado 	= $_POST['id_acordo_parcelamento'];
		$id 				= $_POST['id'];
		$data 				= $_POST['data'];
		$valorTotal 		= $_POST['valorTotal'];
		$valorEntrada  	    = $_POST['valorEntrada']; // valor da entrada
		$parcelas 			= $_POST['parcelas'];
		$id_usuario_editor  = $_SESSION['id_usuario'];
		$valorParcela 		= $_POST['valorParcela']; //array
		$dataVenctoParcela	= $_POST['dataVencimentoParcela']; //array		

		$query_n = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id' ";
		$result_n = mysqli_query($conexao, $query_n);
		$row_n = mysqli_fetch_array($result_n);
		$nome_razao_social = $row_n["nome_razao_social"];
		$numero_cpf_cnpj = $row_n["numero_cpf_cnpj"];

		$mes_faturado = $_SESSION['mes_faturado'];
		$soma2 = $_SESSION['soma2'];

		foreach ($mes_faturado as $meses) {

			$query = "UPDATE historico_financeiro SET id_acordo_parcelamento = '$id_acordo_firmado' where id_unidade_consumidora = '$id' AND mes_faturado = '$meses' ";
			$result = mysqli_query($conexao, $query);
		}

		// para inserir no banco de dados
		// basta descomentar da linha 101 a 118		
		$j = 0;
		for ($x = 1; $x <= $parcelas; $x++) {

			$parcelas = str_pad($parcelas, 2, '0', STR_PAD_LEFT);
			$x = str_pad($x, 2, '0', STR_PAD_LEFT);

			$sql = "INSERT INTO acordo_parcelamento(
						id_localidade,
						id_unidade_consumidora,
						id_acordo_parcelamento,
						numero_parcela,
						id_usuario_editor_registro,
						mes_lancamento_parcela,
						data_lancamento_parcela,
						valor_parcela
					 )VALUES(
						'$id_localidade',
						'$id',
						'$id_acordo_firmado',
						'$x/$parcelas',
						'$id_usuario_editor',
						'" . insertData($dataVenctoParcela[$j]) . "',
						curDate(),
						'" . formatarValor($valorParcela[$j]) . "'						
					 )";

			if (!$conexao->query($sql)) {
				die("<p class='erro'><strong>Erro!</strong> " . $conexao->error . "</p>");
			}
			$j++;
		}

		echo "<p class='sucesso'><strong>Sucesso!</strong> Dados cadastrados corretamente.<br> Não esqueça de gerar o <strong>boleto</strong> para pagamento da entrada de seu acordo!!!</p>";
		echo "<input type='submit' class='btn btn-danger' name='submit' value='Voltar' onClick='window.close();' style='margin-right: 20px;'>";
		echo "<a class='btn btn-success' title='Gerar Boleto' target='_blank' href='../lib/boleto_a/boleto_cef.php?id=$id&valor=$valorEntrada&acordo=$id_acordo_firmado&id_localidade=$id_localidade'>Gerar Boleto</a>";


		// usado para exibir os valores na tela
		// usado para exibir os valores na tela
		//$j = 0;
		//for($x = 1; $x <= $parcelas; $x++) {
		//	$sql = "INSERT INTO tabela(
		//			campo1,
		//			campo2,
		//			campo3
		//		 )VALUES(
		//			'".$x."',
		//			'".formatarData($dataVenctoParcela[$j])."',
		//			'".formatarValor($valorParcela[$j])."'
		//		 )";
		//	echo "#Parcela ".$x . " de " . $parcelas . " " . $dataVenctoParcela[$j] . "<br>";
		//	echo $sql.";<br>";
		//	$j++;
		//}
		// exemplos de mensagens
		// escolha qual usar
		//echo "<p class='sucesso'><strong>Sucesso!</strong> Dados cadastrados corretamente.</p>";
		//echo "<p class='info'><strong>Info!</strong> Este sistema permite gravar os dados em banco de dados.</p>";
		//echo "<p class='erro'><strong>Erro!</strong> Nome da tabela está incorreto.</p>";
		//echo "<p class='aviso'><strong>Aviso!</strong> Todos os campos devem ser preenchidos.</p>";
	}
	?>

	<?php
	if (isset($_POST['acao']) && $_POST['acao'] == "gerarParcelas") {

		$parcela	    = intval($_POST['parcela']); // nr. parcelas
		$valorTotal		= $_POST['valorTotal']; // valor a ser parcelado
		$valorEntrada   = $_POST['valorEntrada']; // valor da entrad
		$valorEntrada2 = str_replace(',', '.', $valorEntrada);
		$extenso_entrada = convert_number_to_words($valorEntrada2);

		$decimal = substr($valorEntrada, 2, 2);
		$decExtenso = (int)$valorEntrada - (int)substr($valorEntrada, 2, 2);

		$extenso_entrada2 = convert_number_to_words($decExtenso) . ' reais';

		$data 		    = $_POST['data']; // data

		$dataVencimentoParcela	= calcularVencimentoParcelas($data, $parcela);
		$valorParcela	= calcularValorParcelas($valorTotal, $valorEntrada, $parcela);
		$valor_p = $_SESSION['valor'];
		$valor_total = @$_SESSION['valor_total'];
		$nParcelas = @$_SESSION['nParcelas'];

		$id = $_SESSION['id'];
		$soma2 = $_SESSION['soma2'];
		$soma3 = str_replace('.', '', $soma2);
		$soma = str_replace(',', '.', $soma3);
		$extenso = convert_number_to_words($soma);

		$id_localidade2 = $_SESSION['id_localidade'];

		//executa o store procedure info consumidor
		$result_sp = mysqli_query(
			$conexao,
			"CALL sp_seleciona_unidade_consumidora($id_localidade2,$id);"
		) or die("Erro na query da procedure y: " . mysqli_error($conexao));
		mysqli_next_result($conexao);
		$row_uc = mysqli_fetch_array($result_sp);
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
		//$id_unidade_hidrometrica  = $row_uc['id_unidade_hidrometrica'];
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

		//trazendo info perfil_saae
		$query_ps = "SELECT * from perfil_saae";
		$result_ps = mysqli_query($conexao, $query_ps);
		$row_ps = mysqli_fetch_array($result_ps);
		@$nome_prefeitura = $row_ps['nome_prefeitura'];
		//mascarando cnpj
		@$cnpj_saae = $row_ps['cnpj_saae'];
		$p1 = substr($cnpj_saae, 0, 2);
		$p2 = substr($cnpj_saae, 2, 3);
		$p3 = substr($cnpj_saae, 5, 3);
		$p4 = substr($cnpj_saae, 8, 4);
		$p5 = substr($cnpj_saae, 12, 2);
		$saae_cnpj = $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4 . '-' . $p5;
		@$nome_bairro_saae = $row_ps['nome_bairro_saae'];
		@$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
		@$numero_imovel_saae = $row_ps['numero_imovel_saae'];
		@$nome_municipio = $row_ps['nome_municipio'];
		@$uf_saae = $row_ps['uf_saae'];
		@$nome_saae = $row_ps['nome_saae'];
		@$email_saae = $row_ps['email_saae'];
		@$logo_orgao = $row_ps['logo_orgao'];
		@$cep_saae = $row_ps['cep_saae'];
		@$fone_saae = $row_ps['fone_saae'];
		@$email_saae = $row_ps['email_saae'];

	?>



		<!-- Modal Contrato de acordo -->
		<div id="modalDiv">
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width: 100%;">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="width: 200%; margin-left: -50%;">
						<div id="close" class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">

							<p class="text-justify" style="padding-left: 5%; padding-right: 5%; font-size: 10pt;">
								<u><b>IDENTIFICAÇÃO DAS PARTES CONTRATANTES:</b></u><br>

								<b><u>DEVEDOR:</u></b><br>
								<span>NOME: <b><?php echo $nome_razao_social; ?></b></span>
								<span style="margin-left: 20px;">CPF: <b><?php echo $numero_cpf_cnpj; ?></b></span>
								<span style="margin-left: 20px;"> Matrícula: <b><?php echo $id; ?></b></span><br>

								<span>BAIRRO: <b><?php echo $nome_bairro; ?></b></span>
								<span style="margin-left: 20px;">LOGRADOURO: <b><?php echo $nome_logradouro; ?></b></span>
								<span style="margin-left: 20px;">Nº: <b><?php echo $numero_logradouro; ?></b></span>
								<span style="margin-left: 20px;">CEP: <b><?php echo $cep_logradouro; ?></b></span><br>
								<span>CREDOR: <b>SERVIÇO AUT. DE ÁGUA E ESGOTO DE <?php echo $nome_municipio; ?></b><br><br>

									As partes acima identificadas têm, entre sí, justo e acertado o presente <b>Contrato de Confissão e Parcelamento de Dívida</b>, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.<br>

									<br><b><u>OBJETO DO CONTRATO</u></b>:<br><br>

									<u><b>Cláusula 1ª</b></u>: O <b>DEVEDOR</b> através do presente reconhece expressamente que possui uma dívida a ser paga diretamente ao <b>CREDOR</b> consubstanciada no montante total de: <span><b>R$ <?php echo $soma2; ?></b></span> (<?php echo $extenso; ?>). Devidamente discriminada no <b>EXTRATO DE DÉBITO</b> em anexo a este contrato, com a devida anuência do <b>DEVEDOR</b>.<br><br>

									<u><b>Cláusula 2ª</b></u>: O <b>DEVEDOR</b> confessa que é inadimplente da quantia supracitada e que ressarcirá a mesma nas condições previstas neste contrato.<br><br>

									<u><b>DO PARCELAMENTO, INTERRUPÇÃO DO FORNECIMENTO E PENALIDADES:</b></u><br><br>

									<u><b>Cláusula 3ª</b></u>: Em acordo firmado no escritório ou balcão eletrônico do: SERVIÇO AUT. DE ÁGUA E ESGOTO DE <?php echo $nome_municipio; ?> fica acertado entre as partes o parcelamento total da dívida do cliente devedor que é de: <span><b>R$ <?php echo $soma2; ?></b></span> (<?php echo $extenso; ?>). Constituido de:<br>

									- ENTRADA: <b><span>R$ <?php echo $valorEntrada; ?></span> (<?php echo $extenso_entrada2; ?>), à vencer em: <span> <?php echo date("d/m/Y", time() + (5 * 86400)); ?></span>;</b><br>

									- PARCELAMENTO: <b>



										<?php
										$difValor = $valor_p + $valor_total;
										$difParcelas = $nParcelas - 1;

										if ($valor_total == 0) {
											echo $nParcelas . ' parcelas de R$ ' . number_format($valor_p, 2, ",", ".") . '.';
										} else {
											echo $difParcelas . ' parcelas de R$ ' . number_format($valor_p, 2, ",", ".") . ' e 1 parcela de R$ ' . number_format($difValor, 2, ",", ".") . '.';
										}


										?>

									</b>
							</p>

							<p class="text-justify" style="padding-left: 5%; padding-right: 5%; font-size: 10pt;">
								<b><u>PARÁGRAFO ÚNICO</u></b>:<br>

								Todas as parcelas acordadas neste instrumento serão acrescidas automaticamente nas faturas mensais do <b>DEVEDOR</b>, até que ocorra a total quitação do débito constante neste contrato.<br><br>
								<b><u>Cláusula 4ª</u></b>: <b>CASO HAJA DESCUMPRIMENTO</b> do acordo o fornecimento de água do devedor será interrompido, sendo normalizado somente após a quitação total da dívida.<br><br>

								<b><u>PARÁGRAFO ÚNICO</u></b>:<br>

								No caso de descumprimento do acordo firmado não será permitido ao devedor nova renegociação e seu fornecimento de água só será normalizado nos termos da <b>Cláusula 4ª</b> deste contrato.<br><br>
								<b><u>Cláusula 5ª</u></b>: O <b>DEVEDOR</b> pagará as faturas nos postos de arrecadação devidamente autorizados pelo SAAE, e nos termos acordados na <b>Cláusula 3ª</b>. Excluindo-se desse modo, qualquer outra forma de pagamento.<br><br>
								<b><u>Cláusula 6ª</u></b>: <b>EM CASO DE LIGAÇÃO CLANDESTINA</b> devidamente identificado por um funcionário do SAAE, designado para a fiscalização , fica o cliente ciente da aplicação de multa que varia de 1 (um) a 10 (dez) salários minimos vigentes no país. E na ocorrência de reincidência, aplicação de cobrança judicial e a inclusão do nome do <b>DEVEDOR</b> no sistema <b>SERASA</b>.<br><br>

								<b><u>PARÁGRAFO 1º</u></b>: Além das sansões previstas no Regulamento aprovado pelo Decreto Municipal nº 63 de 11/05/2012, fica o cliente ciente da pena no Art. 157 do Código Penal Brasileiro que diz: "Subtrair coisa móvel alheia, para sí ou para outrem, mediante grave ameaça ou violência a pessoa, ou depois de havê-la, por qualquer meio, de reduzido resistência".<br>
								PENA: Reclusão de 4 (quatro) a 10 (dez) anos, e multa.<br><br>
								<b><u>PARÁGRAFO 2º</u></b>: O Regulamento do SAAE, através do Decreto 63 de 11/05/2012 dá a esta Autarquia Municipal o pleno poder para aplicar as medidas necessárias estabecelidas neste contrato, inclusive no que tange a interrupção do fornecimento de água como prevê o Art. 72, incisos I, IV e VIII, atendendo o prazo estabelecido pelos incisos I e II do do parágrafo 1º do Art. 72.<br><br>
								<b><u>Cláusula 7ª</u></b>: FICA ELEITO O FORO DA COMARCA DE: <?php echo $nome_municipio; ?> para dirimir qualquer assunto referente ao presente contrato.<br><br><br>

								<span style="float: right;"><?php echo $nome_municipio; ?> (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
																									date_default_timezone_set('America/Sao_Paulo');
																									echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br>


							</p>

							<div id="noprint" class="modal-footer">
								<a class="btn btn-danger" target="_blank" href="rel_contrato.php?func=imprime&id=<?php echo $id; ?>&soma2=<?php echo $soma2; ?>&extenso_entrada2=<?php echo $extenso_entrada2; ?>&extenso=<?php echo $extenso; ?>&valorEntrada=<?php echo $valorEntrada; ?>&valor_p=<?php echo $valor_p; ?>&valor_total=<?php echo $valor_total; ?>&nParcelas=<?php echo $nParcelas; ?>&id_localidade=<?php echo $id_localidade2; ?>">Imprimir</a>
							</div>

						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
</bady>
<script>
	var checa = document.getElementsByName("toggle");
	var numElementos = checa.length;
	var bt = document.getElementById("myP");
	for (var x = 0; x < numElementos; x++) {
		checa[x].onclick = function() {
			// "input[name='toggle']:checked" conta os checkbox checados
			var cont = document.querySelectorAll("input[name='toggle']:checked").length;
			// ternário que verifica se há algum checado.
			// se não há, retorna 0 (false), logo desabilita o botão
			bt.disabled = cont ? false : true;
		}
	}
</script>
<script>
	window.onload = function() {
		var imprimir = document.querySelector("#imprimir");
		imprimir.onclick = function() {
			imprimir.style.display = 'none';
			window.print();

			var time = window.setTimeout(function() {
				imprimir.style.display = 'block';
			}, 1000);
		}
	}
</script>


<img src="../img/load.gif" width="100%" alt="logo do site Maujor" id="imgpos" />
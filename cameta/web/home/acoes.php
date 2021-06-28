    <?php
	session_start(); # Deve ser a primeira linha do arquivo
	// *** descomente esta linha para gravar no banco de dados
	require_once "conexao.php";
	// arquivo  Que contém todas as funções
	require "config/funcoes.php";
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
    </style>

    <bady>

    	<?php
		if (isset($_POST['acao']) && $_POST['acao'] == "gerarParcelas") {
			$parcela	    = intval($_POST['parcela']); // nr. parcelas
			$valorTotal		= $_POST['valorTotal']; // valor a ser parcelado
			$valorEntrada   = $_POST['valorEntrada']; // valor da entrada

			$data 		    = $_POST['data']; // data

			$dataVencimentoParcela	= calcularVencimentoParcelas($data, $parcela);
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
    					Data
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
    						<input type="submit" value="ENVIAR" id="myP" onclick="myFunction()" class="btn btn-success" disabled>
    					</td>


    				</tr>

    				<script>
    					function myFunction() {
    						document.getElementById("myP").style.cursor = "wait";
    					}
    				</script>

    			</tfoot>

    		</table>
    		<div id="consulta5" class="toggle div-inline">
    			<label class="text-justify text-danger" for="id_produto" style="margin-left: -200px;">Para a efetivação do contrato de parcelamento e confissão de dívida é necessário que você leia e concorde com os termos do mesmo. Para visualizar/imprimir o contrato, clique em termos do acordo, e para aceitar marque a seleção abaixo.<br><br></label>
    			<a data-toggle="modal" data-target="#myModal" style="margin-left: -200px;"><span class="text-success" style="cursor: pointer;"><u>Aceitar termos do acordo</u></span></a> <input style="margin-left: -200px;" type="checkbox" id="consultar-acervo" data-id="consultar-acervo" name="toggle">
    		</div>
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
			$id_acordo 			= $_POST['id_acordo_parcelamento'];
			$id 				= $_POST['id'];
			$data 				= $_POST['data'];
			$valorTotal 		= $_POST['valorTotal'];
			$valorEntrada  	    = $_POST['valorEntrada']; // valor da entrada
			$parcelas 			= $_POST['parcelas'];
			$id_usuario_editor  = '00';
			$valorParcela 		= $_POST['valorParcela']; //array
			$dataVenctoParcela	= $_POST['dataVencimentoParcela']; //array

			$query_n = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id' ";
			$result_n = mysqli_query($conexao, $query_n);
			$row_n = mysqli_fetch_array($result_n);
			$nome_razao_social = $row_n["nome_razao_social"];
			$numero_cpf_cnpj = $row_n["numero_cpf_cnpj"];


			$mes_faturado = $_SESSION['mes_faturado'];
			$soma2 = $_SESSION['soma2'];

			echo $soma2;


			foreach ($mes_faturado as $meses) {

				$query = "UPDATE historico_financeiro SET id_acordo_parcelamento = '$id_acordo' where id_unidade_consumidora = '$id' AND mes_faturado = '$meses' ";
				$result = mysqli_query($conexao, $query);
			}
			// copiando registro para historico_financeiro_devedor pago
			//$query_hfd = "INSERT INTO historico_financeiro SELECT * from historico_financeiro_devedor where id_unidade_consumidora = '$id' ";
			//$result_hfd = mysqli_query($conexao, $query_hfd);



			// para inserir no banco de dados
			// basta descomentar da linha 101 a 118
			$j = 0;
			for ($x = 1; $x <= $parcelas; $x++) {
				$sql = "INSERT INTO acordo_parcelamento(
						id_localidade,
						id_unidade_consumidora,
						id_acordo_parcelamento,
						numero_parcela,
						Id_usuario_editor_registro,
						mes_lancamento_parcela,
						data_lancamento_parcela,
						valor_parcela
					 )VALUES(
						'$id_localidade',
						'$id',
						'$id_acordo',
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
			echo "<a class='btn btn-success' title='Gerar Boleto' target='_blank' href='boleto/boleto_cef.php?id=$id&valor=$valorEntrada&acordo=$id_acordo'>Gerar Boleto</a>";


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
			$valorEntrada   = $_POST['valorEntrada']; // valor da entrada
			$valorEntrada2 = str_replace(',', '.', $valorEntrada);
			$extenso_entrada = convert_number_to_words($valorEntrada2);

			$decimal = substr($valorEntrada, 2, 2);
			$decExtenso = $valorEntrada - substr($valorEntrada, 2, 2);

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

			$query_n = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id' ";
			$result_n = mysqli_query($conexao, $query_n);
			$row_n = mysqli_fetch_array($result_n);
			$nome_razao_social = $row_n["nome_razao_social"];
			$numero_cpf_cnpj = $row_n["numero_cpf_cnpj"];

			$query_end = "SELECT * from endereco_instalacao where id_unidade_consumidora = '$id' ";
			$result_end = mysqli_query($conexao, $query_end);
			$row_end = mysqli_fetch_array($result_end);
			@$id_localidade = $row_end["id_localidade"];
			@$id_bairro = $row_end["id_bairro"];
			@$id_logradouro = $row_end["id_logradouro"];
			@$numero_logradouro = $row_end["numero_logradouro"];
			@$complemento_logradouro = $row_end["complemento_logradouro"];

			//trazendo info localidade
			$query_lo = "SELECT * from localidade where id_localidade = '$id_localidade' ";
			$result_lo = mysqli_query($conexao, $query_lo);
			$row_lo = mysqli_fetch_array($result_lo);
			@$nome_localidade = $row_lo["nome_localidade"];

			//trazendo info bairro
			$query_ba = "SELECT * from bairro where id_bairro = '$id_bairro' ";
			$result_ba = mysqli_query($conexao, $query_ba);
			$row_ba = mysqli_fetch_array($result_ba);
			@$nome_bairro = $row_ba["nome_bairro"];

			//trazendo info logradouro
			$query_log = "SELECT * from logradouro where id_logradouro = '$id_logradouro' ";
			$result_log = mysqli_query($conexao, $query_log);
			$row_log = mysqli_fetch_array($result_log);
			@$nome_logradouro = $row_log["nome_logradouro"];
			@$tipo_logradouro = $row_log["tipo_logradouro"];
			@$cep = $row_log["cep_logradouro"];

			//trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
			$query_tp = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$tipo_logradouro' ";
			$result_tp = mysqli_query($conexao, $query_tp);
			$row_tp = mysqli_fetch_array($result_tp);
			@$tipo = $row_tp['abreviatura_tipo_logradouro'];



		?>



    		<!-- Modal -->
    		<div id="modalDiv">
    			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width: 100%;">
    				<div class="modal-dialog" role="document">
    					<div class="modal-content" style="width: 200%; margin-left: -50%;">
    						<div id="close" class="modal-header">
    							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    						</div>
    						<div class="modal-body">

    							<!-- IMAGEM -->
    							<section class="page-section" id="imagem2">
    								<div class="container">
    									<!-- linha -->
    									<div class="row text-center">
    										<div class="slider" style="width: 100%;">
    											<img width="90%" height="90%" src="img/cabecalho.JPG" alt="">
    										</div>
    									</div>
    								</div>
    							</section>


    							<p class="text-justify" style="padding-left: 5%; padding-right: 5%; font-size: 10pt;">
    								<u><b>IDENTIFICAÇÃO DAS PARTES CONTRATANTES:</b></u><br>

    								<b><u>DEVEDOR:</u></b><br>
    								<span>NOME: <b><?php echo $nome_razao_social; ?></b></span>
    								<span style="margin-left: 20px;">CPF: <b><?php echo $numero_cpf_cnpj; ?></b></span>
    								<span style="margin-left: 20px;"> Matrícula: <b><?php echo $id; ?></b></span><br>

    								<span>BAIRRO: <b><?php echo $nome_bairro; ?></b></span>
    								<span style="margin-left: 20px;">LOGRADOURO: <b><?php echo $tipo . ' ' . $nome_logradouro; ?></b></span>
    								<span style="margin-left: 20px;">Nº: <b><?php echo $numero_logradouro; ?></b></span>
    								<span style="margin-left: 20px;">CEP: <b><?php echo $cep; ?></b></span><br>
    								<span>CREDOR: <b>SERVIÇO AUT. DE ÁGUA E ESGOTO DE SANTA IZABEL</b><br><br>

    									As partes acima identificadas têm, entre sí, justo e acertado o presente <b>Contrato de Confissão e Parcelamento de Dívida</b>, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.<br>

    									<br><b><u>OBJETO DO CONTRATO</u></b>:<br><br>

    									<u><b>Cláusula 1ª</b></u>: O <b>DEVEDOR</b> através do presente reconhece expressamente que possui uma dívida a ser paga diretamente ao <b>CREDOR</b> consubstanciada no montante total de: <span><b>R$ <?php echo $soma2; ?></b></span> (<?php echo $extenso; ?>). Devidamente discriminada no <b>EXTRATO DE DÉBITO</b> em anexo a este contrato, com a devida anuência do <b>DEVEDOR</b>.<br><br>

    									<u><b>Cláusula 2ª</b></u>: O <b>DEVEDOR</b> confessa que é inadimplente da quantia supracitada e que ressarcirá a mesma nas condições previstas neste contrato.<br><br>

    									<u><b>DO PARCELAMENTO, INTERRUPÇÃO DO FORNECIMENTO E PENALIDADES:</b></u><br><br>

    									<u><b>Cláusula 3ª</b></u>: Em acordo firmado no escritório ou balcão eletrônico do: SERVIÇO AUT. DE ÁGUA E ESGOTO DE SANTA IZABEL fica acertado entre as partes o parcelamento total da dívida do cliente devedor que é de: <span><b>R$ <?php echo $soma2; ?></b></span> (<?php echo $extenso; ?>). Constituido de:<br>

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
    								<b><u>Cláusula 7ª</u></b>: FICA ELEITO O FORO DA COMARCA DE: S IZABEL para dirimir qualquer assunto referente ao presente contrato.<br><br><br>

    								<span style="float: right;">Santa Izabel (PA), <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
																					date_default_timezone_set('America/Sao_Paulo');
																					echo strftime('%d de %B de %Y', strtotime('today')); ?>.</span><br><br>

    							<div class="text-center" style="font-size: 10pt;"><span>AVENIDA BARÃO DO RIO BRANCO, 1059 <br>
    									CENTRO - S IZABEL - PA C.e.p.: 68.790-000 <br>
    									Fone: (91) 3744-1373 e-Mail: saaesi@gmail.com <br>
    									CNPJ.: 05.696.125.0001/11</span></div>


    							</p>

    							<div id="noprint" class="modal-footer">
    								<button type="button" id="imprimir" class="btn btn-danger" onclick="window.print();">Imprimir Contrato</button>
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
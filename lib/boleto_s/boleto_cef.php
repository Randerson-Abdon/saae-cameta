<?php @session_start(); # Deve ser a primeira linha do arquivo
?>
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

<form>
	<div style="margin-top: 30px;">
		<input type="button" id="imprimir" value="Imprimir" />
	</div>
</form>


<?php
ini_set('default_charset', 'UTF-8');


include_once('../../conexao.php');

$id = $_GET['id'];
$id_acordo_firmado = $_GET['acordo'];
$total_geral_faturado = $_GET['valor'];
$total_geral_faturado2 = str_replace(',', '.', $total_geral_faturado);

$codigo_barras = $_SESSION['codigo_barras'];

$tipo_boleto = '2000';

//trazendo info Bancos
$query_ban = "SELECT * from banco_arrecadador where status_convenio = 'A' ";
$result_ban = mysqli_query($conexao, $query_ban);
$lista_bancos = '';
while ($res = mysqli_fetch_array($result_ban)) {
	$banco = '  -' . $res["nome_banco"];

	$lista_bancos .= $banco;
}

//trazendo info unidade_consumidora
$query_uc = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id' ";
$result_uc = mysqli_query($conexao, $query_uc);
$row_uc = mysqli_fetch_array($result_uc);
@$numero_cpf_cnpj = $row_uc["numero_cpf_cnpj"];
@$nome_razao_social = $row_uc["nome_razao_social"];

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
$query_ba = "SELECT * from bairro where id_localidade = '$id_localidade' and id_bairro = '$id_bairro' ";
$result_ba = mysqli_query($conexao, $query_ba);
$row_ba = mysqli_fetch_array($result_ba);
@$nome_bairro = $row_ba["nome_bairro"];

//trazendo info logradouro
$query_log = "SELECT * from logradouro where id_bairro = '$id_bairro' and id_logradouro = '$id_logradouro' ";
$result_log = mysqli_query($conexao, $query_log);
$row_log = mysqli_fetch_array($result_log);
@$nome_logradouro = $row_log["nome_logradouro"];
@$tipo_logradouro = $row_log["tipo_logradouro"];
@$cep = $row_log["cep_logradouro"];

//trazendo info tipo_logradouro
$query_tp = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$tipo_logradouro' ";
$result_tp = mysqli_query($conexao, $query_tp);
$row_tp = mysqli_fetch_array($result_tp);
@$tipo = $row_tp['abreviatura_tipo_logradouro'];

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
@$home_page_saae = $row_ps['home_page_saae'];
@$logo_orgao = $row_ps['logo_orgao'];


//consulta para numeração automatica
$query_num = "select * from controle_boleto_acordo order by numero_boleto desc ";
$result_num = mysqli_query($conexao, $query_num);
$res_num = mysqli_fetch_array($result_num);
$id_acordo_firmado_res = $res_num["id_acordo_parcelamento"];
$ultima = $res_num["numero_boleto"];
$doc = $ultima + 1;
//completando com zeros a esquerda
$doc = str_pad($doc, 6, '0', STR_PAD_LEFT);
//$doc = rand(100000, 999999);

$data = date('Y/m/d');

$query_teste = "SELECT * from controle_boleto_acordo where id_acordo_parcelamento = '$id_acordo_firmado' AND data_lancamento_boleto = '$data' ";
$result_teste = mysqli_query($conexao, $query_teste);
$linha_count = mysqli_num_rows($result_teste);

if ($linha_count == '') {
	$query_boleto = "INSERT INTO controle_boleto_acordo (id_acordo_parcelamento, numero_boleto, codigo_barras_boleto, valor_boleto, gerador_controle_boleto) values ('$id_acordo_firmado', '$doc', '$codigo_barras', '$total_geral_faturado2', '00')";

	$result_boleto = mysqli_query($conexao, $query_boleto);

	if ($result_boleto == '') {
		echo "<script language='javascript'>window.alert('Ocorreu um erro ao Gerar!'); </script>";
	} else {
		echo "<script language='javascript'>window.alert('Gerado com Sucesso!'); </script>";
	}
}





// ------------------------- DADOS DINÂMICOS DO CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 3;
$taxa_boleto = 0;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
$valor_cobrado = "$total_geral_faturado"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["inicio_nosso_numero"] = $id_localidade;  // 24 - Padrão da Caixa Economica Federal
$dadosboleto["nosso_numero"] = "2000";  // Nosso numero sem o DV - REGRA: MÁximo de 8 caracteres!
$dadosboleto["numero_documento"] = $id_localidade . '.' . $doc . '.' . $id;	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
$dadosboleto["mes_faturado"] = date("m/Y");	// mes da fatura
$dadosboleto["id"] = $id;
$dadosboleto["id_localidade"] = $id_localidade;	// identificação 
$dadosboleto["tipo_boleto"] = $tipo_boleto;	// identificação 
$dadosboleto["bancos"] = $lista_bancos;	// local de pagamento 
$dadosboleto["logo_orgao"] = $logo_orgao;	// logo do saae

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome_razao_social";
$dadosboleto["endereco1"] = "Bairro " . $nome_bairro . ", " . $tipo . " " . $nome_logradouro . " " . $numero_logradouro;
$dadosboleto["endereco2"] =  "Cidade: $nome_localidade  - Estado: PA -  CEP: $cep";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Taxa de serviço de Água e Esgoto";
$dadosboleto["demonstrativo2"] = "Entrada referente ao acordo Nº " . $id_acordo_firmado . " firmado em " . date("d/m/Y");
$dadosboleto["demonstrativo3"] = "Prefeitura Municipal de " . $nome_localidade;

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes0"] = "- SR(A). CAIXA, NÃO RECEBER ESTE BOLETO APÓS O VENCIMENTO";
$dadosboleto["instrucoes1"] = "- O acordo firmado só será validado após o pagamento deste boleto";
$dadosboleto["instrucoes2"] = "- O não pagamento até o dia do vencimento acarretará no cancelamento do acordo firmado";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: " . $email_saae;
$dadosboleto["instrucoes4"] = "- Emitido pelo sistema SAAENET - www." . $home_page_saae;

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = "1565"; // Num da agencia, sem digito
$dadosboleto["conta"] = "13877"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = "87000000414"; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = "3"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = $nome_saae;
$dadosboleto["cpf_cnpj"] = 'CEP ' . $saae_cnpj;
$dadosboleto["endereco"] = 'BAIRRO ' . $nome_bairro . ', ' . $nome_logradouro_saae . ' ' . $numero_imovel_saae;
$dadosboleto["cidade_uf"] = $nome_municipio . ' - ' . $uf_saae;
$dadosboleto["cedente"] = $nome_saae;

// NãO ALTERAR!
include("include/funcoes_cef.php");
include("include/layout_cef.php");

?>
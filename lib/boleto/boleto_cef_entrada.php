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
$id_acordo_parcelamento = $_GET['acordo'];
$total_geral_faturado = $_GET['valor'];
$total_geral_faturado2 = str_replace(',', '.', $total_geral_faturado);
$id_localidade = $_GET['id_localidade'];

$codigo_barras = $_SESSION['codigo_barras'];

$tipo_boleto = '2000';

//trazendo info Bancos
$query_ban = "SELECT * from banco_conveniado where status_convenio = 'A' ";
$result_ban = mysqli_query($conexao, $query_ban);
$lista_bancos = '';
while (@$res = mysqli_fetch_array($result_ban)) {
	$banco = '  -' . $res["nome_banco"];

	$lista_bancos .= $banco;
}

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
@$nome_bairro_saae 	   = $row_ps['nome_bairro_saae'];
@$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
@$numero_imovel_saae   = $row_ps['numero_imovel_saae'];
@$nome_municipio 	   = $row_ps['nome_municipio'];
@$uf_saae 			   = $row_ps['uf_saae'];
@$nome_saae 		   = $row_ps['nome_saae'];
@$email_saae 		   = $row_ps['email_saae'];
@$home_page_saae = $row_ps['home_page_saae'];
@$logo_orgao = $row_ps['logo_orgao'];

//consulta para numera????o automatica
$query_num = "select * from controle_boleto_acordo order by numero_boleto desc ";
$result_num = mysqli_query($conexao, $query_num);
$res_num = mysqli_fetch_array($result_num);
$id_acordo_parcelamento_res = $res_num["id_acordo_parcelamento"];
$ultima = $res_num["numero_boleto"];
$doc = $ultima + 1;
//completando com zeros a esquerda
$doc = str_pad($doc, 6, '0', STR_PAD_LEFT);
//$doc = rand(100000, 999999);

//executa o store procedure info consumidor
$result_sp = mysqli_query(
	$conexao,
	"CALL sp_seleciona_unidade_consumidora($id_localidade,$id);"
) or die("Erro na query da procedure: " . mysqli_error($conexao));
mysqli_next_result($conexao);
$row_uc = mysqli_fetch_array($result_sp);
$nome_razao_social        = $row_uc['NOME'];
$tipo_juridico            = $row_uc['TIPO_JURIDICO'];
$numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
$numero_rg                = $row_uc['N.?? RG'];
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
$observacoes_text         = $row_uc['OBSERVA????ES'];

$id_usuario_editor_registro = $_SESSION['id_usuario'];

$data = date('Y/m/d');
$vencimento = date('Y/m/d', strtotime('+3 days'));

$data2 = date('Y-m-d');
$vencimento2 = date('Y-m-d', strtotime('+3 days'));

$query_teste = "SELECT * from controle_boleto_acordo where id_acordo_parcelamento = '$id_acordo_parcelamento' AND data_lancamento_boleto = '$data2' ";
$result_teste = mysqli_query($conexao, $query_teste);
$linha_count = mysqli_num_rows($result_teste);

$query_teste2 = "SELECT * from acordo_parcelamento where id_acordo_parcelamento = '$id_acordo_parcelamento' AND valor_parcela = '$total_geral_faturado2' AND numero_parcela = '00/00' ";
$result_teste2 = mysqli_query($conexao, $query_teste2);
$linha_count2 = mysqli_num_rows($result_teste2);

//echo $id_acordo_parcelamento . ', ' . $doc . ', ' . $total_geral_faturado2 . ', ' . $data2 . ', ' . $linha_count2 . ', ' . $linha_count . ', ' . $vencimento2 . ', id ' . $id_usuario_editor_registro;

if ($linha_count2 > 0) {
	echo "<script language='javascript'>window.alert('Gerado com Sucesso!'); </script>";
} else {

	if ($linha_count == 0) {

		$query_boleto = "INSERT INTO controle_boleto_acordo (id_acordo_parcelamento, numero_boleto, data_lancamento_boleto, valor_boleto, id_usuario_editor_registro, data_vencimento_boleto) values ('$id_acordo_parcelamento', '$doc', '$data2', '$total_geral_faturado2', '$id_usuario_editor_registro', '$vencimento2')";
		$result_boleto = mysqli_query($conexao, $query_boleto);

		$query_acordo = "INSERT INTO acordo_parcelamento (id_localidade, id_unidade_consumidora, id_acordo_parcelamento, numero_parcela, id_usuario_editor_registro, data_lancamento_parcela, data_vencimento_parcela, valor_parcela) values ('$id_localidade', '$id', '$id_acordo_parcelamento', '00/00', '$id_usuario_editor_registro', '$data2', '$vencimento2', '$total_geral_faturado2')";
		$result_acordo = mysqli_query($conexao, $query_acordo);

		if ($result_boleto == '' && $result_acordo == '') {
			echo "<script language='javascript'>window.alert('Ocorreu um erro ao Gerar!'); </script>";
		} else {

			echo "<script language='javascript'>window.alert('Gerado com Sucesso!'); </script>";
		}
	}
}





// ------------------------- DADOS DIN??MICOS DO CLIENTE PARA A GERA????O DO BOLETO (FIXO OU VIA GET) -------------------- //

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 3;
$taxa_boleto = 0;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
$valor_cobrado = "$total_geral_faturado"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["inicio_nosso_numero"] = $id_localidade;  // 24 - Padr??o da Caixa Economica Federal
$dadosboleto["nosso_numero"] = "2000";  // Nosso numero sem o DV - REGRA: M??ximo de 8 caracteres!
$dadosboleto["numero_documento"] = $id_localidade . '.' . $doc . '.' . $id;	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss??o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v??rgula e sempre com duas casas depois da virgula
$dadosboleto["mes_faturado"] = date("m/Y");	// mes da fatura
$dadosboleto["id"] = $id;
$dadosboleto["id_localidade"] = $id_localidade;	// identifica????o 
$dadosboleto["tipo_boleto"] = $tipo_boleto;	// identifica????o 
$dadosboleto["bancos"] = $lista_bancos;	// local de pagamento 
$dadosboleto["logo_orgao"] = $logo_orgao;	// logo do saae

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome_razao_social";
$dadosboleto["endereco1"] = "Bairro " . $nome_bairro . ", " . $nome_logradouro . " " . $numero_logradouro;
$dadosboleto["endereco2"] =  "Cidade: $nome_localidade  - Estado: PA -  CEP: $cep_logradouro";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Taxa de servi??o de ??gua e Esgoto";
$dadosboleto["demonstrativo2"] = "Entrada referente ao acordo N?? " . $id_acordo_parcelamento . " firmado em " . date("d/m/Y");
$dadosboleto["demonstrativo3"] = "Prefeitura Municipal de " . $nome_localidade;

// INSTRU????ES PARA O CAIXA
$dadosboleto["instrucoes0"] = "- SR(A). CAIXA, N??O RECEBER ESTE BOLETO AP??S O VENCIMENTO";
$dadosboleto["instrucoes1"] = "- O acordo firmado s?? ser?? validado ap??s o pagamento deste boleto";
$dadosboleto["instrucoes2"] = "- O n??o pagamento at?? o dia do vencimento acarretar?? no cancelamento do acordo firmado";
$dadosboleto["instrucoes3"] = "- Em caso de d??vidas entre em contato conosco: $email_saae";
$dadosboleto["instrucoes4"] = "- Emitido pelo sistema SAAENET - $home_page_saae";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURA????O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = "1565"; // Num da agencia, sem digito
$dadosboleto["conta"] = "13877"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = "87000000414"; // ContaCedente do Cliente, sem digito (Somente N??meros)
$dadosboleto["conta_cedente_dv"] = "3"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "SR";  // C??digo da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = $nome_prefeitura;
$dadosboleto["cpf_cnpj"] = 'CNPJ ' . $saae_cnpj;
$dadosboleto["endereco"] = 'BAIRRO ' . $nome_bairro_saae . ', ' . $nome_logradouro_saae . ' ' . $numero_imovel_saae;
$dadosboleto["cidade_uf"] = $nome_municipio . ' - ' . $uf_saae;
$dadosboleto["cedente"] = $nome_saae;

// N??O ALTERAR!
include("include/funcoes_cef.php");
include("include/layout_cef.php");

?>
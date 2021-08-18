
<?php
ini_set('default_charset', 'UTF-8');

include_once('../conexao.php');


//echo $id . ', ' . $id_localidade . '<br>';

@$codigo_barras = $_SESSION['codigo_barras'];

if ($dir == '2') {
	$id_usuario_editor = '00';
} else {
	$id_usuario_editor = $_SESSION['id_usuario'];
}

$fatura2 = implode(" - ", $fatura);

//mudar saae
$localidade = '01';

//trazendo info Bancos
$query_ban = "SELECT * from banco_conveniado where status_convenio = 'A' ";
$result_ban = mysqli_query($conexao, $query_ban);
$lista_bancos = '';
while ($res = mysqli_fetch_array($result_ban)) {
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
@$nome_bairro_saae = $row_ps['nome_bairro_saae'];
@$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
@$numero_imovel_saae = $row_ps['numero_imovel_saae'];
@$nome_municipio = $row_ps['nome_municipio'];
@$uf_saae = $row_ps['uf_saae'];
@$nome_saae = $row_ps['nome_saae'];
@$email_saae = $row_ps['email_saae'];

//consulta para numeração automatica
$query_num = "select * from boleto_avulso order by id_boleto_avulso desc ";
$result_num = mysqli_query($conexao, $query_num);
$res_num = mysqli_fetch_array($result_num);
$ultima = $res_num["id_boleto_avulso"];
$doc = $ultima + 1;
//completando com zeros a esquerda
$doc = str_pad($doc, 6, '0', STR_PAD_LEFT);
//$doc = rand(100000, 999999);

$qty = 0;
$qty2 = 0;
$qty3 = 0;
$qty4 = 0;
$qty5 = 0;
$qty6 = 0;
$fatura_boleto = "";
foreach ($fatura as $mes_fat) {
	$query_valor = "SELECT * from historico_financeiro where id_unidade_consumidora = '$id' AND mes_faturado = '$mes_fat' AND data_pagamento_fatura is null AND id_acordo_parcelamento is null AND status_estorno_tarifa = 'N' order by mes_faturado asc ";
	$result_valor = mysqli_query($conexao, $query_valor);
	$row_valor = mysqli_fetch_array($result_valor);
	$total_geral_tarifa				= $row_valor["total_geral_tarifa"];
	$total_multas_faturadas 		= $row_valor["total_multas_faturadas"];
	$total_juros_faturados			= $row_valor["total_juros_faturados"];
	$total_parcela_acordo			= $row_valor["total_parcela_acordo"];
	$total_servicos_requeridos		= $row_valor["total_servicos_requeridos"];
	$total_geral_faturado			= $row_valor["total_geral_faturado"];
	$faturado_data					= $row_valor["mes_faturado"];

	$rData = explode("/", $faturado_data);
	$rData = ' -' . $rData[1] . '/' . $rData[0];

	$arr1 = str_split($rData, 9);

	$fatura3 = implode(" - ", $arr1);

	$fatura_boleto .= $fatura3;

	$qty += $row_valor['total_geral_tarifa'];
	$t_tarifas = number_format($qty, 2, ".", ".");

	$qty2 += $row_valor['total_multas_faturadas'];
	$t_multas = number_format($qty2, 2, ".", ".");

	$qty3 += $row_valor['total_juros_faturados'];
	$t_juros = number_format($qty3, 2, ".", ".");

	$qty4 += $row_valor['total_servicos_requeridos'];
	$t_servicos = number_format($qty4, 2, ".", ".");

	$qty5 += $row_valor['total_parcela_acordo'];
	$t_acordos = number_format($qty5, 2, ".", ".");

	$qty6 += $row_valor['total_geral_faturado'];
	$t_faturado = number_format($qty6, 2, ".", ".");


	$query_up = "UPDATE historico_financeiro SET id_boleto_avulso = '$doc' where id_unidade_consumidora = '$id' AND mes_faturado = '$mes_fat' AND data_pagamento_fatura is null AND id_acordo_parcelamento is null AND estorno_tarifa_faturada = 'N' ";

	$result_up = mysqli_query($conexao, $query_up);
}

$tipo_boleto = '4000';

//executa o store procedure info consumidor
$result_sp = mysqli_query(
	$conexao,
	"CALL sp_seleciona_unidade_consumidora($localidade,$id);"
) or die("Erro na query da procedure uc: " . mysqli_error($conexao));
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

//formatação de moeda para o BD
$t_tarifas2 = str_replace('.', '', $t_tarifas) / 100;
$t_tarifas2 = number_format($t_tarifas2, 2, ".", "");

$t_faturado2 = str_replace('.', '', $t_faturado) / 100;
$t_faturado2 = number_format($t_faturado2, 2, ".", "");

$data = date('Y/m/d');
$vencimento = date('Y/m/d', strtotime('+3 days'));

$data2 = date('Y-m-d');
$vencimento2 = date('Y-m-d', strtotime('+3 days'));

$query_teste = "SELECT * from boleto_avulso where id_unidade_consumidora = '$id' AND data_lancamento_boleto = '$data2' ";
$result_teste = mysqli_query($conexao, $query_teste);
$linha_count = mysqli_num_rows($result_teste);

if ($linha_count > 0) {
	$query_delete = "DELETE FROM boleto_avulso WHERE id_unidade_consumidora = '$id' AND data_lancamento_boleto = '$data2' ";
	$result_delete = mysqli_query($conexao, $query_delete);
}

$query_boleto = "INSERT INTO boleto_avulso (id_boleto_avulso, id_localidade, id_unidade_consumidora, lista_meses_lancados, total_tarifa_faturada, total_parcela_acordo, total_taxas_servicos, total_multa_faturada, total_juros_faturados, total_geral_faturado, data_vencimento_boleto, id_usuario_editor_registro) values ('$doc', '$localidade', '$id', '$fatura_boleto', '$t_tarifas2', '$t_acordos', '$t_servicos', '$t_multas', '$t_juros', '$t_faturado2', '$vencimento2', '$id_usuario_editor')";

$result_boleto = mysqli_query($conexao, $query_boleto);

if ($result_boleto == '') {
	echo "<script language='javascript'>window.alert('Ocorreu um erro ao gerar este boleto avulso, revise os dados!'); </script>";
} else {
	echo "<script language='javascript'>window.alert('Boleto Avulso Gerado com Sucesso!'); </script>";
}




// ------------------------- DADOS DINÂMICOS DO CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 3;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
$valor_cobrado = "$t_faturado"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_cobrado2 = str_replace(".", "", $valor_cobrado) / 100;
$valor_boleto  = number_format($valor_cobrado2, 2, ',', '.');

$dadosboleto["inicio_nosso_numero"] = $localidade;  // 24 - Padrão da Caixa Economica Federal
$dadosboleto["nosso_numero"] = "4000";  // Nosso numero sem o DV - REGRA: MÁximo de 8 caracteres!
$dadosboleto["numero_documento"] = $localidade . '.' . $doc . '.' . $id;	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
$dadosboleto["mes_faturado"] = date("m/Y");	// mes da fatura
$dadosboleto["id"] = $id;
$dadosboleto["id_localidade"] = $localidade;	// identificação 
$dadosboleto["tipo_boleto"] = $tipo_boleto;	// identificação 
$dadosboleto["bancos"] = $lista_bancos;	// local de pagamento 

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome_razao_social";
$dadosboleto["endereco1"] = "Bairro " . $nome_bairro . ", " . $nome_logradouro . " " . $numero_logradouro;
$dadosboleto["endereco2"] =  "Cidade: $nome_localidade  - Estado: PA -  CEP: $cep_logradouro";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Taxa de serviço de Água e Esgoto";
$dadosboleto["demonstrativo2"] = "Boleto Avulso referente às competências: " . $fatura_boleto;
$dadosboleto["demonstrativo3"] = "Prefeitura Municipal de " . $nome_localidade;

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes0"] = "- SR(A). CAIXA, NÃO RECEBER ESTE BOLETO APÓS O VENCIMENTO";
$dadosboleto["instrucoes1"] = "- Em caso de dúvidas entre em contato conosco: " . $email_saae;
$dadosboleto["instrucoes2"] = "- Emitido pelo sistema SAAENET - www.saaesantaizabel.net";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

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
$dadosboleto["cpf_cnpj"] = 'CNPJ ' . $saae_cnpj;
$dadosboleto["endereco"] = 'BAIRRO ' . $nome_bairro_saae . ', ' . $nome_logradouro_saae . ' ' . $numero_imovel_saae;
$dadosboleto["cidade_uf"] = $nome_municipio . ' - ' . $uf_saae;
$dadosboleto["cedente"] = $nome_saae;

// NãO ALTERAR!
include("include/funcoes_cef.php");
include("include/layout_cef.php");

?>
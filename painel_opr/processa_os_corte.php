<?php
include_once('../conexao.php');
session_start();

$id_unidade_consumidora = $_GET['id'];
$id_localidade          = $_GET['id_localidade'];
$id_usuario_editor = $_SESSION['id_usuario'];

//executa o store procedure info consumidor
$result_sp3 = mysqli_query(
    $conexao,
    "CALL sp_seleciona_unidade_consumidora($id_localidade,$id_unidade_consumidora);"
) or die("Erro na query da procedure: " . mysqli_error($conexao));
mysqli_next_result($conexao);
$row_uc = mysqli_fetch_array($result_sp3);
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

//consulta para numeração automatica
$query_num_req = "select * from requerimento_servico order by id_requerimento desc ";
$result_num_req = mysqli_query($conexao, $query_num_req);
$res_num_req = mysqli_fetch_array($result_num_req);
$ultimo_req = $res_num_req["id_requerimento"];
$ultimo_req = $ultimo_req + 1;

$existe_unidade_consumidora = 'S';

//tratamento para numero_cpf_cnpj
$ncc = str_replace("/", "", $numero_cpf_cnpj);
$ncc2 = str_replace(".", "", $ncc);
$ncc3 = str_replace("-", "", $ncc2);

//tratamento para telefone
$tel = preg_replace("/[^0-9]/", "", $fone_fixo);

//tratamento para celular
$cel = preg_replace("/[^0-9]/", "", $fone_movel);

$status_requerimento = 'D';

if ($tipo_juridico == 'PESSOA FÍSICA') {
    $tipo_juridico = 'F';
} else {
    $tipo_juridico = 'J';
}

if ($fone_zap == 'NÃO') {
    $fone_zap = 'N';
} else {
    $fone_zap = 'S';
}

$data_requerimento = date('Y-m-d');


//echo 'id_localidade ' . $id_localidade . ', id_requerimento ' . $ultimo_req . ', existe_unidade_consumidora ' . $existe_unidade_consumidora . ', id_unidade_consumidora ' . $id_unidade_consumidora . ', tipo_juridico ' . $tipo_juridico . ', numero_cpf_cnpj ' . $ncc3 . ', nome_razao_social ' . $nome_razao_social . ', numero_rg ' . $numero_rg . ', orgao_emissor_rg ' . $orgao_emissor_rg . ', uf_rg ' . $uf_rg . ', fone_fixo ' . $tel . ', fone_movel ' . $cel . ', fone_movel_zap ' . $fone_zap . ', email ' . $email . ', status_requerimento ' . $status_requerimento . ', id_usuario_editor_registro ' . $id_usuario_editor;


// insert requerimento
$query2 = "INSERT INTO requerimento_servico (id_localidade, id_requerimento, data_requerimento, existe_unidade_consumidora, id_unidade_consumidora, tipo_juridico, numero_cpf_cnpj, nome_razao_social, numero_rg, orgao_emissor_rg, uf_rg, fone_fixo, fone_movel, fone_movel_zap, email, status_requerimento, id_usuario_editor_registro) values ('$id_localidade', '$ultimo_req', '$data_requerimento', '$existe_unidade_consumidora', '$id_unidade_consumidora', '$tipo_juridico', '$ncc3', '$nome_razao_social', '$numero_rg', '$orgao_emissor_rg', '$uf_rg', '$tel', '$cel', '$fone_zap', '$email', '$status_requerimento', '$id_usuario_editor')";

$result2 = mysqli_query($conexao, $query2);

//inserindo serviço para CORTE
$query_serv = "INSERT INTO servico_requerido (id_servico_requerido, id_requerimento) values ('16', '$ultimo_req')";
$result_serv = mysqli_query($conexao, $query_serv);

//GERANDO OS

//consulta para numeração automatica
$query_num_os = "select * from ordem_servico order by id_ordem_servico desc ";
$result_num_os = mysqli_query($conexao, $query_num_os);
$res_num_os = mysqli_fetch_array($result_num_os);
$ultimo_os = $res_num_os["id_ordem_servico"];
$id_ordem_servico = $ultimo_os + 1;

// insert os
$query_os = "INSERT INTO ordem_servico (id_requerimento, id_ordem_servico, data_inicio_servico, status_ordem_servico) values ('$ultimo_req', '$id_ordem_servico', curDate(), '2')";
$result_os = mysqli_query($conexao, $query_os);


$mes_lancamento = date('Y/m', strtotime('+30 days'));

$valor_lancamento_servico = '0.00';

// insert servico_faturado
$query_sf = "INSERT INTO servico_faturado (id_localidade, id_unidade_consumidora, mes_lancamento_servico, id_requerimento, data_lancamento_servico, valor_lancamento_servico, id_usuario_editor_registro) values ('$id_localidade', '$id_unidade_consumidora', '$mes_lancamento', '$ultimo_req', curDate(), '$valor_lancamento_servico', '$id_usuario_editor')";
$result_sf = mysqli_query($conexao, $query_sf);


if ($result2 == '') {
    echo "<script language='javascript'>window.alert('Ocorreu um erro ao gerar!'); </script>";
} else {

    echo "<script language='javascript'>window.alert('Gerado com Sucesso!'); </script>";
    echo "<script language='javascript'>window.location='corte_rel_campo.php?func=imprime&id=$id_ordem_servico'; </script>";
}

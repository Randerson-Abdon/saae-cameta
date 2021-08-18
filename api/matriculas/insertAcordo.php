<?php
include_once('../conexao.php');
include_once('../funcoes.php');

$id_unidade_consumidora  = $_GET['uc'];
$id_acordo_parcelamento  = $_GET['dadosAcordo'];
$numero_parcela          = $_GET['nParcelas'];
$data_lancamento_parcela = $_GET['data'];
$valorParcela            = $_GET['parcelas'];
$fatura                  = $_GET['fatura'];

//organiza fatura
$fatura = str_replace('[', '', $fatura);
$fatura = str_replace(']', '', $fatura);
$fatura = str_replace(' ', '', $fatura);
$fatura = explode(',', $fatura);

//organiza valorparcela
$valorParcela = str_replace('[', '', $valorParcela);
$valorParcela = str_replace(']', '', $valorParcela);
$valorParcela = str_replace(' ', '', $valorParcela);
$valorParcela = explode(',', $valorParcela);

$data = date('d/m/Y');

//recupera id_localidade
$result = $pdo->prepare(" SELECT id_localidade from unidade_consumidora where id_unidade_consumidora = :id ");
$result->bindValue(':id', $id_unidade_consumidora);
$result->execute();
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $value) {
    $id_localidade = $value['id_localidade'];
}

$dataVenctoParcela = calcularVencimentoParcelas2($data, $numero_parcela);
$id_usuario_editor_registro = '00';

echo $id_unidade_consumidora . ', ' . $id_acordo_parcelamento . ', ' . $numero_parcela . ', ' . $data_lancamento_parcela . ', ' . $id_localidade . ', ' . $id_usuario_editor_registro . '<br>';

/* var_dump($dataVenctoParcela);
var_dump($valorParcela); */
var_dump($fatura);

foreach ($fatura as $meses) {


    $res = $pdo->prepare(" UPDATE historico_financeiro SET id_acordo_parcelamento = :id_acordo_parcelamento where id_unidade_consumidora = :id_unidade_consumidora AND mes_faturado = :meses ");

    $res->bindValue(":id_acordo_parcelamento", $id_acordo_parcelamento);
    $res->bindValue(":id_unidade_consumidora", $id_unidade_consumidora);
    $res->bindValue(":meses", $meses);

    $res->execute();
}


$j = 0;
for ($x = 0; $x <= $numero_parcela; $x++) {

    $numero_parcela = str_pad($numero_parcela, 2, '0', STR_PAD_LEFT);
    $x = str_pad($x, 2, '0', STR_PAD_LEFT);

    $numeroParcela = $x . '/' . $numero_parcela;

    $res = $pdo->prepare("INSERT into acordo_parcelamento (id_localidade, id_unidade_consumidora, id_acordo_parcelamento, numero_parcela, data_lancamento_parcela, data_vencimento_parcela, valor_parcela, id_usuario_editor_registro) values (:id_localidade, :id_unidade_consumidora, :id_acordo_parcelamento, :numero_parcela, :data_lancamento_parcela, :data_vencimento_parcela, :valor_parcela, :id_usuario_editor_registro)");

    $res->bindValue(":id_localidade", $id_localidade);
    $res->bindValue(":id_unidade_consumidora", $id_unidade_consumidora);
    $res->bindValue(":id_acordo_parcelamento", $id_acordo_parcelamento);
    $res->bindValue(":numero_parcela", $numeroParcela);
    $res->bindValue(":data_lancamento_parcela", $data_lancamento_parcela);
    $res->bindValue(":data_vencimento_parcela", insertData2($dataVenctoParcela[$j]));
    $res->bindValue(":valor_parcela", $valorParcela[$j - 1]);
    $res->bindValue(":id_usuario_editor_registro", $id_usuario_editor_registro);

    $res->execute();

    echo $j;

    $j++;
}

if ($res) {
    echo (json_encode(array('mensagem' => 'Cadastrado com Sucesso!')));
}

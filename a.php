<?php
include_once('conexao.php');

//teste 02

$query_hf = "SELECT * from historico_financeiro where id_boleto_avulso = '017221' ";
$result_hf = mysqli_query($conexao, $query_hf);

$linhas = mysqli_num_rows($result_hf);

while ($res3 = mysqli_fetch_array($result_hf)) {
    $data_pagamento_fatura   = $res3["data_pagamento_fatura"];
    $id_localidade           = $res3["id_localidade"];
    $id_unidade_consumidora  = $res3["id_unidade_consumidora"];
    $mes_faturado            = $res3["mes_faturado"];
    $total_pagamento_fatura  = $res3["total_pagamento_fatura"];
    $id_banco_arrecadador    = $res3["id_banco_arrecadador"];
    $id_boleto_avulso         = $res3["id_boleto_avulso"];

    echo 'teste' . $id_unidade_consumidora;
}

<?php
    session_start(); # Deve ser a primeira linha do arquivo
    include_once('../conexao.php');

    $fatura = $_SESSION['fatura'];
    $id = $_SESSION['id'];
    $id_localidade = $_SESSION['id_localidade'];

    
    
    foreach ($fatura as $dados) {


    } 
  

    // pega os valores do formulário e armazena em variaveis
    $id_localidade = $id_localidade;
    $uc = $id;
    $id_acordo = $_POST['id_acordo'];
    $valor = $_POST['valor'];
    $parcelas = $_POST['parcelas'];
    $entrada = false;

    $valor = str_replace(",",".",$valor);

    echo $id_localidade.'<br>';
    echo $uc.'<br>';
    echo $id_acordo.'<br>';
    echo $valor.'<br>';
    echo $parcelas.'<br>';

// Calcula o valor da parcela dividindo o total pelo número de parcelas
$valorParcela = $valor / $parcelas;

// Se tiver entrada diminui o número de parcelas
$qtd = $parcelas;


// Faz um loop com a quantidade de parcelas
for ($i = 1; $i <= $qtd; $i++) { 

   // Se for última parcela e a soma das parcelas for diferente do valor da compra
   // ex: 100 / 3 == 33.33 logo 3 * 33.33 == 99.99
   // Então acrescenta a diferença na parcela, assim última parcela será 33.34
   if ($qtd == $i && round($valorParcela * $parcelas, 2) != $valor){ 
      $valorParcela += $valor - ($valorParcela * $parcelas);
   }

   // Caso a variavel $entrada seja true
   // o valor $i na primeira parcela será 0
   // então 30 * 0 == 0
   // será adicionado 0 dias a data, ou seja, a primeira parcela
   // será a data atual
   $dias = 30 * $i;

   // Hoje mais X dias
   // Parcela 1: 30 dias
   // Parcela 2: 60 dias
   // Parcela 3: 90 dias...
   $data = date('Y-m-d', strtotime("+{$dias} days"));
    

    $sql ="INSERT INTO acordo_parcelamento ( id_localidade, id_unidade_consumidora, id_acordo, numero_parcela, data_vencimento_parcela, valor_parcela ) VALUES ( '$id_localidade', '$uc', '$id_acordo', '$i', '$data', '$valorParcela' )";
    
  $conexao->query($sql);
   echo $sql;

   echo '<br><br>'.PHP_EOL.PHP_EOL;
    
}


<?php
include('../conexao.php'); //conexao com o banco
echo "<label>Logradouro</label>";
echo "<select name=id_logradouro id=id_logradouro class=form-control mr-2 >";
echo "<option>---Escolha uma opção---</option>";

//busca dados do combo 2
$sql = "SELECT * FROM enderecamento_logradouro WHERE id_bairro = '" . $_GET['bairro'] . "' AND id_localidade = '" . $_GET['localidade'] . "' order by nome_logradouro asc";

$resultado = mysqli_query($conexao, $sql) or die("Problema na Consulta");

while ($linha = mysqli_fetch_array($resultado)) {
   $id_tipo_logradouro = $linha['tipo_logradouro'];
   //trazendo tipo_enderecamento de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
   $query_u = "SELECT * from tipo_logradouro where id_tipo_logradouro = '$id_tipo_logradouro' ";
   $result_u = mysqli_query($conexao, $query_u);
   $row_u = mysqli_fetch_array($result_u);


   echo "<option value=" . utf8_encode($linha['id_logradouro']) . ">" . utf8_encode($row_u['abreviatura_tipo_logradouro']) . ' ' . utf8_encode($linha['nome_logradouro']) . "</option>";
}

echo "</select>";

?>


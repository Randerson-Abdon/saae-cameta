

<?php
include('../conexao.php'); //conexao com o banco

echo "<label>Bairro</label>";
echo "<select  name=id_bairro onchange=javascript:Atualizar02(this.value," . $_GET['localidade'] . "); class=form-control mr-2 >";
echo "<option>---Escolha uma opção---</option>";

//busca dados do combo 2
$sql = "SELECT * FROM enderecamento_bairro INNER JOIN enderecamento_localidade ON enderecamento_localidade.id_localidade = enderecamento_bairro.id_localidade WHERE enderecamento_bairro.id_localidade = '" . $_GET['localidade'] . "' order by nome_bairro asc";

$resultado = mysqli_query($conexao, $sql) or die("Problema na Consulta");

while ($linha = mysqli_fetch_array($resultado)) {
   echo "<option value=" . utf8_encode($linha['id_bairro']) . ">" . utf8_encode($linha['nome_bairro']) . "</option>";
}

echo "</select>";

?>

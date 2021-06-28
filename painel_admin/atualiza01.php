

<?php
   include('../conexao.php'); //conexao com o banco

   echo "<label>Bairro</label>";
   echo "<select  name=id_bairro2 onchange=javascript:Atualizar02(this.value,".$_GET['localidade']."); class=form-control mr-2 >";
   echo "<option>---Escolha uma opção---</option>";

   //busca dados do combo 2
   $sql = "SELECT * FROM bairro INNER JOIN localidade ON localidade.id_localidade = bairro.id_localidade WHERE bairro.id_localidade = '".$_GET['localidade']."' order by nome_bairro asc";

   $resultado = mysqli_query($conexao, $sql) or die ("Problema na Consulta");

   While($linha = mysqli_fetch_array($resultado))
   {
      echo "<option value=".utf8_encode($linha['id_bairro']).">".utf8_encode($linha['nome_bairro'])."</option>";
   }

   echo "</select>";

?>

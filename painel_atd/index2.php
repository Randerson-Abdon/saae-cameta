<html>
 <head>
  <script language="javascript" type="text/javascript" src="script.js">
  </script>
 </head>
 <Body OnLoad='javascript:Atualiza();Atualiza2();'>
  <form>
   <select name=categoria onchange=javascript:Atualiza(this.value);>
    <option>---Escolha uma opção---</option>";
      <?php
        include('conexao.php'); //conexao com o banco
        //monta dados do combo 1
        $sql = "SELECT DISTINCT nome_localidade,id_localidade FROM localidade";

        $resultado = @mysqli_query($conexao, $sql) or die ("Problema na Consulta");

        While($linha = mysqli_fetch_array($resultado))
        {
          echo "<option value=".$linha['id_localidade'].">".$linha['nome_localidade']."</option>";
        }
      ?>
   </select>

  <div id="atualiza"></div>
  <div id="atualiza2"></div>

  </form>  
 </body>
</html>

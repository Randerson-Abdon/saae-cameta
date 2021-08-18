<?php
include_once('conexao.php');
session_start();

?>

<!DOCTYPE html>
<html>

<head>
  <title>PORTAL SAAE</title>

  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- LINK DO fontawesome via cdn(navegador) para icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

  <!-- link com a folha de stilos -->
  <link rel="stylesheet" type="text/css" href="css/estilos-login.css">



</head>

<body>

  <!-- DIV SÃO DIVISOES DENTRO DA PAGINA -->
  <!-- H É A ALTURA EM PORCENTAGEM -->
  <div class="container h-100">
    <!-- D-FREX É EM LINHA EM TODA A AREA -->
    <div class=" d-flex justify-content-center h-100">
      <div class="card_login">

        <div class="area_logo">

          <!-- COLOCA IMG / width é a largura-->
          <a href="index.php"><img src="img/logo22.png" width="150px" class="logo_circular"></a>

        </div>

        <div class=" d-flex justify-content-center form_login">

          <!--METODO PARA VALIDAÇÃO DE LOGIN-->
          <form action="autenticar.php" method="post">
            <!-- mb-3 é a distancia de uma caixa para outra em px -->
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <!-- caixa em si com legenda -->
              <input type="text" name="login_usuario" class="form-control input_usuario" placeholder="Usuário / E-mail" required>
            </div>

            <!-- mb-3 é a distancia de uma caixa para outra em px -->
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <!-- caixa em si com legenda -->
              <input type="password" name="senha_usuario" class="form-control input_usuario" placeholder="Senha" required>
            </div>

            <!-- mb-3 é a distancia de uma caixa para outra em px -->
            <div class="input-group">
              <div class="custom-control custom-checkbox">
                <!-- caixa de marcação lembrar-me -->
                <input type="checkbox" name="" class="custom-control-input" id="customControlInline">
                <!-- legenda da caixa de marcação -->
                <label class="custom-control-label" for="customControlInline">Lembrar-me</label>

              </div>

            </div>



        </div>

        <!-- area dos botoes do login / mt-3 é margin top -->
        <div class="d-flex justify-content-center mt-3 area_botao">
          <button type="submit" name="button" class="btn btn_login">Entrar</button>

        </div>

        </form>

        <!-- area para cadastro e recuperação / ml-2 é margin left -->
        <div class="mt-4 area_links">
          <div class="d-flex justify-content-center links">
            Não possui cadastro? <a href="#" data-toggle="modal" data-target="#modalExemplo" class="ml-2">Cadastre-se</a>

          </div>

          <div class="d-flex justify-content-center links">
            <a href="#" data-toggle="modal" data-target="#modalExemplo2" class="ml-2">Esqueci minha senha!</a>

          </div>


        </div>



      </div>


    </div>

    <p style="font-size: 25pt; color: #0f51ff; font-weight: bold; margin-top: -100px;"><i class="fas fa-tint fa-blink"></i> <a href="#"><img src="img/titulo.png" width="400" height="54" alt="SISTEMA DE GESTÃO COMERCIAL E OPERACIONAL - SAAENET" /></a> <i class="fas fa-tint fa-blink"></i></p>



  </div>

  </div>


  <!-- Modal CADASTRAR -->
  <div id="modalExemplo" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title">Usuários</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">

            <div class="form-group">
              <label for="id_produto">Nome</label>
              <input type="text" class="form-control mr-2" name="nome" placeholder="Nome" required>
            </div>

            <div class="form-group">
              <label for="id_produto">CPF</label>
              <input type="text" class="form-control mr-2" name="cpf" placeholder="CPF" id="cpf" required>
            </div>

            <div class="form-group">
              <label for="id_produto">Email</label>
              <input type="email" class="form-control mr-2" name="usuario" placeholder="Usuário" required>
            </div>

            <div class="form-group">
              <label for="fornecedor">Senha</label>
              <input type="text" class="form-control mr-2" name="senha" placeholder="Senha" required>
            </div>

            <div class="form-group">
              <label for="fornecedor">Nível</label>


              <select class="form-control mr-2" id="category" name="nivel">

                <option value="1">Administrativo</option>
                <option value="3">Atendente</option>
                <option value="2">Operacional</option>
                <option value="0">Admin./Atend./Operac.</option>

              </select>
            </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="salvar">Salvar </button>


          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal Senha -->
  <div id="modalExemplo2" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title">Recuperação de Senha</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">

            <div class="form-group">
              <label for="id_produto">CPF</label>
              <input type="text" class="form-control mr-2" name="cpf" placeholder="Seu CPF aqui" id="cpf" required>
              <label class="text-danger" for="id_produto" style="font-size: 8pt;">* Digite apenas números</label>
            </div>

            <div class="form-group">
              <label for="id_produto">Email</label>
              <input type="email" class="form-control mr-2" name="usuario" placeholder="Seu e-mail aqui" required>
            </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="enviar">Enviar </button>


          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
          </form>
        </div>
      </div>
    </div>
  </div>




  <!--CADASTRO ACESSO -->
  <?php
  if (isset($_POST['enviar'])) {
    $cpf = $_POST['cpf'];
    $usuario = $_POST['usuario'];


    //trazendo info logradouro
    $query_log = "SELECT * from usuario_sistema where cpf_usuario = '$cpf' AND login_usuario = '$usuario' ";
    $result_log = mysqli_query($conexao, $query_log);
    $row_log = mysqli_fetch_array($result_log);
    $senha_usuario = $row_log["senha_usuario"];
    $nome_usuario = $row_log["nome_usuario"];
    $row_verificar = mysqli_num_rows($result_log);
    if ($row_verificar == 0) {
      echo "<script language='javascript'>window.alert('Usuário ou CPF Inexistente!'); </script>";
      exit();
    } else {

      $nome = $nome_usuario;
      $email = '- Sua senha é -> ';
      $mensagem = $senha_usuario;
      $titulo = 'SAAE SANTA IZABEL';
      $dest = $usuario;

      $email = utf8_decode($email);
      $nome = utf8_decode($nome);
      $pedido = utf8_decode('- Pedido de recuperação de senha em nome de: ');

      // usando o PHP_EOL para quebrar a linha
      $dados = $pedido . $nome . PHP_EOL . PHP_EOL . $email . $mensagem;

      mail($dest, $titulo, $dados);

      echo "<script language='javascript'>window.alert('Sua senha foi enviado para seu e-mail!'); </script>";
      echo "<script language='javascript'>window.location='login.php'; </script>";
    }
  }

  ?>







</body>
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
  $("input[id*='cpf']").inputmask({
    mask: ['999.999.999-99', '99.999.999/9999-99'],
    keepStatic: true
  });
</script>
<script>
  $("input[id*='cel']").inputmask({
    mask: ['(99) 99999-9999'],
    keepStatic: true
  });
</script>

</html>

<!--TESTAR AUTENTICAÇÃO -->
<?php
if (isset($_SESSION['inativado'])) {
  echo "<script language='javascript'>window.alert('Você está inativo, procure a administração!'); </script>";
}
//derrubando variavel anterior
unset($_SESSION['inativado']);

?>


<!--TESTAR AUTENTICAÇÃO -->
<?php
if (isset($_SESSION['nao_autenticado'])) {
  echo "<script language='javascript'>window.alert('Usuário ou senha incorretos!'); </script>";
}
//derrubando variavel anterior
unset($_SESSION['nao_autenticado']);

?>



<!--CADASTRO  DE USUARIOS -->

<?php
// QUANDO FOR CLICADO O BOTÃO SALVAR
if (isset($_POST['salvar'])) {
  //RECUPERAÇÃO DE DADOS DOS FORMULARIOS
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $usuario = $_POST['usuario'];
  $senha = $_POST['senha'];
  $nivel = $_POST['nivel'];


  //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
  $query_verificar_cpf = "SELECT * from usuario_sistema where cpf_usuario = '$cpf' ";
  //EXECUÇÃO
  $result_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);
  //QUANTIDADES DE LINHAS CONTADAS
  $row_verificar_cpf = mysqli_num_rows($result_verificar_cpf);
  //VERIFICAÇÃO DE VALIDAÇÃO COM ALERTA
  if ($row_verificar_cpf > 0) {
    echo "<script language='javascript'>window.alert('CPF já Cadastrado'); </script>";
    //FINALIZANDO SEM SALVAR
    exit();
  }


  //VERIFICAR SE O USUARIO JÁ ESTÁ CADASTRADO
  $query_verificar_usu = "SELECT * from usuario_sistema where login_usuario = '$usuario' and nivel_usuario = '$nivel' ";
  $result_verificar_usu = mysqli_query($conexao, $query_verificar_usu);
  $row_verificar_usu = mysqli_num_rows($result_verificar_usu);
  if ($row_verificar_usu > 0) {
    echo "<script language='javascript'>window.alert('Usuário já Cadastrado'); </script>";
    //FINALIZANDO SEM SALVAR
    exit();
  }


  //CONSULTA PARA INCERÇÃO DE USUARIOS COM DATA AUTOMATICA
  $query = "INSERT INTO usuario_sistema (nome_usuario, cpf_usuario, login_usuario, senha_usuario, nivel_usuario, data_cadastro_usuario) values ('$nome', '$cpf', '$usuario', '$senha', '$nivel', curDate())";

  //EXECULTANDO QUERY
  $result = mysqli_query($conexao, $query);



  //VALIDAÇÃO DE CAMPOS VAZIOS COM ALERTAS
  if ($result == '') {
    echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
  } else {
    echo "<script language='javascript'>window.alert('Cadastro realizado com Sucesso. Aguarde o administrador liberar seu acesso !'); </script>";
    //REDIRECIONANDO PARA USUARIOS
    echo "<script language='javascript'>window.location='login.php'; </script>";
  }
}
?>


<!--MASCARAS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
  });
</script>




<!-- OS SCRIPTS DEVEM SEMPRE VIM DEPOIS DAS FOLHAS DE ESTILO -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
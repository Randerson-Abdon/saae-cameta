<?php

include_once('conexao.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro</title>
</head>
<body>

<?php
          /**
          * Função para gerar senhas aleatórias

          * @param integer $tamanho Tamanho da senha a ser gerada
          * @param boolean $maiusculas Se terá letras maiúsculas
          * @param boolean $numeros Se terá números
          * @param boolean $simbolos Se terá símbolos
          *
          * @return string A senha gerada
          */
            function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
            {
            $lmin = 'abcdefghijklmnopqrstuvwxyz';
            $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $num = '1234567890';
            $simb = '!@#$%*-';
            $retorno = '';
            $caracteres = '';

            $caracteres .= $lmin;
            if ($maiusculas) $caracteres .= $lmai;
            if ($numeros) $caracteres .= $num;
            if ($simbolos) $caracteres .= $simb;

            $len = strlen($caracteres);
            for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
            }
            return $retorno;
            }

          ?>


        <!--CADASTRO ACESSO -->
        <?php 
          if(isset($_POST['enviar'])){
            $id_localidade = $_POST['id_localidade'];
            $id_unidade_consumidora = $_POST['id_unidade_consumidora'];
            $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
            $email_contato = $_POST['email_contato'];
            $senha = geraSenha(6, false, true);

            //tratamento para numero_cpf_cnpj
            $ncc = str_replace("/", "", $numero_cpf_cnpj);
            $ncc2 = str_replace(".", "", $ncc);
            $ncc3 = str_replace("-", "", $ncc2);

            $uc = str_pad($id_unidade_consumidora , 5 , '0' , STR_PAD_LEFT);

            //trazendo info unidade_consumidora
            $query_uc = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$uc' AND id_localidade = '$id_localidade' ";
            $result_uc = mysqli_query($conexao, $query_uc);
            $row_uc = mysqli_fetch_array($result_uc);
            $nome_razao_social = $row_uc["nome_razao_social"];
            $numero_cpf_cnpj = $row_uc["numero_cpf_cnpj"];

            //if($numero_cpf_cnpj != $ncc3) {
             // echo "<script language='javascript'>window.alert('CPF INCORRETO, verifique o campo digitado ou procure um posto de atendimento mais proximo. Localize essas informações em tópico FALE CONOSCO!!!'); </script>";
              //echo "<script language='javascript'>window.location='http://datapremium.com.br/s-izabel/web/home/'; </script>";
              //exit();
            //}

           $query = "INSERT INTO acesso_seguro (id_localidade, id_unidade_consumidora, numero_cpf_cnpj, email_contato, senha_provisoria) values ('$id_localidade', '$uc', '$ncc3', '$email_contato', '$senha')";
           $result = mysqli_query($conexao, $query);
            
            if($result == ''){
              echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
            }else{
              echo "<script language='javascript'>window.alert('Cadastro Iniciado com sucesso, verificar seu e-mail para dar continuídade!!!'); </script>";
              echo "<script language='javascript'>window.location='http://datapremium.com.br/s-izabel/web/home/'; </script>";

            }
            
          }
        ?>

        <?php

        $nome = $nome_razao_social;
        $email = 'Obrigado por iniciar o cadastro em nosso sistema, use o link abaixo e a senha provisória para finalizar seu cadastro ao acesso as funcionalidades de nosso SAAE.';
        $senhap = $senha;
        $mensagem = 'http://datapremium.com.br/s-izabel/web/home/index.php?func=edita&id='.$uc.'&cpf='.$ncc3;
        $titulo = 'SAAE SANTA IZABEL';
        $dest = $email_contato;

        $nome = utf8_decode($nome);
        $email = utf8_decode($email);
        $senha = utf8_decode('- Senha Provisória: ');
        $instrucoes = utf8_decode('- Instruções: ');

        // usando o PHP_EOL para quebrar a linha
        $dados = '- Pedido de cadastro ao Sr(a): '.$nome.PHP_EOL.PHP_EOL.$instrucoes.$email.PHP_EOL.PHP_EOL.$senha.$senhap.PHP_EOL.PHP_EOL.'- Acesse aqui para continuar seu cadastro -> '.$mensagem;



        mail($dest, $titulo, $dados);

        ?>

        <meta http-equiv="refresh" content="0" />

</body>
</html>


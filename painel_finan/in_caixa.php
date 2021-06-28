<?php
include_once('../conexao.php');

if ($_SESSION['nivel_usuario'] != '5' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    $id_usuario_editor = $_SESSION['id_usuario'];
    $login_usuario     = $_SESSION['login_usuario'];

    $data = date('Y-m-d');

    $id_localidade = $_SESSION['localidade'];
    $query_loc = "SELECT * from localidade WHERE id_localidade = '$id_localidade' ";
    $result_loc = mysqli_query($conexao, $query_loc);
    $res_loc = mysqli_fetch_array($result_loc);
    @$nome_localidade = $res_loc["nome_localidade"];

    $nome_usuario = $_SESSION['nome_usuario'];




    //consulta para numeração automatica
    $query_num_aula = "select * from cx_termo_abertura_encerramento order by id_termo_abertura_encerramento desc ";
    $result_num_aula = mysqli_query($conexao, $query_num_aula);

    $res_num_aula = mysqli_fetch_array($result_num_aula);
    @$id_termo_abertura_encerramento = $res_num_aula["id_termo_abertura_encerramento"];
    $id_termo_abertura_encerramento = $id_termo_abertura_encerramento + 1;

    // apagando zeros a esquerda
    $id_caixa = ltrim($id_usuario_editor, "0") . ltrim($id_termo_abertura_encerramento, "0");

    ?>


    <form action=" " method="POST">

        <div class="form-row">

            <div class="form-group col-md-1">
                <label for="inputAddress">N° do Caixa</label>
                <input type="text" class="form-control" name="id_caixa" value="<?php echo $id_caixa; ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputloc">Localidade</label>
                <input type="text" class="form-control" name="localidade" value="<?php echo $nome_localidade; ?>" readonly>
            </div>

            <div class="form-group col-md-3">
                <label for="inputoperador">Operador</label>
                <input type="text" class="form-control" name="usuario" value="<?php echo $nome_usuario; ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">Data de Abertura</label>
                <input type="text" class="form-control" name="data_abertura" value="<?php echo date('d/m/Y'); ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">hora de Abertura</label>
                <input type="time" class="form-control" name="hora_abertura" value="<?php echo date('H:i:s'); ?>" readonly>
            </div>

        </div>

        <hr>
        <div class="form-row">

            <div class="form-group col-md-2">
                <label for="inputAddress">Valor de Abertura</label>
                <input type="text" class="form-control" name="valor_abertura" placeholder="0,00">
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">Senha de Usuário</label>
                <input type="password" class="form-control" name="senha" placeholder="Confirmação Pessoal">
            </div>

            <div class="form-group col-md-2" style="margin-top: 29px;">
                <button type="submit" class="btn btn-success" name="abrir">Abrir Caixa</button>
            </div>

        </div>

        <?php

        if (isset($_POST['abrir'])) {

            $senha_usuario = $_POST['senha'];

            // validação de caixa
            $query_hc3 = "SELECT * from cx_termo_abertura_encerramento where id_operador = '$id_usuario_editor' AND data_encerramento is null ";
            $result_hc3 = mysqli_query($conexao, $query_hc3);
            $res_hc3 = mysqli_fetch_array($result_hc3);

            $row_hc3 = mysqli_num_rows($result_hc3);

            if ($row_hc3 > 0) {
                echo "<script language='javascript'>window.alert('Já existe um caixa aberto, faça o fechamento ou use o menu OPERAÇÂO para continuar!!!'); </script>";
                echo "<script language='javascript'>window.location='caixa.php'; </script>";
                exit;
            }

            // validação de senha
            $query_c = "select * from usuario_sistema where login_usuario = '$login_usuario' and senha_usuario = '$senha_usuario'";
            $result_c = mysqli_query($conexao, $query_c);
            $row_c = mysqli_num_rows($result_c);

            if ($row_c == 0) {
                echo "<script language='javascript'>window.alert('A senha de usuário não confere, verifique os dados digitados para continuar!!!'); </script>";
                exit;
            }

            $id_termo_abertura_encerramento = $id_termo_abertura_encerramento;
            $data_abertura       = date('Y-m-d');
            $id_operador         = $id_usuario_editor;
            $hora_abertura       = date('H:i:s');
            $valor_abertura      = str_replace(',', '.', $_POST['valor_abertura']);

            //echo $id_termo_abertura_encerramento . ', ' . $data_abertura . ', ' . $id_operador . ', ' . $hora_abertura . ', ' . $valor_abertura;

            $query_in = "INSERT INTO cx_termo_abertura_encerramento (id_termo_abertura_encerramento, data_abertura , id_operador, hora_abertura, valor_abertura, total_entradas) values ('$id_termo_abertura_encerramento', '$data_abertura', '$id_operador', '$hora_abertura', '$valor_abertura', '$valor_abertura')";

            $result_in = mysqli_query($conexao, $query_in);


            // Insert na tabela de cx_historico_movimento_caixa
            //consulta para numeração automatica
            $query_num_aula = "SELECT * from cx_historico_movimento_caixa where id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' order by id_historico_movimento_caixa desc ";
            $result_num_aula = mysqli_query($conexao, $query_num_aula);

            $res_num_aula = mysqli_fetch_array($result_num_aula);
            @$saldo_atual            = $res_num_aula["saldo_atual"];
            if ($saldo_atual == '') {
                $saldo_atual = '0.00';
            } else {
                $saldo_atual = $res_num_aula["saldo_atual"];
            }


            @$saldo_anterior            = $res_num_aula["saldo_anterior"];
            if ($saldo_anterior == '') {
                $saldo_anterior = '0.00';
            } else {
                $saldo_anterior = $res_num_aula["saldo_anterior"];
            }

            @$valor_saida            = $res_num_aula["valor_saida"];

            @$id_historico_movimento_caixa = $res_num_aula["id_historico_movimento_caixa"];
            $id_historico_movimento_caixa = $id_historico_movimento_caixa + 1;

            $saldo_atual2 = number_format($valor_abertura + $saldo_atual, 2, ".", "");
            $descricao_movimento = 'ABERTURA DE CAIXA';

            //echo $id_termo_abertura_encerramento . ' - ' . $data_abertura . ' - ' . $id_historico_movimento_caixa . ' - ' . $descricao_movimento . ' - ' . $saldo_anterior . ' - ' . $valor_abertura . ' - ' . $saldo_atual . ' - ' . $id_localidade . ' - ' . $id_usuario_editor . ' - ' . $saldo_atual2;

            $query_movimento = "INSERT INTO cx_historico_movimento_caixa (id_termo_abertura_encerramento, data_cadastro_movimento, id_historico_movimento_caixa, tipo_movimento, descricao_movimento, saldo_anterior, valor_entrada, saldo_atual, id_localidade, id_operador) values ('$id_termo_abertura_encerramento', '$data_abertura', '$id_historico_movimento_caixa', 'E', '$descricao_movimento', '$saldo_atual', '$valor_abertura', '$saldo_atual2', '$id_localidade', '$id_usuario_editor')";

            $result_movimento = mysqli_query($conexao, $query_movimento);


            if ($result_movimento == '') {
                echo "<script language='javascript'>window.alert('Erro ao fazer a abertura do caixa, consulte seu administrador!!!'); </script>";
            } else {
                echo "<script language='javascript'>window.alert('Abertura realizada com sucesso!!!'); </script>";
                echo "<script language='javascript'>window.location='operacao.php'; </script>";
            }
        }

        ?>


</body>

</html>
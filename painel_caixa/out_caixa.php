<?php
include_once('../conexao.php');

if ($_SESSION['nivel_usuario'] != '4' && $_SESSION['nivel_usuario'] != '0') {
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

    <script type="text/javascript">
        function redirecionar() {
            if (confirm("Deseja imprimir o comprovante de encerramento?")) {
                window.print();
            }
        }
    </script>

</head>

<body>

    <?php

    $id_usuario_editor = $_SESSION['id_usuario'];
    $login_usuario     = $_SESSION['login_usuario'];

    $data = date('Y-m-d');

    $id_localidade = $_SESSION['localidade'];
    $query_loc = "SELECT * from enderecamento_localidade WHERE id_localidade = '$id_localidade' ";
    $result_loc = mysqli_query($conexao, $query_loc);
    $res_loc = mysqli_fetch_array($result_loc);
    @$nome_localidade = $res_loc["nome_localidade"];

    $nome_usuario = $_SESSION['nome_usuario'];

    // validação de caixa
    $query_hc = "SELECT * from cx_termo_abertura_encerramento where id_operador = '$id_usuario_editor' AND data_encerramento is null ";
    $result_hc = mysqli_query($conexao, $query_hc);
    $res_hc = mysqli_fetch_array($result_hc);
    @$id_termo_abertura_encerramento = $res_hc["id_termo_abertura_encerramento"];
    @$data_abertura      = $res_hc["data_abertura"];
    @$data_abertura2 = explode("-", $data_abertura);
    @$data_abertura2 = $data_abertura2[2] . '/' . $data_abertura2[1] . '/' . $data_abertura2[0];

    @$hora_abertura      = $res_hc["hora_abertura"];
    @$valor_abertura     = $res_hc["valor_abertura"];
    @$total_entradas     = $res_hc["total_entradas"];
    @$total_saidas       = $res_hc["total_saidas"];
    @$valor_encerramento = $res_hc["valor_encerramento"];

    @$total_saidas       = $res_hc["total_saidas"];
    @$total_saidas       = $res_hc["total_saidas"];

    // apagando zeros a esquerda
    $id_caixa = ltrim($id_usuario_editor, "0") . ltrim($id_termo_abertura_encerramento, "0");


    $row_hc = mysqli_num_rows($result_hc);

    if ($row_hc == 0) {
        echo "<script language='javascript'>window.alert('Não existe um caixa aberto para este usuário!!!'); </script>";
        echo "<script language='javascript'>window.location='caixa.php'; </script>";
        exit;
    }

    ?>

    <style>
        .nota {
            font-size: 10pt;
            margin-bottom: -10px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printable,
            #printable * {
                visibility: visible;
            }

            #printable {
                position: fixed;
                left: 0;
                top: 0;
                width: 302px;




            }
        }
    </style>


    <form action=" " method="POST">

        <div class="form-row">

            <div class="form-group col-md-1">
                <label for="inputAddress">N° do Caixa</label>
                <input type="text" class="form-control" name="id_caixa" value="<?php echo $id_termo_abertura_encerramento; ?>" readonly>
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
                <input type="text" class="form-control" name="data_abertura" value="<?php echo $data_abertura2; ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">hora de Abertura</label>
                <input type="time" class="form-control" name="hora_abertura" value="<?php echo $hora_abertura; ?>" readonly>
            </div>

        </div>

        <hr>
        <div class="form-row">

            <div class="form-group col-md-2">
                <label for="inputAddress">Valor de Abertura</label>
                <input type="text" class="form-control" name="valor_abertura" value="<?php echo $valor_abertura; ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">Total de Entradas</label>
                <input type="text" class="form-control" name="total_entradas" value="<?php echo $total_entradas; ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">Total de Saídas</label>
                <input type="text" class="form-control" name="total_saidas" value="<?php if ($total_saidas == '') {
                                                                                        echo '0.00';
                                                                                    } else {
                                                                                        echo $total_saidas;
                                                                                    } ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">Valor de Encerramento</label>
                <input type="text" class="form-control" name="valor_encerramento" value="<?php echo number_format($total_entradas - $total_saidas, 2, ".", ""); ?>" readonly>
            </div>

        </div>

        <hr>
        <div class="form-row">

            <div class="form-group col-md-2">
                <label for="inputAddress">Data de Encerramento</label>
                <input type="text" class="form-control" name="data_encerramento" value="<?php echo date('d/m/Y'); ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">hora de Encerramento</label>
                <input type="time" class="form-control" name="hora_encerramento" value="<?php echo date('H:i:s'); ?>" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="inputAddress">Senha de Usuário</label>
                <input type="password" class="form-control" name="senha" placeholder="Confirmação Pessoal">
            </div>

            <div class="form-group col-md-2" style="margin-top: 29px;">
                <button type="submit" class="btn btn-success" name="fechar" onclick="redirecionar();">Fechar Caixa</button>
            </div>

        </div>



        <?php


        //trazendo info perfil_saae
        $query_ps = "SELECT * from perfil_saae";
        $result_ps = mysqli_query($conexao, $query_ps);
        $row_ps = mysqli_fetch_array($result_ps);
        @$nome_prefeitura = $row_ps['nome_prefeitura'];
        //mascarando cnpj
        @$cnpj_saae            = $row_ps['cnpj_saae'];
        $p1 = substr($cnpj_saae, 0, 2);
        $p2 = substr($cnpj_saae, 2, 3);
        $p3 = substr($cnpj_saae, 5, 3);
        $p4 = substr($cnpj_saae, 8, 4);
        $p5 = substr($cnpj_saae, 12, 2);
        $saae_cnpj             = $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4 . '-' . $p5;
        @$nome_bairro_saae     = $row_ps['nome_bairro_saae'];
        @$nome_logradouro_saae = $row_ps['nome_logradouro_saae'];
        @$numero_imovel_saae   = $row_ps['numero_imovel_saae'];
        @$nome_municipio       = $row_ps['nome_municipio'];
        @$uf_saae              = $row_ps['uf_saae'];
        @$nome_saae            = $row_ps['nome_saae'];
        @$email_saae           = $row_ps['email_saae'];
        $fone_saae             = $row_ps["fone_saae"];


        $atendente = 'Atendente';


        ?>



        <div id="printable" style="visibility:hidden;">

            <div class="row">

                <div class="form-group col-md-10">
                    <label class="nota text-center" for="id_produto"><?php echo $nome_saae; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">CNPJ: <?php echo $saae_cnpj; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Fone: <span id="fone"><?php echo $fone_saae; ?></span></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Endereço: <?php echo $nome_logradouro_saae . ' Nº ' . $numero_imovel_saae . ', BAIRRO ' . $nome_bairro_saae; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Cod. Caixa: <?php echo $id_caixa; ?></label>
                </div>

                <h6 class="text-center" style="margin-top: 20px;">Comprovante de Encerramento do Caixa</h6>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Data de Abertura: <?php echo $data_abertura2; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">hora de Abertura: <?php echo $hora_abertura; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Valor de Abertura: <?php echo $valor_abertura; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Total de Entradas: <?php if ($total_entradas == '') {
                                                                                echo '0.00';
                                                                            } else {
                                                                                echo $total_entradas;
                                                                            } ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Total de Saídas: <?php if ($total_saidas == '') {
                                                                                echo '0.00';
                                                                            } else {
                                                                                echo $total_saidas;
                                                                            } ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Valor de Encerramento: <?php echo number_format($valor_abertura + $total_entradas, 2, ".", ","); ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">Data de Encerramento: <?php echo date('d/m/Y'); ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto">hora de Encerramento: <?php echo date('H:i:s'); ?></label>
                </div>

                <div class="form-group col-md-10" style="margin-top: 50px;">
                    <label class="nota text-block" for="id_produto">_____________________________________________</label><br>
                    <label class="nota text-block mt-1" for="id_produto"><?php echo $nome_usuario; ?></label><br>
                    <label class="nota text-center mt-1" for="id_produto">Atendente</label>
                </div>

            </div>

        </div>



        <?php

        if (isset($_POST['fechar'])) {

            $senha_usuario = $_POST['senha'];
            $valor_encerramento = $_POST['valor_encerramento'];

            // validação de caixa
            $query_hc3 = "SELECT * from cx_termo_abertura_encerramento where id_operador = '$id_usuario_editor' AND data_encerramento is null ";
            $result_hc3 = mysqli_query($conexao, $query_hc3);
            $res_hc3 = mysqli_fetch_array($result_hc3);

            $row_hc3 = mysqli_num_rows($result_hc3);

            if ($row_hc3 == 0) {
                echo "<script language='javascript'>window.alert('Não existe um caixa aberto para este usuário!!!'); </script>";
                echo "<script language='javascript'>window.location='caixa.php'; </script>";
                exit;
            }

            // validação de senha
            $query_c = "SELECT * from usuario_sistema where login_usuario = '$login_usuario' and senha_usuario = '$senha_usuario'";
            $result_c = mysqli_query($conexao, $query_c);
            $row_c = mysqli_num_rows($result_c);

            if ($row_c == 0) {
                echo "<script language='javascript'>window.alert('A senha de usuário não confere, verifique os dados digitados para continuar!!!'); </script>";
                exit;
            }

            $id_termo_abertura_encerramento = $id_termo_abertura_encerramento;
            $data_encerramento       = date('Y-m-d');
            $id_operador         = $id_usuario_editor;
            $hora_encerramento       = date('H:i:s');

            //echo $id_termo_abertura_encerramento . ', ' . $data_abertura . ', ' . $id_operador . ', ' . $hora_abertura . ', ' . $valor_abertura;

            $query_up = "UPDATE cx_termo_abertura_encerramento SET valor_encerramento = '$valor_encerramento', data_encerramento = '$data_encerramento', hora_encerramento = '$hora_encerramento' WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_operador = '$id_usuario_editor' ";

            $result_up = mysqli_query($conexao, $query_up);

            if ($query_up == '') {
                echo "<script language='javascript'>window.alert('Erro ao fechar o caixa!!!'); </script>";
            } else {
                echo "<script language='javascript'>window.alert('Encerramento de caixa realizado com sucesso!!!'); </script>";
                echo "<script language='javascript'>window.location ='caixa.php';</script>";
            }
        }

        ?>

</body>

</html>
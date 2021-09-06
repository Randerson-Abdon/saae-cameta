<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação</title>


</head>

<body>

    <?php
    include_once('conexao.php');

    $codigo_post = $_GET['codigo'];
    $numero_cpf_cnpj = $_GET['doc'];

    ?>

    <div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Digite o código de confirmação recebido.</h5>

                </div>
                <div class="modal-body">

                    <form method="POST" action="">
                        <div class="form-group">
                            <input type="text" class="form-control" id="codigo" name="codigo" maxlength="6" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="codigo_post" name="codigo_post" value="<?php echo $codigo_post; ?>" style="display: none;">
                            <input type="text" class="form-control" id="numero_cpf_cnpj" name="numero_cpf_cnpj" value="<?php echo $numero_cpf_cnpj; ?>" style="display: none;">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success ml-2" name="confirmar">Confirmar</button>
                </div>

                <div class="form-group" id="dados"></div>

                </form>


            </div>
        </div>
    </div>


    <?php

    if (isset($_POST['confirmar'])) {
        $codigo = md5($_POST['codigo']);
        $codigo_post = $_POST['codigo_post'];
        $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
        $numero_cpf_cnpj = preg_replace("/[^0-9]/", "", $numero_cpf_cnpj);

        //echo $numero_cpf_cnpj;

        if ($codigo != $codigo_post) {
            echo "<script language='javascript'>window.alert('Código Incorreto!'); </script>";
        } else {
            $query = "UPDATE acesso_seguro_web SET status_acesso = 'A' where numero_cpf_cnpj = '$numero_cpf_cnpj' ";
            $result = mysqli_query($conexao, $query);

            if ($result == '') {
                echo "<script language='javascript'>window.alert('Ocorreu um erro ao Finalizar!'); </script>";
            } else {
                echo "<script language='javascript'>window.alert('Cadastro finalizado com sucesso! Agora você já pode fazer login e consultar suas faturas.'); </script>";
                echo "<script language='javascript'>window.location='index.php'; </script>";
            }
        }
    }

    ?>


    <script>
        $("#modalConfirmar").modal("show");
    </script>

</body>

</html>
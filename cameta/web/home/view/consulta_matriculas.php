<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Matrícula</title>


</head>

<body>

    <?php
    include_once('conexao.php');

    $senha = $_POST['senha'];
    $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
    $numero_cpf_cnpj = preg_replace("/[^0-9]/", "", $numero_cpf_cnpj);

    //trazendo info login
    $query_un = "SELECT * FROM acesso_seguro_web WHERE numero_cpf_cnpj = '$numero_cpf_cnpj' AND senha_acesso_permanente = '$senha'";
    $result_un = mysqli_query($conexao, $query_un);
    $res_un = mysqli_fetch_array($result_un);
    $status = $res_un['status_acesso'];

    //VERIFICAR SE O EMAIL OU SENHA JÁ ESTÁ CADASTRADO                          
    $row_verificar_un = mysqli_num_rows($result_un);
    if ($row_verificar_un == 0) {
        echo "<script language='javascript'>window.alert('Matrícula ou CPF inexistente, verifique os dados digitados ou procure a unidade de atendimento mais próxima!!!'); </script>";
        echo "<script language='javascript'>window.location='index.php'; </script>";
        exit();
    } elseif ($status == 'I') {
        echo "<script language='javascript'>window.alert('Seu acesso esta bloqueado, procure a unidade de atendimento mais próxima!!!'); </script>";
        echo "<script language='javascript'>window.location='index.php'; </script>";
        exit();
    }

    $query_uc = "SELECT * FROM unidade_consumidora WHERE numero_cpf_cnpj = '$numero_cpf_cnpj'";
    $result_uc = mysqli_query($conexao, $query_uc);

    ?>

    <div class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Matrículas Vinculadas ao seu CPF/CNPJ</h5>

                </div>
                <div class="modal-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Matrícula</th>
                                <th scope="col">Nome/Razão Social</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            while ($res = mysqli_fetch_array($result_uc)) {
                                $nome_razao_social = $res["nome_razao_social"];
                                $id = $res["id_unidade_consumidora"];
                                $id_localidade = $res["id_localidade"];

                                $localidade = md5('localidade');
                                $uc = md5('uc');

                            ?>
                                <tr>
                                    <th scope="row"><a href="resultado.php?<?php echo $localidade; ?>=<?php echo $id_localidade; ?>&<?php echo $uc; ?>=<?php echo $id; ?>" target="_blank" title="Selecione para verificar seu Historico Financeiro"><?php echo $id; ?></a></th>
                                    <td><a href="index.php" target="_blank" title="Selecione para verificar seu Historico Financeiro"><a href="resultado.php?<?php echo $localidade; ?>=<?php echo $id_localidade; ?>&<?php echo $uc; ?>=<?php echo $id; ?>" target="_blank" title="Selecione para verificar seu Historico Financeiro"><?php echo $nome_razao_social; ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="window.location.href='index.php'">Cancelar</button>
                </div>

                <div class="form-group" id="dados"></div>


            </div>
        </div>
    </div>


    <?php

    /* if (isset($_POST['confirmar'])) {
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
                echo "<script language='javascript'>window.alert('Cadastro Finalizado Com Sucesso!'); </script>";
                echo "<script language='javascript'>window.location='index.php'; </script>";
            }
        }
    } */

    ?>


    <script>
        $("#modalConsulta").modal("show");
    </script>

</body>

</html>
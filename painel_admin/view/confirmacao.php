<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação de Usuário</title>
</head>

<body>

    <?php

    $login_usuario = $_SESSION['login_usuario'];
    $id_unidade_consumidora = $_GET['id'];
    $id_localidade = $_GET['id_localidade'];
    $mes_faturado = $_GET['mes_faturado'];

    $mes_faturado = explode("/", $mes_faturado);
    $mes_faturado1 = $mes_faturado[1];
    $mes_faturado2 = $mes_faturado[0];

    ?>

    <!-- Modal -->
    <div class="modal fade" id="modalConfima" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Autenticação de Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="model/processa_confirmacao.php" method="post">

                        <div class="form-group">
                            <label for="">Confirme a senha para o usuário <strong class="text-danger"><?php echo $login_usuario; ?></strong></label>
                            <input type="password" class="form-control" name="senha" id="" placeholder="" required>
                            <small id="helpId" class="form-text text-danger">Conirme sua senha acima.</small>
                            <input type="text" name="id_unidade_consumidora" id="id" value="<?php echo $id_unidade_consumidora; ?>" style="display: none;">
                            <input type="text" class="form-control mr-2" name="id_localidade" value="<?php echo @$id_localidade; ?>" style="text-transform:uppercase; display: none;">
                            <input type="text" class="form-control mr-2" name="mes_faturado1" value="<?php echo @$mes_faturado1; ?>" style="text-transform:uppercase; display: none;">
                            <input type="text" class="form-control mr-2" name="mes_faturado2" value="<?php echo @$mes_faturado2; ?>" style="text-transform:uppercase; display: none;">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="confirmar">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $('#modalConfima').modal('show');
    </script>

</body>

</html>
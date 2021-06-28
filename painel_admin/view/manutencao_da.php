<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
include_once('controller/controller_lancamento_da.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '1' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}

?>



<div class="container ml-4">
    <div class="row">

        <div class="col-lg-8 col-md-6">
            <h3>Manutenção de Notificações</h3>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <form class="form-inline my-2 my-lg-0">
                <input name="txtpesquisarNotificacao" class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                <button name="buttonPesquisar" class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</div>



<div class="container ml-4">


    <br>


    <div class="content">
        <div class="row mr-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <!--LISTAR TODOS -->
                            <?php
                            if (isset($_GET['buttonPesquisar']) and $_GET['txtpesquisarNotificacao'] != '') {


                                $id = $_GET['txtpesquisarNotificacao'];
                                $id = str_pad($id, 5, '0', STR_PAD_LEFT);

                                $notificacao = $_GET['txtpesquisarNotificacao'];
                                $notificacao = str_pad($notificacao, 6, '0', STR_PAD_LEFT);

                                $nome = '%' . $_GET['txtpesquisarNotificacao'] . '%';

                                $query = "SELECT * from notificacoes_divida_ativa where status_notificacao_extrajudical = 'A' and id_unidade_consumidora = '$id' or id_notificacao = '$notificacao' or nome_razao_social like '$nome' order by id_notificacao asc ";

                                $result_count = mysqli_query($conexao, $query);
                            } else {
                                $query = "SELECT * from notificacoes_divida_ativa where status_notificacao_extrajudical = 'A' order by id_notificacao desc limit 15";

                                $query_count = "SELECT * from notificacoes_divida_ativa where status_notificacao_extrajudical = 'A' ";
                                $result_count = mysqli_query($conexao, $query_count);
                            }

                            $result = mysqli_query($conexao, $query);

                            $linha = mysqli_num_rows($result);
                            $linha_count = mysqli_num_rows($result_count);

                            if ($linha == '') {
                                echo "<h3> Não foram encontrados dados Cadastrados no Banco!! </h3>";
                            } else {

                            ?>

                                <table class="table table-sm">
                                    <thead class="text-secondary">

                                        <th class="text-danger">
                                            N° Not.
                                        </th>
                                        <th>
                                            Matrícula
                                        </th>
                                        <th>
                                            Nome Consumidor
                                        </th>
                                        <th>
                                            Data de Lançamento
                                        </th>


                                        <th>
                                            Ações
                                        </th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        while ($res = mysqli_fetch_array($result)) {
                                            $id_localidade          = $res["id_localidade"];
                                            $id_notificacao         = $res["id_notificacao"];
                                            $id_unidade_consumidora = $res["id_unidade_consumidora"];
                                            $nome_razao_social      = $res["nome_razao_social"];
                                            $data_lancamento        = $res["data_lancamento_notificacao_extrajudicial"];

                                            $data_lancamento = date('d/m/Y',  strtotime($data_lancamento));

                                        ?>

                                            <tr>

                                                <td class="text-danger"><?php echo $id_notificacao; ?></td>
                                                <td><?php echo $id_unidade_consumidora; ?></td>
                                                <td><?php echo $nome_razao_social; ?></td>
                                                <td><?php echo $data_lancamento; ?></td>


                                                <td>

                                                    <a class="btn btn-info btn-sm" href="admin.php?acao=manutencao&func=edita&id=<?php echo $id_unidade_consumidora; ?>&id_localidade=<?php echo $id_localidade; ?>"><i class="fas fa-edit"></i></a>

                                                    <a class="btn btn-danger btn-sm" href="admin.php?acao=localidades&func=excluir&id=<?php echo $id; ?>"><i class="fa fa-minus-square"></i></a>

                                                </td>
                                            </tr>

                                        <?php } ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>


                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td>
                                                <span class="text-muted">Registros: <?php echo $linha_count ?> </span>
                                            </td>
                                        </tr>

                                    </tfoot>
                                </table>

                            <?php
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!--EDITAR -->
        <?php
        if (@$_GET['func'] == 'edita') {
            $id_unidade_consumidora = $_GET['id'];
            $id_localidade  = $_GET['id_localidade'];

            $result = listaNotificacao_uc_manutencao($id_localidade, $id_unidade_consumidora);

            while (@$res = mysqli_fetch_array($result)) {
                $id_notificacao         = $res["ID NOT"];
                $nome_razao_social      = $res["NOME DO CLIENTE"];
                $status_ligacao         = $res["SIT. LIG."];
                $numero_meses           = $res["N. MESES"];
                $total_tarifas          = $res["TARIFAS"];
                $total_acordos          = $res["ACORDOS"];
                $total_multas           = $res["(*) MULTAS"];
                $total_juros            = $res["(*) JUROS"];
                $total_faturado         = $res["FATURADO"];
                $multas_atualizadas     = $res["(+) MULTAS"];
                $juros_atualizados      = $res["(+) JUROS"];
                $total_geral            = $res["TOTAL"];
                $data_lançamento        = $res["DTA. LCTO N.E."];
                $descricao_meses        = $res["DESCRIÇÃO DE MESES"];
                $logradouro             = $res["ENDEREÇO"];
                $numero                 = $res["NUMERO"];
                $bairro                 = $res["BAIRRO"];
                $localidade             = $res["LOCALIDADE"];
                $status_notificacao_ej  = $res["STATUS NOTIFICAÇÃO E.J."];
                $status_notificacao_da  = $res["STATUS CERTIDÃO D.A."];


        ?>



                <!-- Modal Editar -->
                <div id="modalEditar" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">

                                <?php if ($status_notificacao_ej == 'ATIVA' && $status_notificacao_da == '') { ?>

                                    <h6 class="modal-title">Manutenção de Notificações Extrajudiciais</h6>

                                <?php } ?>

                                <?php if ($status_notificacao_da == 'ATIVA') { ?>

                                    <h6 class="modal-title">Manutenção de Notificações de Dívida Ativa</h6>

                                <?php } ?>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">

                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <label for="id_produto">N° Not.</label>
                                            <input type="text" class="form-control mr-2" name="id_notificacao" value="<?php echo $id_notificacao ?>" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="id_produto">Matrícula</label>
                                            <input type="text" class="form-control mr-2" name="id_unidade_consumidora" value="<?php echo $id_unidade_consumidora ?>" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="id_produto">Nome Consumidor</label>
                                            <input type="text" class="form-control mr-2" name="nome_razao_social" value="<?php echo $nome_razao_social ?>" style="text-transform:uppercase;" readonly>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="id_produto">Endereço</label>
                                            <input type="text" class="form-control mr-2" name="endereco" value="<?php echo $logradouro . ' N° ' . $numero . ', bairro ' . $bairro . ', ' . $localidade; ?>" style="text-transform:uppercase;" readonly>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row">

                                        <div class="form-group col-md-5">
                                            <label for="fornecedor">Data da Baixa</label>
                                            <input type="date" class="form-control mr-2" maxlength="10" id="saida" name="data_baixa" value="<?php echo date('Y-m-d'); ?>" />
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="fornecedor">Justificativa</label>
                                            <select class="form-control mr-2" id="category" name="justificativa" style="text-transform:uppercase;">

                                                <option value="1">QUITAÇÃO TOTAL DO DÉBITO</option>
                                                <option value="2">PARCELAMENTO DO DÉBITO</option>
                                                <option value="3">COMPROVAÇÃO PARCIAL DE PAGAMENTO</option>
                                                <option value="4">COMPROVAÇÃO TOTAL DE PAGAMENTO</option>
                                                <option value="5">LANÇAMENTO INDEVIDO</option>

                                            </select>
                                        </div>

                                    </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success mb-3" name="editar">Salvar </button>


                                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


        <?php


                if (isset($_POST['editar'])) {
                    $data_baixa = $_POST['data_baixa'];
                    $justificativa = mb_strtoupper($_POST['justificativa']);
                    $id_notificacao = $_POST['id_notificacao'];
                    $id_usuario_editor = $_SESSION['id_usuario'];

                    if ($status_notificacao_ej == 'ATIVA' && $status_notificacao_da == '') {

                        $query = "UPDATE notificacoes_divida_ativa SET data_baixa_notificacao_extrajudicial = '$data_baixa', justificativa_baixa_notificao_extrajudicial = '$justificativa', status_notificacao_extrajudical = 'B', id_operador_ej = '$id_usuario_editor' where id_notificacao = '$id_notificacao' ";
                    } elseif ($status_notificacao_da == 'ATIVA') {
                        $query = "UPDATE notificacoes_divida_ativa SET data_baixa_notificacao_extrajudicial = '$data_baixa', justificativa_baixa_notificao_extrajudicial = '$justificativa', status_notificacao_extrajudical = 'B', status_notificacao_divida_ativa = 'B', id_operador_ej = '$id_usuario_editor' where id_notificacao = '$id_notificacao' ";
                    }

                    $result = mysqli_query($conexao, $query);

                    if ($result == '') {
                        echo "<script language='javascript'>window.alert('Ocorreu um erro ao Editar!'); </script>";
                    } else {
                        echo "<script language='javascript'>window.alert('Salvo com Sucesso!'); </script>";
                        echo "<script language='javascript'>window.location='admin.php?acao=manutencao'; </script>";
                    }
                }
            }
        }

        ?>



        <!--EXCLUIR -->
        <?php
        if (@$_GET['func'] == 'excluir') {
            $id = $_GET['id'];

            $query = "DELETE FROM localidade where id_localidade = '$id' ";
            $result = mysqli_query($conexao, $query);
            echo "<script language='javascript'>window.location='admin.php?acao=localidades'; </script>";
        }

        ?>




        <script>
            $("#modalEditar").modal("show");
        </script>


        <!--MASCARAS -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
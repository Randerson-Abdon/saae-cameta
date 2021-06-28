<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

if ($_SESSION['nivel_usuario'] != '5' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}

?>



<div class="container ml-4">
    <div class="row">

        <div class="col-lg-8 col-md-6">
            <h3>RELATÓRIOS DE CAIXA</h3>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <form method="POST" class="form-inline my-2 my-lg-0">

                <?php
                @$nome2 = $_POST['txtpesquisarRel'];
                @$status2 = $_POST['cbPesquisarCaixa'];
                @$id_usuario_editor2 = $_POST['usuario'];
                ?>


                <label for="fornecedor"><strong>SELECIONE O CAIXA:</strong>&nbsp; </label>
                <select class="form-control mr-2" id="usuario" name="usuario">

                    <?php

                    //recuperando dados da tabela categoria para o select
                    $query = "SELECT DISTINCT id_operador from cx_termo_abertura_encerramento order by id_operador asc";
                    $result = mysqli_query($conexao, $query);
                    while ($res = mysqli_fetch_array($result)) {

                        //recuperando dados da tabela NOME USER
                        $query2 = "SELECT * from usuario_sistema where id_usuario = $res[id_operador] order by id_usuario asc";
                        $result2 = mysqli_query($conexao, $query2);
                        $res_nome = mysqli_fetch_array($result2);
                        $nome_user = $res_nome['nome_usuario'];
                        $id_usuario = $res_nome['id_usuario'];

                    ?>
                        <!--relacionamento com base no id gravando só o mesmo mas visualizando o nome-->
                        <option value="<?php echo $id_usuario; ?>"><?php echo $nome_user; ?></option>

                    <?php
                    }
                    ?>
                </select>


                <!--filtro de pesquisa por status-->
                <select class="form-control mr-2" name="cbPesquisarCaixa" id="">

                    <option value="T">Tudo</option>
                    <option value="E">Entrada</option>
                    <option value="S">Saída</option>

                </select>

                <input name="txtpesquisarRel" type="date" class="form-control mr-sm-2" value="<?php echo date('d/m/Y'); ?>" type="search" placeholder="Pesquisar Caixa" aria-label="Pesquisar">
                <button name="buttonPesquisar" class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                <a type="button" class="btn btn-info btn-sm ml-2" target="_blank" href="relatorio_rel.php?nome2=<?php echo $nome2; ?>&status2=<?php echo $status2; ?>&usuario=<?php echo $id_usuario_editor2; ?>"><i class="fas fa-print"></i> IMPRIMIR</a>
            </form>
            <script type="text/javascript">
                //post segundario
                function submitForm(form, action) {
                    form.action = action;
                    form.submit();
                }
            </script>
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

                            <!--LISTAR TODOS AS LOCALIDADES -->
                            <?php
                            @$id_usuario_editor = $_POST['usuario'];
                            $status = @$_POST['cbPesquisarCaixa'];
                            if (isset($_POST['buttonPesquisar']) and $_POST['txtpesquisarRel'] != '') {

                                $nome = $_POST['txtpesquisarRel'] . '%';

                                //se o status fou igual a todos
                                if ($status == 'T') {
                                    $query = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' AND data_cadastro_movimento = '$nome' order by id_historico_movimento_caixa desc";
                                } else {
                                    $query = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' AND data_cadastro_movimento = '$nome' AND tipo_movimento = '$status' order by id_historico_movimento_caixa desc";
                                }

                                $result_count = mysqli_query($conexao, $query);
                            } else {
                                $data_cadastro = date('Y-m-d');
                                $query = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' and data_cadastro_movimento = '$data_cadastro' order by id_historico_movimento_caixa asc limit 15";

                                $query_count = "SELECT * from cx_historico_movimento_caixa where id_operador = '$id_usuario_editor' and data_cadastro_movimento = '$data_cadastro'";
                                $result_count = mysqli_query($conexao, $query_count);
                            }

                            $result = mysqli_query($conexao, $query);

                            @$linha = mysqli_num_rows($result);
                            $linha_count = mysqli_num_rows($result_count);

                            if ($linha == '') {
                                echo "<h3> Selecione os parametros para a criação do relatório!!! </h3>";
                            } else {

                            ?>


                                <table class="table table-sm">
                                    <thead class="text-secondary">

                                        <th>
                                            Identificação
                                        </th>
                                        <th>
                                            Data
                                        </th>
                                        <th>
                                            Descrição
                                        </th>
                                        <th>
                                            Tipo
                                        </th>
                                        <th>
                                            Valor
                                        </th>


                                        <th>
                                            Ações
                                        </th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        while ($res = mysqli_fetch_array($result)) {
                                            $id_historico_movimento_caixa = $res["id_historico_movimento_caixa"];
                                            $data_cadastro_movimento   = $res["data_cadastro_movimento"];
                                            $descricao_movimento = $res["descricao_movimento"];
                                            $tipo_movimento  = $res["tipo_movimento"];
                                            $valor_entrada = $res["valor_entrada"];
                                            $valor_saida = $res["valor_saida"];

                                            $data2 = implode('/', array_reverse(explode('-', $data_cadastro_movimento)));


                                        ?>

                                            <tr>

                                                <td><?php echo $id_historico_movimento_caixa; ?></td>
                                                <td><?php echo $data2; ?></td>
                                                <td><?php echo $descricao_movimento; ?></td>

                                                <td><?php if ($tipo_movimento == 'E') {
                                                        echo 'ENTRADA';
                                                    } else {
                                                        echo 'SAIDA';
                                                    } ?></td>

                                                <td><?php if ($tipo_movimento == 'E') {
                                                        echo 'R$ ' . number_format($valor_entrada, 2, ",", ".");
                                                    } else {
                                                        echo 'R$ ' . number_format($valor_saida, 2, ",", ".");
                                                    } ?></td>


                                                <td>

                                                    <a class="btn btn-info btn-sm" href="admin.php?acao=localidades&func=edita&id=<?php echo $id; ?>"><i class="fas fa-edit"></i></a>

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




        <!-- Modal -->


        <div id="modalExemplo" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">Movimentação de Caixa</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">

                            <div class="form-group">
                                <label for="fornecedor">Tipo de Movimento</label>
                                <select class="form-control mr-2" id="category" name="tipo_movimento" style="text-transform:uppercase;">

                                    <option value="S">Saída</option>
                                    <option value="E">Entrada</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_produto">Descrição</label>
                                <input type="text" class="form-control mr-2" name="descricao_movimento" placeholder="Descreva aqui" style="text-transform: uppercase;" required>
                            </div>

                            <div class="form-group">
                                <label for="id_produto">Varlor</label>
                                <input type="text" class="form-control mr-2" name="valor_entrada" placeholder="0,00" required>
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




        <!--CADASTRO -->
        <?php
        if (isset($_POST['salvar'])) {

            $tipo_movimento = $_POST['tipo_movimento'];
            $descricao_movimento = mb_strtoupper($_POST['descricao_movimento']);
            @$valor_entrada = str_replace(',', '.', $_POST['valor_entrada']);
            $id_historico_movimento_caixa = $id_historico_movimento_caixa;

            //echo $valor_entrada;

            $id_usuario_editor = $_SESSION['id_usuario'];
            $localidade = $_SESSION['localidade'];




            //info cx_termo_abertura_encerramento
            $query_hc = "SELECT * FROM cx_termo_abertura_encerramento WHERE id_operador = '$id_usuario_editor' AND data_encerramento IS NULL ";
            $result_hc = mysqli_query($conexao, $query_hc);
            $res_hc = mysqli_fetch_array($result_hc);
            $id_termo_abertura_encerramento  = $res_hc["id_termo_abertura_encerramento"];
            $total_entradas = $res_hc["total_entradas"];
            $total_saidas = $res_hc["total_saidas"];

            // Insert na tabela de cx_historico_movimento_caixa
            //consulta para numeração automatica
            $query_num_aula = "SELECT * from cx_historico_movimento_caixa where id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' order by id_historico_movimento_caixa desc ";
            $result_num_aula = mysqli_query($conexao, $query_num_aula);
            $res_num_aula = mysqli_fetch_array($result_num_aula);
            @$id_historico_movimento_caixa = $res_num_aula["id_historico_movimento_caixa"];
            $id_historico_movimento_caixa = $id_historico_movimento_caixa + 1;

            $query_num_aula2 = "SELECT * from cx_historico_movimento_caixa WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_operador = '$id_usuario_editor' order by id_historico_movimento_caixa desc ";
            $result_num_aula2 = mysqli_query($conexao, $query_num_aula2);

            $res_num_aula2 = mysqli_fetch_array($result_num_aula2);
            @$saldo_anterior            = $res_num_aula2["saldo_anterior"];
            @$saldo_atual               = $res_num_aula2["saldo_atual"];

            if ($tipo_movimento == 'E') {
                $saldo_atual2 = $valor_entrada + $saldo_atual;
            } else {
                $saldo_atual2 = $saldo_atual - $valor_entrada;
            }

            $data_cadastro_movimento  = date('Y-m-d');

            if ($tipo_movimento == 'E') {
                $valor_e = $valor_entrada + $total_entradas;
                $valor_s = 0 + $total_saidas;
            } else {
                $valor_e = 0 + $total_entradas;
                $valor_s = $valor_entrada + $total_saidas;
            }

            if ($tipo_movimento == 'E') {
                $tipo = 'valor_entrada';
            } else {
                $tipo = 'valor_saida';
            }

            //echo $id_termo_abertura_encerramento . ' - ' . $data_cadastro_movimento . ' - ' . $id_historico_movimento_caixa . ' - ' . $tipo_movimento . ' - ' . $descricao_movimento . ' - ' . $saldo_atual . ' - ' . $valor_entrada . ' - ' . $saldo_atual2 . ' - ' . $localidade . ' - ' . $id_usuario_editor;

            $query_movimento = "INSERT INTO cx_historico_movimento_caixa (id_termo_abertura_encerramento, data_cadastro_movimento, id_historico_movimento_caixa, tipo_movimento, descricao_movimento, saldo_anterior, $tipo, saldo_atual, id_localidade, id_operador) values ('$id_termo_abertura_encerramento', '$data_cadastro_movimento', '$id_historico_movimento_caixa', '$tipo_movimento', '$descricao_movimento', '$saldo_atual', '$valor_entrada', '$saldo_atual2', '$localidade', '$id_usuario_editor')";

            $result_movimento = mysqli_query($conexao, $query_movimento);


            if ($result_movimento == '') {
                echo "<script language='javascript'>window.alert('Ocorreu um erro ao Salvar!'); </script>";
            } else {

                $query_up = "UPDATE cx_termo_abertura_encerramento SET total_entradas = '$valor_e', total_saidas = '$valor_s' WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_operador = '$id_usuario_editor' ";
                $result_up = mysqli_query($conexao, $query_up);

                echo "<script language='javascript'>window.alert('Lançamento de movimento realizado com sucesso!'); </script>";
                echo "<script language='javascript'>window.location='caixa.php?acao=movimento'; </script>";
            }
        }
        ?>






        <script>
            $("#modalEditar").modal("show");
        </script>


        <!--MASCARAS -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
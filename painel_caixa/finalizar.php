<?php
session_start();
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');

date_default_timezone_set('America/Sao_Paulo');

if ($_SESSION['nivel_usuario'] != '4' && $_SESSION['nivel_usuario'] != '0') {
    header('Location: ../login.php');
    exit();
}

// seções de perfil saae
@$nome_prefeitura      = $_SESSION['nome_prefeitura'];
@$saae_cnpj            = $_SESSION['saae_cnpj'];
@$nome_bairro_saae     = $_SESSION['nome_bairro_saae'];
@$nome_logradouro_saae = $_SESSION['nome_logradouro_saae'];
@$numero_imovel_saae   = $_SESSION['numero_imovel_saae'];
@$nome_municipio       = $_SESSION['nome_municipio'];
@$uf_saae              = $_SESSION['uf_saae'];
@$nome_saae            = $_SESSION['nome_saae'];
@$email_saae           = $_SESSION['email_saae'];
$fone_saae             = $_SESSION['fone_saae'];

$id_usuario_editor              = $_SESSION['id_usuario'];
$nome_usuario                   = $_SESSION['nome_usuario'];
$localidade                     = $_SESSION['localidade'];

$id_termo_abertura_encerramento = $_POST['id_termo_abertura_encerramento'];
$id_caixa                       = $_POST['id_caixa'];
$v_pago                         = $_POST['v_pago'];
$v_pago                         = str_replace(',', '.', $v_pago);
$codigo_barras                  = $_POST['codigo_barras'];

$resultado = mysqli_query($conexao, "SELECT sum(valor_total_arrecadacao), sum(valor_arrecadacao), sum(valor_multa), sum(valor_juros) FROM cx_caixa_temporario WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_caixa = '$id_caixa' ");
$linhas = mysqli_num_rows($resultado);

while ($linhas = mysqli_fetch_array($resultado)) {
    $valor_total_arrecadacao = $linhas['sum(valor_total_arrecadacao)'];
    $valor_arrecadacao       = $linhas['sum(valor_arrecadacao)'];
    $valor_multa             = $linhas['sum(valor_multa)'];
    $valor_juros             = $linhas['sum(valor_juros)'];
}

if ($v_pago == '') {
    $v_pago = $valor_total_arrecadacao;
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
            position: absolute;
            left: 0;
            top: 0;
            height: auto;

        }
    }
</style>


<!-- Modal Nota -->
<div id="modalExemplo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Finalizar Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">

                    <div class="form-group">
                        <label class="nota" for="id_produto">CNPJ: <?php echo $saae_cnpj; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Fone: <span id="fone"><?php echo $fone_saae; ?></span></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Endereço: <?php echo $nome_logradouro_saae . ' Nº ' . $numero_imovel_saae . ', BAIRRO ' . $nome_bairro_saae; ?></label>
                    </div>

                    <h6 style="margin-top: 30px;">Dados de Pagamento</h6>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Atendente: <?php echo $nome_usuario; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Data Pagamento: <?php echo date('d/m/Y'); ?></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Valor Total das Faturas: R$ <?php echo $valor_arrecadacao; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Juros: R$ <?php echo $valor_juros; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Multas: R$ <?php echo $valor_multa; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="nota" for="id_produto">Valor Total a Pagar: R$ <?php echo $valor_total_arrecadacao; ?></label>
                    </div>

                    <div class="form-group">
                        <label class="text-justify text-danger" for="id_produto" style="font-size: 14pt;">Troco: R$ <?php echo number_format($v_pago - $valor_total_arrecadacao, 2, ",", "");
                                                                                                                    ?></label>

                        <input type="text" class="form-control mr-2" name="id_caixa" value="<?php echo $id_caixa; ?>" style="display: none;">
                        <input type="text" class="form-control mr-2" name="id_caixa" value="<?php echo $id_termo_abertura_encerramento; ?>" style="display: none;">
                        <input type="text" class="form-control mr-2" name="id_caixa" value="<?php echo $codigo_barras; ?>" style="display: none;">
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success mb-3" onclick="window.print();" id="autenticar" name="autenticar">Autenticar </button>


                <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal-body" id="printable" style="visibility:hidden;">
    <form method="POST" action="">

        <?php

        $query_cp = "SELECT * FROM cx_caixa_temporario WHERE id_termo_abertura_encerramento = '$id_termo_abertura_encerramento' AND id_caixa = '$id_caixa' ";
        $result_cp = mysqli_query($conexao, $query_cp);

        while ($row = mysqli_fetch_assoc($result_cp)) {
            $id_localidade           = $row["id_localidade"];
            $id_unidade_consumidora  = $row["id_unidade_consumidora"];
            $id_caixa                = $row["id_caixa"];
            $mes_fatura_arrecadada   = $row["mes_fatura_arrecadada"];
            $data_vencimento_fatura  = $row["data_vencimento_fatura"];
            $data_vencimento_fatura = explode("-", $data_vencimento_fatura);
            $data_vencimento_fatura = $data_vencimento_fatura[2] . '/' . $data_vencimento_fatura[1] . '/' . $data_vencimento_fatura[0];

            $valor_juros             = $row["valor_juros"];
            $valor_multa             = $row["valor_multa"];
            $valor_total_arrecadacao = $row["valor_total_arrecadacao"];
            $valor_arrecadacao       = $row["valor_arrecadacao"];

            //executa o store procedure info consumidor
            $result_sp = mysqli_query(
                $conexao,
                "CALL sp_seleciona_unidade_consumidora($id_localidade,$id_unidade_consumidora);"
            ) or die("Erro na query da procedure: " . mysqli_error($conexao));
            mysqli_next_result($conexao);
            $row_uc = mysqli_fetch_array($result_sp);
            $nome_razao_social        = $row_uc['NOME'];
            $tipo_juridico            = $row_uc['TIPO_JURIDICO'];
            $numero_cpf_cnpj          = $row_uc['CPF_CNPJ'];
            $numero_rg                = $row_uc['N.º RG'];
            $orgao_emissor_rg         = $row_uc['ORGAO_EMISSOR'];
            $uf_rg                    = $row_uc['UF'];
            $fone_fixo                = $row_uc['FONE_FIXO'];
            $fone_movel               = $row_uc['CELULAR'];
            $fone_zap                 = $row_uc['ZAP'];
            $email                    = $row_uc['EMAIL'];
            $tipo_consumo             = $row_uc['TIPO_CONSUMO'];
            $faixa_consumo            = $row_uc['FAIXA'];
            $tipo_medicao             = $row_uc['MEDICAO'];
            $id_unidade_hidrometrica  = '';
            $valor_faixa_consumo      = $row_uc['VALOR'];
            $nome_localidade          = $row_uc['LOCALIDADE'];
            $nome_bairro              = $row_uc['BAIRRO'];
            $nome_logradouro          = $row_uc['LOGRADOURO'];
            $numero_logradouro        = $row_uc['NUMERO'];
            $complemento_logradouro   = $row_uc['COMPLEMENTO'];
            $cep_logradouro           = $row_uc['CEP'];
            $tipo_enderecamento       = $row_uc['CORRESPONDENCIA'];
            $status_ligacao           = $row_uc['STATUS'];
            $data_cadastro            = $row_uc['CADASTRO'];
            $observacoes_text         = $row_uc['OBSERVAÇÕES'];


        ?>
            <div class="row" style="margin-bottom: 100px;">

                <div class="form-group col-md-10">
                    <label class="nota text-center" for="id_produto" style="font-weight: bold;"><?php echo $nome_saae; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">CNPJ: <?php echo $saae_cnpj; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Fone: <span id="fone"><?php echo $fone_saae; ?></span></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Endereço: <?php echo $nome_logradouro_saae . ' Nº ' . $numero_imovel_saae . ', BAIRRO ' . $nome_bairro_saae; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Atendente: <?php echo $nome_usuario; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Cod. Caixa: <?php echo $id_caixa; ?></label>
                </div>

                <h6 style="margin-top: 20px;" style="font-weight: bold;">Comprovante de Pagamento</h6>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Titular: <?php echo $nome_razao_social; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">CPF/CNPJ: <?php echo $numero_cpf_cnpj; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Localidade: <?php echo $nome_localidade; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Matrícula: <?php echo $id_unidade_consumidora; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Competência: <?php echo $mes_fatura_arrecadada; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Data Pagamento: <?php echo date('d/m/Y'); ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Data Vencimento: <?php echo $data_vencimento_fatura; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Total da Fatura: <?php echo $valor_arrecadacao; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Juros: <?php echo $valor_juros; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Multas: <?php echo $valor_multa; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota" for="id_produto" style="font-weight: bold;">Total Pago: <?php echo $valor_total_arrecadacao; ?></label>
                </div>

                <div class="form-group col-md-10">
                    <label class="nota text-center" for="id_produto">A sua fatura completa e detalhada esta disponível no endereço eletronico: saaecameta.com.br</label>
                </div>
            </div>

        <?php } ?>

    </form>

</div>

<script>
    $("#autenticar").click(function() {
        $.ajax({
            url: "salve.php",
            type: "POST",
            data: ({
                codigo_barras: $("input[name='codigo_barras']").val(),
                id_termo_abertura_encerramento: $("input[name='id_termo_abertura_encerramento']").val(),
                id_caixa: $("input[name='id_caixa']").val()
            }), //estamos enviando o valor do input
            success: function(resposta) {
                $('#dados').html(resposta);
            }
        });
    });
</script>



<script>
    $("#modalExemplo").modal("show");
</script>

<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $("span[id*='fone']").inputmask({
        mask: ['(99) 9999-9999'],
        keepStatic: true
    });
</script>

<?php

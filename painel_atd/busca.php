<style>
    section .modal-body{
        margin-top: -170px;
        margin-bottom: -170px;
    }
</style>

<?php

//LOCAL PADRÃO DA APLICAÇÃO BRASIL
date_default_timezone_set('America/Sao_Paulo');
//OBJETO QUE SE MANTEM, CONSTANTE COM DADOS PARA CONEXÃO AO BD
define('HOST', 'santaizabel-pa.cz2ewjwgfqye.us-east-1.rds.amazonaws.com');
define('USUARIO', 'acessoremoto');
define('SENHA', 'portalsaae2020');
define('BD', 'santaizabel-pa');

//VARIAVEL PARA GUARDAR A EXECUÇÃO DA CONEXÃO
$conn = mysqli_connect(HOST, USUARIO, SENHA, BD) or die ('Não Conectou');

//Checando conexção
if (!$conn) {
    die("Falha na conexção: " . mysqli_connect_error());
}

$palavra = $_POST['palavra'];
$cc = $_POST['cc'];

$sql = "SELECT * FROM unidade_consumidora WHERE id_unidade_consumidora LIKE '%$palavra%' and numero_cpf_cnpj = '%$cc%' limit 3";
$query = mysqli_query($conn, $sql);
$qtd = mysqli_num_rows($query);
?>
<section>
    <?php
    if($qtd>0){
    ?>
    <div class="modal-body">
        <tbody>
            <?php 
            while($linha = mysqli_fetch_assoc($query)){
            ?>
            <hr style="background-color: rgb(197, 49, 30);">
            <div class="row">
            

                <div class="form-group col-md-4" >
                    <label for="id_produto">CPF/CNPJ</label>
                    <input type="text" id="numero_cpf_cnpj" class="form-control mr-2" name="numero_cpf_cnpj_n" value="<?=$linha['numero_cpf_cnpj'];?>" style="text-transform:uppercase;">
                </div>
            
                <div class="form-group col-md-8">
                    <label for="id_produto">Nome/Razão Social</label>
                    <input type="text" class="form-control mr-2" name="nome_razao_social_n" value="<?=$linha['nome_razao_social'];?>" style="text-transform:uppercase;">
                </div>

                <div class="form-group col-md-3">
                    <label for="id_produto">RG</label>
                    <input type="text" class="form-control mr-2" name="numero_rg_n" value="<?=$linha['numero_rg'];?>" id="rg" style="text-transform:uppercase;">
                </div>

                <div class="form-group col-md-3">
                    <label for="id_produto">Orgão Emissor</label>
                    <input type="text" class="form-control mr-2" name="orgao_emissor_rg_n" value="<?=$linha['orgao_emissor_rg'];?>" style="text-transform:uppercase;">
                </div>

                <div class="form-group col-md-3">
                    <label for="id_produto">UF RG</label>
                    <input type="text" class="form-control mr-2" name="uf_rg_n" value="<?=$linha['uf_rg'];?>" style="text-transform:uppercase;">
                </div>

                <div class="form-group col-md-3">
                    <label for="id_produto">Telefone Fixo</label>
                    <input type="text" class="form-control mr-2" name="fone_fixo_n" value="<?=$linha['fone_fixo'];?>" style="text-transform:uppercase;" >
                </div>

                <div class="form-group col-md-3">
                    <label for="id_produto">Celular</label>
                    <input type="text" class="form-control mr-2" name="fone_movel_n" value="<?=$linha['fone_movel'];?>" style="text-transform:uppercase;">
                </div>

                <div class="form-group col-md-3">
                    <label for="id_produto">WhatsApp</label>
                    <input type="text" class="form-control mr-2" name="fone_movel_zap_n" value="<?=$linha['fone_zap'];?>" style="text-transform:uppercase;">
                </div>

                <div class="form-group col-md-5">
                    <label for="id_produto">E-mail</label>
                    <input type="email" class="form-control mr-2" name="email_n" value="<?=$linha['email'];?>" style="text-transform:uppercase;">
                </div>              


            </div>
            <hr style="background-color: rgb(197, 49, 30);">
            <?php }?>
        </tbody>
    </div>
    <?php }else{?>
    <h4>Nao foram encontrados registros com esta palavra.</h4>
    <?php }?>
</section>
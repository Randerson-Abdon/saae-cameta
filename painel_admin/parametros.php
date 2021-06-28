<?php
include_once('../conexao.php');
?>


<?php

$query = "select * from perfil_saae";
$result = mysqli_query($conexao, $query);

while ($res = mysqli_fetch_array($result)) {
    $nome_municipio = $res["nome_municipio"];
    $nome_prefeitura = $res["nome_prefeitura"];
    $nome_saae = $res["nome_saae"];
    $cnpj_saae = $res["cnpj_saae"];
    $nome_logradouro_saae = $res["nome_logradouro_saae"];
    $numero_imovel_saae = $res["numero_imovel_saae"];
    $complemento_endereco_saae = $res["complemento_endereco_saae"];
    $nome_bairro_saae = $res["nome_bairro_saae"];
    $cep_saae = $res["cep_saae"];
    $uf_saae = $res["uf_saae"];
    $fone_saae = $res["fone_saae"];
    $email_saae = $res["email_saae"];
    $home_page_saae = $res["home_page_saae"];
    $nome_gestor_saae = $res["nome_gestor_saae"];
    $cpf_gestor_saae = $res["cpf_gestor_saae"];
    $numero_decreto_nomeacao = $res["numero_decreto_nomeacao"];
    $imagem_assinatura_gestor = $res["imagem_assinatura_gestor"];
    $logo_marca_saae = $res["logo_marca_saae"];
    $logo_marca_prefeitura = $res["logo_marca_prefeitura"];
    $logo_orgao = $res["logo_orgao"];
    $logo_orgao = $res["logo_orgao"];
    $logo_prefeitura = $res["logo_prefeitura"];


    //se existir o get comimg na url a foto recebe o caminho da url
    if (isset($_GET['img'])) {
        //guardando img
        $foto = $_GET['img'];
    } else {
        $foto = $res["logo_orgao"];
    }

?>

    <!--contenner-->
    <div class="container ml-4">

        <!--formulario-->
        <form class="mr-4" method="post">

            <!--linha01-->
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputEmail4">Município</label>
                    <!--value recebendo dados recuperados do while-->
                    <input type="text" class="form-control" value="<?php echo $nome_municipio; ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Prefeitura</label>
                    <input type="text" class="form-control" value="<?php echo $nome_prefeitura; ?>" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">Saae</label>
                    <input type="text" class="form-control" value="<?php echo $nome_saae; ?>" readonly>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputPassword4">CNPJ Saae</label>
                    <input type="text" class="form-control" id="cnpj" value="<?php echo $cnpj_saae; ?>" readonly>
                </div>
            </div>


            <!--linha02-->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Bairro</label>
                    <input type="text" class="form-control" name="bairro" value="<?php echo $nome_bairro_saae; ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4">Logradouro</label>
                    <input type="text" class="form-control" name="logradouro" placeholder="Logardouro" value="<?php echo $nome_logradouro_saae; ?>">
                </div>
                <div class="form-group col-md-1">
                    <label for="inputPassword4">N°</label>
                    <input type="text" class="form-control" name="numero" placeholder="N°" value="<?php echo $numero_imovel_saae; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputPassword4">Complemento</label>
                    <input type="text" class="form-control" name="complemento" value="<?php echo $complemento_endereco_saae; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputPassword4">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $cep_saae; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label for="inputPassword4">UF</label>
                    <input type="text" class="form-control" name="uf" value="<?php echo $uf_saae; ?>">
                </div>

            </div>

            <!--linha03-->
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputPassword4">Telefone</label>
                    <input type="text" class="form-control" id="fone" name="telefone" value="<?php echo $fone_saae; ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email_saae; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputPassword4">Site</label>
                    <input type="text" class="form-control" name="home_page" value="<?php echo $home_page_saae; ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4">Gestor</label>
                    <input type="text" class="form-control" name="gestor" value="<?php echo $nome_gestor_saae; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputPassword4">CPF do Gestor</label>
                    <input type="password" class="form-control" name="cpf_gestor" value="<?php echo $cpf_gestor_saae; ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4">Decreto N°</label>
                    <input type="text" class="form-control" name="decreto" value="<?php echo $numero_decreto_nomeacao; ?>">
                </div>

            </div>




            <div class="form-row">


                <div class="form-group col-md-6 mt-5">

                    <button name="salvar" type="submit" class="btn btn-primary">Salvar</button>

                </div>

        </form>


        <div class="form-group col-md-3">
            <label for="inputAddress">Logo SAAE</label>
            <div class="custom-file">
                <!--multipart/form-data é sempre utilizado para subir arquivos-->
                <form method="post" enctype="multipart/form-data">
                    <input type="file" class="custom-file-input" name="foto" id="foto">
                    <label class="custom-file-label" for="customFile">Escolher Foto</label>

            </div>
        </div>


        <div class="form-group col-md-1">
            <label for="inputAddress">Atualizar</label><br>

            <button type="submit" name="atualizar" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></button>

        </div>





        <div class="form-group col-md-2">

            <!--trazendo foto do bd pelo while conforme login realizado-->
            <img src="../img/parametros/<?php echo $foto; ?>" width="120">

        </div>
    </div>



    </form>


    </div>





    <?php
    //função para imagem de perfil, se existir faça
    if (isset($_POST['atualizar'])) {

        //carregando foto
        $caminho = '../img/parametros/' . $_FILES['foto']['name'];
        $nome = $_FILES['foto']['name'];
        $nome_temp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($nome_temp, $caminho);

        //redirecionando para atualizar a imagem
        echo "<script language='javascript'>window.location='admin.php?acao=parametros&img=$nome'; </script>";
    }

    ?>

    <?php
    //quando o post vier do botão salvar faça
    if (isset($_POST['salvar'])) {

        //nome vai receber oq vier do post do campo nome, nunca usar mesma variavel na mesma pagina
        $bairro      = $_POST['bairro'];
        $logradouro  = $_POST['logradouro'];
        $numero      = $_POST['numero'];
        $complemento = $_POST['complemento'];

        $cep         = $_POST['cep'];
        $cep = str_replace('-', '', $cep);

        $uf          = $_POST['uf'];

        $telefone    = $_POST['telefone'];
        $telefone = preg_replace("/[^0-9]/", "", $telefone);

        $email       = $_POST['email'];
        $home_page   = $_POST['home_page'];
        $gestor      = $_POST['gestor'];
        $cpf_gestor  = $_POST['cpf_gestor'];
        $decreto     = $_POST['decreto'];

        //atualização do perfil
        $query_user = "UPDATE perfil_saae SET nome_bairro_saae = '$bairro', nome_logradouro_saae = '$logradouro', numero_imovel_saae = '$numero', complemento_endereco_saae = '$complemento', cep_saae = '$cep', uf_saae = '$uf', uf_saae = '$uf', fone_saae = '$telefone', email_saae = '$email', home_page_saae = '$home_page', nome_gestor_saae = '$gestor', cpf_gestor_saae = '$cpf_gestor', numero_decreto_nomeacao = '$decreto', logo_orgao = '$foto' ";

        $result_user = mysqli_query($conexao, $query_user);

        if ($result_user == '') {
            echo "<script language='javascript'>window.alert('Erro ao editar dados, tente novamente mais tarde!!!'); </script>";
        } else {
            echo "<script language='javascript'>window.alert('Dados alterados com sucesso!!!'); </script>";
            //redirecionando para atualizar a imagem
            echo "<script language='javascript'>window.location='admin.php?acao=parametros'; </script>";
        }
    }

    ?>

    <!--fechamento do while -->
<?php } ?>

<!--MASCARAS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#fone').mask('(00) 0000-0000');
        $('#cpf').mask('000.000.000-00');
        $('#cnpj').mask('00.000.000/0000-00');
        $('#cep').mask('00000-000');
    });
</script>
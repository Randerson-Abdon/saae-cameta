<p class="titulo">
    Balcão Eletrônico</p>

<!-- area link uteis -->
<section class="bg-light page-section" id="cursos">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
            </div>
        </div>

        <div class="row">
            <!-- linha media com 3 paineis/ sm-6= em resolução menor  paineis -->

            <div class="col-md-4 col-sm-6 cursos-item">
                <!-- coluna -->
                <a class="cursos-link" data-toggle="modal" data-target=".bd-example-modal-sm">
                    <!-- imagem com efeito de add com icone de adicionar -->
                    <div class="cursos-hover">
                        <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/boleto.png" alt="">
                </a>
                <div class="cursos-caption">
                    <p class="text-muted">Emissão de 2ª via.</p>
                </div>
            </div>

            <!-- Modal cad acesso -->
            <div class="modal fade bd-example-modal-sm" style="z-index: 3;" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">

                                <h5 class="modal-title">Emissão de 2ª via.</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="resultado.php" target="_blank">

                                    <div class="form-group">
                                        <label for="fornecedor">Localidade</label>

                                        <select class="form-control mr-2" id="category" name="id_localidade" onchange=javascript:Atualizar(this.value); required>
                                            <option value="">---Escolha uma opção---</option>";
                                            <?php

                                            //monta dados do combo 1
                                            $sql = "SELECT DISTINCT nome_localidade,id_localidade FROM enderecamento_localidade";

                                            $resultado = @mysqli_query($conexao, $sql) or die("Problema na Consulta");

                                            while ($linha = mysqli_fetch_array($resultado)) {
                                                echo "<option value=" . $linha['id_localidade'] . ">" . $linha['nome_localidade'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_produto">Matrícula</label>
                                        <input type="text" class="form-control mr-2" name="uc" placeholder="Sua matrícula aqui" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_produto">CPF/CNPJ</label>
                                        <input type="text" class="form-control mr-2" name="numero_cpf_cnpj" id="numero_cpf_cnpj" placeholder="Seu CPF aqui" required>
                                    </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success mb-3" name="enviar">Consultar</button>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal CADASTRAR -->
            <div id="modalExemplo" class="modal fade" role="dialog" style="z-index: 3;">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title">Cadastrando Novo Acesso</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="">

                                <div class="form-group">
                                    <label for="fornecedor">Localidade</label>
                                    <select class="form-control mr-2" id="category" name="id_localidade" style="text-transform:uppercase;">

                                        <option value="01">Santa Izabel</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fornecedor">RG</label>
                                    <input type="text" class="form-control mr-2" name="rg" placeholder="RG" required>
                                </div>

                                <div class="form-group">
                                    <label for="id_produto">CPF</label>
                                    <input type="text" class="form-control mr-2" name="numero_cpf_cnpj" id="numero_cpf_cnpj" placeholder="CPF" required>
                                </div>

                                <div class="form-group">
                                    <label for="id_produto">E-mail</label>
                                    <input type="email" class="form-control mr-2" name="email_contato" placeholder="E-mail" required>
                                </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success mb-3" name="enviar">Enviar</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Função para gerar senhas aleatórias

             * @param integer $tamanho Tamanho da senha a ser gerada
             * @param boolean $maiusculas Se terá letras maiúsculas
             * @param boolean $numeros Se terá números
             * @param boolean $simbolos Se terá símbolos
             *
             * @return string A senha gerada
             */
            function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
            {
                $lmin = 'abcdefghijklmnopqrstuvwxyz';
                $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $num = '1234567890';
                $simb = '!@#$%*-';
                $retorno = '';
                $caracteres = '';

                $caracteres .= $lmin;
                if ($maiusculas) $caracteres .= $lmai;
                if ($numeros) $caracteres .= $num;
                if ($simbolos) $caracteres .= $simb;

                $len = strlen($caracteres);
                for ($n = 1; $n <= $tamanho; $n++) {
                    $rand = mt_rand(1, $len);
                    $retorno .= $caracteres[$rand - 1];
                }
                return $retorno;
            }

            ?>


            <!--CADASTRO ACESSO -->
            <?php
            if (isset($_POST['enviar'])) {
                $id_localidade = $_POST['id_localidade'];
                $rg = $_POST['rg'];
                $numero_cpf_cnpj_novo = $_POST['numero_cpf_cnpj'];
                $email_contato = $_POST['email_contato'];
                $senha = geraSenha(6, false, true);

                //tratamento para numero_cpf_cnpj
                $ncc = str_replace("/", "", $numero_cpf_cnpj_novo);
                $ncc2 = str_replace(".", "", $ncc);
                $ncc3 = str_replace("-", "", $ncc2);

                //$uc = str_pad($id_unidade_consumidora , 5 , '0' , STR_PAD_LEFT);

                //trazendo info unidade_consumidora
                $query_uc = "SELECT * from unidade_consumidora where numero_cpf_cnpj = '$ncc3' AND numero_rg = '$rg' ";
                $result_uc = mysqli_query($conexao, $query_uc);
                $row_uc = mysqli_fetch_array($result_uc);
                $nome_razao_social = $row_uc["nome_razao_social"];
                $numero_cpf_cnpj = $row_uc["numero_cpf_cnpj"];

                if ($numero_cpf_cnpj != $ncc3) {
                    echo "<script language='javascript'>window.alert('CPF INCORRETO, verifique o campo digitado ou procure um posto de atendimento mais proximo. Localize essas informações no menu FALE CONOSCO!!!'); </script>";
                    echo "<script> $('#modalExemplo').modal('show'); </script> ";
                    exit();
                }

                $query = "INSERT INTO acesso_seguro (id_localidade, numero_rg, numero_cpf_cnpj, email_contato, senha_provisoria) values ('$id_localidade', '$rg', '$ncc3', '$email_contato', '$senha')";
                $result = mysqli_query($conexao, $query);

                if ($result == '') {
                    echo "<script language='javascript'>window.alert('Erro ao cadastrar, verifique os dados informados ou tente novamente mais tarde!!!'); </script>";
                } else {
                    echo "<script language='javascript'>window.alert('Cadastro Iniciado com sucesso, verificar seu e-mail para dar continuídade!!!'); </script>";
                    echo "<script language='javascript'>window.location='http://datapremium.com.br/s-izabel/web/home/'; </script>";
                }
            }
            ?>

            <?php

            @$nome = $nome_razao_social;
            $email = 'Obrigado por iniciar o cadastro em nosso sistema, use o link abaixo e a senha provisória para finalizar seu cadastro ao acesso as funcionalidades de nosso SAAE.';
            @$senhap = $senha;
            @$mensagem = 'http://datapremium.com.br/s-izabel/web/home/index.php?func=edita&rg=' . $rg . '&cpf=' . $ncc3;
            $titulo = 'SAAE SANTA IZABEL';
            @$dest = $email_contato;

            $nome = utf8_decode($nome);
            $email = utf8_decode($email);
            $senha = utf8_decode('- Senha Provisória: ');
            $instrucoes = utf8_decode('- Instruções: ');

            // usando o PHP_EOL para quebrar a linha
            $dados = '- Pedido de cadastro ao Sr(a): ' . $nome . PHP_EOL . PHP_EOL . $instrucoes . $email . PHP_EOL . PHP_EOL . $senha . $senhap . PHP_EOL . PHP_EOL . '- Acesse aqui para continuar seu cadastro -> ' . $mensagem;



            @mail($dest, $titulo, $dados);

            ?>


            <!--EDITAR -->
            <?php
            if (@$_GET['func'] == 'edita') {
                $rg = $_GET['rg'];
                $numero_cpf_cnpj = $_GET['cpf'];

                $query = "select * from acesso_seguro where numero_rg = '$rg' AND numero_cpf_cnpj = '$numero_cpf_cnpj' ";
                $result = mysqli_query($conexao, $query);

                //trazendo info unidade_consumidora
                $query_uc = "SELECT * from unidade_consumidora where numero_cpf_cnpj = '$numero_cpf_cnpj' ";
                $result_uc = mysqli_query($conexao, $query_uc);
                $row_uc = mysqli_fetch_array($result_uc);
                $nome_razao_social = $row_uc["nome_razao_social"];


                while ($res = mysqli_fetch_array($result)) {
                    $email_contato = $res["email_contato"];
                    $senha_provisoria = $res["senha_provisoria"];

            ?>

                    <!-- Modal Editar -->
                    <div id="modalEditar" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">Continuando Cadastro de Acesso</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="">

                                        <div class="form-group">
                                            <label for="id_produto">Nome/ Razão Social</label>
                                            <input type="text" class="form-control mr-2" name="nome_razao_social" value="<?php echo $nome_razao_social ?>" placeholder="Nome" style="text-transform:uppercase;" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="id_produto">CPF/CNPJ</label>
                                            <input type="text" class="form-control mr-2" name="numero_cpf_cnpj" id="numero_cpf_cnpj" placeholder="CPF" id="cpf" value="<?php echo $numero_cpf_cnpj ?>" style="text-transform:uppercase;" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="id_produto">E-mail</label>
                                            <input type="email" class="form-control mr-2" name="usuario" placeholder="Usuário" value="<?php echo $email_contato ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="fornecedor">Celular</label>
                                            <input type="text" class="form-control mr-2" name="fone_movel" id="cel" placeholder="Celular" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="fornecedor">WhatsApp</label>
                                            <select class="form-control mr-2" id="category" name="fone_zap" style="text-transform:uppercase;">

                                                <option value="" <?php if ($fone_zap == '') { ?> selected <?php } ?>>SELECIONE</option>
                                                <option value="S" <?php if ($fone_zap == 'T') { ?> selected <?php } ?>>SIM</option>
                                                <option value="N" <?php if ($fone_zap == 'F') { ?> selected <?php } ?>>NÃO</option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="fornecedor">Tipo de contato preferencial</label>
                                            <select class="form-control mr-2" id="category" name="tipo_contato_preferencial" style="text-transform:uppercase;">

                                                <option value="" <?php if ($tipo_contato_preferencial == '') { ?> selected <?php } ?>>SELECIONE</option>
                                                <option value="1" <?php if ($tipo_contato_preferencial == '1') { ?> selected <?php } ?>>E-mail</option>
                                                <option value="2" <?php if ($tipo_contato_preferencial == '2') { ?> selected <?php } ?>>WhatsApp</option>
                                                <option value="3" <?php if ($tipo_contato_preferencial == '3') { ?> selected <?php } ?>>SMS</option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="fornecedor">Senha Provisória</label>
                                            <input type="text" class="form-control mr-2" name="senha_provisoria" placeholder="Senha Provisória" required>
                                            <span class="text-danger" style="font-size: 10pt;">*Enviada com e-mail de pedido de cadastro</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="fornecedor">Nova Senha</label>
                                            <input type="text" class="form-control mr-2" name="senha_acesso_permanente" placeholder="Nova Senha" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="fornecedor">Confirmar Nova Senha</label>
                                            <input type="text" class="form-control mr-2" name="senha_acesso_permanente2" placeholder="Confirmar" required>
                                        </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success mb-3 mr-3" name="editar">Concluir </button>
                                    <button type="button" class="btn btn-danger mb-3 mr-3" data-dismiss="modal">Cancelar </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


            <?php
                    if (isset($_POST['editar'])) {
                        $fone_movel = $_POST['fone_movel'];
                        $senha_provisoria = $_POST['senha_provisoria'];
                        $numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];
                        $senha_acesso_permanente = $_POST['senha_acesso_permanente'];
                        $senha_acesso_permanente2 = $_POST['senha_acesso_permanente2'];
                        $fone_zap = $_POST['fone_zap'];
                        $tipo_contato_preferencial = $_POST['tipo_contato_preferencial'];

                        //tratamento para numero_cpf_cnpj
                        $ncc = str_replace("/", "", $numero_cpf_cnpj);
                        $ncc2 = str_replace(".", "", $ncc);
                        $ncc3 = str_replace("-", "", $ncc2);

                        //tratamento para celular
                        $cel = preg_replace("/[^0-9]/", "", $fone_movel);

                        if ($senha_acesso_permanente != $senha_acesso_permanente2) {
                            echo "<script language='javascript'>window.alert('A confirmação da nova senha não confere!!!'); </script>";
                            echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
                            exit();
                        }

                        //VERIFICAR SE O CPF JÁ ESTÁ CADASTRADO
                        $query_verificar_cpf = "SELECT * from acesso_seguro where numero_cpf_cnpj = '$ncc3' AND senha_provisoria = '$senha_provisoria' ";
                        $result_verificar_cpf = mysqli_query($conexao, $query_verificar_cpf);
                        $row_verificar_usu = mysqli_num_rows($result_verificar_cpf);
                        if ($row_verificar_usu == 0) {
                            echo "<script language='javascript'>window.alert('Senha provisória incorreta, verifique no e-mail de pedido de cadastro!!!'); </script>";
                            echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
                            exit();
                        }


                        $query = "UPDATE acesso_seguro SET fone_movel = '$cel', senha_acesso_permanente = '$senha_acesso_permanente', data_senha_permanente = curDate(), tipo_contato_preferencial = '$tipo_contato_preferencial', fone_zap = '$fone_zap' where numero_cpf_cnpj = '$ncc3' ";

                        $result = mysqli_query($conexao, $query);


                        if ($result == '') {
                            echo "<script language='javascript'>window.alert('Erro ao finalizar, verifique os dados informados ou tente novamente mais tarde!!!!'); </script>";
                        } else {
                            echo "<script language='javascript'>window.alert(' Cadastro de acesso a 2ª via e área do cliente realizado Sucesso!!!'); </script>";
                            echo "<script language='javascript'>window.location='http://datapremium.com.br/s-izabel/web/home/'; </script>";
                        }
                    }
                }
            }

            ?>




            <div class="col-md-4 col-sm-6 cursos-item" style="z-index: 0;">
                <!-- coluna -->
                <a class="cursos-link" href="#">
                    <!-- imagem com efeito de add com icone de adicionar -->
                    <div class="cursos-hover">
                        <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/servico.jpg" alt="">
                </a>
                <div class="cursos-caption">

                    <p class="text-muted">Solicitação de serviços</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 cursos-item">
                <!-- coluna -->
                <a class="cursos-link" href="#contatos">
                    <!-- imagem com efeito de add com icone de adicionar -->
                    <div class="cursos-hover">
                        <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/contato.png" alt="">
                </a>
                <div class="cursos-caption">
                    <p class="text-muted">Fale Conosco</p>
                </div>
            </div>

        </div>


    </div>
</section>


<!-- AREA DE NOTICIAS -->
<p class="titulo">
    Últimas Notícias</p>

<!-- area link uteis -->
<section class="bg-light page-section" id="cursos">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
            </div>
        </div>

        <div class="row">
            <!-- linha media com 3 paineis/ sm-6= em resolução menor  paineis -->

            <div class="col-md-4 col-sm-6 cursos-item">
                <!-- coluna -->
                <a class="cursos-link" href="#">
                    <!-- imagem com efeito de add com icone de adicionar -->
                    <div class="cursos-hover">
                        <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/noticias/01.jpg" alt="">
                </a>
                <div class="cursos-caption">
                    <p class="text-muted">Nova sede operacional do SAAE irá sanar problemas</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 cursos-item">
                <!-- coluna -->
                <a class="cursos-link" href="#">
                    <!-- imagem com efeito de add com icone de adicionar -->
                    <div class="cursos-hover">
                        <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/noticias/02.jpg" alt="">
                </a>
                <div class="cursos-caption">

                    <p class="text-muted">SAAE manterá serviços emergenciais durante o feriado de carnaval</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 cursos-item">
                <!-- coluna -->
                <a class="cursos-link" href="#">
                    <!-- imagem com efeito de add com icone de adicionar -->
                    <div class="cursos-hover">
                        <div class="cursos-hover-content">
                            <i class="fas fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/noticias/03.jpg" alt="">
                </a>
                <div class="cursos-caption">
                    <p class="text-muted">Falta de energia interrompe o abastecimento</p>
                </div>
            </div>

        </div>


    </div>
</section>
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
                                <form method="POST" action="index.php?acao=consulta">

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
                                        <label for="id_produto">CPF/CNPJ</label>
                                        <input type="text" class="form-control mr-2" name="numero_cpf_cnpj" id="numero_cpf_cnpj" placeholder="Seu CPF aqui" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_produto">Senha</label>
                                        <input type="password" class="form-control mr-2" name="senha" required>
                                    </div>

                            </div>

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-success mb-3" name="enviar">Consultar </button>

                                <button type="button" class="btn btn-danger mb-3 ml-4" data-toggle="modal" data-target="#modalExemplo">Cadastre-se aqui. </button>


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
                                    <label for="fornecedor">Senha</label>
                                    <input type="text" class="form-control mr-2" name="senha" placeholder="Senha" required>
                                </div>

                                <div class="form-group">
                                    <label for="id_produto">CPF</label>
                                    <input type="text" class="form-control mr-2" name="numero_cpf_cnpj" id="numero_cpf_cnpj" placeholder="CPF" required>
                                </div>

                                <div class="form-group">
                                    <label for="id_produto">E-mail</label>
                                    <input type="email" class="form-control mr-2" name="email_contato" placeholder="E-mail" required>
                                </div>

                                <div class="form-group">
                                    <label for="id_produto">Celular (WhatsApp)</label>
                                    <input type="text" class="form-control mr-2" name="fone_movel" placeholder="Celular" id="cel" style="text-transform:uppercase;" required>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: 10pt;" class="text-danger" for="id_produto">Obs.: Escolha a baixo a forma para receber seu código de confirmação.</label>
                                </div>

                        </div>

                        <div class="modal-footer">

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <input style="font-size: 10pt;" type="button" class="btn btn-danger form-control" value="Receber WhatsApp" onclick="javascript:submitForm(this.form, './../../../api/api_zap.php');" />
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="button" class="btn btn-danger form-control" name="enviar" value="Receber E-mail" onclick="javascript:submitForm(this.form, 'processa.php');" />
                                </div>

                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <script type="text/javascript">
                //post alternativo
                function submitForm(form, action) {
                    form.action = action;
                    form.submit();
                }
            </script>



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
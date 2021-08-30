<?php

include_once('conexao.php');

$query_perfil = "SELECT * from perfil_saae";
$result_perfil = mysqli_query($conexao, $query_perfil);
$row_perfil = mysqli_fetch_array($result_perfil);
$nome_municipio           = $row_perfil["nome_municipio"];
$logo_orgao               = $row_perfil["logo_orgao"];
$email_saae               = $row_perfil["email_saae"];
$fone_saae                = $row_perfil["fone_saae"];
$nome_logradouro_saae     = $row_perfil["nome_logradouro_saae"];
$numero_imovel_saae       = $row_perfil["numero_imovel_saae"];
$nome_bairro_saae         = $row_perfil["nome_bairro_saae"];
$cep_saae                 = $row_perfil["cep_saae"];
$uf_saae                  = $row_perfil["uf_saae"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Saae Cameta">
<meta name="author" content="Randerson Abdon">
<meta name="keywords" content="saaecameta.net, saaecameta, cameta, cameta, saae, segunda via cameta, saae cameta">

<head>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-6J98H96C8H"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-6J98H96C8H');
  </script>

  <title>SAAENET - <?php echo $nome_municipio; ?></title>

  <link rel="stylesheet" type="text/css" href="../CSS/estilo.css" />
  <script type="text/javascript" src="../CSS/jquery/jquery-1.7.1.min.js"></script>
  <link rel="stylesheet" href="../CSS/banner/banner/themes/default/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../CSS/banner/banner/nivo-slider.css" type="text/css" media="screen" />

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- LINK DO BOOTSTRAP via cdn(navegador) -->


  <!-- LINK DO fontawesome via cdn(navegador) para icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">



  <div class="topo" style="margin-bottom: -6%;">
    <div class="row" style="width: 100%;">
      <div class="col-md-3">
        <a href="index.php">
          <img width="200" height="150" src="../../../img/parametros/<?php echo $logo_orgao; ?>" class="img-fluid" alt="Imagem responsiva">
      </div>
      <div class="col-md-3">
        <a href="index.php">
          <img width="200" height="150" src="../../../img/parametros/logo 02.jpeg" class="img-fluid" alt="Imagem responsiva">
      </div>
    </div>
  </div>
  <div class="menu borderRadius transitionALL">
    <ul>

      <li><a href="index.php">
          Serviço Autônomo de Água e Esgoto de <?php echo $nome_municipio; ?></a></li>

      <li><a href="index.php?acao=transparencia#meio">
          Transparência</a></li>

      <li><a data-toggle="modal" data-target="#modalExemplo3" href="#">
          Autenticação de Certidões</a></li>

      <li><a href="#contatos">
          Fale Conosco</a></li>

      <li><a href="../../../login.php" target="_blank">
          Área Administrativa</a></li>

    </ul>
  </div>
  <div class="contentOne" id="non-printable">
    <div class="banner theme-default borderRadius">
      <div id="slider" class="nivoSlider">

        <a href="#">
          <img src="../../upload/banner/banner%20site%201.png" width="1500px" /></a>

        <a href="3">
          <img src="../../upload/banner/banner_crianca.jpg" /></a>

      </div>
    </div>
    <script type="text/javascript" src="../CSS/banner/banner/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
      $(window).load(function() {
        $('#slider').nivoSlider();
      });
    </script>
  </div>
  <div class="content">
    <div class="menuLeft">
      <ul id="menuLeft">

        <li id="institucional"><a>
            Institucional</a>
          <div id="rptMain_pnlMain_0">

            <ul id="S13031413215753">

              <li><a href="index.php?acao=sobre#meio">
                  Sobre o SAAE
                </a>
              </li>

              <li><a href="index.php?acao=diretoria#meio">
                  Diretoria
                </a>
              </li>

              <li><a href="javascript:void(0);">
                  Setores
                </a>
                <div id="rptMain_rptSub_0_pnlSub_2">

                  <ul id="S13031508402753">

                    <li><a href="#">
                        Água e Esgoto
                      </a>

                    </li>

                    <li><a href="#">
                        Arrecadação e Pagamentos
                      </a>

                    </li>

                    <li><a href="#">
                        Assessoria Jurídica
                      </a>

                    </li>

                    <li><a href="#">
                        Assessoria Técnico Administrativa
                      </a>

                    </li>

                    <li><a href="#">
                        Cadastro e Protocolo
                      </a>

                    </li>

                    <li><a href="#">
                        Contabilidade e Planejamento
                      </a>

                    </li>

                    <li><a href="#">
                        Diretoria de Administração e Finanças
                      </a>

                    </li>

                    <li><a href="#">
                        Diretoria Técnica Operacional
                      </a>

                    </li>

                    <li><a href="#">
                        Recursos Humanos
                      </a>

                    </li>

                    <li><a href="#">
                        Recursos Materiais e Patrimônio
                      </a>

                    </li>

                    <li><a href="#">
                        Seção Operacional
                      </a>

                    </li>

                    <li><a href="#">
                        Superintendência
                      </a>

                    </li>

                  </ul>

                </div>
              </li>

              <li><a href="javascript:void(0);">
                  Unidades
                </a>
                <div id="rptMain_rptSub_0_pnlSub_3">

                  <ul id="W13031508401106">

                    <li><a href="#">
                        Escritório
                      </a>

                    </li>

                    <li><a href="#">
                        Captação de Água
                      </a>

                    </li>

                    <li><a href="#">
                        Estação de Tratamento de Água
                      </a>

                    </li>

                    <li><a href="#">
                        Estação de Tratamento de Esgoto
                      </a>

                    </li>

                  </ul>

                </div>
              </li>

            </ul>

          </div>
        </li>




        <li><a href="index.php?acao=servicos#meio">Serviços</a></li>

        <li id="LicitacoesPortal"><a>
            Licitações Em Andamento</a>
          <div id="rptLicitacoesPortal_pnlMain_0">

            <ul id="X13050212531423">

              <li><a href="javascript:void(0);">
                  2020
                </a>
                <div id="rptLicitacoesPortal_rptSub_0_pnlSub_0">

                  <ul id="S20011316192353">

                    <li><a href="javascript:void(0);">
                        Carta Convite
                      </a>
                      <div id="rptLicitacoesPortal_rptSub_0_rptSubSub_0_pnlSubSub_0">

                        <ul id="S20011316221453">

                          <li><a href="#">
                              Carta Convite 01/2020 - Aquisição de Grelhas de Ferro Fundido para galerias de águas pluviais
                            </a>

                          </li>

                          <li><a href="#">
                              Carta Convite 02/2020 - Aquisição de Tampões de Ferro Fundido Dúctil
                            </a>

                          </li>

                        </ul>

                      </div>
                    </li>

                    <li><a href="javascript:void(0);">
                        Pregão Presencial
                      </a>
                      <div id="rptLicitacoesPortal_rptSub_0_rptSubSub_0_pnlSubSub_1">

                        <ul id="S20011316201153">

                          <li><a href="#">
                              Pregão Presencial 01/2020 - Aquisição de refeições (marmitex) para plantonistas
                            </a>

                          </li>

                          <li><a href="#">
                              Pregão Presencial 02/2020 - Aquisição de Cloro Gás Liquefeito
                            </a>

                          </li>

                          <li><a href="#">
                              Pregão Presencial 03/2020 - Aquisição de Policloreto de Alumínio
                            </a>

                          </li>



                        </ul>

                      </div>
                    </li>

                  </ul>

                </div>
              </li>

            </ul>

          </div>
        </li>

        <li><a href="#">Licitações
            Encerradas</a></li>

        <li id="Legislacao"><a>
            Legislação</a>
          <div id="rptLegislacao_pnlMain_0">

            <ul id="Y13031116501436">

              <li><a href="#">
                  Instruções Normativas SAAE
                </a>

              </li>

              <li><a href="#">
                  Leis e Decretos Municipais
                </a>

              </li>

              <li><a href="#3">
                  Ministério da Saúde
                </a>

              </li>

              <li><a href="#">
                  Resolução ARES-PCJ
                </a>

              </li>

              <li><a href="#">
                  Tarifas
                </a>

              </li>

            </ul>

          </div>
        </li>


        <li><a href="index.php#meio">Emissão da 2ª Via</a></li>
        <li><a href="#">Tarifas</a></li>

        <li id="noticias"><a>
            Notícias</a>
          <div id="rptNoticias_pnlMain_0">

            <ul id="S13031116431253">

              <li><a href="#">
                  2018
                </a>

              </li>

              <li><a href="#">
                  2019
                </a>

              </li>

            </ul>

          </div>
        </li>


        <li id="GaleriaFoto"><a>
            Galeria de Fotos</a>

        </li>




        <li id="GaleriasExtras"><a>
            Plano de Saneamento Básico</a>
          <div id="rptGaleriasExtras_pnlMain_0">

            <ul id="S17092911532753">

              <li><a href="index.php?acao=plano01#meio">
                  Tratamento de Água
                </a>



            </ul>

          </div>
        </li>

        <li><a href="#">Links</a></li>
        <li><a href="#">Downloads</a></li>
        <li><a href="#">Dicas Úteis</a></li>
        <li><a href="#">Telefones Úteis</a></li>
        <li><a href="#">Fale Conosco</a></li>
        <li><a href="#">Localização</a></li>
      </ul>
      <script>
        $('#menuLeft li').click(function() {
          $(this).nextAll().find('ul').slideUp(300);
          $(this).prevAll().find('ul').slideUp(300);
          if ($(this).children().children().length > 0) {
            $(this).children().children().slideDown(300);
          }
        });
        //                               $(document).ready(function() {
        //                                    $('#menuLeft #qualidade').slideDown(400);
        //                                });		
      </script>
    </div>

    <div id="pop">
      <div class="close">
        fechar</div>
      <a id="ContentPlaceHolder1_HyperLink1"><img id="ContentPlaceHolder1_Image1" src="#" /></a>
    </div>



    <div class="meio" id="meio">

      <!-- sidebar-wrapper  -->
      <main class="page-content">

        <!--CARREGAMENTO DAS DEMAIS PÁGINAS DO PAINÉL -->
        <?php
        if (@$_GET['acao'] == 'diretoria') {
          include_once('view/diretoria.php');
        } elseif (@$_GET['acao'] == 'servicos') {
          include_once('view/servicos.php');
        } elseif (@$_GET['acao'] == 'sobre') {
          include_once('view/sobre.php');
        } elseif (@$_GET['acao'] == 'transparencia') {
          include_once('view/transparencia.php');
        } elseif (@$_GET['acao'] == 'plano01') {
          include_once('view/plano01.php');
        } else {
          include_once('view/home.php');
        }

        ?>


      </main>
      <!-- page-content" -->


    </div>

  </div>




  <!-- Contatos -->
  <!-- titulo e subtitulo -->
  <section class="page-section" id="contatos">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Contate-nos</h2>
          <h3 class="section-subheading text-muted text-primary">Em caso de dúvidas preencha abaixo!!</h3>
        </div>
      </div>
      <!-- linha com 12 -->
      <div class="row">
        <div class="col-lg-12">
          <form id="contactForm" method="post" action="contato.php">
            <!-- linha -->
            <div class="row">
              <!-- coluna -->
              <div class="col-md-6">
                <div class="form-group">
                  <!-- Caixa para nome obrigatoria, com mensagem -->
                  <input class="form-control" id="nome" name="nome" type="text" placeholder="Seu Nome *" required="required" data-validation-required-message="Fill in your name!!!">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <!-- Caixa para email obrigatoria, com mensagem -->
                  <input class="form-control" id="email" name="email" type="email" placeholder="Seu Email *" required="required" data-validation-required-message="Fill in your Email!!!">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <!-- Caixa para telefone não obrigatoria -->
                  <input class="form-control" id="telefone" name="fone" type="tel" placeholder="Seu Telefone">

                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <!-- Caixa para mensagem obrigatoria, com mensagem -->
                  <textarea class="form-control" id="mensagem" name="mensagem" placeholder="Sua Mensagem *" required="required" data-validation-required-message="Enter the Message !!!"></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-12 text-center" style="margin-bottom: 20px;">
                <div id="success"></div>
                <button id="" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar</button>
              </div>

            </div>

          </form>
        </div>
      </div>
    </div>
  </section>





  <!-- Rodapé -->
  <footer class="footer">
    <div class="container">
      <!-- linha -->
      <div class="row align-items-center">
        <!-- coluna -->
        <div class="col-md-4">
          <ul class="list-inline quicklinks">
            <!-- link para o zap -->
            <li class="list-inline-item">
              <span class="copyright"><i class="far fa-envelope mr-1"></i><?php echo $nome_logradouro_saae . ' N° ' . $numero_imovel_saae;  ?></span>
            </li>
            <li class="list-inline-item" style="margin-top: -20px;">
              <span class="copyright"><?php echo 'BAIRRO ' . $nome_bairro_saae . ', ' . $nome_municipio . '-' . $uf_saae;  ?></span>
            </li>
          </ul>
        </div>
        <!-- coluna link sociais -->
        <div class="col-md-4">
          <ul class="list-inline social-buttons">
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
          </ul>
        </div>
        <!-- coluna -->
        <div class="col-md-4">
          <ul class="list-inline quicklinks">
            <!-- link para o zap -->
            <li class="list-inline-item">
              <!-- com zap -->
              <a class="text-muted" href="http://api.whatsapp.com/send?1=pt_BR&phone=5591985389940" alt="(91) 98538-9940" target="_blank"><i class="fab fa-whatsapp mr-1"></i>(91) 98538-9940</a> ou <span class="copyright"><i class="fas fa-phone-alt"></i> (91) 3235-3973</span>

              <!-- sem zap -->
              <!-- SAAE Cametá - <span class="copyright"><i class="fas fa-phone-alt"></i> 91 3235-3973</span> -->
            </li>
            <li class="list-inline-item" style="margin-top: -20px;">
              <span class="copyright"><i class="far fa-envelope mr-1"></i>administrativo@bcinformatica-pa.com.br</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>






  <!-- Modal VALIDAÇÃO DE DOCUMENTOS -->
  <div id="modalExemplo3" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <form action="" method="POST">

            <h5 class="modal-title">Validação de Documento</h5>

        </div>
        <div class="modal-body">
          <form method="POST" action="">

            <div class="form-group">
              <label for="id_produto">Código Para Autenticação</label>
              <input type="text" class="form-control mr-2" name="valida" placeholder="Digite aqui" required>
            </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success mb-3" name="validar">Validar </button>


          <button type="button" class="btn btn-danger mb-3" data-dismiss="modal">Cancelar </button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <?php
  if (isset($_POST['validar'])) {
    $codigo_autenticacao = $_POST['valida'];

    //consulta declaracao_quitacao
    $query_num_dq = "SELECT * from declaracao_quitacao WHERE codigo_autenticacao = '$codigo_autenticacao' ";
    $result_num_dq = mysqli_query($conexao, $query_num_dq);
    $res_num_dq = mysqli_fetch_array($result_num_dq);
    @$uc            = $res_num_dq["id_unidade_consumidora"];
    @$id_localidade = $res_num_dq["id_localidade"];
    $linha = mysqli_num_rows($result_num_dq);

    if ($linha == 0) {
      echo "<script language='javascript'>window.location='index.php?acao=quitacao&func=invalida'; </script>";
    } else {
      echo "<script language='javascript'>window.location='index.php?acao=quitacao&func=valida&id=$uc&id_localidade=$id_localidade'; </script>";
    }
  }
  ?>


  <!--validação -->
  <?php
  if (@$_GET['func'] == 'valida') {
    $id         = $_GET['id'];
    $localidade = $_GET['id_localidade'];

    //executa o store procedure info consumidor
    $result_sp = mysqli_query(
      $conexao,
      "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
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
    //$id_unidade_hidrometrica  = $row_uc['id_unidade_hidrometrica'];
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

    <!-- Modal validação -->
    <div class="modal fade" id="modalExemplo4" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form method="POST" action="">

              <h5 class="modal-title text-center">VALIDADO COM SUCESSO</h5>
              <hr>
              <div class="row">

                <div class="form-group col-md-12" style="margin-left: 25%;">
                  <img width="50%" src="img/confirma.gif" alt="">
                </div>

                <div class="form-group col-md-12 text-center" style="color: #c40000; margin-top: -30px;">
                  <label for="id_produto"><b>Matrícula: </b></label>
                  <label for="id_produto"><?php echo $id ?></label>
                </div>

                <div class="form-group col-md-12 text-center" style="margin-top: -25px; color: #c40000;">
                  <label for="id_produto"><b>Nome: </b></label>
                  <label for="id_produto"><?php echo $nome_razao_social ?></label>
                </div>

              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

  <?php

  } ?>


  <!--validação -->
  <?php
  if (@$_GET['func'] == 'invalida') {


  ?>

    <!-- Modal validação -->
    <div class="modal fade" id="modalExemplo5" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form method="POST" action="">

              <h5 class="modal-title text-center">ERRO AO VALIDAR</h5>
              <hr>
              <div class="row">

                <div class="form-group col-md-12" style="margin-left: 25%;">
                  <img width="50%" src="img/atencao.gif" alt="">
                </div>

                <div class="form-group col-md-12 text-center" style="color: #c40000; margin-top: -30px;">
                  <label for="id_produto"><b>Dados do documento não encotrados!!!</b></label>
                  <label for="id_produto"><b>Por favor, ignorar este documento.</b></label>
                </div>

              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

  <?php

  } ?>







  </form>
  </body>

  <script>
    $("#modalEditar").modal("show");
  </script>

  <script>
    $("#modalExemplo4").modal("show");
  </script>

  <script>
    $("#modalExemplo5").modal("show");
  </script>

  <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
  <script>
    $("input[id*='numero_cpf_cnpj']").inputmask({
      mask: ['999.999.999-99', '99.999.999/9999-99'],
      keepStatic: true
    });
  </script>
  <script>
    $("input[id*='cel']").inputmask({
      mask: ['(99) 99999-9999'],
      keepStatic: true
    });
  </script>

</html>
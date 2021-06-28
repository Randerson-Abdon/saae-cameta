<?php
include_once('../conexao.php');
include_once('../verificar_autenticacao.php');
?>

<?php

if ($_SESSION['nivel_usuario'] != '3' && $_SESSION['nivel_usuario'] != '0') {
  header('Location: ../login.php');
  exit();
}

//$result_sp = mysqli_query(
//  $conexao,
//  "CALL sp_numero_registros('unidade_consumidora', '', '',@numero_registros);"
//) or die("Erro na query da procedure: " . mysqli_error($conexao));
//mysqli_next_result($conexao);
//@$row_uc = mysqli_fetch_array($result_sp);
//@$rg_uc        = $row_uc['numero_registros'];

//echo var_dump($rg_uc);


?>

<div class="content area_cards">
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-globe"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category"></p>
                <p class="card-title">16.000
                <p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            Total de Consumidores
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="far fa-money-bill-alt text-success"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category"></p>
                <p class="card-title">1.680,00
                <p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            Total Arrecadado do Dia
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-calendar-week text-info"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category"></p>
                <p class="card-title">23
                <p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            Serviços Pendentes
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fas fa-users text-primary"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category"></p>
                <p class="card-title">45
                <p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            Contas Vencidas
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
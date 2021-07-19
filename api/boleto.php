<?php

    /* $id             = $_GET['id'];
$mes_faturado   = $_GET['mes_faturado'];
$id_localidade  = $_GET['id_localidade'];
$vencimento     = $_GET['vencimento'];
$vencimento2    = $_GET['vencimento2'] */;

$id            = $_GET['uc'];
$mes_faturado  = $_GET['mesfaturado'];
$id_localidade = $_GET['idlocalidade'];
$vencimento2   = $_GET['vencimento'];

$vdata = explode("/", $vencimento2);
$vencimento = $vdata[2] . "-" . $vdata[1] . "-" . $vdata[0];


/* $id             = '00730';
$mes_faturado   = '2011/02';
$id_localidade  = '01';
$vencimento     = '2011-03-07';
$vencimento2    = '07/03/2011'; */


$dataFaturaBoleto = str_replace('/', '', $mes_faturado);

use Dompdf\Dompdf;

require_once '../dompdf/autoload.inc.php';

$dompdf = new Dompdf(["enable_remote" => true]);


ob_start();
require __DIR__ . "/boleto/boleto_cef.php";
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4", "portrait");

$dompdf->render();

$output = $dompdf->output();
file_put_contents("$id-$dataFaturaBoleto.pdf", $output);

/* $dompdf->stream(
    "relatorio.pdf", //nome
    array(
        "Attachment" => false //false visualiza e true faz download
    )
);
 */
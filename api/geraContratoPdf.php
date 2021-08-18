<?php

$id           = $_GET['uc'];
$totalDebito  = $_GET['total'];
$valorEntrada = $_GET['entrada'];
$parcelas     = $_GET['parcelas'];
$nParcelas    = $_GET['nParcelas'];


use Dompdf\Dompdf;

require_once '../dompdf/autoload.inc.php';

$dompdf = new Dompdf(["enable_remote" => true]);

$data = date('Y-m-d');
$dia = str_replace('-', '', $data);

ob_start();
require __DIR__ . "/usuarios/contratoPdf.php";
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4", "portrait");

$dompdf->render();

$output = $dompdf->output();
file_put_contents("$id-acordo-$dia.pdf", $output);

/* $dompdf->stream(
    "relatorio.pdf", //nome
    array(
        "Attachment" => false //false visualiza e true faz download
    )
);
 */

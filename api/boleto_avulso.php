<?php

$id             = $_GET['id'];
//$id_localidade = $_POST['id_localidade'];
$fatura         = $_GET['competencia'];
$dir              = '2';

$fatura = str_replace('[', '', $fatura);
$fatura = str_replace(']', '', $fatura);
$fatura = str_replace(' ', '', $fatura);

$fatura = explode(',', $fatura);


print_r($fatura);


use Dompdf\Dompdf;

require_once '../dompdf/autoload.inc.php';

$dompdf = new Dompdf(["enable_remote" => true]);

$data = date('Y-m-d');
$dia = str_replace('-', '', $data);

ob_start();
require __DIR__ . "/boleto/boleto_cef_avulso.php";
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4", "portrait");

$dompdf->render();

$output = $dompdf->output();
file_put_contents("$id-avulso-$dia.pdf", $output);

/* $dompdf->stream(
    "relatorio.pdf", //nome
    array(
        "Attachment" => false //false visualiza e true faz download
    )
);
 */

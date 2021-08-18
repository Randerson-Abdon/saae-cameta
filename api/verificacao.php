<?php
$teste = 0;
$nome = $_GET['nome'];
//$nome = '00730-avulso-20210803';

while ($teste == 0) {
    if (file_exists("$nome.pdf")) {
        $teste = 1;
        echo json_encode(array('code' => 1, 'message' => 'ok'));
    } else {
        $teste = 0;
    }
    //echo $teste . '<br>';
}

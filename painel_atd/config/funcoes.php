<?php
@session_start(); # Deve ser a primeira linha do arquivo
// função para formatar a data no formato correto para gravar no banco de dados


function formatarData($data)
{
    $rData = implode("-", array_reverse(explode("/", trim($data))));
    return $rData;
}

// função para exibir data no padrão brasileiro
function exibirData($data)
{
    $rData = explode("-", $data);
    $rData = $rData[2] . '/' . $rData[1] . '/' . $rData[0];
    return $rData;
}

// função para inserir data no padrão americano no bd
function insertData($data)
{
    $rData = explode("/", $data);
    $rData = $rData[1] . '/' . $rData[0];
    return $rData;
}
// função para inserir data no padrão americano no bd
function insertData2($data)
{
    $rData = explode("/", $data);
    $rData = $rData[2] . '-' . $rData[1] . '-' . $rData[0];
    return $rData;
}

// função para formatar o valor no formato correto para gravar no banco de dados
function formatarValor($valor)
{
    $valor = str_replace(".", "", $valor); // retira o ponto
    $valor = str_replace(",", ".", $valor); // substitui ,(vírgula) por .(ponto)
    return $valor;
}

// função para exibir o valor corretamente
function exibirValor($valor)
{
    return number_format($valor, 2, ",", ".");
}

// função para ajustar o dia
function diaFixo($ano, $mes)
{
    if (((fmod($ano, 4) == 0) and (fmod($ano, 100) != 0)) or (fmod($ano, 400) == 0)) {
        $dias_fevereiro = 29;
    } else {
        $dias_fevereiro = 28;
    }
    switch ($mes) {
        case 2:
            return $dias_fevereiro;
            break;
        default:
            // date("t") -- numero de dias de um dado mês
            // 28 a 31
            return date("t", strtotime(date("$ano-$mes-01")));
            break;
    }
}

// função para calcular a data de vencimento de cada parcela
function calcularVencimentoParcelas($dtVencimento, $nParcelas, $repete = "")
{

    if ($repete != "") {

        $data = formatarData($dtVencimento);

        for ($i = 1; $i <= $nParcelas; $i++) {
            $repeteDias = $i * $repete;
            $datas[$i] = exibirData(date('Y-m-d', strtotime("+$repeteDias days", strtotime($data))));
        }
    } else {
        $dataExplode = explode("/", $dtVencimento);
        $dia    = $dataExplode[0];
        if ($dia > 15) {
            $mes = $dataExplode[1];
        } else {
            $mes    = $dataExplode[1] - 1;
        }
        $ano    = $dataExplode[2];

        for ($i = 1; $i <= $nParcelas; $i++) {
            $mes = $mes + 1;
            if ($mes > 12) {
                $mes = 1;
                $ano = $ano + 1;
            }
            if ($mes == 2) {
                $diaFixo = diaFixo($ano, $mes);
                if ($dia >= $diaFixo) {
                    $diaVenc = $diaFixo;
                } else {
                    $diaVenc = $dia;
                }
            } else {
                $diaFixo    = diaFixo($ano, $mes);
                if ($dia >= $diaFixo)
                    $diaVenc = $diaFixo;
                else
                    $diaVenc = $dia;
            }
            $mes = str_pad($mes, 2, '0', STR_PAD_LEFT); // completar com zeros
            $data       = $mes . "/" . $ano;
            $datas[$i]  = $data;
        }
    }
    // return array
    return $datas;
}

// função para calcular a data de vencimento de cada parcela 2
function calcularVencimentoParcelas2($dtVencimento, $nParcelas, $repete = "")
{

    if ($repete != "") {

        $data = formatarData($dtVencimento);

        for ($i = 1; $i <= $nParcelas; $i++) {
            $repeteDias = $i * $repete;
            $datas[$i] = exibirData(date('Y-m-d', strtotime("+$repeteDias days", strtotime($data))));
        }
    } else {
        $dataExplode = explode("/", $dtVencimento);
        $dia    = $dataExplode[0];
        $mes    = $dataExplode[1];
        $ano    = $dataExplode[2];

        for ($i = 1; $i <= $nParcelas; $i++) {
            $mes = $mes + 1;
            if ($mes > 12) {
                $mes = 1;
                $ano = $ano + 1;
            }
            if ($mes == 2) {
                $diaFixo = diaFixo($ano, $mes);
                if ($dia >= $diaFixo) {
                    $diaVenc = $diaFixo;
                } else {
                    $diaVenc = $dia;
                }
            } else {
                $diaFixo    = diaFixo($ano, $mes);
                if ($dia >= $diaFixo)
                    $diaVenc = $diaFixo;
                else
                    $diaVenc = $dia;
            }
            $data       = $diaVenc . "/" . $mes . "/" . $ano;
            $datas[$i]  = $data;
        }
    }
    // return array
    return $datas;
}

// função para calcular o valor de cada parcela
function calcularValorParcelas($valorTotal, $valorEntrada = 0, $nParcelas)
{
    if ($valorEntrada > 0) {
        $valorTotal     = formatarValor($valorTotal);
        $valorEntrada    = formatarValor($valorEntrada);
        $valor_entrada     = $valorTotal - $valorEntrada;
        $valor             = round(($valor_entrada / $nParcelas), 2);
        $valor_total    = round($valor_entrada - ($valor * $nParcelas), 2);
        $_SESSION['valor'] = $valor;
        $_SESSION['valor_total'] = $valor_total;
        $_SESSION['nParcelas'] = $nParcelas;

        for ($i = 1; $i <= $nParcelas; $i++) {
            if ($i == $nParcelas) $valor = $valor + $valor_total;
            //echo "Parcelamento $i:  $valor<br/>";

        }
        return $valor;
    } else {
        $valorTotal     = formatarValor($valorTotal);
        $valor             = round(($valorTotal / $nParcelas), 2);
        $valor_total    = round($valorTotal - ($valor * $nParcelas), 2);

        $_SESSION['valor'] = $valor;
        $_SESSION['valor_total'] = $valor_total;
        $_SESSION['nParcelas'] = $nParcelas;

        for ($i = 1; $i <= $nParcelas; $i++) {
            if ($i == $nParcelas) $valor = $valor + $valor_total;
            //echo "Parcelamento $i:  $valor<br/>";

        }
        return $valor;
    }
}

// função para recalcular o valor de cada parcela
function recalcularValorParcelas($valorTotal, $valorEntrada = 0, $valoresParcelas, $nParcelas)
{
    $valorTotal     = formatarValor($valorTotal);
    $valorEntrada    = formatarValor($valorEntrada);
    $resultado       = $valorTotal - $valorEntrada;

    $aculumado      = 0;

    $novosValores   = array();

    $j = 1;
    for ($i = 0; $i < $nParcelas; $i++) {
        if ($i == $nParcelas - 1) {
            $valorAjustado      = $resultado - $aculumado;
            $novosValores[$j]   = exibirValor($valorAjustado);
        } else {
            $novosValores[$j]   = $valoresParcelas[$i];
            $aculumado         += formatarValor($valoresParcelas[$i]);
        }

        $j++;
    }
    // array
    return $novosValores;
}

// função para mostrar por extenso valor
function convert_number_to_words($number)
{

    $hyphen      = '-';
    $conjunction = ' e ';
    $conjunction_r = ' reais e ';
    $separator   = ', ';
    $negative    = 'menos ';
    $decimal     = ' reais ';
    $fim     = ' centavos';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'um',
        2                   => 'dois',
        3                   => 'três',
        4                   => 'quatro',
        5                   => 'cinco',
        6                   => 'seis',
        7                   => 'sete',
        8                   => 'oito',
        9                   => 'nove',
        10                  => 'dez',
        11                  => 'onze',
        12                  => 'doze',
        13                  => 'treze',
        14                  => 'quatorze',
        15                  => 'quinze',
        16                  => 'dezesseis',
        17                  => 'dezessete',
        18                  => 'dezoito',
        19                  => 'dezenove',
        20                  => 'vinte',
        30                  => 'trinta',
        40                  => 'quarenta',
        50                  => 'cinquenta',
        60                  => 'sessenta',
        70                  => 'setenta',
        80                  => 'oitenta',
        90                  => 'noventa',
        100                 => 'cento',
        200                 => 'duzentos',
        300                 => 'trezentos',
        400                 => 'quatrocentos',
        500                 => 'quinhentos',
        600                 => 'seiscentos',
        700                 => 'setecentos',
        800                 => 'oitocentos',
        900                 => 'novecentos',
        1000                => 'mil',
        1000000             => array('milhão', 'milhões'),
        1000000000          => array('bilhão', 'bilhões'),
        1000000000000       => array('trilhão', 'trilhões'),
        1000000000000000    => array('quatrilhão', 'quatrilhões'),
        1000000000000000000 => array('quinquilhão', 'quinquilhões')
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $conjunction . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = floor($number / 100) * 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            if ($baseUnit == 1000) {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[1000];
            } elseif ($numBaseUnits == 1) {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
            } else {
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
            }
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $fraction < 100 ? $conjunction_r : $separator;
        $string .= convert_number_to_words($fraction) . $fim;
    }

    return $string;
}



// função para mostrar por extenso valor inteiro
function convert_number_to_words_int($number)
{

    $hyphen      = '-';
    $conjunction = ' e ';
    $conjunction_r = ' reais e ';
    $separator   = ', ';
    $negative    = 'menos ';
    $decimal     = ' reais ';
    $fim     = ' centavos';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'um',
        2                   => 'dois',
        3                   => 'três',
        4                   => 'quatro',
        5                   => 'cinco',
        6                   => 'seis',
        7                   => 'sete',
        8                   => 'oito',
        9                   => 'nove',
        10                  => 'dez',
        11                  => 'onze',
        12                  => 'doze',
        13                  => 'treze',
        14                  => 'quatorze',
        15                  => 'quinze',
        16                  => 'dezesseis',
        17                  => 'dezessete',
        18                  => 'dezoito',
        19                  => 'dezenove',
        20                  => 'vinte',
        30                  => 'trinta',
        40                  => 'quarenta',
        50                  => 'cinquenta',
        60                  => 'sessenta',
        70                  => 'setenta',
        80                  => 'oitenta',
        90                  => 'noventa',
        100                 => 'cem reais',
        200                 => 'duzentos',
        300                 => 'trezentos',
        400                 => 'quatrocentos',
        500                 => 'quinhentos',
        600                 => 'seiscentos',
        700                 => 'setecentos',
        800                 => 'oitocentos',
        900                 => 'novecentos',
        1000                => 'mil',
        1000000             => array('milhão', 'milhões'),
        1000000000          => array('bilhão', 'bilhões'),
        1000000000000       => array('trilhão', 'trilhões'),
        1000000000000000    => array('quatrilhão', 'quatrilhões'),
        1000000000000000000 => array('quinquilhão', 'quinquilhões')
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words_int(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $conjunction . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = floor($number / 100) * 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words_int($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            if ($baseUnit == 1000) {
                $string = convert_number_to_words_int($numBaseUnits) . ' ' . $dictionary[1000];
            } elseif ($numBaseUnits == 1) {
                $string = convert_number_to_words_int($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
            } else {
                $string = convert_number_to_words_int($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
            }
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words_int($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $fraction < 100 ? $conjunction_r : $separator;
        $string .= convert_number_to_words_int($fraction) . $fim;
    }

    return $string;
}

<?php
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


include_once('../conexao.php');

$parcelas = str_replace('[', '', $parcelas);
$parcelas = str_replace(']', '', $parcelas);
$parcelas = str_replace(' ', '', $parcelas);

$parcelas = explode(',', $parcelas);

$parcelas[0] != $parcelas[intval($nParcelas) - 1] ? $parcelamento = (intval($nParcelas) - 1) . ' parcelas de R$ ' . number_format($parcelas[0], 2, ",", ".") . '<br>&nbsp&nbsp e 1 parcela de R$ ' . number_format($parcelas[intval($nParcelas) - 1], 2, ",", ".") : $parcelamento = $nParcelas . ' parcelas de R$ ' . number_format($parcelas[0], 2, ",", ".");


//consulta para recuperação do nome da localidade
$query_loc = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$id' ";
$result_loc = mysqli_query($conexao, $query_loc);
$row_loc = mysqli_fetch_array($result_loc);
$localidade = $row_loc['id_localidade'];

//echo $id . ', ' . $totalDebito . ', ' . $valorEntrada . ', ' . $nParcelas . ', ' . $parcelas . ', ' . $parcelamento . ', ' . $localidade . '<br>';

//$id = '00730';
//$localidade = '01';
//$totalDebito = '1.500,00';
$extenso = convert_number_to_words($totalDebito);
//$valorEntrada = '500,00';
//$parcelamento = '5 parcelas de R$ 200,00';

$result_sp = mysqli_query(
    $conexao,
    "CALL sp_seleciona_unidade_consumidora($localidade,$id);"
) or die("Erro na query da procedure 1: " . mysqli_error($conexao));
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



<!-- Modal Contrato de acordo -->


<p style="padding-left: 5%; padding-right: 5%; font-size: 10pt; text-align: justify;">
    <u><b>IDENTIFICAÇÃO DAS PARTES CONTRATANTES:</b></u><br><br>

    <b><u>DEVEDOR:</u></b><br>
    <span>NOME: <b><?php echo $nome_razao_social; ?></b></span><br>
    <span>CPF: <b><?php echo $numero_cpf_cnpj; ?></b></span><br>
    <span>U.C: <b><?php echo $id; ?></b></span><br>

    <span>BAIRRO: <b><?php echo $nome_bairro; ?></b></span><br>
    <span>LOGRADOURO: <b><?php echo $nome_logradouro; ?></b></span><br>
    <span>Nº: <b><?php echo $numero_logradouro; ?></b></span><br>
    <span>CEP: <b><?php echo $cep_logradouro; ?></b></span><br><br>

    <b><u>CREDOR:</u></b><br>
    <span>NOME: <b>SERVIÇO AUT. DE ÁGUA E ESGOTO DE SANTA IZABEL</b></span><br><br>

    As partes acima identificadas têm, entre sí, justo e acertado o presente <b>Contrato de Confissão e Parcelamento de Dívida</b>, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente.<br>

    <br><b><u>OBJETO DO CONTRATO</u></b>:<br><br>

    <u><b>Cláusula 1ª</b></u>: O <b>DEVEDOR</b> através do presente reconhece expressamente que possui uma dívida a ser paga diretamente ao <b>CREDOR</b> consubstanciada no montante total de: <span><b>R$ <?php echo number_format($totalDebito, 2, ",", "."); ?></b></span> (<?php echo $extenso; ?>). Devidamente discriminada no <b>EXTRATO DE DÉBITO</b> em anexo a este contrato, com a devida anuência do <b>DEVEDOR</b>.<br><br>

    <u><b>Cláusula 2ª</b></u>: O <b>DEVEDOR</b> confessa que é inadimplente da quantia supracitada e que ressarcirá a mesma nas condições previstas neste contrato.<br><br>

    <u><b>DO PARCELAMENTO, INTERRUPÇÃO DO FORNECIMENTO E PENALIDADES:</b></u><br><br>

    <u><b>Cláusula 3ª</b></u>: Em acordo firmado no escritório ou balcão eletrônico do: SERVIÇO AUT. DE ÁGUA E ESGOTO DE SANTA IZABEL fica acertado entre as partes o parcelamento total da dívida do cliente devedor que é de: <span><b>R$ <?php echo number_format($totalDebito, 2, ",", "."); ?></b></span> (<?php echo $extenso; ?>). Constituido de:<br>

    - ENTRADA: <b><span> <?php echo $valorEntrada; ?></span>, à vencer em: <span> <?php echo date("d/m/Y", time() + (3 * 86400)); ?></span>;</b><br>

    - PARCELAMENTO: <b><?php echo $parcelamento; ?>.</b>
</p>

<p style="padding-left: 5%; padding-right: 5%; font-size: 10pt; text-align: justify;">
    <b><u>PARÁGRAFO ÚNICO</u></b>:<br>

    Todas as parcelas acordadas neste instrumento serão acrescidas automaticamente nas faturas mensais do <b>DEVEDOR</b>, até que ocorra a total quitação do débito constante neste contrato.<br><br>
    <b><u>Cláusula 4ª</u></b>: <b>CASO HAJA DESCUMPRIMENTO</b> do acordo o fornecimento de água do devedor será interrompido, sendo normalizado somente após a quitação total da dívida.<br><br>

    <b><u>PARÁGRAFO ÚNICO</u></b>:<br>

    No caso de descumprimento do acordo firmado não será permitido ao devedor nova renegociação e seu fornecimento de água só será normalizado nos termos da <b>Cláusula 4ª</b> deste contrato.<br><br>
    <b><u>Cláusula 5ª</u></b>: O <b>DEVEDOR</b> pagará as faturas nos postos de arrecadação devidamente autorizados pelo SAAE, e nos termos acordados na <b>Cláusula 3ª</b>. Excluindo-se desse modo, qualquer outra forma de pagamento.<br><br>
    <b><u>Cláusula 6ª</u></b>: <b>EM CASO DE LIGAÇÃO CLANDESTINA</b> devidamente identificado por um funcionário do SAAE, designado para a fiscalização , fica o cliente ciente da aplicação de multa que varia de 1 (um) a 10 (dez) salários minimos vigentes no país. E na ocorrência de reincidência, aplicação de cobrança judicial e a inclusão do nome do <b>DEVEDOR</b> no sistema <b>SERASA</b>.<br><br>

    <b><u>PARÁGRAFO 1º</u></b>: Além das sansões previstas no Regulamento aprovado pelo Decreto Municipal nº 63 de 11/05/2012, fica o cliente ciente da pena no Art. 157 do Código Penal Brasileiro que diz: "Subtrair coisa móvel alheia, para sí ou para outrem, mediante grave ameaça ou violência a pessoa, ou depois de havê-la, por qualquer meio, de reduzido resistência".<br>
    PENA: Reclusão de 4 (quatro) a 10 (dez) anos, e multa.<br><br>
    <b><u>PARÁGRAFO 2º</u></b>: O Regulamento do SAAE, através do Decreto 63 de 11/05/2012 dá a esta Autarquia Municipal o pleno poder para aplicar as medidas necessárias estabecelidas neste contrato, inclusive no que tange a interrupção do fornecimento de água como prevê o Art. 72, incisos I, IV e VIII, atendendo o prazo estabelecido pelos incisos I e II do do parágrafo 1º do Art. 72.<br><br>
    <b><u>Cláusula 7ª</u></b>: FICA ELEITO O FORO DA COMARCA DE: S IZABEL para dirimir qualquer assunto referente ao presente contrato.

</p>
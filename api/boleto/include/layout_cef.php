<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>

<HEAD>
  <TITLE><?php echo $dadosboleto["identificacao"]; ?></TITLE>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <META http-equiv=Content-Type content=text/html charset=ISO-8859-1>
  <meta name='Generator' content='Randerson Abdon' />
  <style type=text/css>
    .cp {
      font: bold 10px Arial;
      color: black
    }

    .ti {
      font: 9px Arial, Helvetica, sans-serif
    }

    .ld {
      font: bold 15px Arial;
      color: #000000
    }

    .ct {
      FONT: 9px 'Arial Narrow';
      COLOR: #000033
    }

    .cn {
      FONT: 9px Arial;
      COLOR: black
    }

    .bc {
      font: bold 20px Arial;
      color: #000000
    }

    .ld2 {
      font: bold 12px Arial;
      color: #000000
    }
  </style>
</head>

<BODY text=#000000 bgColor=#ffffff topMargin=0 rightMargin=0>
  <table width=666 cellspacing=0 cellpadding=0 border=0>
    <tr>
      <td valign=top class=cp>
        <DIV ALIGN="left">Instruções de Impressão</DIV>
      </TD>
    </TR>
    <TR>
      <TD valign=top class=cp>
        <DIV ALIGN="left">
          <p>
            <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).<br>
            <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas é esquerda e à direita do formulário.<br>
            <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.<br>
            <li>Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela.
            <li>Caso tenha problemas ao imprimir, copie a sequencia numúrica abaixo e pague no caixa eletrônico ou no internet banking:<br><br>
              <span class="ld2">
                &nbsp;&nbsp;&nbsp;&nbsp;Linha Digitável: &nbsp;<?php echo $dadosboleto["linha_digitavel"]; ?><br>
                &nbsp;&nbsp;&nbsp;&nbsp;Valor: &nbsp;&nbsp;R$ <?php echo $dadosboleto["valor_boleto"]; ?><br>
              </span>
        </DIV>
      </td>
    </tr>
  </table><br>
  <table cellspacing=0 cellpadding=0 width=400 border=0>
    <TBODY>
      <TR>
        <TD class=ct width=400><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/6.png width=665 border=0></TD>
      </TR>
      <TR>
        <TD class=ct width=400>
          <div align=right><b class=cp>Recibo
              do Sacado</b></div>
        </TD>
      </tr>
    </tbody>
  </table>
  <table width=666 cellspacing=5 cellpadding=0 border=0>
    <tr>
      <td width=41></TD>
    </tr>
  </table>
  <table width=666 cellspacing=5 cellpadding=0 border=0 align=Default>
    <tr>
      <td width=41><IMG SRC='http://www.saaesantaizabel.com.br/lib/boleto/imagens/logo.png' alt='Logo'></td>
      <td class=ti width=455><?php echo $dadosboleto["identificacao"]; ?> <?php echo isset($dadosboleto["cpf_cnpj"]) ? "<br>" . $dadosboleto["cpf_cnpj"] : '' ?><br>
        <?php echo $dadosboleto["endereco"]; ?><br>
        <?php echo $dadosboleto["cidade_uf"]; ?><br>
      </td>
      <td align=RIGHT width=150 class=ti>&nbsp;</td>
    </tr>
  </table>
  <BR>
  <table cellspacing=0 cellpadding=0 width=600 border=0>
    <tr>
      <td class=cp width=100>
        <span class='campo'><IMG src='http://www.saaesantaizabel.com.br/lib/boleto/imagens/logo01.png' width='150' height='40' border=0></span>
      </td>
      <td width=3 valign=bottom><img height=22 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/3.png width=2 border=0></td>
      <td class=cpt width=0 valign=bottom></td>
      <td class=ld align=left width=300 valign=bottom><span class=ld>
          <span class='campotitulo'>
            <?php echo $dadosboleto["linha_digitavel"]; ?>
          </span></span></td>
    </tr>
    <tbody>
      <tr>
        <td colspan=5><img height=2 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=666 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=7 height=10>Cedente</td>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Agência/Código do Cedente</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=10 height=10>Espécie</td>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=20 height=10>Quantidade</td>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=50 height=10>Nosso
          número</td>
      </tr>
      <tr>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp align=left valign=top width=50 height=10>
          <span width=7><?php echo $dadosboleto["cedente"]; ?></span>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["agencia_codigo"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10><span class='campo'>
            <?php echo $dadosboleto["especie"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10><span class='campo'>
            <?php echo $dadosboleto["quantidade"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=left width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["nosso_numero"]; ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=310 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=156 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=34 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=9 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=53 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=66 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top colspan=3 height=10>número do documento</td>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>CPF/CNPJ</td>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Vencimento</td>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Valor documento</td>
      </tr>
      <tr>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top colspan=3 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["numero_documento"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["cpf_cnpj"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <span class='campo'>
            <?php echo ($data_venc != "") ? $dadosboleto["data_vencimento"] : "Contra Apresentação"; ?>
          </span>
        </td>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["valor_boleto"] ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=150 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=30 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=72 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=132 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=134 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=108 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=9>(-) Desconto / Abatimentos</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=9>(-) Outras deduções</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=9>(+) Mora / Multa</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=9>(+) Outros acréscimos</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=9>(=) Valor cobrado</td>
      </tr>
      <tr>
        <td class=cp valign=top width=0 height=0><img height=11 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=9></td>
        <td class=cp valign=top width=0 height=0><img height=11 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=9></td>
        <td class=cp valign=top width=0 height=0><img height=11 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=9></td>
        <td class=cp valign=top width=0 height=0><img height=11 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=9></td>
        <td class=cp valign=top width=0 height=0><img height=11 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=9></td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=113 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=112 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=113 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=113 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=180 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=659 height=10>Sacado</td>
      </tr>
      <tr>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=659 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["sacado"]; ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=656 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct width=0 height=12></td>
        <td class=ct width=430>Demonstrativo</td>
        <td class=ct width=0 height=12></td>
        <td class=ct width=0>Autenticação mecânica</td>
      </tr>
      <tr>
        <td width=7></td>
        <td class=cp width=0>
          <span class='campo'>
            <?php echo $dadosboleto["demonstrativo1"]; ?><br>
            <?php echo $dadosboleto["demonstrativo2"]; ?><br>
            <?php echo $dadosboleto["demonstrativo3"]; ?><br>
          </span>
        </td>
        <td width=0></td>
        <td width=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 width=666 border=0>
    <tbody>
      <tr>
        <td width=7></td>
        <td width=500 class=cp>
          <br><br><br>
        </td>
        <td width=159></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 width=0 border=0>
    <tr>
      <td class=ct width=0></td>
    </tr>
    <tbody>
      <tr>
        <td class=ct width=0>
          <div align=right><strong>VIA DO ARRECADADOR</strong></div>
        </td>
      </tr>
      <tr>
        <td class=ct width=0><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/6.png width=666 border=0></td>
      </tr>
    </tbody>
  </table><br>
  <table cellspacing=0 cellpadding=0 width=600 border=0>
    <tr>
      <td class=cp width=100>
        <span class='campo'><IMG src='http://www.saaesantaizabel.com.br/lib/boleto/imagens/logo01.png' width='150' height='40' border=0></span>
      </td>
      <td width=3 valign=bottom><img height=22 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/3.png width=2 border=0></td>
      <td class=cpt width=0 valign=bottom></td>
      <td class=ld align=left width=300 valign=bottom><span class=ld>
          <span class='campotitulo'>
            <?php echo $dadosboleto["linha_digitavel"]; ?>
          </span></span></td>
    </tr>
    <tbody>
      <tr>
        <td colspan=5><img height=2 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=666 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Local de pagamento</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Vencimento</td>
      </tr>
      <tr>
        <td class=cp valign=top width=0 height=12><img height=20 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=12>

          <span style='font-size: 6pt;'><?php echo $dadosboleto["bancos"]; ?></span>

        </td>
        <td class=cp valign=top width=0 height=12><img height=20 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=12>
          <span class='campo'>
            <?php echo ($data_venc != "") ? $dadosboleto["data_vencimento"] : "Contra Apresentação"; ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=472 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=177 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Cedente</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Agência/Código
          cedente</td>
      </tr>
      <tr>
        <td class=cp valign=top width=0 height=9><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=9>
          <span class='campo'>
            <?php echo $dadosboleto["cedente"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=0 height=9><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=9>
          <span class='campo'>
            <?php echo $dadosboleto["agencia_codigo"]; ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=472 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=177 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=0 height=10>
          <img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0>
        </td>
        <td class=ct valign=top width=0 height=10>Data do documento</td>
        <td class=ct valign=top width=0 height=10> <img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>N<u>o</u> documento</td>
        <td class=ct valign=top width=0 height=10> <img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Espécie doc.</td>
        <td class=ct valign=top width=0 height=10> <img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Aceite</td>
        <td class=ct valign=top width=0 height=10>
          <img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0>
        </td>
        <td class=ct valign=top width=0 height=10>Data processamento</td>
        <td class=ct valign=top width=0 height=10> <img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Nosso número</td>
      </tr>
      <tr>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <div align=left>
            <span class='campo'>
              <?php echo $dadosboleto["data_documento"]; ?>
            </span>
          </div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["numero_documento"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <div align=left><span class='campo'>
              <?php echo $dadosboleto["especie_doc"]; ?>
            </span>
          </div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <div align=left><span class='campo'>
              <?php echo $dadosboleto["aceite"] ?>
            </span>
          </div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10>
          <div align=left>
            <span class='campo'>
              <?php echo $dadosboleto["data_processamento"] ?>
            </span>
          </div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["nosso_numero"] ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=10 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=113 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=133 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=62 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=34 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=102 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=177 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top COLSPAN='3' height=10>Uso do banco</td>
        <td class=ct valign=top height=0 width=7><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Carteira</td>
        <td class=ct valign=top height=0 width=7><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Espécie</td>
        <td class=ct valign=top height=0 width=7><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Quantidade</td>
        <td class=ct valign=top height=0 width=7><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Valor Documento</td>
        <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>(=)Valor documento</td>
      </tr>
      <tr>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td valign=top class=cp height=0 COLSPAN='3'>
          <div align=left>
          </div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0>
          <div align=left> <span class='campo'>
              <?php echo $dadosboleto["carteira"]; ?>
            </span></div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0>
          <div align=left><span class='campo'>
              <?php echo $dadosboleto["especie"]; ?>
            </span>
          </div>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0><span class='campo'>
            <?php echo $dadosboleto["quantidade"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0>
          <span class='campo'>
            <?php echo $dadosboleto["valor_unitario"]; ?>
          </span>
        </td>
        <td class=cp valign=top width=0 height=10> <img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top align=right width=0 height=10>
          <span class='campo'>
            <?php echo $dadosboleto["valor_boleto"]; ?>
          </span>
        </td>
      </tr>
      <tr>
        <td valign=top width=0 height=1> <img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=75 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=20 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=31 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=83 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=43 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=9 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=103 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=9 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=102 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=155 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 width=0 border=0>
    <tbody>
      <tr>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0 align=left>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=1 border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td valign=top width=350 rowspan=5>
          <span class=ct>Instruções (Texto de responsabilidade do cedente)</span><br><br><span class=cp>
            <FONT class=campo>
              - <?php echo $dadosboleto["demonstrativo2"] ?><br>
              <?php echo $dadosboleto["instrucoes3"]; ?><br>
              <?php echo $dadosboleto["instrucoes4"]; ?></FONT><br><br>
          </span>
        </td>
        <td align=right width=188>
          <table cellspacing=0 cellpadding=0 border=0>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=ct valign=top width=0 height=10>(-) Desconto / Abatimentos</td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=cp valign=top align=right width=0 height=10></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=17 border=0></td>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=178 border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0 align=left>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=1 border=0>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=ct valign=top width=0 height=10>(-) Outras deduções</td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10> <img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=cp valign=top align=right width=0 height=10></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=17 border=0></td>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=178 border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0 align=left>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0>
                </td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=1 border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=ct valign=top width=0 height=10>(+) Mora / Multa</td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=cp valign=top align=right width=0 height=10></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1> <img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=17 border=0></td>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=178 border=0>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0 align=left>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=0><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=ct valign=top width=0 height=10>(+) Outros acréscimos</td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=cp valign=top align=right width=0 height=10></td>
              </tr>
              <tr>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=17 border=0></td>
                <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=178 border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0 align=left>
            <tbody>
              <tr>
                <td class=ct valign=top width=0 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=5><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td align=right width=0>
          <table cellspacing=0 cellpadding=0 border=0>
            <tbody>
              <tr>
                <td class=ct valign=top width=13 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=ct valign=top width=0 height=10>(=) Valor cobrado</td>
              </tr>
              <tr>
                <td class=cp valign=top width=0 height=5><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
                <td class=cp valign=top align=right width=0 height=10></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 width=0 border=0>
    <tbody>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=666 border=0></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=ct valign=top width=659 height=10>Sacado</td>
      </tr>
      <tr>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=659 height=10><span class='campo'>
            <?php echo $dadosboleto["sacado"]; ?>
          </span>
        </td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=cp valign=top width=7 height=10><img height=12 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=0 height=10><span class='campo'>
            <?php echo $dadosboleto["endereco1"]; ?>
          </span>
        </td>
      </tr>
    </tbody>
  </table>
  <table cellspacing=0 cellpadding=0 border=0>
    <tbody>
      <tr>
        <td class=ct valign=top width=7 height=10><img height=13 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png width=1 border=0></td>
        <td class=cp valign=top width=7 height=10><span class='campo'>
            <?php echo $dadosboleto["endereco2"]; ?>
          </span>
        </td>
        <td class=ct valign=top width=0 height=10><img height=13 src='http://www.saaesantaizabel.com.br/lib/boleto/imagens/1.png' width=1 border=0></td>
        <td class=ct valign=top width=0 height=10>Céd.baixa</td>
      </tr>
      <tr>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=8 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=461 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=7 border=0></td>
        <td valign=top width=0 height=1><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/2.png width=192 border=0></td>
      </tr>
    </tbody>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 border=0 width=0>
    <TBODY>
      <TR>
        <TD class=ct width=0 height=12></TD>
        <TD class=ct width=359>Sacador/Avalista</TD>
        <TD class=ct width=0>
          <div align=right>Autenticação mecânica - <b class=cp>Ficha de Compensação</b></div>
        </TD>
      </TR>
      <TR>
        <TD class=ct colspan=3></TD>
      </tr>
    </tbody>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width=666 border=0>
    <TBODY>
      <TR>
        <TD vAlign=bottom align=left height=50><?php echo $dadosboleto["desenho_barras"]->desenhaBarras() ?>
        </TD>
      </tr>
    </tbody>
  </table>
  <TABLE cellSpacing=0 cellPadding=0 width=666 border=0>
    <TR>
      <TD class=ct width=666></TD>
    </TR>
    <TBODY>
      <TR>
        <TD class=ct width=666>
          <div align=right><strong>VIA DO CLIENTE</strong></div>
        </TD>
      </TR>
      <TR>
        <TD class=ct width=666><img height=1 src=http://www.saaesantaizabel.com.br/lib/boleto/imagens/6.png width=670 border=0></TD>
      </tr>
    </tbody>
  </table>
</BODY>

</HTML>
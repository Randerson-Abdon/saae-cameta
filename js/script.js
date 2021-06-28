
//FUNÇÃO MODAL VISUALIZAR E EDITAR ENDEREÇO
var req2;

function loadXMLDoc01(url,valor)
{
    req2 = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req2 = new XMLHttpRequest();
        req2.onreadystatechange = processReqChange01;
        req2.open("GET", url+'?localidade='+valor, true);
        req2.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req2 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req2) {
            req2.onreadystatechange = processReqChange01;
            req2.open("GET", url+'?localidade='+valor, true);
            req2.send();
        }
    }
}

function loadXMLDoc02(url,valor,valor2)
{
    req2 = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req2 = new XMLHttpRequest();
        req2.onreadystatechange = processReqChange02;
        req2.open("GET", url+'?localidade='+valor2+'&bairro='+valor, true);
        req2.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req2 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req2) {
            req2.onreadystatechange = processReqChange02;
            req2.open("GET", url+'?localidade='+valor2+'&bairro='+valor, true);
            req2.send();
        }
    }
}

function processReqChange01()
{
    // apenas quando o estado for "completado"
    if (req2.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req2.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('atualiza0').innerHTML = req2.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req2.statusText);
        }
    }
}


function processReqChange02()
{
    // apenas quando o estado for "completado"
    if (req2.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req2.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('atualiza02').innerHTML = req2.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req2.statusText);
        }
    }
}

function Atualizar01(valor)
{
    loadXMLDoc01("atualiza0.php",valor);
}


function Atualizar02(valor,valor2)
{
    loadXMLDoc02("atualiza02.php",valor,valor2);
}



var req;

function loadXMLDoc(url,valor)
{
    req = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("GET", url+'?localidade='+valor, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url+'?localidade='+valor, true);
            req.send();
        }
    }
}

function loadXMLDoc2(url,valor,valor2)
{
    req = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange2;
        req.open("GET", url+'?localidade='+valor2+'&bairro='+valor, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange2;
            req.open("GET", url+'?localidade='+valor2+'&bairro='+valor, true);
            req.send();
        }
    }
}

function processReqChange()
{
    // apenas quando o estado for "completado"
    if (req.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('atualiza').innerHTML = req.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req.statusText);
        }
    }
}


function processReqChange2()
{
    // apenas quando o estado for "completado"
    if (req.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('atualiza2').innerHTML = req.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req.statusText);
        }
    }
}

function Atualizar(valor)
{
    loadXMLDoc("atualiza.php",valor);
}


function Atualizar2(valor,valor2)
{
    loadXMLDoc2("atualiza2.php",valor,valor2);
}




//FUNÇÃO MODAL VISUALIZAR E EDITAR ENDEREÇO
var req2;

function loadXMLDoc01(url,valor)
{
    req2 = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req2 = new XMLHttpRequest();
        req2.onreadystatechange = processReqChange01;
        req2.open("GET", url+'?localidade='+valor, true);
        req2.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req2 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req2) {
            req2.onreadystatechange = processReqChange01;
            req2.open("GET", url+'?localidade='+valor, true);
            req2.send();
        }
    }
}

function loadXMLDoc02(url,valor,valor2)
{
    req2 = null;
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req2 = new XMLHttpRequest();
        req2.onreadystatechange = processReqChange02;
        req2.open("GET", url+'?localidade='+valor2+'&bairro='+valor, true);
        req2.send(null);
    // Procura por uma versao ActiveX (IE)
    } else if (window.ActiveXObject) {
        req2 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req2) {
            req2.onreadystatechange = processReqChange02;
            req2.open("GET", url+'?localidade='+valor2+'&bairro='+valor, true);
            req2.send();
        }
    }
}

function processReqChange01()
{
    // apenas quando o estado for "completado"
    if (req2.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req2.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('atualiza0').innerHTML = req2.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req2.statusText);
        }
    }
}


function processReqChange02()
{
    // apenas quando o estado for "completado"
    if (req2.readyState == 4) {
        // apenas se o servidor retornar "OK"
        if (req2.status == 200) {
            // procura pela div id="atualiza" e insere o conteudo
            // retornado nela, como texto HTML
            document.getElementById('atualiza02').innerHTML = req2.responseText;
        } else {
            alert("Houve um problema ao obter os dados:\n" + req2.statusText);
        }
    }
}

function Atualizar01(valor)
{
    loadXMLDoc01("atualiza0.php",valor);
}


function Atualizar02(valor,valor2)
{
    loadXMLDoc02("atualiza02.php",valor,valor2);
}

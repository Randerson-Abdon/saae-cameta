$(function($){

    $("#parcelas").change(function(){
        //
        $("#resultado").css({"color":'#000'});

        var parcela = $("option:selected", this).val();
        var valorTotal = $("#valorTotal").val();
        if(parcela > 0 && valorTotal != ""){
            geraParcelas();
        }else if(parcela == 0){
            $("#resultado").css({"color":'#ff0000'}).html("Selecione uma parcela para o cálculo");
        }else{
            $("#resultado").css({"color":'#ff0000'}).html("Informe um valor para o cálculo");
        }
    });

    $("#data, #valorTotal, #valorEntrada").on("keyup change", function(){
        //
        $("#resultado").css({"color":'#000'});

        var valorTotal   = $("#valorTotal").val();
        var parcela = $("#parcelas option:selected").val();
        if (valorTotal != "0,00" && parcela > 0)
            geraParcelas();
        else if (valorTotal == "0,00" || valorTotal == ""){
            $("#resultado").css({"color":'#ff0000'}).html("Informe um valor para o cálculo99");
        }else
            $("#resultado").css({"color":'#ff0000'}).html("Selecione uma parcela para o cálculo");
    });

    function geraParcelas(){
        var acao		    = "gerarParcelas";
        var parcela		    = $("#parcelas option:selected").val();
        var valorTotal		= $("#valorTotal").val();
        var valorEntrada    = $("#valorEntrada").val();
        var data		    = $("#data").val();
        $.ajax({
            type: "POST",
            url: "acoes.php",
            data: { 'acao':acao, 'parcela':parcela, 'valorTotal': valorTotal, 'valorEntrada': valorEntrada, 'data': data },
            beforeSend: function () {
                $("#resultado").html("processando...");
            }
        }).done(function( msg ) {
            $("#resultado").html(msg);

            // aplica máscara
            $('.vlrParcela').mask('000.000.000,00', {reverse: true});

            // blur - recalcula
            $("table").on("blur", "input", function () {
                recalculaParcelas();
            });

        });
    }

    function recalculaParcelas(){
        var acao		    = "recalcularParcelas";
        var parcela		    = $("#parcelas option:selected").val();
        var valorTotal		    = $("#valorTotal").val();
        var valorEntrada    = $("#valorEntrada").val();
        var data		    = $("#data").val();

        var valoresParcelas = new Array();

        $(".vlrParcela").each(function(){
            valoresParcelas.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: "acoes.php",
            data: { 'acao':acao, 'parcela':parcela, 'valorTotal': valorTotal, 'valorEntrada': valorEntrada, 'data': data, 'valoresParcelas' : valoresParcelas },
            beforeSend: function () {
                $("#resultado").html("processando...");
            }
        }).done(function( msg ) {
            $("#resultado").html(msg);

            $(".vlrParcela").mask('000.000.000,00', {reverse: true});
            $("table").on("blur", "input", function () {
                recalculaParcelas();
            });
        });
    }

    // aplicando máscara
    $("#valorTotal, #valorEntrada").mask('000.000.000,00', {reverse: true});

    // submit do form
    $('form').on('submit', function(){
        var formdata = $("#form").serialize();
        $.ajax({
            type: "POST",
            url: "acoes.php",
            data: formdata+'&acao=enviarDados'
        }).done(function( data ) {
            $("#resultado").html(data);
        });
        return false;
    });

});
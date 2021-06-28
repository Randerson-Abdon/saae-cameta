$(document).ready(function(){
    //Chama o evento após selecionar um valor
    $('#slBuscar').on('change', function() {
        //Verifica se o valor é igual a cpf mostra a divCnpj
      if ( this.value == 'cpf')
      {
            $("#nome").hide();
            $("#dados2").hide();
            $("#dados3").hide();
            $("#dados4").hide();
            $("#uc").hide();
            $("#endereco").hide();
        $("#cpfcnpjd").show();
        $("#dados").show();

      }
        //Se o tempo for mé igual a nome mostra a divCpf
      else if( this.value == 'nome')
      {
          $("#cpfcnpjd").hide();
          $("#dados").hide();
          $("#dados3").hide();
          $("#dados4").hide();
          $("#uc").hide();
          $("#endereco").hide();
        $("#nome").show();
        $("#dados2").show();
      }
        //Se o tempo for mé igual a uc mostra a divCpf
        else if( this.value == 'uc')
        {
            $("#cpfcnpjd").hide();
            $("#dados4").hide();
            $("#dados2").hide();
            $("#dados").hide();
            $("#nome").hide();
            $("#endereco").hide();
          $("#uc").show();
          $("#dados3").show();
        }
        //Se o tempo for mé igual a endereco mostra a divCpf
        else if( this.value == 'endereco')
        {
            $("#cpfcnpjd").hide();
            $("#dados3").hide();
            $("#dados2").hide();
            $("#dados").hide();
            $("#nome").hide();
            $("#uc").hide();
          $("#endereco").show();
          $("#dados4").show();
        }
        //Se não for nem 1 nem 2 esconde as duas
        else{
             $("#cpfcnpjd").hide();
             $("#dados4").hide();
             $("#dados3").hide();
             $("#dados2").hide();
             $("#dados").hide();
              $("#nome").hide();
              $("#uc").hide();
              $("#endereco").hide();
        }
    });
});



$(document).ready(function(){
  //Chama o evento após selecionar um valor
  $('#tipo_enderecamento').on('change', function() {
      //Verifica se o valor é igual a L
    if ( this.value == 'L')
    {
      $("#externa").hide();
      $("#local").show();

    }
      //Se o tempo for mé igual a E
    else if( this.value == 'E')
    {
      $("#local").hide();
      $("#externa").show();

    }
      //Se não for nem L nem E esconde as duas
      else{
           $("#local").hide();
           $("#externa").hide();
      }
           
  });
});



$(document).ready(function(){
  //Chama o evento após selecionar um valor
  $('#tipo_enderecamento_e').on('change', function() {
      //Verifica se o valor é igual a L
    if ( this.value == 'L')
    {
      $("#externa_e").hide();
      $("#local_e").show();

    }
      //Se o tempo for mé igual a E
    else if( this.value == 'E')
    {
      $("#local_e").hide();
      $("#externa_e").show();

    }
      //Se não for nem L nem E esconde as duas
      else{
           $("#local_e").hide();
           $("#externa_e").hide();
      }
           
  });
});






function buscar(){
    alert('funcuisfsdsa');
    var parametros = {
                "valorCaja1" : 'nada'
        };
        $.ajax({
                data:  parametros,
                url:   'http://localhost/www/kohisekai/masticapp/busqueda/buscar',
                type:  'post',
                beforeSend: function () {
                        //$("#resultado").html("Procesando, espere por favor...");
                        alert('algo paso');
                },
                success:  function (response) {
                        //$("#resultado").html(response);
                        alert('funcione');
                },
                fail: function (){
                    alert('Fallo!');
                }
        });

}

<?
$datos = json_encode($basedatos);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Obtenedor de direcciones</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
                inicio();
                $('#progress').hide();
            });

            function sleep(ms) {
              return new Promise(resolve => setTimeout(resolve, ms));
            }

            function inicio(){
                ultimo = <?= $ultimo;?>;
                $("#ultimo").html("<p>Ultimo marcardor = "+ultimo+"</p>");
            }
         </script>
        <script type="application/javascript">
           async function localizar(){
               var TOTAL = <?= $totalDB; ?>;
               var ULTIMO = <?= $ultimo; ?>;
               $('#progress').show();
                for(i=ULTIMO;i<TOTAL;i++){
                    locales = <?= $datos?>;
                    var id = locales[i]['ml_id'];
                    var calle = locales[i]['ml_calle'];
                    v = i+1;
                    $("#estado").html("Cargando registro "+v+" ");

                    var direccion = $("<div id='local'"+i+">id: "+id+" - "+calle+"</div>");
                    var divlat = $("<div id='lat"+i+"'>Latitud: </div>");
                    var divlng = $("<div id='lng"+i+"'>Longitud: </div>");
                    var estado = $("<div id='stat"+i+"'></div>");
                    var direccion_format = $("<div id='for_det"+i+"'></div>");
                    var br = $("<br>");
                    $("#datos").append(direccion,divlat,divlng,direccion_format,estado,br);

                    //peticion de geolocalizacion
                    $.ajax({
                        url: "https://maps.googleapis.com/maps/api/geocode/json?address="+calle+"&key=AIzaSyDjc1jrRTTOiJkuuxqOFiWl7-p7WJy84pI&language=es&region=CL",
                        dataType:"json"
                    }).done(function(result) {
                        if(result.status != "OK"){
                            $('#stat'+i).append(result.status);
                            $('#estado').append(result.status);
                        }
                        else{
                            $('#stat'+i).append(result.status);
                            $('#lat'+i).append(result.results[0].geometry.location.lat);
                            $('#lng'+i).append(result.results[0].geometry.location.lng);
                            $('#for_det'+i).append(result.results[0].formatted_address);
                            $('#estado').append(result.status);

                            //carga en la base de datos marcadores
                            $.ajax({
                                url:"<?= base_url('mapa2/ingresar/')?>",
                                type:"POST",
                                data:{id:id,
                                      direccion:calle,
                                      lat:result.results[0].geometry.location.lat,
                                      lng:result.results[0].geometry.location.lng,
                                     },
                                success:function(respuesta){

                                    if(respuesta == true){
                                        $('#estado').append(" Subiendo ");
                                        console.log("Agregado id = "+id);
                                    }
                                    else{
                                        $('#estado').append(" Ya existe.");
                                        console.log("ya existe id = "+id);
                                    }

                                    console.log(respuesta);
                                },
                                fail:function(respuesta){
                                    $('#estado').append(" Error");
                                    console.log(respuesta);
                                }
                            });
                        }

                    });

                    await sleep(1000);
                }
            total = i;
            $("#datos").append("total de registros afectados = "+total);
            $('#estado').html("<p>Finalizado, total de registros afectados = "+total+"</p>");
            $('#progress').hide();
            }

       </script>
    </head>
    <body>
        <div class="container">
            <div id='control'>
                <div id="ultimo"></div>
                <button onclick="localizar()">Iniciar</button>
            </div>
            <div id="estado" class="l-10">
            </div>
            <div id="progress">
                <img style="width:20%;" src="assets/img/kirby.gif"/>
            </div>
            <div id="datos" class="col l-10"></div>
        </div>
    </body>

</html>

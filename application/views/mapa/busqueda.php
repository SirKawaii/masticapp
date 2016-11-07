<script>
    $(document).ready(function(valor){
        $(".input_box").on("input", function(){
            buscar();
        });

        $(".boton").on("click", function(){
           buscar();
        });

        $(".input_box").keypress(function(e) {
            if(e.which == 13) {
            // Acciones a realizar, por ej: enviar formulario.
            buscar();
            return false;
            }
        });

    });

    function buscar(){
            valor = document.getElementById('local').value;
            $.ajax({
                url:"<?= base_url('busqueda/user_data_submit')?>" ,
                type:"POST",
                data:{buscar:valor},
                success:function(respuesta){
                    console.log(respuesta);
                    var registros = eval(respuesta);
                    html="";
                    html= "<table class='centered striped highlight'><thead><tr>";
                    html += "<th data-field='nombre'>Nombre</th>";
                    html += "</th></thead>";
                    html += "<tbody>";
                    for(var i = 0;i<registros.length; i++){
                        html += "<tr>";
                        html += "<td>"+registros[i]["ml_nombre_local"]+"</td>"
                        html += "</tr>";
                    }

                    html +="</tbody></table>";
                    $('#resultado_busqueda').html(html);
                }
            });
        }
</script>

<body>
<div id="container" class="col l4">
    <?
echo form_open();
// Parametros
echo form_label('Busqueda');
$in_busqueda = array(
'name' => 'local',
'class' => 'input_box',
'placeholder' => 'Buscar',
'id' => 'local'
);
echo form_input($in_busqueda);
echo form_close();
?>
<a class="waves-effect waves-light btn boton">Apretame</a>
    <div id="resultado_busqueda">

    </div>
</div>
</body>

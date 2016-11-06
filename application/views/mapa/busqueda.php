<script>/*
    $(document).ready(function(){
        $(".boton").on("click", function(){
            alert(document.getElementById('local').value);
            var j_busqueda = "un texto simple";
            $.get("<?= base_url('busqueda/user_data_submit')?>/"+j_busqueda,"",function(data){
                console.log(data);
                $('#resultado_busqueda').html(data);
            });
        });
    });
    */
    $(document).ready(function(valor){
        $(".boton").on("click", function(){
            valor = document.getElementById('local').value;
            $.ajax({
                url:"<?= base_url('busqueda/user_data_submit')?>" ,
                type:"POST",
                data:{buscar:valor},
                success:function(respuesta){
                    alert(respuesta);
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
        });
    });
</script>

<body>
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
</body>

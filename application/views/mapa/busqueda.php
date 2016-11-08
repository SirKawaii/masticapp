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
            var base_url = "<?=base_url('local');?>";
            var link = "";
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
                        zelda = base_url+"/index/"+registros[i]['ml_id'];
                        html += "<tr>";
                        html += "<td><a href='"+zelda+"'>"+registros[i]['ml_nombre_local']+"</a></td>";
                        html += "</tr>";
                    }

                    html +="</tbody></table>";
                    $('#resultado_busqueda').html(html);
                }
            });
        }
</script>

<body>
<div class="container">
    <div class="row">
        <div class="col s6 m8 l10 hoverable ">
            <?
            echo form_open();
            // Parametros
            //echo form_label('Busqueda');
            $in_busqueda = array(
            'name' => 'local',
            'class' => 'input_box',
            'placeholder' => 'Buscar',
            'id' => 'local'
            );
            echo form_input($in_busqueda);
            echo form_close();
            ?>
        </div>
        <div class="col">
            <a class="boton btn-floating btn-large waves-effect waves-light red"><i class="material-icons">search</i></a>
        </div>
    </div>

    <div id="resultado_busqueda" class="col s4"></div>
</div>
</body>

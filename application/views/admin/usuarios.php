
<div id="container">
        <div class="row ">
           <div class="col l6 s12 ">
           <div class="card-panel grey lighten-5 z-depth-1 hoverable">
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Mail</th>
                            <th>Estado</th>
                            <th>modificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $usuarios?>
                    </tbody>
                </table>
            </div>
           </div>
        </div>
          <div id="modal1" class="modal">
<div class="modal-content">
      <h4>administradores</h4>
        <div class="input-field col s6">
          <input placeholder="Name" id="username" type="text" class="validate">
          <label for="first_name">Name</label>
        </div>

    <div class="input-field col s12" >
        <select id="usertype">
          <option value="" disabled selected>Elige alguna opcion.</option>
          <option value="7">Administrador</option>
          <option value="3">Editor</option>
          <option value="1">Usuario</option>
        </select>
        <label>Seleccionar Nivel</label>
    </div>


    </div>
    <div class="modal-footer">
        <a href="#" id="send" onclick="modificar_confirm(user.id)" class="modal-action modal-close waves-effect waves-green btn-flat">Send</a>
        <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
  </div>
</div>

<script type="text/javascript">
    var user = {name:null,id:null,type:null};

    $(document).ready(function() {
        $('select').material_select();
    });

    function modificar(idUsuario,){
        $("#username").val($("#"+idUsuario+" > td").eq(0).text());
        $('#modal1').modal('open');
        user.id = idUsuario;
    }

    function modificar_confirm(idUsuario){
        var nombre = $("#username").val();
        var tipoUsuario = $('#usertype').val();
        if(nombre == null || tipoUsuario == null){
            alert("Debes llenar todos los campos.")
        }
        else{
        $.ajax({
            url:"<?= base_url('usuarios/modificarUsuario/')?>" ,
            type:"POST",
            data:{  idUsuario   :idUsuario,
                    nombre      :nombre,
                    tipoUsuario :tipoUsuario
                },
            success:function(respuesta){
                console.log(respuesta);
                Materialize.toast('Usuario Modificado.'+idUsuario, 4000); // 4000 is the duration of the toast
            },
            fail:function(respuesta){
                alert("el voto a fallado ");
            }

        });
        }
    }

function eliminar(idUsuario){
        if(confirmar()){
            $.ajax({
                url:"<?= base_url('usuarios/eliminarUsuario/')?>" ,
                type:"POST",
                data:{  idUsuario   :idUsuario
                    },
                success:function(respuesta){
                    console.log(respuesta);
                    $("#"+idUsuario).remove();
                    Materialize.toast('Usuario Eliminado.'+idUsuario, 4000); // 4000 is the duration of the toast
                },
                fail:function(respuesta){
                    alert("Error al Eliminar");
                }

            });
        }
}

function confirmar() {
    var txt;
    var r = confirm("Esta seguro?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}


</script>

<script>
    $(document).ready(function() {        
        ocultarspanedit();
        mostrardatos();    
        /****************************************************/
        //EDITAR BUTTON DIALOG 
        $("#editusersave").click(function(e) {      
            e.preventDefault();
//           if ( $("#editusuario").val().trim().length == 0 ) {
//                $("#spneditusuario").html("Campo requerido");
//                $("#spneditusuario").show();                
//                $("#spneditalert").show();
//            }else 
            if ( $("#editrut").val().trim().length == 0 ){
                $("#spneditrut").html("Campo requerido");
                $("#spneditrut").show();
                $("#spneditalert").show();
            }else if ( $("#editnombre").val().trim().length == 0 ){
                $("#spneditnombre").html("Campo requerido");
                $("#spneditnombre").show();
                $("#spneditalert").show();
            }else if ( $("#editapellidopaterno").val().trim().length == 0 ){
                $("#spneditappaterno").html("Campo requerido");
                $("#spneditappaterno").show();
                $("#spneditalert").show();
//            }else if ( $("#select-edittcbanco").val().trim().length == 0 ){
//                $("#spneditappaterno").html("Campo requerido");
//                $("#spneditappaterno").show();
//                $("#spneditalert").show();
//            }else if ( $("#editnumerocuenta").val().trim().length == 0 ){
//                $("#spneditappaterno").html("Campo requerido");
//                $("#spneditappaterno").show();
//                $("#spneditalert").show();
            }else{
                $.ajax({
                    url: 'Users/edit/' + idusers,
                    type: "POST",
                    data: $("#formedit").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        console.log(n);
                        $("#cargando").dialog("close");
                        if (n==1) {
                            mostrarDatos("id","asc");
                            alert("Editado con exito");
                            $("#formeditproductos").trigger("reset");
                            $("#editaruser").dialog("close");
                        }else if (n==0){
                            $("#spneditproductos").html("No se pudo editar, intentelo de nuevo");
                            $("#spneditproductos").show();                                                  
                        }
                    }
                 });
              }
        });
    });
   
    function mostrardatos(){
    $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'viewmicuenta/'.$this->Session->read('User.0.Email'))); ?>',
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");$("#list-edittipo").html("");},
                success: function(data) {
                console.log(data[0]);
                $("#cargando").dialog("close");
                $("#editrut").val(data[0].User.rut);
                $("#editnombre").val(data[0].User.nombre);
                $("#editapellidopaterno").val(data[0].User.apellidoPaterno);
                $("#editapellidomaterno").val(data[0].User.apellidoMaterno);
                if (data[0].User.sexo =="M"){
                    $("#radiom").prop( "selected", true );
                }else if(data[0].User.sexo=="F"){
                    $("#radiof").prop( "selected", true );
                }
                //llenarlistboxcatvend(data.User.categoria_vendedore_id);
                //llenarlistboxtcbancos(data.User.tipo_cuentas_bancaria_id,"x");
                $("#editnumerocuenta").val(data[0].User.numeroCuenta); 
                },
                error: function(n) {
                    console.log(n);
                }
            });
    }
    function ocultarspanedit(){
        //$("#spneditusuario").hide();
        $("#spneditrepassword").hide();
        $("#spneditrut").hide();
        $("#spneditnombre").hide();
        $("#spneditappaterno").hide();
        $("#spnedittipoctabancaria").hide();
        $("#spneditalert").hide();
    }


    /********************************************************************/
//CIERRE USUARIOS          
    /********************************************************************/
</script>
<!--EDITAR USUARIOS -->
<div id="editaruser" title="Editar Usuario">
    <form id="formedit" method="POST">
    <table class="actualizarusuario">
        <tr>
            <td>
                <label>Rut:</label><br>   
                <input id="editrut" type="text" name="rut" maxlength="10">
                <span id="spneditrut"></span>
            </td>
            <td>
                
            </td>
        </tr>
        <tr>
            <td> 
                <label>Nombre:</label>   
                <input id="editnombre" type="text" name="nombre">
                <span id="spneditnombre"></span>
            </td>
            <td>
                <label>Ap. Paterno:</label>   
                <input id="editapellidopaterno" type="text" name="apellidoPaterno">
                <span id="spneditappaterno"></span>
            </td>
            <td> 
                <label>Ap. Materno:</label>   
                <input id="editapellidomaterno" type="text" name="apellidoMaterno">
            </td>
        </tr>
        <tr>
            <td>
                <label>Sexo:</label>   
                <select id="listboxsexo">
                    <option id="radiom" value ="M">Masculino</option>
                    <option id="radiof" value ="F">Femenino</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Categoria Vendedor:</label> 
            </td>
        </tr>
        <tr>
            <td><label>Bancos:</label></td>
        </tr>
        <tr>
            <td><label>Cuenta:</label> </td>
        </tr>        
        <tr>
            <td><label>Numero cuenta Bancaria:</label>
            <input id="editnumerocuenta" type="text" name="numeroCuenta">
            </td>
        </tr>        
        <tr>
            <td></td>
            <td></td>
            <td><button id="editusersave" class="botones">Guardar</button>
            <span id="spneditalert">Debe llenar los campos correctamente</span>
            </td>
        </tr>      
        
        
    </table>
    </form>
</div>

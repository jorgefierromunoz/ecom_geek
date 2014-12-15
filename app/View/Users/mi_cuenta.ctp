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
                url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'view/'.$this->Session->read('User.0.IdUsu'))); ?>',
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");$("#list-edittipo").html("");},
                success: function(data) {
                $("#cargando").dialog("close");
                $("#editrut").val(data.User.rut);
                $("#editnombre").val(data.User.nombre);
                $("#editapellidopaterno").val(data.User.apellidoPaterno);
                $("#editapellidomaterno").val(data.User.apellidoMaterno);
                if (data.User.sexo =="M"){
                    $("#radiom").prop( "checked", true );
                }else if(data.User.sexo=="F"){
                    $("#radiof").prop( "checked", true );
                }
                $("#editpuntos").val(data.User.puntoAcumulado);
                $("#editreferido").val(data.User.referido);
                if (data.User.referido){
                    $("#editreferido").prop("checked", true);
                    $("#editrefhidd").val("true");
                }else{
                     $("#editreferido").prop("checked", false);
                      $("#editrefhidd").val("");
                }
                $("#editemail").val(data.User.email);                
                llenarlistboxcatvend(data.User.categoria_vendedore_id);
                llenarlistboxtcbancos(data.User.tipo_cuentas_bancaria_id,"x");
                $("#editnumerocuenta").val(data.User.numeroCuenta); 
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
        <label>Rut:</label>   
        <input id="editrut" type="text" name="rut">
        <span id="spneditrut"></span>
        <label>Nombre:</label>   
        <input id="editnombre" type="text" name="nombre">
        <span id="spneditnombre"></span>
        <label>Ap. Paterno:</label>   
        <input id="editapellidopaterno" type="text" name="apellidoPaterno">
        <span id="spneditappaterno"></span>
        <label>Ap. Materno:</label>   
        <input id="editapellidomaterno" type="text" name="apellidoMaterno">
        <label>Sexo:</label>   
        <input id="radiom" type="radio" value="M" name="sexo">Masculino<br>
        <input id="radiof" type="radio" value="F" name="sexo">Femenino<br>
        <label>Total puntos:</label>   
        <input id="editpuntos" type="text" name="puntoAcumulado">
        <label>Referido:</label>   
        <input id="editreferido" type="checkbox">
        <input id="editrefhidd" type="hidden" name="referido">
        <br>
        <label>Email:</label>   
        <input id="editemail" type="text" name="email">
        <span id="spneditemail"></span>
        <label>Categoria Vendedor:</label> 
        <div id="list-editcatvendedor"></div>        
        <label>Bancos:</label> 
        <div id="list-editbanco"></div>
        <label>Cuenta:</label> 
        <div id="list-edittcbanco"></div>
        <span id="spnedittipoctabancaria"></span>
        <label>Numero cuenta Bancaria:</label>   
        <input id="editnumerocuenta" type="text" name="numeroCuenta">
        
        <hr>
        <p align="right"><button id="editusersave" align="right">Guardar</button></p>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
    </form>
</div>

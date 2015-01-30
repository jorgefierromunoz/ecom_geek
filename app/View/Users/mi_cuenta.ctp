<script>
    $(document).ready(function() {        
        ocultarspanedit();
        mostrardatos();    
        bancos();
        $("#list-banco").change(function() {
            tipo_cta_bancos($("#select-banco").val());
        });
        /****************************************************/
        //EDITAR BUTTON DIALOG 
        $("#editusersave").click(function(e) {      
            e.preventDefault();
            if ( $("#editnombre").val().trim().length == 0 ){
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
                    url: 'edit/' + <?php echo $this->Session->read('User.0.IdUsu'); ?>,
                    type: "POST",
                    data: $("#formedit").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1) {
                            mostrardatos();
                            $("#spanAlertAct").html("Editado con éxito");
                        }else if (n==0){
                            $("#spneditproductos").html("No se pudo editar, inténtelo de nuevo");
                            $("#spneditproductos").show();                                                  
                        }
                    },error: function(n){
                        alert("Error: inténtelo nuevamente");
                        $("#cargando").dialog("close");
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
    function bancos(){
    $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Bancos','action'=>'listabancosComboBox')); ?>',
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");$("#list-edittipo").html("");},
                success: function(data) {
                var list='';
                list += '<select id="select-banco"><option value="">Seleccione un Banco</option>';
                $.each(data, function(item) {
                    list+='<option value="' + data[item].Banco.id + '">' + data[item].Banco.banco + '</option>';
                });
                $("#list-banco").html(list);
                },
                error: function(n) {
                    console.log(n);
                }
            });
    
    }
    function tipo_cta_bancos(id){
    $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'TipoCuentasBancarias','action'=>'listatcbancariasComboBox')); ?>/'+id,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ },
                success: function(data) {
                var list='';
                list += '<select id="select-tipo-banco"><option value="">Seleccione Tipo de Cuenta</option>';
                $.each(data, function(item) {
                    console.log(data[item].TipoCuentasBancaria.tipoCuentaBancaria);
                    list+='<option value="' + data[item].TipoCuentasBancaria.id + '">' + data[item].TipoCuentasBancaria.tipoCuentaBancaria + '</option>';
                });
                $("#list-tipo-banco").html(list);
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
<h3 id="spanAlertAct"></h3>
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
                <select id="listboxsexo" name="sexo" >
                    <option id="radiom" value ="M">Masculino</option>
                    <option id="radiof" value ="F">Femenino</option>
                </select>
                <input id="estado" type="text" name="estado" value="habilitado">
            </td>
        </tr>
        <tr>
            <td>
            </td>
        </tr>
        <tr>
            <td><label>Banco:</label><br><div id="list-banco"></div></td>
        </tr>
        <tr>
            <td><label>Tipo de Cuenta:</label><br><div id="list-tipo-banco"></div> </td>
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
            
            </td>
        </tr>      
        <tr>
            <td coldspan="2">&nbsp</td>
            <td><span id="spneditalert">Debe llenar los campos correctamente</span></td>
        </tr> 
        
    </table>
    </form>
</div>
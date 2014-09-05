<script type="text/javascript" src="js/banco_tipo_cta_bancaria.js"></script>
<script>
    $(document).ready(function() {
        
        //MOSTRAR TABLA ACTUAL        
        mostrarDatos("id","asc");
       //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-banco").change(function() {
            if ($("#select-banco").val()==""){
              $("#list-tcbanco").html("<select id=select-tcbanco><option value=''>Seleccione una Cuenta</option>");
            }
            else{
               llenarlistboxtcbancos("x", $("#select-banco").val()); 
            }    
        });   
        
         $("#list-edittcbanco").change(function() {
            llenarlistboxbancosus($("#select-edittcbanco").val());
        });
        $("#list-editbanco").change(function() {
            llenarlistboxtcbancos("xa",$("#select-editbanco").val());
        });
        $("#editreferido").change(function(){
           var opcion=$("#editreferido").prop("checked");  
           if (opcion){
                $("#editrefhidd").val(opcion);
           }else{
               $("#editrefhidd").val("");
           }
        });
        $("#referido").change(function(){
           var opcion=$("#referido").prop("checked");  
           if (opcion){
                $("#refhidd").val(opcion);
           }else{
               $("#refhidd").val("");
           }
        });
        //OPEN DIV NUEVO USUARIO BUTTON
        //-----------------------------------
        $("#adddiv").click(function() {
            $("#formadduser").trigger("reset");
            ocultarspanadd();
            $("#refhidd").val("");
            $("#list-tcbanco").html("<select id=select-tcbanco><option value=''>Seleccione una Cuenta</option>");
            llenarlistboxcatvend("x");
            llenarlistboxbancosus("x");
            $("#divuser").dialog("open");

        });

        //OPEN DIV EDIT USUARIO 
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES   
        $(document).on("click", ".editar", function() {
            ocultarspanedit();
            idusers = $(this).attr('data-id');
            $.ajax({
                url: 'Users/view/' + idusers,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");$("#list-edittipo").html("");},
                success: function(data) {
                $("#cargando").dialog("close");                                               
                $("#editaruser").dialog("open");
                var select='';
                if (data.User.estado=="habilitado"){
                    select='<select id="editselecestado" name="estado"><option value="habilitado" selected>Habilitado</option><option value="deshabilitado">Deshabilitado</option></select>';
                }else if (data.User.estado=="deshabilitado"){
                    select='<select id="editselectipousuario" name="estado"><option value="habilitado">Habilitado</option><option value="deshabilitado" selected>Deshabilitado</option></select>';
                }
                $("#list-editestado").html(select);
                $("#editusuario").val(data.User.username);
                select='';
                if (data.User.tipo=="admin"){
                    select='<select id="editselectipousuario" name="tipo"><option value="admin" selected>Administrador</option><option value="cliente">Cliente</option></select>';
                }else if (data.User.tipo=="cliente"){
                    select='<select id="editselectipousuario" name="tipo"><option value="admin">Administrador</option><option value="cliente" selected>Cliente</option></select>';
                }
                $("#list-edittipo").html(select);
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
        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR USERS
        $("#divuser").dialog({
            height: '500',
            width: '40%',
            autoOpen: false,
            modal: true,
            show: {
                effect: "blind",
                duration: 300
            },
            hide: {
                effect: "blind",
                duration: 300
            }
        }).css("font-size", "15px", "width", "auto");
        $('#divuser').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#editaruser").dialog({
            height: '500',
            width: '40%',
            autoOpen: false,
            modal: true,
            show: {
                effect: "blind",
                duration: 300
            },
            hide: {
                effect: "blind",
                duration: 300
            }
        }).css("font-size", "15px", "width", "auto");
        $('#editaruser').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#adduserssave").click(function(e) {
            e.preventDefault();
             if ( $("#usuario").val().trim().length == 0 ) {
                $("#spnaddusuario").html("Campo requerido");
                $("#spnaddusuario").show();                
                $("#spnaalert").show();
            }else if ( $("#password").val().trim().length == 0 ){
                $("#spnaddpassword").html("Campo requerido");
                $("#spnaddpassword").show();
                $("#spnaalert").show();
            }else if ( $("#repassword").val().trim().length == 0 ){
                $("#spnaddrepassword").html("Password no coinciden");
                $("#spnaddrepassword").show();
                $("#spnaalert").show();
            }else if ( $("#rut").val().trim().length == 0 ){
                $("#spnaddrut").html("Campo requerido");
                $("#spnaddrut").show();
                $("#spnaalert").show();
            }else if ( $("#nombre").val().trim().length == 0 ){
                $("#spnaddnombre").html("Campo requerido");
                $("#spnaddnombre").show();
                $("#spnaalert").show();
            }else if ( $("#apellidopaterno").val().trim().length == 0 ){
                $("#spnaddappaterno").html("Campo requerido");
                $("#spnaddappaterno").show();
                $("#spnaalert").show();
            }else if ( $("#select-tcbanco").val().trim().length == 0 ){
                $("#spnedittipoctabancaria").html("Campo requerido");
                $("#spnedittipoctabancaria").show();
                $("#spnaalert").show();
            }else if ( $("#numerocuenta").val().trim().length == 0 ){
                $("#spnaddnumerocuenta").html("Campo requerido");
                $("#spnaddnumerocuenta").show();
                $("#spnaalert").show();
            }else{
                $.ajax({
                    url: "Users/add",
                    type: "POST",
                    data: $("#formadduser").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formadduser").trigger("reset");                           
                           mostrarDatos("id","asc");
                           $("#divuser").dialog("close");
                        }else if (n==0){
                            $("#spnaalert").html("No se pudo guardar, intentelo de nuevo");
                            $("#spnaalert").show();
                        }
                    },
                    error: function(n) {
                        console.log(n);
                        $("#spnaalert").html("No se pudo guardar, intentelo de nuevo");
                        $("#spnaalert").show();
                        $("#cargando").dialog("close");
                    }
                });
            }
        });
        /****************************************************/
        //EDITAR BUTTON DIALOG 
        $("#editusersave").click(function(e) {      
            e.preventDefault();
           if ( $("#editusuario").val().trim().length == 0 ) {
                $("#spneditusuario").html("Campo requerido");
                $("#spneditusuario").show();                
                $("#spneditalert").show();
            }else if ( $("#editrut").val().trim().length == 0 ){
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
            }else if ( $("#select-edittcbanco").val().trim().length == 0 ){
                $("#spneditappaterno").html("Campo requerido");
                $("#spneditappaterno").show();
                $("#spneditalert").show();
            }else if ( $("#editnumerocuenta").val().trim().length == 0 ){
                $("#spneditappaterno").html("Campo requerido");
                $("#spneditappaterno").show();
                $("#spneditalert").show();
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
        
          //ELIMINAR BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idusers = $(this).attr('data-id');
            $.ajax({
                url: "Users/delete/" + idusers,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {    
                    $("#cargando").dialog("close");
                    if (n=='t'){               
                        mostrarDatos("id","asc");
                        alert("Usuario id: " + idusers + " eliminado con éxito");          
                    }else{
                        alert("No se pudo eliminar por que hay " + n + " registro(s) asociado(s)");   
                    }
                    
                },
                error: function(n){
                    console.log(n);
                    $("#cargando").dialog("close");
                }
            });
        });

    });
    //FUNCION PARA MOSTRAR DATOS DE LA TABLA
    function mostrarDatos(atributo,orden) {
        $.ajax({
            url: 'Users/listausers/User.'+atributo+'/'+orden,
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if (data != null) {
                    var tabla = '<table>';
                    tabla += '<tr>';
                    tabla += '<th>Estado</th><th>Email</th><th>User</th><th>Tipo Usuario</th><th>Cat. Vendedor</th><th>Rut</th><th>Nombre</th><th>Ap Paterno</th><th>Ap Materno</th><th>Sexo</th><th>Total Ptos.</th><th>Referido</th><th>Cta Bancaria</th><th>N° Cta</th><th>Editar</th><th>Eliminar</th>';
                    tabla += '</tr>';
                    $.each(data, function(index, item) {  
                        tabla += '<tr>';
                        if (item.User.estado=="habilitado"){
                            tabla += '<td><input type=checkbox checked disabled></td>';
                         }else if (item.User.estado=="deshabilitado"){
                             tabla += '<td><input type=checkbox disabled></td>';
                         }
                        tabla += '<td>' + item.User.email + '</td>';
                        tabla += '<td>' + item.User.username + '</td>';                        
                        tabla += '<td>' + item.User.tipo + '</td>';
                        tabla += '<td>' + item.CategoriaVendedore.categoriaVendedor + '</td>';
                        tabla += '<td>' + item.User.rut + '</td>';
                        tabla += '<td>' + item.User.nombre + '</td>';
                        tabla += '<td>' + item.User.apellidoPaterno + '</td>';
                        tabla += '<td>' + item.User.apellidoMaterno + '</td>';
                        tabla += '<td>' + item.User.sexo + '</td>';                                                
                        tabla += '<td>' + item.User.puntoAcumulado + '</td>';
                        tabla += '<td>' + item.User.referido + '</td>';
                        tabla += '<td>'+ item.TipoCuentasBancaria.tipoCuentaBancaria+'</td>';
                        tabla += '<td>' + item.User.numeroCuenta + '</td>';
                        tabla += '<td><button type="button" class="editar" data-id="' + item.User.id + '">Editar</button></td>';
                        tabla += '<td><button type="button" class="delete" data-id="' + item.User.id + '">Eliminar</button></td>';
                        tabla += '</tr>';
                    });
                    tabla += '</table>';
                    $('#tablausers').html(tabla);
                } else {                    
                    tabla = 'No hay usuarios en la base de datos';
                    $('#tablausers').html(tabla);
                }

            }
        });
    }
    function llenarlistboxcatvend(resp) {
        $.ajax({
            url: 'CategoriaVendedores/listacatvendedoresComboBox',
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ if (resp=="x"){
                   $('#list-catvendedor').html("<img src='img/ajaxload2.gif'>");}
               else{
                   $('#list-editcatvendedor').html("<img src='img/ajaxload2.gif'>");
               }},
            success: function(data) {
                if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-catvend" name="categoria_vendedore_id" ><option value="">Categoria Vendedores</option>';
                    }else{
                        list ='<select id="select-editcatvend" name="categoria_vendedore_id">';
                    }     
                    $.each(data, function(item) {
                        var id = data[item].CategoriaVendedore.id;
                        var catvend = data[item].CategoriaVendedore.categoriaVendedor;
                        if(resp==id){ 
                            list += '<option selected=selected value=' + id+ '>' + catvend + '</option>';
                        }else{
                            list += '<option value=' + id + '>' + catvend + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-catvendedor').html(list);
                    }else{
                        $('#list-editcatvendedor').html(list);
                    }
                }else{
                    var list = '<select id="select-editcatvend"><option>No hay Cat. de Vendedores en la BD</option>';
                    if (resp=="x") {
                        $('#list-catvendedor').html(list);
                    }else{
                        $('#list-editcatvendedor').html(list);
                    }
                }
               }
         });
    }
    
    function ocultarspanadd(){
        $("#spnaddusuario").hide();
        $("#spnaddpassword").hide();
        $("#spnaddrepassword").hide();
        $("#spnaddrut").hide();
        $("#spnaddnombre").hide();
        $("#spnaddappaterno").hide();
        $("#spnaddtipoctabancaria").hide();
        $("#spnaddnumerocuenta").hide();        
        $("#spnaalert").hide(); 
    }
    function ocultarspanedit(){
        $("#spneditusuario").hide();
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

<!-- LISTA -->
<div id="tablausers"></div>

<!-- AGREGAR USUARIOS -->
<button  id="adddiv" class="botones">Nuevo Usuario</button>
<div id="divuser" title="Nuevo Usuario"> 
    <form id="formadduser" method="POST">
        <label>Estado:</label>   
        <input id="estado" type="text" name="estado" value="deshabilitado">
        <label>Usuario:</label>   
        <input id="usuario" type="text" name="username">
        <span id="spnaddusuario"></span><br>
        <label>Password:</label>   
        <input id="password" type="password" name="password">
        <span id="spnaddpassword"></span>
        <label>Repita password:</label>   
        <input id="repassword" type="password" name="">
        <span id="spnaddrepassword"></span>
        <label>Tipo de usuario:</label>   
        <select id="selectipousuario" name="tipo">
            <option value="admin">Administrador</option>
            <option value="cliente">Cliente</option>
        </select>   
        <label>Rut:</label>   
        <input id="rut" type="text" name="rut">
        <span id="spnaddrut"></span>
        <label>Nombre:</label>   
        <input id="nombre" type="text" name="nombre">
        <span id="spnaddnombre"></span>
        <label>Ap. Paterno:</label>   
        <input id="apellidopaterno" type="text" name="apellidoPaterno">
        <span id="spnaddappaterno"></span>
        <label>Ap. Materno:</label>   
        <input id="apellidomaterno" type="text" name="apellidoMaterno">
        <label>Sexo:</label>   
        <input type="radio" value="M" name="sexo">Masculino<br>
        <input type="radio" value="F" name="sexo">Femenino<br>
        <label>Total puntos:</label>   
        <input id="puntos" type="text" name="puntoAcumulado">
        <label>Referido:</label>   
        <input id="referido" type="checkbox" name="referido">        
        <input id="refhidd" type="text" name="referido">
        <br>
        <label>Email:</label>   
        <input id="email" type="text" name="email">
        <span id="spnaddemail"></span>
        <label>Categoria Vendedor:</label> 
        <div id="list-catvendedor"></div>        
        <label>Bancos:</label> 
        <div id="list-banco"></div>
        <label>Cuenta:</label> 
        <div id="list-tcbanco"></div>
        <span id="spnaddtipoctabancaria"></span>
        <label>Numero cuenta Bancaria:</label>   
        <input id="numerocuenta" type="text" name="numeroCuenta"><br>
        <span id="spnaddnumerocuenta"></span>
        <p align="right"><button id="adduserssave">Guardar</button></p>
        <span id="spnaalert">Debe llenar los campos correctamente</span>
    </form>
</div>
<!--EDITAR USUARIOS -->
<div id="editaruser" title="Editar Usuario">
    <form id="formedit" method="POST">
        <label>Estado:</label>   
        <div id="list-editestado"></div> 
        <label>Usuario:</label>
        <input id="editusuario" type="text" name="username"> 
        <span id="spneditusuario"></span><br>
        <label>Tipo de usuario:</label> 
        <div id="list-edittipo"></div> 
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

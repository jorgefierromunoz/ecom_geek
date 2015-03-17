<script>
    $(document).ready(function() {
        iddireccionesglobal = 0;
        //LISTA 
        mostrarDatos("id","asc");
        $("#checkestado").change(function(){
           var opcion=$("#checkestado").prop("checked");  
            if (opcion){
                $("#iptestado").val(opcion);
           }else{
               $("#iptestado").val("");
           }
        });
        //check edit  
        $("#editcheckestado").change(function(){
           var opcion=$("#editcheckestado").prop("checked");  
           if (opcion){
                $("#editestado").val(opcion);
           }else{
               $("#editestado").val("");
           }
        });
        //OPEN DIV NUEVO BUTTON   
        //-----------------------------------
        $("#btnadddirecciones").click(function() {
            $("#formadddirecciones").trigger("reset");
            $("#iptpestado").val("");        
            ocultarspan();
            llenarlistboxcomunas("x");
            $("#divadddirecciones").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES     
        $(document).on("click", ".editar", function() {
            ocultarspan();            
            iddireccionesglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Direcciones/view/' + iddireccionesglobal,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editcalle").val(data.Direccione.calle);
                    $("#editnumero").val(data.Direccione.numero);
                    $("#editdpto").val(data.Direccione.dpto);
                    $("#editrestodireccion").val(data.Direccione.restoDireccion);
                    $("#editcodigoPostal").val(data.Direccione.codigoPostal);
                    $("#editgeoreferencia").val(data.Direccione.georeferencia);
                    if (data.Direccione.estado){
                        $("#editestado").val(data.Direccione.estado);
                        $("#editcheckestado").prop("checked", true);
                    }else{
                         $("#editestado").val("");
                         $("#editcheckestado").prop("checked", false);
                    }
                    $("#edituser_id").val(data.Direccione.user_id);
                    
                    llenarlistboxcomunas(data.Direccione.comuna_id);
                    $("#diveditdirecciones").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });
        });
        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divadddirecciones").dialog({
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
         $('#formadddirecciones').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditdirecciones").dialog({
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
        $('#formeditdirecciones').submit(function(e) {
            e.preventDefault();
        });
        
        //GUARDAR BUTTON ADD DIALOG 
        $("#adddireccionessave").click(function(e) {
            e.preventDefault();
              if ( $("#iptcalle").val().trim().length == 0) {
                $("#spnaddcalle").html("Campo requerido");
                $("#spnaddcalle").show();
                $("#spnaddalert").show();
                
              }else if ( $("#iptnumero").val().trim().length == 0) {
                $("#spnaddnumero").html("Campo requerido");
                $("#spnaddnumero").show();
                $("#spnaddalert").show();
              }else if ( $("#select-comunas").val().trim().length == 0){
                $("#spnaddcomuna").html("Campo requerido");
                $("#spnaddcomuna").show();
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: "Direcciones/add",
                    type: "POST",
                    data: $("#formadddirecciones").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formadddirecciones").trigger("reset");                           
                           mostrarDatos("id","asc");
                           $("#divadddirecciones").dialog("close");
                        }else if (n==0){
                            alert("No se pudo guardar, intentelo de nuevo");
                        }
                    },
                    error: function(n) {
                        console.log(n);
                    }
                });
             }
        });
        /****************************************************/
        /****************************************************/
        //EDITAR BUTTON DIALOG 
        $("#editdireccionessave").click(function(e) {      
            e.preventDefault();            
              if ( $("#editcalle").val().trim().length == 0) {
                $("#spneditcalle").html("Campo requerido");
                $("#spneditcalle").show();
                $("#spneditalert").show();
                
              }else if ( $("#editnumero").val().trim().length == 0) {
                $("#spneditnumero").html("Campo requerido");
                $("#spneditnumero").show();
                $("#spneditalert").show();
              }else if ( $("#select-editcomunas").val().trim().length == 0){
                $("#spneditcomuna").html("Campo requerido");
                $("#spneditcomuna").show();
                $("#spneditalert").show();
              }else{
                $.ajax({
                    url: 'Direcciones/edit/' + iddireccionesglobal,
                    type: "POST",
                    data: $("#formeditdirecciones").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1) {
                            mostrarDatos("id","asc");
                            alert("Editado con exito");
                            $("#formeditdirecciones").trigger("reset");
                            $("#diveditdirecciones").dialog("close");
                        }else if (n==0){
                            $("#spneditdirecciones").html("No se pudo editar, intentelo de nuevo");
                            $("#spneditdirecciones").show();                                                  
                        }
                    }
                 });
              }
        });
        /****************************************************/
        /****************************************************/
       //ELIMINAR  BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            iddireccionesglobal = $(this).attr('data-id');
            $.ajax({
                url: "Direcciones/delete/" + iddireccionesglobal,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='1'){          
                        alert("Direccione id: " + iddireccionesglobal + " eliminada con éxito");               
                        mostrarDatos("id","asc");
                    }else{
                        alert("No se pudo eliminar intentelo de nuevo");   
                    }
                }
            });
        });
         //ORDENAR           
        var ascendente=false;
        $(document).on("click", ".ordenar", function(e) {
            e.preventDefault();
            var tabla = $(this).attr('data-id');
            if (ascendente){
                mostrarDatos(tabla,"asc");
                ascendente=!ascendente;
            }else{
                mostrarDatos(tabla,"desc");        
                ascendente=!ascendente;
            }
         });
         
   });     
    //LISTAR
    function mostrarDatos(atributo,orden) {
        $.ajax({
            url: 'Direcciones/listadirecciones/Direccione.'+atributo+'/'+orden,
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th class=ordenar data-id=id>Id</th>';
                tabla += '<th class=ordenar data-id=calle>Calle</th>';
                tabla += '<th class=ordenar data-id=numero>numero</th><th class=ordenar data-id=dpto>Departamento</th>';
                tabla += '<th class=ordenar data-id=restoDireccion>Resto Dirección</th><th class=ordenar data-id=codigoPostal>Código Postal</th><th class=ordenar data-id=georeferencia>Georeferencia</th>';
                tabla += '<th class=ordenar data-id=estado>Estado</th>';
                //tabla += '<th class=ordenar data-id=user_id>Usuario</th>';
                tabla += '<th class=ordenar data-id=comuna_id>Comuna</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Direccione.id + '</td>';
                    tabla += '<td>' + item.Direccione.calle + '</td>';
                    tabla += '<td>' + item.Direccione.numero +'</td>';
                    tabla += '<td>' + item.Direccione.dpto +'</td>';
                    tabla += '<td>' + item.Direccione.restoDireccion +'</td>';                    
                    tabla += '<td>' + item.Direccione.codigoPostal +'</td>';
                    tabla += '<td>' + item.Direccione.georeferencia +'</td>';
                    //tabla += '<td>' + item.Direccione.estado +'</td>';
                    if (item.Direccione.estado ){
                       tabla += '<td ><input type=checkbox checked disabled></td>';
                    }else{
                        tabla += '<td ><input type=checkbox disabled></td>';
                    }
                    //tabla += '<td>' + item.User.username +'</td>';
                    tabla += '<td>' + item.Comuna.comuna +'</td>';

                    tabla += '<td><button type="button" class="editar" data-id="' + item.Direccione.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Direccione.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listadirecciones').html(tabla);
                }else{
                   tabla = 'No hay direcciones en la base de datos';
                $('#listadirecciones').html(tabla);
                }
            }
        });
    }
     
    function ocultarspan(){   
        $("#spnaddcalle").hide();
        $("#spnaddnumero").hide(); 
        $("#spnaddcomuna").hide(); 
        $("#spnaddalert").hide();
        
        $("#spneditcalle").hide();
        $("#spneditnumero").hide(); 
        $("#spneditcomuna").hide();
        $("#spneditalert").hide();
    }
/********************************************************************/
//CIERRE        
/********************************************************************/
</script>
<div class="contbotones">
    <button  id="btnadddirecciones" class="botones">Nueva Dirección</button>
</div>
<!-- LISTA  -->
<div id="listadirecciones"></div>
<!-- AGREGAR  -->
<div id="divadddirecciones" title="Nueva Dirección"> 
    <form id="formadddirecciones" method="POST">
        <label>Calle:</label> 
        <input id="iptcalle" type="text" name="calle">
        <span id="spnaddcalle"></span>
        <label>Número:</label> 
        <input id="iptnumero" type="text" name="numero">
        <span id="spnaddnumero"></span> 
        <label>Departamento:</label> 
        <input id="iptdpto" type="text" name="dpto"> 
        <label>Resto de la Dirección:</label> 
        <input id="iptrestodireccion" type="text" name="restoDireccion">
        <label>Código Postal:</label> 
        <input id="iptcodigoPostal" type="text" name="codigoPostal">
        <label>Geo-Referencia:</label> 
        <input id="iptgeoreferencia" type="text" name="georeferencia"> 
        <br><br>
        <input type="checkbox" id="checkestado"><label for="check">Estado</label>
        <input id="iptestado" type="hidden" name="estado">
        
        <label>Usuario:</label> 
        <input id="iptuser_id" type="text" name="user_id">
        <label>Comuna:</label> 
        <div id="list-comunas"></div>  
        <span id="spnaddcomuna"></span> 
        <hr>
        <p align="right"><button id="adddireccionessave">Guardar</button></p>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditdirecciones" title="Editar Dirección">
    <form id="formeditdirecciones" method="POST">
        <label>Calle:</label> 
        <input id="editcalle" type="text" name="calle">
        <span id="spneditcalle"></span>       
        <label>Número:</label> 
        <input id="editnumero" type="text" name="numero"> 
        <span id="spneditnumero"></span> 
        <label>Departamento:</label> 
        <input id="editdpto" type="text" name="dpto"> 
        <label>Resto de la Dirección:</label> 
        <input id="editrestodireccion" type="text" name="restoDireccion">
        <label>Código Postal:</label> 
        <input id="editcodigoPostal" type="text" name="codigoPostal">
        <label>Geo-Referencia:</label> 
        <input id="editgeoreferencia" type="text" name="georeferencia"> 
        <br>
        <input type="checkbox" id="editcheckestado"><label for="check">Estado</label>
        <input id="editestado" type="hidden" name="estado">
        <br>
        <label>Usuario:</label> 
        <input id="edituser_id" type="text" name="user_id">
        <label>Comuna:</label> 
        <div id="list-editcomunas"></div>  
        <span id="spnaeditcomuna"></span> 
        <hr>
        <p align="right"><button id="editdireccionessave">Guardar</button></p>
        <span id="spneditalert">Debe llenar los campos correctamente</span>       
    </form>
</div>


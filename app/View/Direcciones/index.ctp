<script>
    $(document).ready(function() {
        iddireccionesglobal = 0;
        //LISTA 
        mostrarDatos("id","asc");
        $("#checkaddppuntos").change(function(){
           var opcion=$("#checkaddppuntos").prop("checked");  
           if (opcion){
                $("#iptprioridadPunto").val(opcion);
           }else{
               $("#iptprioridadPunto").val("");
           }
        });
        //check edit  
        $("#checkeditppuntos").change(function(){
           var opcion=$("#checkeditppuntos").prop("checked");  
           if (opcion){
                $("#editprioridadPuntoinput").val(opcion);
           }else{
               $("#editprioridadPuntoinput").val("");
           }
        });
        //OPEN DIV NUEVO BUTTON   
        //-----------------------------------
        $("#btnadddirecciones").click(function() {
            $("#formadddirecciones").trigger("reset");
            $("#iptpestado").val("");        
            ocultarspan();
            l("x");
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
                success: function(data) {
                    $("#editdireccionesinput").val(data.Direccione.direccione);
                    $("#editdescripcioninput").val(data.Direccione.descripcion);
                    $("#editstockinput").val(data.Direccione.stock);
                    $("#editprecioinput").val(data.Direccione.precio);
                    $("#editprecioPuntoinput").val(data.Direccione.precioPunto);
                    if (data.Direccione.prioridadPunto){
                        $("#editprioridadPuntoinput").val(data.Direccione.prioridadPunto);
                        $("#checkeditppuntos").prop("checked", true);
                    }else{
                         $("#editprioridadPuntoinput").val("");
                         $("#checkeditppuntos").prop("checked", false);
                    }
                     if (data.Direccione.prioridadPrecio){
                        $("#editprioridadPrecioinput").val(data.Direccione.prioridadPrecio);
                        $("#checkeditprecio").prop("checked", true);
                    }else{
                         $("#editprioridadPrecioinput").val("");
                         $("#checkeditprecio").prop("checked", false);
                    }
                    //$("#ipteditsubCategoria_id").val(data.Direccione.sub_categoria_id);
                    $("#ipteditmodelo_id").val(data.Direccione.modelo_id);
                    $("#iptedittamano_id").val(data.Direccione.tamano_id);  
                    
                    llenarlistboxsubCategorias(data.Direccione.sub_categoria_id,"x");
                    
                    llenarlistboxmodelos(data.Direccione.modelo_id);
                    llenarlistboxtamanos(data.Direccione.tamano_id);
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
            height: 'auto',
            width: 'auto',
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
        /****************************************************/
         $("#ver").dialog({
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
        $('#ver').submit(function(e) {
            e.preventDefault();
        });
        //GUARDAR BUTTON ADD DIALOG 
        $("#adddireccionessave").click(function(e) {
            e.preventDefault();
              if ( $("#iptdirecciones").val().trim().length == 0) {
                $("#spnadddirecciones").html("Campo requerido");
                $("#spnadddirecciones").show();
                $("#spnaddalert").show();
                
              }else if ( $("#iptdescripcion").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptstock").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptprecio").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptprecioPunto").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#select-subcategorias").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#iptmodelo_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#ipttamano_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: "Direcciones/add",
                    type: "POST",
                    data: $("#formadddirecciones").serialize(),
                    dataType:'json',
                    success: function(n) {
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
            if ( $("#editdireccionesinput").val().trim().length == 0) {
                $("#spneditdirecciones").html("Campo requerido");
                $("#spneditdirecciones").show();
                $("#spnaddalert").show();
              }else if ( $("#editdescripcioninput").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#editstockinput").val().trim().length == 0) {
                $("#spnaddalert").show(); 
              }else if ( $("#editprecioinput").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#editprecioPuntoinput").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#select-editsubcategorias").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#ipteditmodelo_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#iptedittamano_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: 'Direcciones/edit/' + iddireccionesglobal,
                    type: "POST",
                    data: $("#formeditdirecciones").serialize(),
                    dataType:'json',
                    success: function(n) {
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
                success: function(n) {
                    if (n=='t'){          
                        alert("Direccione id: " + iddireccionesglobal + " eliminada con éxito");               
                        mostrarDatos("id","asc");
                    }else{
                        alert("No se puede eliminar por que hay " + n + " foto(s) asociada(s)");   
                    }
                }
            });
        });
        //VER BUTTON
        $(document).on("click", ".ver", function(e) {
            e.preventDefault();
            iddireccionesglobal = $(this).attr('data-id');
            $.ajax({
                url: "Direcciones/ver/" + iddireccionesglobal,
                type: "POST",
                dataType:'json',
                success: function(data) {
                    $("#verdireccione").html("Direccione: " + data.Direccione.direccione);
                    $("#iptdireccione_id").val(data.Direccione.id);
                    var listadirecciones='';
                    $.each(data.Foto, function(item) {
                        listadirecciones += '<article class="direcciones">';
                        listadirecciones += '<img src="img/Fotos/s_' + data.Foto[item].url + '" height="100px" width="100px">';
                        listadirecciones += '</article>';
                    });
                    
                    $("#imagenes").html(listadirecciones);
                    $("#ver").dialog("open");
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
                beforeSend: function() {
                $('#listadirecciones').html("Llenando datos...");
            },
            success: function(data) {
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th class=ordenar data-id=id>Id</th>';
                tabla += '<th class=ordenar data-id=calle>Calle</th>';
                tabla += '<th class=ordenar data-id=numero>numero</th><th class=ordenar data-id=dpto>Departamento</th>';
                tabla += '<th class=ordenar data-id=restoDireccion>Resto Dirección</th><th class=ordenar data-id=codigoPostal>Código Postal</th><th class=ordenar data-id=georeferencia>Georeferencia</th>';
                tabla += '<th class=ordenar data-id=estado>Estado</th><th class=ordenar data-id=user_id>Usuario</th>';
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
                    tabla += '<td>' + item.User.username +'</td>';
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
    
    function llenarlistboxcomunas(resp) {
        $.ajax({
            url: 'Comunas/listacomunasComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
                if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-comunas"><option value="">Seleccione una comuna</option>';
                    }else{
                        list ='<select id="select-editcomunas">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Modelo.id){ 
                            list += '<option selected=selected value=' + data[item].Comuna.id + '>' + data[item].Comuna.comuna + '</option>';
                        }else{
                            list += '<option value=' +  data[item].Comuna.id + '>' +data[item].Comuna.comuna + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-comunas').html(list);
                    }else{
                        $('#list-editcomunas').html(list);
                    }
                }else{
                    var list = '<select id="select-editcomunas"><option>No hay comunas en la BD</option>';
                    if (resp=="x"){
                         $('#list-comunas').html(list);
                    }else{
                         $('#list-editcomunas').html(list);
                    }
                }
               }
         });
    }
     
    function ocultarspan(){   
        $("#spnaddcalle").hide();
        $("#spnaddnumero").hide(); 
        $("#spnaddalert").hide();
        
        $("#spneditalert").hide();
    }
/********************************************************************/
//CIERRE        
/********************************************************************/
</script>

<!-- LISTA  -->
<div id="listadirecciones"></div>
<!-- AGREGAR  -->
<button  id="btnadddirecciones" class="botones">Nueva Dirección</button>
<div id="divadddirecciones" title="Nueva Dirección"> 
    <form id="formadddirecciones" method="POST">
        <label>Calle:</label> 
        <input id="iptcalle" type="text" name="calle">
        <span id="spnaddcalle"></span> spnaddcalle spnaddnumero
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
        <br>
        <input type="checkbox" id="checkestado"><label for="check">Estado</label>
        <input id="iptpestado" type="text" name="estado">
        <br>
        <input id="iptuser_id" type="text" name="user_id">
        <label>Comuna:</label> 
        <div id="list-comuna"></div>        

        <p align="right"><button id="adddireccionessave">Guardar</button></p>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditdirecciones" title="Editar Direcciones">
    <form id="formeditdirecciones" method="POST">
        <label>Direccione: </label>
        <input id="editdireccionesinput" type="text" name="direccione">
        <span id="spneditdirecciones"></span>        
        <label>Descripción:</label> 
        <input id="editdescripcioninput" type="text" name="descripcion">
        <span id="spneditdescripcion"></span> 
        <label>Stock:</label> 
        <input id="editstockinput" type="text" name="stock">
        <span id="spneditstock"></span> 
        <label>Precio:</label> 
        <input id="editprecioinput" type="text" name="precio">
        <span id="spneditprecio"></span> 
        <label>Precio Punto:</label> 
        <input id="editprecioPuntoinput" type="text" name="precioPunto">
        <span id="spneditprecioPunto"></span>

        <input type="checkbox" id="checkeditppuntos"><label for="check">Prioridad Puntos</label>
        <input id="editprioridadPuntoinput" type="hidden" name="prioridadPunto">
        <span id="spneditprioridadPunto"></span>

        <input type="checkbox" id="checkeditprecio"><label for="check">Prioridad Precio</label> 
        <input id="editprioridadPrecioinput" type="hidden" name="prioridadPrecio">
        <span id="spneditprioridadPrecio"></span>
        <label>Categoria:</label> 
        <div id="list-editcategorias"></div>
        <label>Sub Categoria:</label> 
        <div id="list-editsubcategorias"></div>        
        <label>Modelo:</label> 
        <div id="list-editmodelos"></div>
        <input id="ipteditmodelo_id" type="hidden" name="modelo_id" >
        
        <label>Tamaño:</label> 
        <div id="list-edittamanos"></div>
        <input id="iptedittamano_id" type="hidden" name="tamano_id" >
         
        <button id="editdireccionessave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>       
    </form>
</div>
<!-- VER -->
<div id="ver" title="Ver Direccione" >
     <!--<button id="btnaddfoto" class="botones">Agregar nueva Imagen</button>-->
    <table>
        <tr><td><label id="verdireccione"></label></td></tr>
    </table>
    <div id="imagenes"></div>
</div>


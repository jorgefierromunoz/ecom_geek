<script>
    $(document).ready(function() {
        iddireccionesglobal = 0;
        //LISTA 
        mostrarDatos("id","asc");
        //check add
        $("#addnewfoto").button();
        $("#checkaddppuntos").change(function(){
           var opcion=$("#checkaddppuntos").prop("checked");  
           if (opcion){
                $("#iptprioridadPunto").val(opcion);
           }else{
               $("#iptprioridadPunto").val("");
           }
        });
        $("#checkaddprecio").change(function(){
           var opcion=$("#checkaddprecio").prop("checked");  
           if (opcion){
                $("#iptprioridadPrecio").val(opcion);
           }else{
               $("#iptprioridadPrecio").val("");
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
        $("#checkeditprecio").change(function(){
           var opcion=$("#checkeditprecio").prop("checked");  
           if (opcion){
                $("#editprioridadPrecioinput").val(opcion);
           }else{
               $("#editprioridadPrecioinput").val("");
           }
        });
        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-categorias").change(function() {
            if ($("#select-categorias").val()==""){
              $("#list-subcategorias").html("<select id=select-subcategorias><option value=''><-------Sub Categorias-------></option>");
            }
            else{
               llenarlistboxsubCategorias("x", $("#select-categorias").val()); 
            }    
        });
        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-editcategorias").change(function() {
            llenarlistboxsubCategorias("ax", $("#select-editcategorias").val()); 
        });

        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-modelos").change(function() {
            var opcion = $("#select-modelos").val();
            $("#iptmodelo_id").val(opcion);
        });
        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-tamanos").change(function() {
            var opcion = $("#select-tamanos").val();
            $("#ipttamano_id").val(opcion);
        });
       
         //SELECCION DEL COMBOBOX ON CHANGE EDIT
        $("#list-editmodelos").change(function() {
            var opcion = $("#select-editmodelos").val();
            $("#ipteditmodelo_id").val(opcion);
        });
         //SELECCION DEL COMBOBOX ON CHANGE EDIT
        $("#list-edittamanos").change(function() {
            var opcion = $("#select-edittamanos").val();
            $("#iptedittamano_id").val(opcion);
        });
        
        //OPEN DIV NUEVO BUTTON   
        //-----------------------------------
        $("#btnadddirecciones").click(function() {
            $("#list-subcategorias").html("<select id=select-subcategorias><option value=''><-------Sub Categorias-------></option>");
            $("#formadddirecciones").trigger("reset");
            //$("#iptsubCategoria_id").val("");
            $("#iptmodelo_id").val("");
            $("#ipttamano_id").val("");
            $("#iptprioridadPunto").val("");
            $("#iptprioridadPrecio").val("");               
            ocultarspan();
            llenarlistboxCategorias("x");
            llenarlistboxmodelos("x");
            llenarlistboxtamanos("x");
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
                    tabla += '<td>' + item.Direccione.estado +'</td>';
                    tabla += '<td>' + item.User.username +'</td>';
                    tabla += '<td>' + item.Comuna.comuna +'</td>';
//                    if (item.Direccione.prioridadPunto ){
//                       tabla += '<td ><input type=checkbox checked disabled></td>';
//                    }else{
//                        tabla += '<td ><input type=checkbox disabled></td>';
//                    }
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
    //resp =x cuando es add n° cuando es edit 
    function llenarlistboxsubCategorias(resp,idcat) {
        $.ajax({
            url: 'SubCategorias/listasubcategoriasComboBox/'+idcat,
            dataType: 'json',
            type:'POST',
            success: function(data) {     
                    if(data!=""){
                        var list =""; 
                        if (resp=="x") {
                            list = '<select id="select-subcategorias" name="sub_categoria_id"><option value="">Seleccione una Sub Categoria</option>';
                        }else{
                            list ='<select id="select-editsubcategorias" name="sub_categoria_id">';
                        }     
                        $.each(data, function(item) {                        
                            if(resp==data[item].SubCategoria.id){ 
                                list += '<option selected=selected value=' + data[item].SubCategoria.id + '>' + data[item].SubCategoria.subCategoria + '</option>';
                                llenarlistboxCategorias(data[item].Categoria.id);
                            }else{
                                list += '<option value=' +  data[item].SubCategoria.id + '>' + data[item].SubCategoria.subCategoria + '</option>';
                            }                       
                        });
                        list += '</select>';
                        if (resp=="x") {
                            $('#list-subcategorias').html(list);
                        }else{
                            $('#list-editsubcategorias').html(list);
                        }
                    }else{
                        var list = '<select id="select-editsubcategorias"><option>No hay Sub Categorias en la BD</option>';
                        if (resp=="x"){
                            $('#list-subcategorias').html(list);
                        }else{
                             $('#list-editsubcategorias').html(list);
                        }
                    }
               }
         });
    }
    function llenarlistboxCategorias(resp) {
        $.ajax({
            url: 'Categorias/listacategoriasComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
                    if(data!=""){
                    var list =""; 
                        if (resp=="x") {
                            list = '<select id="select-categorias"><option value="">Seleccione una Categoria</option>';
                        }else{
                            list ='<select id="select-editcategorias">';
                        }     
                        $.each(data, function(item) {
                            if(resp==data[item].Categoria.id){ 
                                list += '<option selected=selected value=' + data[item].Categoria.id + '>' + data[item].Categoria.categoria + '</option>';
                            }else{
                                list += '<option value=' +  data[item].Categoria.id + '>' + data[item].Categoria.categoria + '</option>';
                            }                       
                        });
                        list += '</select>';
                        if (resp=="x") {
                            $('#list-categorias').html(list);
                        }else{
                            $('#list-editcategorias').html(list);
                        }
                    }else{
                        var list = '<select id="select-editcategorias"><option>No hay Categorias en la BD</option>';
                        if (resp=="x"){
                             $('#list-categorias').html(list);
                        }else{
                             $('#list-editcategorias').html(list);
                        }
                }
               }
         });
    }
    function llenarlistboxmodelos(resp) {
        $.ajax({
            url: 'Modelos/listamodelosComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
                if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-modelos"><option value="">Seleccione un modelo</option>';
                    }else{
                        list ='<select id="select-editmodelos">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Modelo.id){ 
                            list += '<option selected=selected value=' + data[item].Modelo.id + '>' + data[item].Modelo.modelo + '</option>';
                        }else{
                            list += '<option value=' +  data[item].Modelo.id + '>' +data[item].Modelo.modelo + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-modelos').html(list);
                    }else{
                        $('#list-editmodelos').html(list);
                    }
                }else{
                    var list = '<select id="select-editmodelos"><option>No hay modelos en la BD</option>';
                    if (resp=="x"){
                         $('#list-modelos').html(list);
                    }else{
                         $('#list-editmodelos').html(list);
                    }
                }
               }
         });
    }
     function llenarlistboxtamanos(resp) {
        $.ajax({
            url: 'Tamanos/listatamanosComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
                if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-tamanos"><option value="">Seleccione un tamaño</option>';
                    }else{
                        list ='<select id="select-edittamanos">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Tamano.id){ 
                            list += '<option selected=selected value=' + data[item].Tamano.id + '>' + data[item].Tamano.tamano + '</option>';
                        }else{
                            list += '<option value=' +  data[item].Tamano.id + '>' +data[item].Tamano.tamano + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-tamanos').html(list);
                    }else{
                        $('#list-edittamanos').html(list);
                    }
                }else{
                    var list = '<select id="select-edittamanos"><option>No hay tamaños en la BD</option>';
                    if (resp=="x"){
                         $('#list-tamanos').html(list);
                    }else{
                         $('#list-edittamanos').html(list);
                    }
                }
               }
         });
    }
    function ocultarspan(){   
        $("#spnadddirecciones").hide();
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
<button  id="btnadddirecciones" class="botones">Nuevo Direccione</button>
<div id="divadddirecciones" title="Nuevo Direccione"> 
    <form id="formadddirecciones" method="POST">
        <label>Nombre del Direccione:</label> 
        <input id="iptdirecciones" type="text" name="direccione">
        <span id="spnadddirecciones"></span> 
        <label>Descripción:</label> 
        <input id="iptdescripcion" type="text" name="descripcion">
        <span id="spnadddescripcion"></span> 
        <label>Stock:</label> 
        <input id="iptstock" type="text" name="stock">
        <span id="spnaddstock"></span> 
        <label>Precio:</label> 
        <input id="iptprecio" type="text" name="precio">
        <span id="spnaddprecio"></span> 
        <label>Precio Punto:</label> 
        <input id="iptprecioPunto" type="text" name="precioPunto">
        <span id="spnaddprecioPunto"></span>
        <br>
        <input type="checkbox" id="checkaddppuntos"><label for="check">Prioridad Puntos</label>
        <input id="iptprioridadPunto" type="hidden" name="prioridadPunto">
        <span id="spnaddprioridadPunto"></span>
        <br>
        <input type="checkbox" id="checkaddprecio"><label for="check">Prioridad Precio</label> 
        <input id="iptprioridadPrecio" type="hidden" name="prioridadPrecio">
        <span id="spnaddprioridadPrecio"></span>
        <br>
        <label>Categoria:</label> 
        <div id="list-categorias"></div>
        
        <label>Sub Categoria:</label> 
        <div id="list-subcategorias"></div>         
      
        <label>Modelos:</label> 
        <div id="list-modelos"></div>
        <input id="iptmodelo_id" type="hidden" name="modelo_id" >
        
        <label>Tamaño:</label> 
        <div id="list-tamanos"></div>
        <input id="ipttamano_id" type="hidden" name="tamano_id" >
        
        <button id="adddireccionessave">Guardar</button>
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


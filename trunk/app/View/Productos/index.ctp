<script>
    $(document).ready(function() {
        idproductosglobal = 0;
        //LISTA 
        mostrarDatos();
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
        $("#list-subcategorias").change(function() {
            var opcion = $("#select-subcategorias").val();
            $("#iptsubCategoria_id").val(opcion);
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
        $("#list-editsubcategorias").change(function() {
            var opcion = $("#select-editsubcategorias").val();
            $("#ipteditsubCategoria_id").val(opcion);
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
        $("#btnaddproductos").click(function() {
            $("#formaddproductos").trigger("reset");
            $("#iptsubCategoria_id").val("");
            $("#iptmodelo_id").val("");
            $("#ipttamano_id").val("");
            $("#iptprioridadPunto").val("");
            $("#iptprioridadPrecio").val("");               
            ocultarspan();
            llenarlistboxsubCategorias("x");
            llenarlistboxmodelos("x");
            llenarlistboxtamanos("x");
            $("#divaddproductos").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES     
        $(document).on("click", ".editar", function() {
            ocultarspan();            
            idproductosglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Productos/view/' + idproductosglobal,
                dataType: 'json',
                type: "POST",
                success: function(data) {
                    $("#editproductosinput").val(data.Producto.producto);
                    $("#editdescripcioninput").val(data.Producto.descripcion);
                    $("#editstockinput").val(data.Producto.stock);
                    $("#editprecioinput").val(data.Producto.precio);
                    $("#editprecioPuntoinput").val(data.Producto.precioPunto);
                    if (data.Producto.prioridadPunto){
                        $("#editprioridadPuntoinput").val(data.Producto.prioridadPunto);
                        $("#checkeditppuntos").prop("checked", true);
                    }else{
                         $("#editprioridadPuntoinput").val("");
                         $("#checkeditppuntos").prop("checked", false);
                    }
                     if (data.Producto.prioridadPrecio){
                        $("#editprioridadPrecioinput").val(data.Producto.prioridadPrecio);
                        $("#checkeditprecio").prop("checked", true);
                    }else{
                         $("#editprioridadPrecioinput").val("");
                         $("#checkeditprecio").prop("checked", false);
                    }
                    $("#ipteditsubCategoria_id").val(data.Producto.sub_categoria_id);
                    $("#ipteditmodelo_id").val(data.Producto.modelo_id);
                    $("#iptedittamano_id").val(data.Producto.tamano_id);               
                    llenarlistboxsubCategorias(data.Producto.sub_categoria_id);
                    llenarlistboxmodelos(data.Producto.modelo_id);
                    llenarlistboxtamanos(data.Producto.tamano_id);
                    $("#diveditproductos").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });
        });
        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddproductos").dialog({
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
         $('#formaddproductos').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditproductos").dialog({
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
        $('#formeditproductos').submit(function(e) {
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
        $("#addproductossave").click(function(e) {
            e.preventDefault();
              if ( $("#iptproductos").val().trim().length == 0) {
                $("#spnaddproductos").html("Campo requerido");
                $("#spnaddproductos").show();
                $("#spnaddalert").show();
                
              }else if ( $("#iptdescripcion").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptstock").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptprecio").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptprecioPunto").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#iptsubCategoria_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#iptmodelo_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#ipttamano_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: "Productos/add",
                    type: "POST",
                    data: $("#formaddproductos").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1){
                           $("#formaddproductos").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddproductos").dialog("close");
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
        $("#editproductossave").click(function(e) {      
            e.preventDefault();
            if ( $("#editproductosinput").val().trim().length == 0) {
                $("#spneditproductos").html("Campo requerido");
                $("#spneditproductos").show();
                $("#spnaddalert").show();
              }else if ( $("#editdescripcioninput").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#editstockinput").val().trim().length == 0) {
                $("#spnaddalert").show(); 
              }else if ( $("#editprecioinput").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#editprecioPuntoinput").val().trim().length == 0) {
                $("#spnaddalert").show();
              }else if ( $("#ipteditsubCategoria_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#ipteditmodelo_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#iptedittamano_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: 'Productos/edit/' + idproductosglobal,
                    type: "POST",
                    data: $("#formeditproductos").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1) {
                            mostrarDatos();
                            alert("Editado con exito");
                            $("#formeditproductos").trigger("reset");
                            $("#diveditproductos").dialog("close");
                        }else if (n==0){
                            $("#spneditproductos").html("No se pudo editar, intentelo de nuevo");
                            $("#spneditproductos").show();                                                  
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
            idproductosglobal = $(this).attr('data-id');
            $.ajax({
                url: "Productos/delete/" + idproductosglobal,
                type: "POST",
                dataType:'json',
                success: function(n) {
                    if (n=='t'){          
                        alert("Producto id: " + idproductosglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else{
                        alert("No se puede eliminar por que hay " + n + " foto(s) asociada(s)");   
                    }
                }
            });
        });
        //VER BUTTON 
        $(document).on("click", ".ver", function(e) {
            e.preventDefault();
            idproductosglobal = $(this).attr('data-id');
            $.ajax({
                url: "Productos/ver/" + idproductosglobal,
                type: "POST",
                dataType:'json',
                success: function(data) {
                    $("#verproducto").html("Producto: " + data.Producto.producto);
                    $("#iptproducto_id").val(data.Producto.id);
                    var listaproductos='';
                    $.each(data.Foto, function(item) {
                        listaproductos += '<article class="productos">';
                        listaproductos += '<img src="img/Fotos/' + data.Foto[item].url + '" height="100px" width="100px">';
                        listaproductos += '</article>';
                    });
                    
                    $("#imagenes").html(listaproductos);
                    $("#ver").dialog("open");
                }
            });
         });
         
   });     
    //LISTAR
    function mostrarDatos() {
        $.ajax({
            url: 'Productos/listaproductos',
            type: 'POST',
            dataType: 'json',
                beforeSend: function() {
                $('#listaproductos').html("Llenando datos...");
            },
            success: function(data) {
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Producto</th><th>Descripción</th><th>Stock</th><th>Precio</th><th>Precio Puntos</th><th>Prioridad Puntos</th>';
                tabla += '<th>Prioridad Precio</th><th>Sub Categoria</th><th>Modelo</th><th>Tamaño</th><th>Ver</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Producto.id + '</td>';
                    tabla += '<td>' + item.Producto.producto + '</td>';
                    tabla += '<td>' + item.Producto.descripcion +'</td>';
                    tabla += '<td>' + item.Producto.stock +'</td>';
                    tabla += '<td>' + item.Producto.precio +'</td>';
                    tabla += '<td>' + item.Producto.precioPunto +'</td>';
                    if (item.Producto.prioridadPunto ){
                       tabla += '<td ><input type=checkbox checked disabled></td>';
                    }else{
                        tabla += '<td ><input type=checkbox disabled></td>';
                    }
                    if (item.Producto.prioridadPrecio){
                       tabla += '<td ><input type=checkbox checked disabled></td>';
                    }else{
                        tabla += '<td ><input type=checkbox disabled></td>';
                    }                        
                    tabla += '<td>' + item.SubCategoria.subCategoria +'</td>';
                    tabla += '<td>' + item.Modelo.modelo +'</td>';
                    tabla += '<td>' + item.Tamano.tamano +'</td>';
                    tabla += '<td><button type="button" class="ver" data-id="' + item.Producto.id + '">Ver</button></td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Producto.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Producto.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listaproductos').html(tabla);
                }else{
                   tabla = 'No hay productos en la base de datos';
                $('#listaproductos').html(tabla);
                }
            }
        });
    }
    //resp =x cuando es add n° cuando es edit 
    function llenarlistboxsubCategorias(resp) {
        $.ajax({
            url: 'SubCategorias/listasubcategoriasComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
                    if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-subcategorias"><option value="">Seleccione una Sub Categoria</option>';
                    }else{
                        list ='<select id="select-editsubcategorias">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].SubCategoria.id){ 
                            list += '<option selected=selected value=' + data[item].SubCategoria.id + '>' + data[item].SubCategoria.subCategoria + '</option>';
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
        $("#spnaddproductos").hide();
        $("#spnaddalert").hide();
        $("#spneditalert").hide();
    }
/********************************************************************/
//CIERRE        
/********************************************************************/
</script>

<!-- LISTA  -->
<div id="listaproductos"></div>
<!-- AGREGAR  -->
<button  id="btnaddproductos" class="botones">Nuevo Producto</button>
<div id="divaddproductos" title="Nuevo Producto"> 
    <form id="formaddproductos" method="POST">
        <label>Nombre del Producto:</label> 
        <input id="iptproductos" type="text" name="producto">
        <span id="spnaddproductos"></span> 
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
        <label>Sub Categoria:</label> 
        <div id="list-subcategorias"></div>
        <input id="iptsubCategoria_id" type="hidden" name="sub_categoria_id" >
        
        <label>Modelos:</label> 
        <div id="list-modelos"></div>
        <input id="iptmodelo_id" type="hidden" name="modelo_id" >
        
        <label>Tamaño:</label> 
        <div id="list-tamanos"></div>
        <input id="ipttamano_id" type="hidden" name="tamano_id" >
        
        <button id="addproductossave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditproductos" title="Editar Productos">
    <form id="formeditproductos" method="POST">
        <label>Producto: </label>
        <input id="editproductosinput" type="text" name="producto">
        <span id="spneditproductos"></span>        
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
      
         <label>Sub Categoria:</label> 
        <div id="list-editsubcategorias"></div>
        <input id="ipteditsubCategoria_id" type="hidden" name="sub_categoria_id" >
        
        <label>Modelo:</label> 
        <div id="list-editmodelos"></div>
        <input id="ipteditmodelo_id" type="hidden" name="modelo_id" >
        
        <label>Tamaño:</label> 
        <div id="list-edittamanos"></div>
        <input id="iptedittamano_id" type="hidden" name="tamano_id" >
         
        <button id="editproductossave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>       
    </form>
</div>
<!-- VER -->
<div id="ver" title="Ver Producto" >
     <!--<button id="btnaddfoto" class="botones">Agregar nueva Imagen</button>-->
    <table>
        <tr><td><label id="verproducto"></label></td></tr>
    </table>
    <div id="imagenes"></div>
</div>


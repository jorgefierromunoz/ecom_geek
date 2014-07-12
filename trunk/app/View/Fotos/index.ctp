<script>
    $(document).ready(function() {
        idfotoglobal = 0;
        //LISTA 
        mostrarDatos();
        //SELECCION DEL COMBOBOX ON CHANGE  ADD
        $("#list-productos").change(function() {
        var opcion = $("#select-productos").val();
        $("#iptproducto_id").val(opcion);
        });
        //SELECCION DEL COMBOBOX ON CHANGE  EDIT
        $("#list-editproductos").change(function() {
            var opcion = $("#select-editproductos").val();
            $("#ipteditproducto_id").val(opcion);
        });
         //SELECCION DE IMAGENES AGREGAR 
        $('#imagenefile').change(function() {
            var fileName = $('#imagenefile').val();
            var clean = fileName.split('\\').pop(); // clean from C:\fakepath OR C:\fake_path 
            $("#iptfoto").val(clean);
        });
        //OPEN DIV NUEVA  BUTTON
        //-----------------------------------
        $("#btnaddfoto").click(function() {
            $("#formaddfoto").trigger("reset");
            $("#iptproducto_id").val("");
            $("#imagenefile").val("");            
            ocultarspan();
            llenarlistboxproductos("x");
            $("#divaddfoto").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idfotoglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Fotos/view/' + idfotoglobal,
                dataType: 'json',
                type: "POST",
                success: function(data) {
                    console.log(data);
                    //   ipteditproducto_id
                    $("#editfotoinput").val(data.Foto.url);
                    $("#editmimeinput").val(data.Foto.mime);
                    $("#editdescripcioninput").val(data.Foto.descripcion);                  
                    $("#ipteditproducto_id").val(data.Foto.producto_id);
                    llenarlistboxproductos(data.Foto.producto_id);
                    $("#diveditfoto").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });
        });
        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddfoto").dialog({
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
         $('#formaddfoto').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditfoto").dialog({
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
        $('#formeditfoto').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#addfotosave").click(function(e) {            
            e.preventDefault();
              if ( $("#iptfoto").val().trim().length == 0) {
                $("#spnaddfoto").html("Elija una imagen");
                $("#spnaddfoto").show();
                $("#spnaddalert").show();
              }else if ( $("#iptmime").val().trim().length == 0) {
                $("#spnaddmime").html("Campo requerido");
                $("#spnaddmime").show();
                $("#spnaddalert").show();
              }else if ( $("#iptdescripcion").val().trim().length == 0) {
                $("#spnadddescripcion").html("Campo requerido");
                $("#spnadddescripcion").show();
                $("#spnaddalert").show();
              }else if ( $("#iptproducto_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else {
               $("#prog").show();
                $("#imagenefile").upload("Fotos/subirimagen", function(e) {
                if (e=="1"){
                $.ajax({
                    url: "Fotos/add",
                    type: "POST",
                    data: $("#formaddfoto").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1){
                           $("#formaddfoto").trigger("reset"); 
                            mostrarDatos(); 
                           $("#divaddfoto").dialog("close");
                        }else if (n==0){
                            alert("No se pudo guardar los datos de la foto, intentelo de nuevo");
                        }
                    },
                    error: function(n) {
                        console.log(n);
                    }
                });
                    }else{
                        alert("Foto no valida, debe pesar menos de 2 mb");
                    }
                    $("#prog").hide();
                }, $("#prog"));    
             

             }
        });
        /****************************************************/
        /****************************************************/
        //EDITAR BUTTON DIALOG  
        $("#editfotosave").click(function(e) {      
            e.preventDefault();
            if ( $("#editfotoinput").val().trim().length == 0) {
                $("#spneditfoto").html("Seleccione una imagen");
                $("#spneditfoto").show();
                $("#spnaddalert").show();
              }else if ( $("#editmimeinput").val().trim().length == 0) {
                $("#spneditmime").html("Campo requerido");
                $("#spneditmime").show();
                $("#spnaddalert").show();
              }else if ( $("#editdescripcioninput").val().trim().length == 0) {
                $("#spneditdescripcion").html("Campo requerido");
                $("#spneditdescripcion").show();
                $("#spnaddalert").show();
              }
              else if ( $("#ipteditproducto_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: 'Fotos/edit/' + idfotoglobal,
                    type: "POST",
                    data: $("#formeditfoto").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1) {
                            mostrarDatos();
                            alert("Editado con exito");
                            $("#formeditfoto").trigger("reset");
                            $("#diveditfoto").dialog("close");
                        }else if (n==0){
                            $("#spneditfoto").html("No se pudo editar, intentelo de nuevo");
                            $("#spneditfoto").show();                                                  
                        }
                    }
                 });
              }
        });
        /****************************************************/
        /****************************************************/
        //ELIMINAR BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idfotoglobal = $(this).attr('data-id');
            $.ajax({
                url: "Fotos/delete/" + idfotoglobal,
                type: "POST",
                dataType:'json',
                success: function(n) {
                    if (n==1){          
                        alert("Foto id: " + idfotoglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else if (n==2){
                        alert("No se pudo eliminar");   
                    }
                    
                }
            });
        });
    });
    //LISTAR 
    function mostrarDatos() {
        $.ajax({
            url: 'Fotos/listafotos',
            type: 'POST',
            dataType: 'json',
                beforeSend: function() {
                $('#listafotos').html("Llenando datos...");
            },
            success: function(data) {
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Imagen</th><th>Nombre</th><th>Mime</th><th>Descripcion</th><th>Producto</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Foto.id + '</td>';
                    tabla += '<td><img src="img/Fotos/' + item.Foto.url + '" height="100px" width="100px"></td>';
                    tabla += '<td>' + item.Foto.url + '</td>';
                    tabla += '<td>' + item.Foto.mime + '</td>';
                    tabla += '<td>' + item.Foto.descripcion + '</td>';
                    tabla += '<td>'+ item.Producto.producto +'</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' +  item.Foto.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' +  item.Foto.id  + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listafotos').html(tabla);
                }else{
                   tabla = 'No hay fotos en la base de datos';
                $('#listafotos').html(tabla);
                }
            }
        });
    }
    function llenarlistboxproductos(resp) {
        $.ajax({
            url: 'Productos/listaproductosComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-productos"><option value="">Seleccione un Producto</option>';
                    }else{
                        list ='<select id="select-editproductos">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Producto.id){ 
                            list += '<option selected=selected value=' + data[item].Producto.id + '>' + data[item].Producto.producto + '</option>';
                        }else{
                            list += '<option value=' + data[item].Producto.id + '>' + data[item].Producto.producto + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-productos').html(list);
                    }else{
                        $('#list-editproductos').html(list);
                    }
                }else{
                    var list = '<select id="select-productos"><option>No hay productos en la BD</option>';
                    if (resp=="x"){
                         $('#list-productos').html(list);
                    }else{
                         $('#list-editproductos').html(list);
                    }
                }
               }
         });
    }
    function ocultarspan(){       
        $("#spnaddfoto").hide();   
        $("#spnaddmime").hide();   
        $("#spnadddescripcion").hide(); 
        $("#spnaddalert").hide(); 
        $("#spneditfoto").hide(); 
        $("#spneditmime").hide(); 
        $("#spneditdescripcion").hide();
        $("#spneditalert").hide();
        $("#prog").hide();
    }
/********************************************************************/
//CIERRE        
/********************************************************************/
</script>

<!-- LISTA  -->
<div id="listafotos"></div>
 
<!-- AGREGAR  -->
<button  id="btnaddfoto" class="botones">Nueva Foto</button>
<div id="divaddfoto" title="Nueva Foto"> 
    <form id="formaddfoto" method="POST">
        <label>URL:</label> 
        <input type="file" id="imagenefile" name="imagen" /><br>
        <progress id="prog" value="0" min="0" max="100"></progress><br>
        <input id="iptfoto" type="hidden" name="url">
        <span id="spnaddfoto"></span> 
        <label>mime:</label> 
        <input id="iptmime" type="text" name="mime">
        <span id="spnaddmime"></span> 
        <label>descripcion:</label> 
        <input id="iptdescripcion" type="text" name="descripcion">
        <span id="spnadddescripcion"></span> 
        <label>Producto:</label> 
        <div id="list-productos"></div>        
        <input id="iptproducto_id" type="hidden" name="producto_id" >
        <button id="addfotosave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditfoto" title="Editar Fotos">
    <form id="formeditfoto" method="POST">
        <label> URL: </label>
        <input id="editfotoinput" type="text" name="url" disabled>
        <span id="spneditfoto"></span>
        <label> Mime: </label>
        <input id="editmimeinput" type="text" name="mime">
        <span id="spneditmime"></span>
        <label> Descripcion: </label>
        <input id="editdescripcioninput" type="text" name="descripcion">
        <span id="spneditdescripcion"></span>
        <label>Producto:</label> 
        <div id="list-editproductos"></div>        
        <input id="ipteditproducto_id" type="hidden" name="producto_id" >
        <button id="editfotosave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
    </form>
</div>
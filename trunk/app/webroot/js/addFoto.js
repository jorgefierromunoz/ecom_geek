$(document).ready(function() {
        idfotoglobal = 0;
        //LISTA 
        mostrarDatos();
        $(".botones").button();
        
        $("#checkededitimagen").change(function(){
           var opcion=$("#checkededitimagen").prop("checked");  
           if (opcion){
                $("#imagenefileedit").removeAttr("disabled");
                $("#editfotoinput").removeAttr("disabled");
           }else{
               $("#imagenefileedit").attr("disabled",true);
               $("#editfotoinput").attr("disabled",true);
           }
        });
         //SELECCION DE IMAGENES AGREGAR 
        $('#imagenefile').change(function() {
            $("#iptfoto").val(limpiarNombre($('#imagenefile').val()));
        });
         //SELECCION DE IMAGENES EDITAR
        $('#imagenefileedit').change(function() {
            $("#editfotoinput").val(limpiarNombre($('#imagenefileedit').val()));
        });
        //OPEN DIV NUEVA  BUTTON
        //-----------------------------------
        $("#btnaddfoto").click(function() {
            $("#formaddfoto").trigger("reset");
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
                beforeSend: function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    var urlfoto=data.Foto.url;
                    $("#editfotoinput").val(urlfoto.substring(0, urlfoto.indexOf('.')));
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
        //nueva imagen
        $("#addfotosave").click(function(e) {            
        e.preventDefault();
        //imagenefile
          if ( $("#iptfoto").val().trim().length == 0) {
            $("#spnaddfoto").html("Elija una imagen");
            $("#spnaddfoto").show();
            $("#spnaddalert").show();
          }else if ( $("#imagenefile").val().trim().length == 0){
            $("#spnaddalert").show();
          }else if ( $("#select-productos").val().trim().length == 0){
            $("#spnaddalert").show();
          }else {
           $("#prog").show();
           $("#imagenefile").upload("Fotos/subirimagen",{url:$("#iptfoto").val(),producto_id:$("#select-productos").val()} ,function(listo) {
                if (listo=="1"){
                    $("#formaddfoto").trigger("reset"); 
                    mostrarDatos(); 
                    $("#divaddfoto").dialog("close");
                }else{
                    $("#spnaddfoto").html(listo);
                    $("#spnaddfoto").show();
                    $("#spnaddalert").show();
                }
                $("#prog").hide();
            }, $("#prog"));    


         }
    });       
        //EDITAR
        $("#editfotosave").click(function(e) {      
            e.preventDefault();
            if ( $("#editfotoinput").val().trim().length == 0) {
                $("#spneditfoto").html("Escriba un nombre para la imagen");
                $("#spneditfoto").show();
                $("#spneditalert").show();
              }else if ( $("#select-editproductos").val().trim().length == 0){
                $("#spneditalert").show();
              }else{
                  if($("#checkededitimagen").prop("checked")){                      
                       if ( $("#imagenefileedit").val().trim().length == 0) {
                            $("#spneditfoto").html("Debe elegir una imagen para editarla");
                            $("#spneditfoto").show(); 
                       }else{
                           //BORRAR IMAGEN ANTIGUA DEL SERVIDOR
                           $("#progedit").show();
                           $("#imagenefileedit").upload("Fotos/edit/"+idfotoglobal+"/0",{url:$("#editfotoinput").val(),idproducto:$("#select-editproductos").val()} ,function(resp) {
                               if(resp==1){
                                    mostrarDatos();
                                    alert("Editado con exito");
                                    $("#formeditfoto").trigger("reset");
                                    $("#diveditfoto").dialog("close");
                               }
                               else{
                                   alert(resp);
                               }
                           },$("#progedit"));    
                       }

                  }else{
                    $.ajax({
                    url: 'Fotos/edit/' + idfotoglobal,
                    type: "POST",
                    data: {idproducto:$("#select-editproductos").val()},
                    beforeSend: function(){ $("#cargando").dialog("open");},                    
                    dataType:'json',
                    success: function(n) {
                        if (n==1) {
                            mostrarDatos();
                            alert("Editado con exito");
                            $("#formeditfoto").trigger("reset");
                            $("#diveditfoto").dialog("close");
                        }else{
                            $("#spneditfoto").html(n);
                            $("#spneditfoto").show();                                                  
                        }
                    }
                 }); 
                  }
                
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
                beforeSend: function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1){          
                        alert("Foto id: " + idfotoglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else if (n==0){
                        alert("No se pudo eliminar registro");   
                    }else if (n==2){
                         alert("Foto id: " + idfotoglobal + " eliminada con éxito");               
                         mostrarDatos();                    
                     }else if (n==-1){
                         alert("No se pudo eliminar registro");   
                         console.log("No se pudo eliminar imagen");
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
            beforeSend: function(){ $("#cargando").dialog("open");},  
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Imagen</th><th>Nombre</th><th>Mime</th><th>Descripción</th><th>Producto</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Foto.id + '</td>';
                    tabla += '<td><img src="img/Fotos/s_' + item.Foto.url + '" height=100px width=100px></td>';
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
            beforeSend: function(){ $('#list-productos').html("Recuperando datos...");
                                    $('#list-editproductos').html("Recuperando datos...");},
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-productos" name=producto_id ><option value="">Seleccione un Producto</option>';
                    }else{
                        list ='<select id="select-editproductos" name=producto_id >';
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
        $("#spnaddalert").hide(); 
        $("#spneditfoto").hide(); 
        $("#spneditalert").hide();
        $("#prog").hide();
        $("#progedit").hide();
        
    }
    function limpiarNombre(nombre){
        var e=nombre.split('\\').pop();
        return e.substring(0, e.indexOf('.'));
    }
$(document).ready(function() {
        idfotoglobal = 0;
        //LISTA 
        mostrarDatos();
        $(".botones").button();
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
        //13-08-2014
        //else if ( $("#iptmime").val().trim().length == 0) {
         //   $("#spnaddmime").html("Campo requerido");
         //   $("#spnaddmime").show();
         //   $("#spnaddalert").show();
         // }
        $("#addfotosave").click(function(e) {            
        e.preventDefault();
          if ( $("#iptfoto").val().trim().length == 0) {
            $("#spnaddfoto").html("Elija una imagen");
            $("#spnaddfoto").show();
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
        //EDITAR BUTTON DIALOG  
        //13-08-2014
//        else if ( $("#editmimeinput").val().trim().length == 0) {
//                $("#spneditmime").html("Campo requerido");
//                $("#spneditmime").show();
//                $("#spnaddalert").show();
//              }
        $("#editfotosave").click(function(e) {      
            e.preventDefault();
            if ( $("#editfotoinput").val().trim().length == 0) {
                $("#spneditfoto").html("Seleccione una imagen");
                $("#spneditfoto").show();
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
                    console.log(n);
                    if (n==1){          
                        alert("Foto id: " + idfotoglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else if (n==0){
                        alert("No se pudo eliminar registro");   
                    }else if (n==2){
                         alert("Foto id: " + idfotoglobal + " eliminada con éxito");               
                         mostrarDatos();
                         console.log("No se pudo eliminar imagen");
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
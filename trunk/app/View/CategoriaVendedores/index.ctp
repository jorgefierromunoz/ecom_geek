<script>
    $(document).ready(function() {
        idcatvendglobal = 0;
        //LISTA
        mostrarDatos("id","asc");
        //OPEN DIV NUEVO BUTTON
        //-----------------------------------
        $("#btnaddcatvend").click(function() {
            $("#formaddcatvend").trigger("reset");
            ocultarspan();
            $("#divaddcatvend").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idcatvendglobal = $(this).attr('data-id');
            $.ajax({
                url: 'CategoriaVendedores/view/' + idcatvendglobal,
                dataType: 'json',
                type: "POST",
                beforeSend: function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editcatvendinput").val(data.CategoriaVendedore.categoriaVendedor);
                    $("#editporcentajeinput").val(data.CategoriaVendedore.porcentaje);
                    $("#diveditcatvend").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddcatvend").dialog({
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
         $('#formaddcatvend').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditcatvend").dialog({
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
        $('#formeditcatvend').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG 
        $("#addcatvendsave").click(function(e) {
            e.preventDefault();
             if ( $("#iptcategoriaVendedor").val().trim().length == 0 ) {
                $("#spnaddcatvend").html("Campo requerido");
                $("#spnaddcatvend").show();                
                $("#spnaalert").show();
            }else if ( $("#iptporcentaje").val().trim().length == 0 ) {
                $("#spnaddporcentaje").html("Campo requerido");
                $("#spnaddporcentaje").show();                
                $("#spnaalert").show();
            }else{
                $.ajax({
                    url: "CategoriaVendedores/add",
                    type: "POST",
                    beforeSend: function(){ $("#cargando").dialog("open");},
                    data: $("#formaddcatvend").serialize(),
                    dataType:'json',
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddcatvend").trigger("reset");                           
                           mostrarDatos("id","asc");
                           $("#divaddcatvend").dialog("close");
                        }else if (n==0){
                            alert("No se pudo guardar, intentelo de nuevo");
                            $("#spnaalert").show();
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
        $("#editcatvendsave").click(function(e) {      
            e.preventDefault();
            if ( $("#editcatvendinput").val().trim().length == 0 ) {
                $("#spneditcatvend").html("Campo requerido");
                $("#spneditcatvend").show();
                $("#spnaalertedit").show();
            }else if ( $("#editporcentajeinput").val().trim().length == 0 ) {
                $("#spneditporcentaje").html("Campo requerido");
                $("#spneditporcentaje").show();
                $("#spnaalertedit").show();
            }else{
            $.ajax({
                url: 'CategoriaVendedores/edit/' + idcatvendglobal,
                type: "POST",
                data: $("#formeditcatvend").serialize(),
                dataType:'json',
                beforeSend: function(){ $("#cargando").dialog("open");},                
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1) {
                        mostrarDatos("id","asc");
                        $("#formeditcatvend").trigger("reset");
                        $("#diveditcatvend").dialog("close");
                        alert("Editado con éxito");                       
                    }else if (n==0){
                        alert("No se pudo editar, intentelo de nuevo");                                                
                    }
                }
            });
            } 

        });
        /****************************************************/
        /****************************************************/
         //ELIMINAR CATEGORIA BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idcatvendglobal = $(this).attr('data-id');
            $.ajax({
                url: "CategoriaVendedores/delete/" + idcatvendglobal,
                type: "POST",
                dataType:'json',
                beforeSend: function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){          
                        alert("La Categoria del Vendedor id: " + idcatvendglobal + " fue eliminada con éxito");               
                        mostrarDatos("id","asc");
                    }else{
                        alert("No se puede eliminar por que hay " + n + " usuario(s) asociado(s)");   
                    }
                }
            });
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
    //LISTAR
    function mostrarDatos(atributo,orden) {
        $.ajax({
            url: 'CategoriaVendedores/listacatvendedores/CategoriaVendedore.'+atributo+'/'+orden,
            type: 'POST',
            dataType: 'json',
            beforeSend: function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th class=ordenar data-id=id>Id</th><th class=ordenar data-id=categoriaVendedor>Categoria del vendedor</th><th class=ordenar data-id=porcentaje>Porcentaje</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.CategoriaVendedore.id + '</td>';
                    tabla += '<td>' + item.CategoriaVendedore.categoriaVendedor + '</td>';
                    tabla += '<td>' + item.CategoriaVendedore.porcentaje + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.CategoriaVendedore.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.CategoriaVendedore.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listacategoriavendedores').html(tabla);
                }else{
                   tabla = 'No hay Categorias de Vendedores en la base de datos';
                $('#listacategoriavendedores').html(tabla);
                }
            }
        });
    }
    function ocultarspan(){
        $("#spnaddcatvend").hide();
        $("#spnaddporcentaje").hide();       
        $("#spnaalert").hide(); 
        
        $("#spneditcatvend").hide();
        $("#spneditporcentaje").hide(); 
        $("#spnaalertedit").hide();
          
    }
/********************************************************************/
//CIERRE
/********************************************************************/
</script>

<div class="contbotones">
   <button  id="btnaddcatvend" class="botones">Nueva Categoria-Vendedor</button> 
</div>
<!-- LISTA -->
<div id="listacategoriavendedores"></div>
<!-- AGREGAR -->
<div id="divaddcatvend" title="Nueva Categoria-Vendedor"> 
    <form id="formaddcatvend" method="POST">
        <label>Categoria del vendedor:</label> 
        <input id="iptcategoriaVendedor" type="text" name="categoriaVendedor">
        <span id="spnaddcatvend"></span><br>
        <label>Porcentaje:</label> 
        <input id="iptporcentaje" type="text" name="porcentaje">
        <span id="spnaddporcentaje"></span><br>
        <button id="addcatvendsave">Guardar</button>
        <span id="spnaalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR -->
<div id="diveditcatvend" title="Editar Categoria del Vendedor">
    <form id="formeditcatvend" method="POST">
        <label> Categoria del Vendedor: </label>
        <input id="editcatvendinput" type="text" name="categoriaVendedor">
        <span id="spneditcatvend"></span><br>
        <label> Porcentaje: </label>
        <input id="editporcentajeinput" type="text" name="porcentaje">
        <span id="spneditporcentaje"></span><br>  
        <button id="editcatvendsave">Guardar</button>
        <span id="spnaalertedit">Debe llenar los campos correctamente</span>
    </form>
</div>
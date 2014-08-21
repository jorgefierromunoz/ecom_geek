<script>
    $(document).ready(function() {
        idzonaglobal = 0;
        //LISTA
        mostrarDatos();
        //OPEN DIV NUEVO BUTTON
        //-----------------------------------
        $("#btnaddzona").click(function() {
            $("#formaddzona").trigger("reset");
            ocultarspan();
            $("#divaddzona").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idzonaglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Zonas/view/' + idzonaglobal,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editzonainput").val(data.Zona.zona);
                    $("#editprecioinput").val(data.Zona.precio);
                    $("#editpreciopuntosinput").val(data.Zona.precioPunto);
                    $("#diveditzona").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddzona").dialog({
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
         $('#formaddzona').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditzona").dialog({
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
        $('#formeditzona').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#addzonasave").click(function(e) {
            e.preventDefault();
             if ( $("#iptzona").val().trim().length == 0 ) {
                $("#spnaddzona").html("Campo requerido");
                $("#spnaddzona").show();                
                $("#spnaalert").show();
            }else if ( $("#iptprecio").val().trim().length == 0 ){
                $("#spnaddprecio").html("Campo requerido");
                $("#spnaddprecio").show();
                $("#spnaalert").show();
            }else if ( $("#iptpreciopuntos").val().trim().length == 0 ){
                $("#spnaddpreciopuntos").html("Campo requerido");
                $("#spnaddpreciopuntos").show();
                $("#spnaalert").show();
            }else{
                $.ajax({
                    url: "Zonas/add",
                    type: "POST",
                    data: $("#formaddzona").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddzona").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddzona").dialog("close");
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
        $("#editzonasave").click(function(e) {      
            e.preventDefault();
            if ( $("#editzonainput").val().trim().length == 0 ) {
                $("#spneditzona").html("Campo requerido");
                $("#spneditzona").show();
                $("#spnaalertedit").show();
            }else if ( $("#editprecioinput").val().trim().length == 0 ){
                $("#spneditprecio").html("Campo requerido");
                $("#spneditprecio").show();
                $("#spnaalertedit").show();
            }else if ( $("#editpreciopuntosinput").val().trim().length == 0 ){
                $("#spneditpreciopuntos").html("Campo requerido");
                $("#spneditpreciopuntos").show();
                $("#spnaalertedit").show();
            }else{
            $.ajax({
                url: 'Zonas/edit/' + idzonaglobal,
                type: "POST",
                data: $("#formeditzona").serialize(),
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1) {
                        mostrarDatos();
                        $("#formeditzona").trigger("reset");
                        $("#diveditzona").dialog("close");
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
        //ELIMINAR BUTTON 
       $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idzonaglobal = $(this).attr('data-id');
            $.ajax({
                url: "Zonas/delete/" + idzonaglobal,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){          
                        alert("Zona id: " + idzonaglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else{
                        alert("No se puede eliminar por que hay " + n + " comuna(s) asociada(s)");   
                    }
                }
            });
        });
    });
    //LISTAR
    function mostrarDatos() {
        $.ajax({
            url: 'Zonas/listazonas',
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Zonas</th><th>Precio</th><th>Precio en Puntos</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Zona.id + '</td>';
                    tabla += '<td>' + item.Zona.zona + '</td>';
                    tabla += '<td>' + item.Zona.precio + '</td>';
                    tabla += '<td>' + item.Zona.precioPunto + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Zona.id  + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Zona.id  + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listazonas').html(tabla);
                }else{
                   tabla = 'No hay zonas en la base de datos';
                $('#listazonas').html(tabla);
                }
            }
        });
    }
    function ocultarspan(){
        $("#spnaddzona").hide();
        $("#spnaddprecio").hide();
        $("#spnaddpreciopuntos").hide(); 
        $("#spnaalert").hide();
        $("#spneditzona").hide();
        $("#spneditprecio").hide();
        $("#spneditpreciopuntos").hide(); 
        $("#spnaalertedit").hide();
          
    }
/********************************************************************/
//CIERRE 
/********************************************************************/
</script>

<!-- LISTA -->
<div id="listazonas"></div>
<!-- AGREGAR -->
<button  id="btnaddzona" class="botones">Nueva Zona</button>
<div id="divaddzona" title="Nuev Zona"> 
    <form id="formaddzona" method="POST">
        <label>Zona:</label> 
        <input id="iptzona" type="text" name="zona">
        <span id="spnaddzona"></span><br>
        <label>Precio:</label> 
        <input id="iptprecio" type="text" name="precio">
        <span id="spnaddprecio"></span><br>
        <label>Precio Puntos:</label> 
        <input id="iptpreciopuntos" type="text" name="precioPunto">
        <span id="spnaddpreciopuntos"></span><br>
        <button id="addzonasave">Guardar</button>
        <span id="spnaalert">Debe llenar los campos correczonaente</span>
    </form>
</div>

<!--EDITAR -->
<div id="diveditzona" title="Editar Tamaño">
    <form id="formeditzona" method="POST">
        <label>Zona: </label>
        <input id="editzonainput" type="text" name="zona">
        <span id="spneditzona"></span><br>
        <label>Precio:</label> 
        <input id="editprecioinput" type="text" name="precio">
        <span id="spneditprecio"></span><br>
        <label>Precio Puntos:</label> 
        <input id="editpreciopuntosinput" type="text" name="precioPunto">
        <span id="spneditpreciopuntos"></span><br>
        <button id="editzonasave">Guardar</button>
        <span id="spnaalertedit">Debe llenar los campos correczonaente</span>
    </form>

</div>
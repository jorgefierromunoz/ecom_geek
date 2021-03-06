<script>
    $(document).ready(function() {
        idcatglobal = 0;
        //LISTA CATEGORIAS
        mostrarDatos("id","asc");
        //OPEN DIV NUEVA CATEGORIA BUTTON
        //-----------------------------------
        $("#btnaddcat").click(function() {
            $("#formaddcat").trigger("reset");
            $("#spnaddcat").hide();
            $("#divaddcat").dialog("open");
        });
        //OPEN DIV EDIT CATEGORIA 
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            $("#spneditcat").hide();
            idcatglobal = $(this).attr('data-id');
            var nombre="";
            $.ajax({
                url: 'Categorias/view/' + idcatglobal,
                dataType: 'json',
                beforeSend: function(){ $("#cargando").dialog("open");},
                
                type: "POST",
                success: function(data) {
                    $("#cargando").dialog("close");
                    $.each(data, function(item2) {
                        nombre = data[item2].categoria;
                    });
                    $("#editcatinput").val(nombre);
                    $("#diveditcat").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR CATEGORIAS
        $("#divaddcat").dialog({
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
         $('#formaddcat').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditcat").dialog({
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
        $('#formeditcat').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR CATEGORIA BUTTON ADD DIALOG
        $("#addcatsave").click(function(e) {
            e.preventDefault();
              if ( $("#iptcategoria").val().trim().length !== 0 ) {
                $.ajax({
                    url: "Categorias/add",
                    type: "POST",
                    data: $("#formaddcat").serialize(),
                    dataType:'json',
                    beforeSend: function(){ $("#cargando").dialog("open");},
                    
                    success: function(n) {
                       $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddcat").trigger("reset");                           
                           mostrarDatos("id","asc");
                           $("#divaddcat").dialog("close");
                        }else if (n==0){
                            $("#spnaddcat").html("No se pudo guardar, intentelo de nuevo");
                            $("#spnaddcat").show();
                        }
                    },
                    error: function(n) {
                        console.log(n);
                    }
            });
            }else{
            $("#spnaddcat").html("Campo requerido");
            $("#spnaddcat").show();
            }
        });
        /****************************************************/
        /****************************************************/
        //EDITAR CATEGORIA BUTTON DIALOG
        $("#editcatsave").click(function(e) {      
            e.preventDefault();
            if ( $("#editcatinput").val().trim().length !== 0 ) {
            $.ajax({
                url: 'Categorias/edit/' + idcatglobal,
                type: "POST",
                data: $("#formeditcat").serialize(),
                dataType:'json',
                beforeSend: function(){ $("#cargando").dialog("open");},
                
                success: function(n) {
                   $("#cargando").dialog("close");
                    if (n==1) {
                        mostrarDatos("id","asc");
                        alert("Editado con exito");
                        $("#formeditcat").trigger("reset");
                        $("#diveditcat").dialog("close");
                    }else if (n==0){
                        $("#spneditcat").html("No se pudo editar, intentelo de nuevo");
                        $("#spneditcat").show();                                                  
                    }
                }
            });
            }else{
             $("#spneditcat").html("Campo requerido");
             $("#spneditcat").show();
            }

        });
        /****************************************************/
        /****************************************************/
        //ELIMINAR CATEGORIA BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idcatglobal = $(this).attr('data-id');
            $.ajax({
                url: "Categorias/delete/" + idcatglobal,
                type: "POST",
                dataType:'json',
                beforeSend: function(){ $("#cargando").dialog("open");},
                
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){          
                        alert("Categoria id: " + idcatglobal + " eliminada con éxito");               
                        mostrarDatos("id","asc");
                    }else{
                        alert("No se puede eliminar por que hay " + n + " sub-categoria(s) asociada(s)");   
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
    //LISTAR CATEGORIA
    function mostrarDatos(atributo,orden) {
        $.ajax({
            url: 'Categorias/listacategorias/Categoria.'+atributo+'/'+orden,
            type: 'POST',
            dataType: 'json',
            beforeSend: function(){ $("#cargando").dialog("open");},
            
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th class=ordenar data-id=id>Id</th><th class=ordenar data-id=categoria>Categorias</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Categoria.id + '</td>';
                    tabla += '<td>' + item.Categoria.categoria + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Categoria.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Categoria.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listacategorias').html(tabla);
                }else{
                   tabla = 'No hay categorias en la base de datos';
                $('#listacategorias').html(tabla);
                }
            }
        });
    }
/********************************************************************/
//CIERRE CATEGORIAS
/********************************************************************/
</script>
<div class="contbotones">
    <button  id="btnaddcat" class="botones">Nueva Categoria</button>
</div>
<!-- LISTA CATEGORIAS -->
<div id="listacategorias"></div>
<!-- AGREGAR CATEGORIAS -->

<div id="divaddcat" title="Nueva Categoria"> 
    <form id="formaddcat" method="POST">
        <label>Categoria:</label> 
        <input id="iptcategoria" type="text" name="categoria">
        <span id="spnaddcat"></span><br>
        <button id="addcatsave">Guardar</button>
    </form>
</div>

<!--EDITAR CATEGORIAS -->
<div id="diveditcat" title="Editar Categoria">
    <form id="formeditcat" method="POST">
        <label> Nombre: </label>
        <input id="editcatinput" type="text" name="categoria">
        <span id="spneditcat"></span><br>
        <button id="editcatsave">Guardar</button>
    </form>

</div>
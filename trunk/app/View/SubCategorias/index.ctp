<script>
    $(document).ready(function() {
        idsubcatglobal = 0;
        //LISTA SUBCATEGORIAS
        mostrarDatos();
        //SELECCION DEL COMBOBOX ON CHANGE CATEGORIAS ADD
        $("#list-categoria").change(function() {
            var opcion = $("#select-categoria").val();
            $("#iptcategoria_id").val(opcion);
        });
        //SELECCION DEL COMBOBOX ON CHANGE CATEGORIAS EDIT
        $("#list-editcategoria").change(function() {
            var opcion = $("#select-editcategoria").val();
            $("#ipteditcategoria_id").val(opcion);
        });
        //OPEN DIV NUEVA SUBCATEGORIA BUTTON
        //-----------------------------------
        $("#btnaddsubcat").click(function() {
            $("#formaddsubcat").trigger("reset");
            $("#spnaddsubcat").hide();
            llenarlistboxcategorias("x");
            $("#divaddsubcat").dialog("open");
        });
        //OPEN DIV EDIT SUBCATEGORIA 
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            $("#spneditsubcat").hide();
            idsubcatglobal = $(this).attr('data-id');
            $("formedit").trigger("reset");
            $.ajax({
                url: 'SubCategorias/view/' + idsubcatglobal,
                dataType: 'json',
                type: "POST",
                success: function(data) {
                    $("#editsubcatinput").val(data.SubCategoria.subCategoria);
                    $("#ipteditcategoria_id").val(data.SubCategoria.categoria_id);
                    llenarlistboxcategorias(data.SubCategoria.categoria_id);
                    $("#diveditsubcat").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR SUBCATEGORIAS
        $("#divaddsubcat").dialog({
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
         $('#formaddsubcat').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditsubcat").dialog({
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
        $('#formeditsubcat').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR SUBCATEGORIA BUTTON ADD DIALOG
        $("#addsubcatsave").click(function(e) {
            e.preventDefault();
              if ( $("#iptsubcategoria").val().trim().length !== 0 ) {
                $.ajax({
                    url: "SubCategorias/add",
                    type: "POST",
                    data: $("#formaddsubcat").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1){
                           $("#formaddsubcat").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddsubcat").dialog("close");
                        }else if (n==0){
                            $("#spnaddsubcat").html("No se pudo guardar, intentelo de nuevo");
                            $("#spnaddsubcat").show();
                        }
                    },
                    error: function(n) {
                        console.log(n);
                    }
            });
            }else{
            $("#spnaddsubcat").html("Campo requerido");
            $("#spnaddsubcat").show();
            }
        });
        /****************************************************/
        /****************************************************/
        //EDITAR SUBCATEGORIA BUTTON DIALOG
        $("#editsubcatsave").click(function(e) {      
            e.preventDefault();
            if ( $("#editsubcatinput").val().trim().length !== 0 ) {
            $.ajax({
                url: 'SubCategorias/edit/' + idsubcatglobal,
                type: "POST",
                data: $("#formeditsubcat").serialize(),
                dataType:'json',
                success: function(n) {
                    if (n==1) {
                        mostrarDatos();
                        alert("Editado con exito");
                        $("#formeditsubcat").trigger("reset");
                        $("#diveditsubcat").dialog("close");
                    }else if (n==0){
                        $("#spneditsubcat").html("No se pudo editar, intentelo de nuevo");
                        $("#spneditsubcat").show();                                                  
                    }
                }
            });
            }else{
             $("#spneditsubcat").html("Campo requerido");
             $("#spneditsubcat").show();
            }

        });
        /****************************************************/
        /****************************************************/
        //ELIMINAR SUBCATEGORIA BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idsubcatglobal = $(this).attr('data-id');
            $.ajax({
                url: "SubCategorias/delete/" + idsubcatglobal,
                type: "POST",
                dataType:'json',
                success: function(n) {
                    if (n==1){          
                        alert("Sub-Categoria id: " + idsubcatglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else if (n==2){
                        alert("No se pudo eliminar");   
                    }
                    
                }
            });
        });
    });
    //LISTAR SUBCATEGORIA
    function mostrarDatos() {
        $.ajax({
            url: 'SubCategorias/listasubcategorias',
            type: 'POST',
            dataType: 'json',
                beforeSend: function() {
                $('#listasubcategorias').html("Llenando datos...");
            },
            success: function(data) {
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Sub-Categorias</th><th>Categoria</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.SubCategoria.id + '</td>';
                    tabla += '<td>' + item.SubCategoria.subCategoria + '</td>';
                    tabla += '<td>'+ item.Categoria.categoria +'</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.SubCategoria.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.SubCategoria.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listasubcategorias').html(tabla);
                }else{
                   tabla = 'No hay sub-categorias en la base de datos';
                $('#listasubcategorias').html(tabla);
                }
            }
        });
    }
    //resp =true cuando es add False cuando es edit
    function llenarlistboxcategorias(resp) {
        $.ajax({
            url: 'Categorias/listacategoriasComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-categoria"><option>Seleccione una Categoria</option>';
                    }else{
                        list ='<select id="select-editcategoria">';
                    }     
                    $.each(data, function(item) {
                        var idCat = data[item].Categoria.id;
                        var categorianom = data[item].Categoria.categoria;
                        if(resp==idCat){ 
                            list += '<option selected=selected value=' + idCat + '>' + categorianom + '</option>';
                        }else{
                            list += '<option value=' + idCat + '>' + categorianom + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-categoria').html(list);
                    }else{
                        $('#list-editcategoria').html(list);
                    }
                }else{
                    var list = '<select id="select-editsubcategoria"><option>No hay categorias en la BD</option>';
                    $('#list-editcategoria').html(list);
                }
               }
         });
    }
/********************************************************************/
//CIERRE SUBCATEGORIAS
/********************************************************************/
</script>

<!-- LISTA SUBCATEGORIAS -->
<div id="listasubcategorias"></div>
<!-- AGREGAR SUBCATEGORIAS -->
<button  id="btnaddsubcat" class="botones">Nueva Sub-Categoria</button>
<div id="divaddsubcat" title="Nueva Sub-Categoria"> 
    <form id="formaddsubcat" method="POST">
        <label>Sub-Categoria:</label> 
        <input id="iptsubcategoria" type="text" name="subCategoria">
        <span id="spnaddsubcat"></span>
        <label>Categoria:</label> 
        <div id="list-categoria"></div>
        <input id="iptcategoria_id" type="hidden" name="categoria_id" >
        <button id="addsubcatsave">Guardar</button>
    </form>
</div>

<!--EDITAR SUBCATEGORIAS -->
<div id="diveditsubcat" title="Editar Sub-Categoria">
    <form id="formeditsubcat" method="POST">
        <label> Nombre: </label>
        <input id="editsubcatinput" type="text" name="subCategoria">
        <span id="spneditsubcat"></span>
        <label>Categoria:</label> 
        <div id="list-editcategoria"></div>
        <button id="editsubcatsave">Guardar</button>
        <input id="ipteditcategoria_id" type="hidden" name="categoria_id" >
    </form>
</div>
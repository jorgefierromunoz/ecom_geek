<script>
    $(document).ready(function() {
        idtamglobal = 0;
        //LISTA
        mostrarDatos();
        //OPEN DIV NUEVO BUTTON
        //-----------------------------------
        $("#btnaddtam").click(function() {
            $("#formaddtam").trigger("reset");
            ocultarspan();
            $("#divaddtam").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idtamglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Tamanos/view/' + idtamglobal,
                dataType: 'json',
                type: "POST",
                success: function(data) {
                    $("#edittaminput").val(data.Tamano.tamano);
                    $("#editfactorinput").val(data.Tamano.factor);
                    $("#divedittam").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddtam").dialog({
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
         $('#formaddtam').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#divedittam").dialog({
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
        $('#formedittam').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#addtamsave").click(function(e) {
            e.preventDefault();
             if ( $("#ipttamano").val().trim().length == 0 ) {
                $("#spnaddtam").html("Campo requerido");
                $("#spnaddtam").show();                
                $("#spnaalert").show();
            }else if ( $("#iptfactor").val().trim().length == 0 ){
                $("#spnaddfactor").html("Campo requerido");
                $("#spnaddfactor").show();
                $("#spnaalert").show();
            }else{
                $.ajax({
                    url: "Tamanos/add",
                    type: "POST",
                    data: $("#formaddtam").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1){
                           $("#formaddtam").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddtam").dialog("close");
                        }else if (n==0){
                            $("#spnaalert").html("No se pudo guardar, intentelo de nuevo");
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
        $("#edittamsave").click(function(e) {      
            e.preventDefault();
            if ( $("#edittaminput").val().trim().length == 0 ) {
                $("#spnedittam").html("Campo requerido");
                $("#spnedittam").show();
                $("#spnaalertedit").show();
            }else if ( $("#editfactorinput").val().trim().length == 0 ){
                $("#spneditfactor").html("Campo requerido");
                $("#spneditfactor").show();
                $("#spnaalertedit").show();
            }else{
            $.ajax({
                url: 'Tamanos/edit/' + idtamglobal,
                type: "POST",
                data: $("#formedittam").serialize(),
                dataType:'json',
                success: function(n) {
                    if (n==1) {
                        mostrarDatos();
                        $("#formedittam").trigger("reset");
                        $("#divedittam").dialog("close");
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
            idtamglobal = $(this).attr('data-id');
            $.ajax({
                url: "Tamanos/delete/" + idtamglobal,
                type: "POST",
                dataType:'json',
                success: function(n) {
                    if (n==1){               
                        mostrarDatos();
                        alert("Tamaño id: " + idtamglobal + " eliminado con éxito");          
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
            url: 'Tamanos/listatamanos',
            type: 'POST',
            dataType: 'json',
                beforeSend: function() {
                $('#listatamanos').html("Llenando datos...");
            },
            success: function(data) {
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Tamaños</th><th>Factor</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Tamano.id + '</td>';
                    tabla += '<td>' + item.Tamano.tamano + '</td>';
                    tabla += '<td>' + item.Tamano.factor + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Tamano.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Tamano.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listatamanos').html(tabla);
                }else{
                   tabla = 'No hay Tamaños en la base de datos';
                $('#listatamanos').html(tabla);
                }
            }
        });
    }
    function ocultarspan(){
        $("#spnaddtam").hide();
        $("#spnaddfactor").hide();
        $("#spnaalert").hide(); 
        $("#spnedittam").hide();
        $("#spneditfactor").hide();
        $("#spnaalertedit").hide();
          
    }
/********************************************************************/
//CIERRE
/********************************************************************/
</script>

<!-- LISTA -->
<div id="listatamanos"></div>
<!-- AGREGAR -->
<button  id="btnaddtam" class="botones">Nuevo Tamaño</button>
<div id="divaddtam" title="Nuevo Tamaño"> 
    <form id="formaddtam" method="POST">
        <label>Tamaño:</label> 
        <input id="ipttamano" type="text" name="tamano">
        <span id="spnaddtam"></span><br>
        <label>Factor:</label> 
        <input id="iptfactor" type="text" name="factor">
        <span id="spnaddfactor"></span><br>
        <button id="addtamsave">Guardar</button>
        <span id="spnaalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR -->
<div id="divedittam" title="Editar Tamaño">
    <form id="formedittam" method="POST">
        <label> Tamaño: </label>
        <input id="edittaminput" type="text" name="tamano">
        <span id="spnedittam"></span><br>
        <label>Factor:</label> 
        <input id="editfactorinput" type="text" name="factor">
        <span id="spneditfactor"></span><br>
        <button id="edittamsave">Guardar</button>
        <span id="spnaalertedit">Debe llenar los campos correctamente</span>
    </form>

</div>
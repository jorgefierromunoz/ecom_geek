<script>
    $(document).ready(function() {
        idpaisesglobal = 0;
        //LISTA
        mostrarDatos();
        //OPEN DIV NUEVO BUTTON
        //-----------------------------------
        $("#btnaddpais").click(function() {
            $("#formaddpais").trigger("reset");
            ocultarspan();
            $("#divaddpais").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idpaisesglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Paises/view/' + idpaisesglobal,
                dataType: 'json',
                type: "POST",
                success: function(data) {
                    $("#editpaisinput").val(data.Paise.pais);
                    $("#diveditpais").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddpais").dialog({
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
         $('#formaddpais').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditpais").dialog({
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
        $('#formeditpais').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#addpaissave").click(function(e) {
            e.preventDefault();
             if ( $("#iptpais").val().trim().length == 0 ) {
                $("#spnaddpais").html("Campo requerido");
                $("#spnaddpais").show();                
                $("#spnaalert").show();
            }else{
                $.ajax({
                    url: "Paises/add",
                    type: "POST",
                    data: $("#formaddpais").serialize(),
                    dataType:'json',
                    success: function(n) {
                        if (n==1){
                           $("#formaddpais").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddpais").dialog("close");
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
        $("#editpaissave").click(function(e) {      
            e.preventDefault();
            if ( $("#editpaisinput").val().trim().length == 0 ) {
                $("#spneditpais").html("Campo requerido");
                $("#spneditpais").show();
                $("#spnaalertedit").show();
            }else{
            $.ajax({
                url: 'Paises/edit/' + idpaisesglobal,
                type: "POST",
                data: $("#formeditpais").serialize(),
                dataType:'json',
                success: function(n) {
                    if (n==1) {
                        mostrarDatos();
                        $("#formeditpais").trigger("reset");
                        $("#diveditpais").dialog("close");
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
            idpaisesglobal = $(this).attr('data-id');
            $.ajax({
                url: "Paises/delete/" + idpaisesglobal,
                type: "POST",
                dataType:'json',
                success: function(n) {
                    if (n=='t'){               
                        mostrarDatos();
                        alert("Pais id: " + idpaisesglobal + " eliminado con éxito");          
                    }else{
                        alert("No se pudo eliminar por que hay " + n + " region(es) asociada(s)");   
                    }
                    
                }
            });
        });
    });
    //LISTAR
    function mostrarDatos() {
        $.ajax({
            url: 'Paises/listapaises',
            type: 'POST',
            dataType: 'json',
                beforeSend: function() {
                $('#listapaises').html("Llenando datos...");
            },
            success: function(data) {
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Paises</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Paise.id + '</td>';
                    tabla += '<td>' + item.Paise.pais + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Paise.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Paise.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listapaises').html(tabla);
                }else{
                   tabla = 'No hay Paises en la base de datos';
                $('#listapaises').html(tabla);
                }
            }
        });
    }
    function ocultarspan(){
        $("#spnaddpais").hide();
        $("#spnaalert").hide(); 
        $("#spneditpais").hide();
        $("#spnaalertedit").hide();
    }
/********************************************************************/
//CIERRE
/********************************************************************/
</script>

<!-- LISTA -->
<div id="listapaises"></div>
<!-- AGREGAR -->
<button  id="btnaddpais" class="botones">Nuevo Pais</button>
<div id="divaddpais" title="Nuevo Pais"> 
    <form id="formaddpais" method="POST">
        <label>Pais:</label> 
        <input id="iptpais" type="text" name="pais">
        <span id="spnaddpais"></span><br>
        <button id="addpaissave">Guardar</button>
        <span id="spnaalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR -->
<div id="diveditpais" title="Editar Paises">
    <form id="formeditpais" method="POST">
        <label> Pais: </label>
        <input id="editpaisinput" type="text" name="pais">
        <span id="spneditpais"></span><br>        
        <button id="editpaissave">Guardar</button>
        <span id="spnaalertedit">Debe llenar los campos correctamente</span>
    </form>
</div>
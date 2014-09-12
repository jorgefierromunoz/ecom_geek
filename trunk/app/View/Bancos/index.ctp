<script>
    $(document).ready(function() {
        idbancoglobal = 0;
        //LISTA
        mostrarDatos();
        //OPEN DIV NUEVA BUTTON
        //-----------------------------------
        $("#btnaddbanco").click(function() {
            $("#formaddbanco").trigger("reset");
            $("#spnaddbanco").hide();
            $("#divaddbanco").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            $("#spneditbanco").hide();
            idbancoglobal = $(this).attr('data-id');
            var nombre="";
            $.ajax({
                url: 'Bancos/view/' + idbancoglobal,
                dataType: 'json',
                type: "POST",                
                beforeSend: function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $.each(data, function(item2) {
                        nombre = data[item2].banco;
                    });
                    $("#editbancoinput").val(nombre);
                    $("#diveditbanco").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddbanco").dialog({
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
         $('#formaddbanco').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditbanco").dialog({
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
        $('#formeditbanco').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#addbancosave").click(function(e) {
            e.preventDefault();
              if ( $("#iptbanco").val().trim().length !== 0 ) {
                $.ajax({
                    url: "Bancos/add",
                    type: "POST",
                    data: $("#formaddbanco").serialize(),
                    dataType:'json',                    
                    beforeSend: function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                         $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddbanco").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddbanco").dialog("close");
                        }else if (n==0){
                            $("#spnaddbanco").html("No se pudo guardar, intentelo de nuevo");
                            $("#spnaddbanco").show();
                        }
                    },
                    error: function(n) {
                        console.log(n);
                    }
            });
            }else{
            $("#spnaddbanco").html("Campo requerido");
            $("#spnaddbanco").show();
            }
        });
        /****************************************************/
        /****************************************************/
        //EDITAR BUTTON DIALOG
        $("#editbancosave").click(function(e) {      
            e.preventDefault();
            if ( $("#editbancoinput").val().trim().length !== 0 ) {
            $.ajax({
                url: 'Bancos/edit/' + idbancoglobal,
                type: "POST",                
                beforeSend: function(){ $("#cargando").dialog("open");},
                data: $("#formeditbanco").serialize(),
                dataType:'json',
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1) {
                        mostrarDatos();
                        $("#formeditbanco").trigger("reset");
                        $("#diveditbanco").dialog("close");
                    }else if (n==0){
                        $("#spneditbanco").html("No se pudo editar, intentelo de nuevo");
                        $("#spneditbanco").show();                                                  
                    }
                },
                error:function(n){console.log(n)}                
            });
            }else{
             $("#spneditbanco").html("Campo requerido");
             $("#spneditbanco").show();
            }

        });
        /****************************************************/
        /****************************************************/
        //ELIMINAR BUTTON 
        $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idbancoglobal = $(this).attr('data-id');
            $.ajax({
                url: "Bancos/delete/" + idbancoglobal,
                type: "POST",
                dataType:'json',
                beforeSend: function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){               
                        mostrarDatos();
                    }else{
                        alert("No se puede eliminar por que hay " + n + " tipo(s) de cuenta(s) bancaria(s) asociada(s)");   
                    }
                }
            });
        });
    });
    //LISTAR
    function mostrarDatos() {
        $.ajax({
            url: 'Bancos/listabancos',
            type: 'POST',
            dataType: 'json',
            beforeSend: function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Bancos</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Banco.id + '</td>';
                    tabla += '<td>' + item.Banco.banco + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Banco.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Banco.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listabancos').html(tabla);
                }else{
                   tabla = 'No hay bancos en la base de datos';
                $('#listabancos').html(tabla);
                }
            }
        });
    }
/********************************************************************/
//CIERRE 
/********************************************************************/
</script>
<div class="contbotones">
<button  id="btnaddbanco" class="botones">Nuevo Banco</button>
</div>
<!-- LISTA  -->
<div id="listabancos"></div>
<!-- AGREGAR -->
<div id="divaddbanco" title="Nuevo Banco"> 
    <form id="formaddbanco" method="POST">
        <label>Banco:</label> 
        <input id="iptbanco" type="text" name="banco">
        <span id="spnaddbanco"></span><br>
        <button id="addbancosave">Guardar</button>
    </form>
</div>

<!--EDITAR -->
<div id="diveditbanco" title="Editar Banco">
    <form id="formeditbanco" method="POST">
        <label> Nombre: </label>
        <input id="editbancoinput" type="text" name="banco">
        <span id="spneditbanco"></span><br>
        <button id="editbancosave">Guardar</button>
    </form>

</div>
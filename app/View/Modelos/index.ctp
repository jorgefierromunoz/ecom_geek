<script>
    $(document).ready(function() {
        idmodglobal = 0;
        //LISTA
        mostrarDatos("id","asc");
        //OPEN DIV NUEVO BUTTON
        //-----------------------------------
        $("#btnaddmod").click(function() {
            $("#formaddmod").trigger("reset");
            ocultarspan();
            $("#divaddmod").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idmodglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Modelos/view/' + idmodglobal,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editmodinput").val(data.Modelo.modelo);
                    $("#diveditmod").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });

        });

        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddmod").dialog({
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
         $('#formaddmod').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditmod").dialog({
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
        $('#formeditmod').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG
        $("#addmodsave").click(function(e) {
            e.preventDefault();
             if ( $("#iptmodelo").val().trim().length == 0 ) {
                $("#spnaddmod").html("Campo requerido");
                $("#spnaddmod").show();                
                $("#spnaalert").show();
            }else{
                $.ajax({
                    url: "Modelos/add",
                    type: "POST",
                    data: $("#formaddmod").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddmod").trigger("reset");                           
                           mostrarDatos("id","asc");
                           $("#divaddmod").dialog("close");
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
        $("#editmodsave").click(function(e) {      
            e.preventDefault();
            if ( $("#editmodinput").val().trim().length == 0 ) {
                $("#spneditmod").html("Campo requerido");
                $("#spneditmod").show();
                $("#spnaalertedit").show();
            }else{
            $.ajax({
                url: 'Modelos/edit/' + idmodglobal,
                type: "POST",
                data: $("#formeditmod").serialize(),
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1) {
                        mostrarDatos("id","asc");
                        $("#formeditmod").trigger("reset");
                        $("#diveditmod").dialog("close");
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
            idmodglobal = $(this).attr('data-id');
            $.ajax({
                url: "Modelos/delete/" + idmodglobal,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){          
                        alert("Modelo id: " + idmodglobal + " eliminada con éxito");               
                        mostrarDatos("id","asc");
                    }else{
                        alert("No se puede eliminar por que hay " + n + " producto(s) asociado(s)");   
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
            url: 'Modelos/listamodelos/Modelo.'+atributo+'/'+orden,
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th class=ordenar data-id=id>Id</th><th class=ordenar data-id=modelo>Modelos</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Modelo.id + '</td>';
                    tabla += '<td>' + item.Modelo.modelo + '</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Modelo.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Modelo.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listamodelos').html(tabla);
                }else{
                   tabla = 'No hay Modelos en la base de datos';
                $('#listamodelos').html(tabla);
                }
            }
        });
    }
    function ocultarspan(){
        $("#spnaddmod").hide();
        $("#spnaalert").hide(); 
        $("#spneditmod").hide();
        $("#spnaalertedit").hide();
          
    }
/********************************************************************/
//CIERRE
/********************************************************************/
</script>

<!-- LISTA -->
<div id="listamodelos"></div>
<!-- AGREGAR -->
<button  id="btnaddmod" class="botones">Nuevo Modelo</button>
<div id="divaddmod" title="Nuevo Modelo"> 
    <form id="formaddmod" method="POST">
        <label>Modelo:</label> 
        <input id="iptmodelo" type="text" name="modelo">
        <span id="spnaddmod"></span><br>
        <button id="addmodsave">Guardar</button>
        <span id="spnaalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR -->
<div id="diveditmod" title="Editar Modelo">
    <form id="formeditmod" method="POST">
        <label> Modelo: </label>
        <input id="editmodinput" type="text" name="modelo">
        <span id="spneditmod"></span><br>        
        <button id="editmodsave">Guardar</button>
        <span id="spnaalertedit">Debe llenar los campos correctamente</span>
    </form>
</div>
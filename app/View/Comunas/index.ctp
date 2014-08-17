<script>
    $(document).ready(function() {
        idcomunasglobal = 0;
        //LISTA
        mostrarDatos();
        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-regiones").change(function() {
            var opcion = $("#select-regiones").val();
            $("#iptregione_id").val(opcion);
        });
        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-zonas").change(function() {
            var opcion = $("#select-zonas").val();
            $("#iptzona_id").val(opcion);
        });
        //SELECCION DEL COMBOBOX ON CHANGE EDIT
        $("#list-editregiones").change(function() {
            var opcion = $("#select-editregiones").val();
            $("#ipteditregione_id").val(opcion);
        });
         //SELECCION DEL COMBOBOX ON CHANGE EDIT
        $("#list-editzonas").change(function() {
            var opcion = $("#select-editzonas").val();
            $("#ipteditzona_id").val(opcion);
        });
        
        //OPEN DIV NUEVA BUTTON
        //-----------------------------------
        $("#btnaddcomunas").click(function() {
            $("#formaddcomunas").trigger("reset");
            $("#iptregione_id").val("");
            $("#iptzona_id").val("");
            ocultarspan();
            llenarlistboxregiones("x");
            llenarlistboxzonas("x");
            $("#divaddcomunas").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idcomunasglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Comunas/view/' + idcomunasglobal,
                dataType: 'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                type: "POST",
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editcomunasinput").val(data.Comuna.comuna);
                    $("#ipteditregione_id").val(data.Comuna.regione_id);
                    $("#ipteditzona_id").val(data.Comuna.zona_id);
                    llenarlistboxregiones(data.Comuna.regione_id);
                    llenarlistboxzonas(data.Comuna.regione_id);
                    $("#diveditcomunas").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });
        });
        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddcomunas").dialog({
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
         $('#formaddcomunas').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditcomunas").dialog({
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
        $('#formeditcomunas').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG 
        $("#addcomunassave").click(function(e) {
            e.preventDefault();
              if ( $("#iptcomunas").val().trim().length == 0) {
                $("#spnaddcomunas").html("Campo requerido");
                $("#spnaddcomunas").show();
                $("#spnaddalert").show();
              }else if ( $("#iptregione_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else if ( $("#iptzona_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: "Comunas/add",
                    type: "POST",
                    data: $("#formaddcomunas").serialize(),
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    dataType:'json',
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddcomunas").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddcomunas").dialog("close");
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
        $("#editcomunassave").click(function(e) {      
            e.preventDefault();
            if ( $("#editcomunasinput").val().trim().length == 0) {
                $("#spneditcomunas").html("Campo requerido");
                $("#spneditcomunas").show();
                $("#spneditalert").show();
              }else if ( $("#ipteditregione_id").val().trim().length == 0){
                $("#spneditalert").show();
              }else if ( $("#ipteditzona_id").val().trim().length == 0){
                $("#spneditalert").show();
              }else{
                $.ajax({
                    url: 'Comunas/edit/' + idcomunasglobal,
                    type: "POST",
                    data: $("#formeditcomunas").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1) {
                            mostrarDatos();
                            alert("Editado con exito");
                            $("#formeditcomunas").trigger("reset");
                            $("#diveditcomunas").dialog("close");
                        }else if (n==0){
                            $("#spneditcomunas").html("No se pudo editar, intentelo de nuevo");
                            $("#spneditcomunas").show();                                                  
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
            idcomunasglobal = $(this).attr('data-id');
            $.ajax({
                url: "Comunas/delete/" + idcomunasglobal,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1){          
                        alert("Region id: " + idcomunasglobal + " eliminada con éxito");               
                        mostrarDatos();
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
            url: 'Comunas/listacomunas',
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("open");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Comuna</th><th>Region</th><th>Zona</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Comuna.id + '</td>';
                    tabla += '<td>' + item.Comuna.comuna + '</td>';
                    tabla += '<td>' + item.Regione.region +'</td>';
                    tabla += '<td>' + item.Zona.zona +'</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Comuna.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Comuna.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listacomunas').html(tabla);
                }else{
                   tabla = 'No hay comunas en la base de datos';
                $('#listacomunas').html(tabla);
                }
            }
        });
    }
    //resp =x cuando es add n° cuando es edit
    function llenarlistboxregiones(resp) {
        $.ajax({
            url: 'Regiones/listaregionesComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
                    if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-regiones"><option value="">Seleccione una Region</option>';
                    }else{
                        list ='<select id="select-editregiones">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Regione.id){ 
                            list += '<option selected=selected value=' + data[item].Regione.id + '>' + data[item].Regione.region + '</option>';
                        }else{
                            list += '<option value=' +  data[item].Regione.id + '>' + data[item].Regione.region + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-regiones').html(list);
                    }else{
                        $('#list-editregiones').html(list);
                    }
                }else{
                    var list = '<select id="select-editregiones"><option>No hay regiones en la BD</option>';
                    if (resp=="x"){
                         $('#list-regiones').html(list);
                    }else{
                         $('#list-editregiones').html(list);
                    }
                }
               }
         });
    }
    function llenarlistboxzonas(resp) {
        $.ajax({
            url: 'Zonas/listazonasComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-zonas"><option value="">Seleccione una Zona</option>';
                    }else{
                        list ='<select id="select-editzonas">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Zona.id){ 
                            list += '<option selected=selected value=' + data[item].Zona.id + '>' + data[item].Zona.zona + '</option>';
                        }else{
                            list += '<option value=' +  data[item].Zona.id + '>' +data[item].Zona.zona + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-zonas').html(list);
                    }else{
                        $('#list-editzonas').html(list);
                    }
                }else{
                    var list = '<select id="select-editzonas"><option>No hay zonas en la BD</option>';
                    if (resp=="x"){
                         $('#list-zonas').html(list);
                    }else{
                         $('#list-editzonas').html(list);
                    }
                }
               }
         });
    }
    function ocultarspan(){       
        $("#spnaddcomunas").hide();
        $("#spnaddalert").hide();
        $("#spneditcomunas").hide();
        $("#spneditalert").hide();       
    }
/********************************************************************/
//CIERRE 
/********************************************************************/
</script>

<!-- LISTA  -->
<div id="listacomunas"></div>
<!-- AGREGAR  -->
<button  id="btnaddcomunas" class="botones">Nueva Comuna</button>
<div id="divaddcomunas" title="Nueva Comuna"> 
    <form id="formaddcomunas" method="POST">
        <label>Comuna:</label> 
        <input id="iptcomunas" type="text" name="comuna">
        <span id="spnaddcomunas"></span> 
        <label>Region:</label> 
        <div id="list-regiones"></div>
        <input id="iptregione_id" type="hidden" name="regione_id" >
        <label>Zona:</label> 
        <div id="list-zonas"></div>
        <input id="iptzona_id" type="hidden" name="zona_id" >
        <button id="addcomunassave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditcomunas" title="Editar Comunas">
    <form id="formeditcomunas" method="POST">
        <label>Comuna: </label>
        <input id="editcomunasinput" type="text" name="comuna">
        <span id="spneditcomunas"></span>
        <label>Region:</label> 
        <div id="list-editregiones"></div>
        <input id="ipteditregione_id" type="hidden" name="regione_id" >
        <label>Zona:</label> 
        <div id="list-editzonas"></div>
         <input id="ipteditzona_id" type="hidden" name="zona_id" >
        <button id="editcomunassave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>       
    </form>
</div>
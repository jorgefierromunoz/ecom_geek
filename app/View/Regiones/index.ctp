<script>
    $(document).ready(function() {
        idregionesglobal = 0;
        //LISTA
        mostrarDatos();
        //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-paises").change(function() {
            var opcion = $("#select-paises").val();
            $("#iptpaise_id").val(opcion);
        });
        //SELECCION DEL COMBOBOX ON CHANGE EDIT
        $("#list-editpaises").change(function() {
            var opcion = $("#select-editpaises").val();
            $("#ipteditpaise_id").val(opcion);
        });
        //OPEN DIV NUEVA BUTTON
        //-----------------------------------
        $("#btnaddregiones").click(function() {
            $("#formaddregiones").trigger("reset");
            $("#iptpaise_id").val("");
            ocultarspan();
            llenarlistboxpaises("x");
            $("#divaddregiones").dialog("open");
        });
        //OPEN DIV EDIT  
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idregionesglobal = $(this).attr('data-id');
            $.ajax({
                url: 'Regiones/view/' + idregionesglobal,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editregionesinput").val(data.Regione.region);
                    $("#ipteditpaise_id").val(data.Regione.paise_id);
                    llenarlistboxpaises(data.Regione.paise_id);
                    $("#diveditregiones").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });
        });
        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddregiones").dialog({
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
         $('#formaddregiones').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#diveditregiones").dialog({
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
        $('#formeditregiones').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR BUTTON ADD DIALOG 
        $("#addregionessave").click(function(e) {
            e.preventDefault();
              if ( $("#iptregiones").val().trim().length == 0) {
                $("#spnaddregiones").html("Campo requerido");
                $("#spnaddregiones").show();
                $("#spnaddalert").show();
              }else if ( $("#iptpaise_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: "Regiones/add",
                    type: "POST",
                    data: $("#formaddregiones").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddregiones").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddregiones").dialog("close");
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
        $("#editregionessave").click(function(e) {      
            e.preventDefault();
            if ( $("#editregionesinput").val().trim().length == 0) {
                $("#spneditregiones").html("Campo requerido");
                $("#spneditregiones").show();
                $("#spnaddalert").show();
              }else if ( $("#ipteditpaise_id").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: 'Regiones/edit/' + idregionesglobal,
                    type: "POST",
                    data: $("#formeditregiones").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1) {
                            mostrarDatos();
                            alert("Editado con exito");
                            $("#formeditregiones").trigger("reset");
                            $("#diveditregiones").dialog("close");
                        }else if (n==0){
                            $("#spneditregiones").html("No se pudo editar, intentelo de nuevo");
                            $("#spneditregiones").show();                                                  
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
            idregionesglobal = $(this).attr('data-id');
            $.ajax({
                url: "Regiones/delete/" + idregionesglobal,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){          
                        alert("Region id: " + idregionesglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else{
                        alert("No se pudo eliminar por que hay " + n + " comuna(s) asociada(s)");   
                    }
                    
                }
            });
        });
    });
    //LISTAR
    function mostrarDatos() {
        $.ajax({
            url: 'Regiones/listaregiones',
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Region</th><th>Pais</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.Regione.id + '</td>';
                    tabla += '<td>' + item.Regione.region + '</td>';
                    tabla += '<td>'+ item.Paise.pais +'</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.Regione.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.Regione.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listaregiones').html(tabla);
                }else{
                   tabla = 'No hay regiones en la base de datos';
                $('#listaregiones').html(tabla);
                }
            }
        });
    }
    //resp =x cuando es add n° cuando es edit
    function llenarlistboxpaises(resp) {
        $.ajax({
            url: 'Paises/listapaisesComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-paises"><option value="">Seleccione un Pais</option>';
                    }else{
                        list ='<select id="select-editpaises">';
                    }     
                    $.each(data, function(item) {
                        if(resp==data[item].Paise.id){ 
                            list += '<option selected=selected value=' + data[item].Paise.id + '>' + data[item].Paise.pais + '</option>';
                        }else{
                            list += '<option value=' +  data[item].Paise.id + '>' + data[item].Paise.pais + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-paises').html(list);
                    }else{
                        $('#list-editpaises').html(list);
                    }
                }else{
                    var list = '<select id="select-editregiones"><option>No hay paises en la BD</option>';
                    if (resp=="x"){
                         $('#list-paises').html(list);
                    }else{
                         $('#list-editpaises').html(list);
                    }
                }
               }
         });
    }
    function ocultarspan(){       
        $("#spnaddregiones").hide();
        $("#spnaddalert").hide();
        $("#spneditregiones").hide();
        $("#spneditalert").hide();       
    }
/********************************************************************/
//CIERRE 
/********************************************************************/
</script>

<!-- LISTA  -->
<div id="listaregiones"></div>
<!-- AGREGAR  -->
<button  id="btnaddregiones" class="botones">Nueva Region</button>
<div id="divaddregiones" title="Nueva Region"> 
    <form id="formaddregiones" method="POST">
        <label>Region:</label> 
        <input id="iptregiones" type="text" name="region">
        <span id="spnaddregiones"></span> 
        <label>Pais:</label> 
        <div id="list-paises"></div>
        <input id="iptpaise_id" type="hidden" name="paise_id" >
        <button id="addregionessave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditregiones" title="Editar Regiones">
    <form id="formeditregiones" method="POST">
        <label> Region: </label>
        <input id="editregionesinput" type="text" name="region">
        <span id="spneditregiones"></span>
        <label>Paises:</label> 
        <div id="list-editpaises"></div>
        <button id="editregionessave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
        <input id="ipteditpaise_id" type="hidden" name="paise_id" >
    </form>
</div>
<script>
    $(document).ready(function() {
        idtcbancariasglobal = 0;
        //LISTA SUBCATEGORIAS
        mostrarDatos();
       
        //OPEN DIV NUEVA SUBCATEGORIA BUTTON
        //-----------------------------------
        $("#btnaddtcbancarias").click(function() {
            $("#formaddtcbancarias").trigger("reset");
            $("#iptbanco_id").val("");
            ocultarspan();
            llenarlistboxbancos("x");
            $("#divaddtcbancarias").dialog("open");
        });
        //OPEN DIV EDIT SUBCATEGORIA 
        //-------------------------------------
        //LLENAR EDITAR CON DATOS EXISTENTES
        $(document).on("click", ".editar", function() {
            ocultarspan();
            idtcbancariasglobal = $(this).attr('data-id');
            $.ajax({
                url: 'TipoCuentasBancarias/view/' + idtcbancariasglobal,
                dataType: 'json',
                type: "POST",
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#edittcbancariasinput").val(data.TipoCuentasBancaria.tipoCuentaBancaria);
                    llenarlistboxbancos(data.TipoCuentasBancaria.banco_id);
                    $("#divedittcbancarias").dialog("open");
                },
                error: function(n) {
                    console.log(n);
                }
            });
        });
        /****************************************************/
        /****************************************************/
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR SUBCATEGORIAS
        $("#divaddtcbancarias").dialog({
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
         $('#formaddtcbancarias').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        /****************************************************/
        $("#divedittcbancarias").dialog({
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
        $('#formedittcbancarias').submit(function(e) {
            e.preventDefault();
        });
        /****************************************************/
        //GUARDAR SUBCATEGORIA BUTTON ADD DIALOG
        $("#addtcbancariassave").click(function(e) {
            e.preventDefault();
              if ( $("#ipttcbancariasegoria").val().trim().length == 0) {
                $("#spnaddtcbancarias").html("Campo requerido");
                $("#spnaddtcbancarias").show();
                $("#spnaddalert").show();
              }else if ( $("#select-banco").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: "TipoCuentasBancarias/add",
                    type: "POST",
                    data: $("#formaddtcbancarias").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddtcbancarias").trigger("reset");                           
                           mostrarDatos();
                           $("#divaddtcbancarias").dialog("close");
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
        //EDITAR SUBCATEGORIA BUTTON DIALOG
        $("#edittcbancariassave").click(function(e) {      
            e.preventDefault();
            if ( $("#edittcbancariasinput").val().trim().length == 0) {
                $("#spnedittcbancarias").html("Campo requerido");
                $("#spnedittcbancarias").show();
                $("#spnaddalert").show();
              }else if ( $("#select-editbanco").val().trim().length == 0){
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: 'TipoCuentasBancarias/edit/' + idtcbancariasglobal,
                    type: "POST",
                    data: $("#formedittcbancarias").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1) {
                            mostrarDatos();
                            alert("Editado con exito");
                            $("#formedittcbancarias").trigger("reset");
                            $("#divedittcbancarias").dialog("close");
                        }else if (n==0){
                            $("#spnedittcbancarias").html("No se pudo editar, intentelo de nuevo");
                            $("#spnedittcbancarias").show();                                                  
                        }
                    }
                 });
              }
        });
        /****************************************************/
        /****************************************************/
        //ELIMINAR SUBCATEGORIA BUTTON 
         $(document).on("click", ".delete", function(e) {
            e.preventDefault();
            idtcbancariasglobal = $(this).attr('data-id');
            $.ajax({
                url: "TipoCuentasBancarias/delete/" + idtcbancariasglobal,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='t'){          
                        alert("Cuenta id: " + idtcbancariasglobal + " eliminada con éxito");               
                        mostrarDatos();
                    }else{
                        alert("No se puede eliminar por que hay " + n + " usuario(s) asociado(s)");   
                    }
                }
            });
        });
    });
    //LISTAR SUBCATEGORIA
    function mostrarDatos() {
        $.ajax({
            url: 'TipoCuentasBancarias/listatcbancarias',
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                var tabla = '<table>';
                tabla += '<tr>';
                tabla += '<th>Id</th><th>Tipo de Cuenta</th><th>Banco</th><th>Editar</th><th>Eliminar</th>';
                tabla += '</tr>';
                $.each(data, function(index, item) {
                    tabla += '<tr>';
                    tabla += '<td>' + item.TipoCuentasBancaria.id + '</td>';
                    tabla += '<td>' + item.TipoCuentasBancaria.tipoCuentaBancaria + '</td>';
                    tabla += '<td>'+ item.Banco.banco +'</td>';
                    tabla += '<td><button type="button" class="editar" data-id="' + item.TipoCuentasBancaria.id + '">Editar</button></td>';
                    tabla += '<td><button type="button" class="delete" data-id="' + item.TipoCuentasBancaria.id + '">Eliminar</button></td>';
                    tabla += '</tr>';
                });
                tabla += '</table>';
                $('#listatcbancarias').html(tabla);
                }else{
                   tabla = 'No hay cuentas bancarias en la base de datos';
                $('#listatcbancarias').html(tabla);
                }
            }
        });
    }
    function llenarlistboxbancos(resp) {
        $.ajax({
            url: 'Bancos/listabancosComboBox',
            dataType: 'json',
            type:'POST',
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-banco" name="banco_id" ><option value="">Seleccione un Banco</option>';
                    }else{
                        list ='<select id="select-editbanco" name="banco_id">';
                    }     
                    $.each(data, function(item) {
                        var idBanco = data[item].Banco.id;
                        var banconom = data[item].Banco.banco;
                        if(resp==idBanco){ 
                            list += '<option selected=selected value=' + idBanco + '>' + banconom + '</option>';
                        }else{
                            list += '<option value=' + idBanco + '>' + banconom + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-banco').html(list);
                    }else{
                        $('#list-editbanco').html(list);
                    }
                }else{
                    var list = '<select id="select-edittcbancariasegoria"><option>No hay bancos en la BD</option>';
                    if (resp=="x"){
                         $('#list-banco').html(list);
                    }else{
                         $('#list-editbanco').html(list);
                    }
                }
               }
         });
    }
    function ocultarspan(){       
        $("#spnaddtcbancarias").hide();
        $("#spnaddalert").hide();
        $("#spnedittcbancarias").hide(); 
        $("#spneditalert").hide();          
    }
/********************************************************************/
//CIERRE SUBCATEGORIAS
/********************************************************************/
</script>

<!-- LISTA -->
<div id="listatcbancarias"></div>
<!-- AGREGAR -->
<button  id="btnaddtcbancarias" class="botones">Nueva Cuenta</button>
<div id="divaddtcbancarias" title="Nueva Cuenta Bancaria"> 
    <form id="formaddtcbancarias" method="POST">
        <label>Tipo de Cuenta Bancaria:</label> 
        <input id="ipttcbancariasegoria" type="text" name="tipoCuentaBancaria">
        <span id="spnaddtcbancarias"></span> 
        <label>Banco:</label> 
        <div id="list-banco"></div>
        <button id="addtcbancariassave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR -->
<div id="divedittcbancarias" title="Editar Cuenta Bancaria">
    <form id="formedittcbancarias" method="POST">
        <label> Tipo de Cuenta Bancaria: </label>
        <input id="edittcbancariasinput" type="text" name="tipoCuentaBancaria">
        <span id="spnedittcbancarias"></span>
        <label>Banco:</label> 
        <div id="list-editbanco"></div>
        <button id="edittcbancariassave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
        
    </form>
</div>
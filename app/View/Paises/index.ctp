<script>
    $(document).ready(function() {
        idpaisesglobal = 0;
        //LISTA
        mostrarDatos("id","asc","1");
        
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
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(data) {
                    $("#cargando").dialog("close");
                    $("#editpaisinput").val(data.Paise.pais);
                    $("#editabreviaturainput").val(data.Paise.abreviatura);
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
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formaddpais").trigger("reset");                           
                           mostrarDatos("id","asc","1");
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
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n==1) {
                        mostrarDatos("id","asc","1");
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
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {                    
                    $("#cargando").dialog("close");
                    if (n=='t'){               
                        mostrarDatos("id","asc","1");
                        alert("Pais id: " + idpaisesglobal + " eliminado con éxito");          
                    }else{
                        alert("No se pudo eliminar por que hay " + n + " region(es) asociada(s)");   
                    }
                    
                }
            });
        });
    });
    //OPEN DIV NUEVO BUTTON
        //-----------------------------------
         $(document).on("click", "#btnaddpais", function(e) {
            $("#formaddpais").trigger("reset");
            ocultarspan();
            $("#divaddpais").dialog("open");
        });
   //ORDENAR           
        var ascendente=false;
        $(document).on("click", ".ordenar", function(e) {
            e.preventDefault();
            var tabla = $(this).attr('data-id');
            var pa = parseInt($(this).attr('data-pa'));
            var pu = parseInt($(this).attr('data-pu'));
            var res= -(pa-1)+pu;
            if (ascendente){
                mostrarDatos(tabla,"asc",res);
                ascendente=!ascendente;
            }else{
                mostrarDatos(tabla,"desc",res);        
                ascendente=!ascendente;
            }
         });
          //PAGINA           
        $(document).on("click", ".pagina", function(e) {
            e.preventDefault();
            var boton = $(this).attr('data-id');
            var pa = parseInt($(this).attr('data-pa'));
            if (boton=="atras"){
                mostrarDatos("id","asc",pa-1);
            }else if (boton=="siguiente"){
                mostrarDatos("id","asc",pa+1);
            }else if (boton=="ultima"||boton=="primera"){
                mostrarDatos("id","asc",pa);
            }
         });
    //LISTAR 
    function mostrarDatos(atributo,orden,pagina) {
        $.ajax({
            url: 'Paises/listapaises/Paise.'+atributo+'/'+orden+'/'+pagina,
            type: 'POST',
            dataType: 'json',
            beforeSend:function(){ $("#cargando").dialog("open");},
            success: function(data) {
                $("#cargando").dialog("close");
                if(data!=""){
                    var pagina="";
                    if (data[2]==1){
                        pagina='<span class=pagina data-id=primera data-pa=1 >Primera </span>'+data[2] +'/'+ data[3] +'<span class=pagina data-id=siguiente data-pa=' + data[2]+' > Siguiente </span><span class=pagina data-id=ultima data-pa=' + data[3]+' > Ultima </span>';
                    }else if(data[2]==data[3]){
                        pagina='<span class=pagina data-id=primera data-pa=1 >Primera </span><span class=pagina data-id=atras data-pa=' + data[2] + ' >Atrás</span> '+data[2] +'/'+ data[3]+'<span class=pagina data-id=ultima data-pa=' + data[3]+' > Ultima </span>';
                    }else{
                        pagina='<span class=pagina data-id=primera data-pa=1 >Primera </span><span class=pagina data-id=atras data-pa=' + data[2] + ' >Atrás</span> '+ data[2] +'/'+ data[3] +' <span class=pagina data-id=siguiente data-pa=' + data[2] + ' >Siguiente</span><span class=pagina data-id=ultima data-pa=' + data[3]+' > Ultima </span>';
                    }
                    var tabla='<table>';
                    tabla += '<tr>';
                    tabla += '<td class=mostrarpaginacion ><button  id="btnaddpais" class="botones">Nuevo Pais</button></td> <td class=mostrarpaginacion>'+pagina+'</td><td class=mostrarpaginacion></td>';
                    tabla += '</tr>';
                    tabla +='</table>';
                    tabla += '<table>';
                    tabla += '<tr>';
                    tabla += '<th class=ordenar data-id=id data-pa=' + data[2] + ' data-pu=' + data[3] + '>Id</th><th class=ordenar data-id=pais data-pa=' + data[2] + ' data-pu=' + data[3] +'>Paises</th><th class=ordenar data-id=abreviatura data-pa=' + data[2] + ' data-pu=' + data[3] +'>Abreviatura</th><th>Editar</th><th>Eliminar</th>';
                    tabla += '</tr>';
                    $.each(data[0], function(index, item) {
                        tabla += '<tr>';
                        tabla += '<td>' + item.Paise.id + '</td>';
                        tabla += '<td>' + item.Paise.pais + '</td>';
                        tabla += '<td>' + item.Paise.abreviatura + '</td>';
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
<!-- AGREGAR -->

<!-- LISTA -->
<div id="listapaises"></div>

<div id="divaddpais" title="Nuevo Pais"> 
    <form id="formaddpais" method="POST">
        <label>Pais:</label> 
        <input id="iptpais" type="text" name="pais">
        <span id="spnaddpais"></span><br>
        <label>Abreviatura:</label> 
        <input id="iptabreviatura" type="text" name="abreviatura">
        <span id="spnaddabreviatura"></span><br>
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
        <label>Abreviatura:</label> 
        <input id="editabreviaturainput" type="text" name="abreviatura">
        <span id="spneditabreviatura"></span><br>
        <button id="editpaissave">Guardar</button>
        <span id="spnaalertedit">Debe llenar los campos correctamente</span>
    </form>
</div>
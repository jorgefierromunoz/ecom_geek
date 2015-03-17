
<script type="text/javascript">
$(document).ready(function(){
    ocultarspan();
    misdirecciones();
    $("#carrito").remove();
    $("#divadddirecciones").dialog({
             height: '500',
             width: '40%',
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
    $('#formadddirecciones').submit(function(e) {
        e.preventDefault();
    });
    verdetallecarro();
    $("#addnuevadireccion").click(function() {
        ocultarspan();
        $("#formadddirecciones").trigger("reset");
        llenarlistboxcomunas();
        $("#divadddirecciones").dialog("open");
     });
     $("#adddireccionessave").click(function(e) {
            e.preventDefault();
              if ( $("#iptcalle").val().trim().length == 0) {
                $("#spnaddcalle").html("Campo requerido");
                $("#spnaddcalle").show();
                $("#spnaddalert").show();
                
              }else if ( $("#iptnumero").val().trim().length == 0) {
                $("#spnaddnumero").html("Campo requerido");
                $("#spnaddnumero").show();
                $("#spnaddalert").show();
              }else if ( $("#select-comunas").val().trim().length == 0){
                $("#spnaddcomuna").html("Campo requerido");
                $("#spnaddcomuna").show();
                $("#spnaddalert").show();
              }else{
                $.ajax({
                    url: '<?php echo $this->Html->url(array('controller'=>'Direcciones','action'=>'add')); ?>',
                    type: "POST",
                    data: $("#formadddirecciones").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#cargando").dialog("close");
                        if (n==1){
                           $("#formadddirecciones").trigger("reset");                           
                           $("#divadddirecciones").dialog("close");
                           misdirecciones();
                           $("#spndireccion").html("Dirección agregada con éxito");
                        }else if (n==0){
                            $("#spndireccion").html("No se pudo guardar, intentelo de nuevo");
                        }
                    }
                    ,
                    error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    $("#cargando").dialog("close");
                    $("#spndireccion").html("Error con el servidor intentelo denuevo");
                    console.log(xhr.responseText );
                }
                });
             }
        });
});
$(document).on("click", "#deletedireccion", function(e) {
            e.preventDefault();
            var id = $("#combodirecciones").val();
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Direcciones','action'=>'delete')); ?>/' + id,
                type: "POST",
                dataType:'json',
                beforeSend:function(){ $("#cargando").dialog("open");},
                success: function(n) {
                    $("#cargando").dialog("close");
                    if (n=='1'){          
                        $("#spndireccion").html("Dirección eliminada con éxito");               
                        misdirecciones();
                    }else{
                        $("#spndireccion").html("No se pudo eliminar la dirección, inténtelo de nuevo");   
                    }
                },  
                    error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }
                
            });
        });
$(document).on("change","#combodirecciones",function(e){
   $(".valorflete").html($(this).find(':selected').attr('data-precio'));
   var total=parseInt($("#totalcomprar").text()) + parseInt($("#totalflete").text());
   $("#resultadofinal").html(total);
    $("#ptosdespuescompra").html(parseInt($("#mispuntos").text()) - total);
});        
function ocultarspan(){
    $("#spnaddcomuna").hide(); 
    $("#spnaddcalle").hide(); 
    $("#spnaddnumero").hide(); 
    $("#spnaddalert").hide(); 
}
function verdetallecarro(){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'versession')); ?>',
                dataType: 'json',
                success: function(data) {
                if (data != '0'){                    
                    var lista="<table class=tabledetcar><tr><td>Cód.</td><td>Nombre Producto</td><td>Precio Ptos.</td><td>Cantidad</td><td>SubTotal Ptos.</td></tr>";
                    var precio=0;
                    var preciopto=0;
                    var cantidad=0;
                    var subtotal=0;
                    var subtotalpto=0;
                    var total=0;
                    var totalpto=0;
                    $.each(data, function(item) {
                        
                        preciopto=parseInt(data[item].PrecioPunto);
                        cantidad=parseInt(data[item].Cantidad);
                        subtotalpto=preciopto*cantidad;
                        lista+="<tr id=prod_carrito_det" + data[item].Id + " >";
                        lista+="<td>"+ data[item].Id + "</td>"; 
                        lista+="<td>"+ data[item].Producto + "</td>"; 
                        lista+="<td>"+ preciopto + "</td>"; 
                        lista+="<td>"+ cantidad + "</td>"; 
                        lista+="<td>"+ subtotalpto + "</td>";
                        lista+="</tr>";                        
                        total+=subtotal;
                        totalpto+=subtotalpto;
                    });
                    lista+="</table>";
                    $("#detalle").html(lista);                            
                }else{
                    $("#totaldetcar").html("0");
                    $("#totalptodetcar").html("0");
                    }
                    
                },  
                error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }                
            });
        }
function llenarlistboxcomunas() {
        $.ajax({
            //url: 'Comunas/listacomunasComboBox',
            url:'<?php echo $this->Html->url(array('controller'=>'Comunas','action'=>'listacomunasComboBox')); ?>',
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ 
                    $('#list-comunas').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                },
            success: function(data) {
                if(data!=""){
                    var list =""; 
                    list = '<select id="select-comunas" name=comuna_id ><option value="">Seleccione una comuna</option>';
                    $.each(data, function(item) {
                            list += '<option value=' +  data[item].Comuna.id + '>' +data[item].Comuna.comuna + '</option>';                     
                    });
                    list += '</select>';
                        $('#list-comunas').html(list);
                }else{
                    var list = '<select id="select-editcomunas"><option>No hay comunas en la BD</option>';
                    $('#list-comunas').html(list);
                }
               }, error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }
                
         });
    }
function misdirecciones(){
$.ajax({
            url:'<?php echo $this->Html->url(array('controller'=>'Direcciones','action'=>'misdirecciones')); ?>',
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ 
                    $('#combodirecciones').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                },
            success: function(data) {
                if(data!=""){
                    $("#deletedireccion").show();
                    var list =""; 
                    $.each(data, function(item) {
                            list += '<option data-precio=' + data[item].Comuna.Zona.precio + ' value=' +  data[item].Direccione.id + '>' +data[item].Direccione.calle + ' ' +data[item].Direccione.numero + '</option>';                     
                    });
                    $('#combodirecciones').html(list);
                    $(".valorflete").html(data[0].Comuna.Zona.precio);
                    var totalcompra=parseInt($("#totalcomprar").text()) + parseInt($("#totalflete").text());
                    $("#resultadofinal").html(totalcompra);
                    $("#ptosdespuescompra").html(parseInt($("#mispuntos").text()) - totalcompra);
                }else{
                    $("#deletedireccion").hide();
                    var list = '<option>No ha ingresado ninguna dirección de despacho</option>';
                    $('#combodirecciones').html(list);
                }
               }, error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }
                       
         });
}

</script>


<span><h3>Confirmar Compra</h3></span>
<div id="detalleCarrito">
    <div id="detalle">
    
    </div>
 <table>
     <tr><td style='text-align:right;'>Total Compra: </td><td><?php echo $productos['precios']['totalpuntos']; ?></td></tr>
 </table>
<table>
    <tr style="background-color: #ffffff;"><td colspan="6"><h3>Direccion de despacho</h3></td></tr>
    <tr>    
        <td style='width: 20%;'>
            <select id='combodirecciones'>
            </select>
        </td>
        <td style="text-align:left; width: 5%;"><div class="botones" id="addnuevadireccion" style='width: 20px;'>+</div></td>
        <td style="text-align:left; width: 5%;"><div class="botones" id="deletedireccion" style='width: 20px;'>-</div></td>
        <td style="width: 70%;"><span id="spndireccion"></span></td>        
    </tr>
    <tr>
        <td colspan="3"></td>
        <td><div style="text-align: right; margin-right: 185px;">Costo Flete: <span id="valorflete" class="valorflete"></span></div></td>
    </tr>
</table>
<table>
    <tr style="background-color: #ffffff;"><td colspan="3"><h3>Totales</h3></td></tr>
    <tr><td style="width: 50%;"></td><td>Total Compra: </td><td><span id="totalcomprar"><?php echo $productos['precios']['totalpuntos']; ?></span></td></tr>
    <tr><td></td><td>Flete: </td><td><span id="totalflete" class="valorflete"></span></td></tr>
    <tr><td></td><td>Totales: </td><td><span id="resultadofinal"></td></tr>
    <tr><td></td><td>Tus Puntos: </td><td><span id="mispuntos"><?php echo $productos['usuario']['User']['puntoAcumulado']; ?></td></tr>
    <tr><td></td><td>Referencia: </td><td><span id="ptosdespuescompra"></span></td></tr>
    <tr>
        <td class="tdspanalert"><span id="spanAlert"></span></td> <td><div class="botones" id="pagaPuntos" style="margin-left: 90px;position: static; width:50%; ">Comprar con Puntos</div></td>
    </tr>
</table>
</div>
<!-- AGREGAR  -->
<div id="divadddirecciones" title="Nueva Dirección"> 
    <form id="formadddirecciones" method="POST">
        <label>*Calle:</label> 
        <input id="iptcalle" type="text" name="calle">
        <span id="spnaddcalle"></span>
        <label>*Número:</label> 
        <input id="iptnumero" type="text" name="numero">
        <span id="spnaddnumero"></span> 
        <label>Departamento:</label> 
        <input id="iptdpto" type="text" name="dpto"> 
        <label>Referencias de la Dirección:</label> 
        <input id="iptrestodireccion" type="text" name="restoDireccion">
        <label>Código Postal:</label> 
        <input id="iptcodigoPostal" type="text" name="codigoPostal">
        <label>Geo-Referencia:</label> 
        <input id="iptgeoreferencia" type="text" name="georeferencia">
        <label>Comuna:</label> 
        <div id="list-comunas"></div>  
        <span id="spnaddcomuna"></span> 
        <hr>
        <span id="spnaddalert">Procure llenar los campos correctamente</span> 
        <p align="right"><button id="adddireccionessave">Guardar</button></p>
    </form>
</div>

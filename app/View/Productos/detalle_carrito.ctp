<style>
    #menucentral{
        height: 550px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        verdetallecarro();
        $("#carrito").remove();
    });
    $(document).on("click",".cerr_car_det", function() {   
        var idpro = $(this).attr('data-id');
        $("#prod_carrito_det" + idpro).fadeOut("normal", function() {                
               $.ajax({
                   beforeSend: function() { 
                        $("#prod_carrito_det"+idpro).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                   },
                   url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'eliminarproductocarro')); ?>/'+idpro,
                   type: 'POST',
                   dataType: 'json',
                   success: function(data) {                         
                       if (data=="0"){                            
                           $("#detalle").html("<span id='spncarrito_det'>No hay productos en el carrito</span>");
                           $("#totaldetcar").html("0");
                           $("#totalptodetcar").html("0");
                       }else{
                           $("#prod_carrito_det" + idpro).remove();                           
                           totalcarrito("totaldetcar","totalptodetcar");
                       }
                   }
                });
           });
           
        });
    $(document).on("change", ".cant", function() {
        var idpro = $(this).attr('data-id');
        var cantidad = $(this).val();
            $.ajax({                
            url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'cantidadcarrito')); ?>/'+idpro + '/'+cantidad ,
            dataType: 'json',
            beforeSend: function() {
                    //$("#totaldetcar").html('');
                    //$("#totalptodetcar").html('');
                    $("#subtotal" + idpro).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    $("#subtotalpto"+ idpro).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                },    
            success: function(data) {
                $("#subtotal" + idpro).html(data[1]);                
                $("#subtotalpto" + idpro).html(data[2]);
                $("#iptcant"+ idpro).val(data[0]);
                totalcarrito("totaldetcar","totalptodetcar");
            },
            error: function (e,a){
            console.log(e);
            }
            });
    }); 
$(document).on("click", "#pagaPuntos", function() {
          var totalptos= $("#totalptodetcar").text();
          if (totalptos==0){
              $("#spanAlert").html("Elija almenos un producto de la página");
          }else{
               $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'validarcompra')); ?>',
                dataType: 'json',
                success: function(data) {   
                    console.log(data);
                    if(data == '0'){
                        $("#spanAlert").html("Primero debe iniciar sesión");
                        $('#divloginizq').animate({backgroundColor: '#94FF94'}, 'slow');
                        $('#divloginizq').animate({backgroundColor: '#FFFFFF'}, 'slow');
                    }else if(data=='1'){
                        window.location.href = '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'confirmacionCompra')); ?>';
                    }
                    
                },
                error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }
            });
          } 
});
               
    function verdetallecarro(){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'versession')); ?>',
                dataType: 'json',
                success: function(data) {
                if (data != '0'){                    
                    var lista="<table class=tabledetcar><tr><td>Cód.</td><td>Nombre Producto</td><td>Precio Unit.</td><td>Precio Ptos.</td><td>Cantidad</td><td>SubTotal Precio</td><td>SubTotal Ptos.</td><td>Eliminar</td></tr>";
                    var precio=0;
                    var preciopto=0;
                    var cantidad=0;
                    var subtotal=0;
                    var subtotalpto=0;
                    var total=0;
                    var totalpto=0;
                    $.each(data, function(item) {
                        precio=parseInt(data[item].Precio);
                        preciopto=parseInt(data[item].PrecioPunto);
                        cantidad=parseInt(data[item].Cantidad);
                        subtotal= precio*cantidad;
                        subtotalpto=preciopto*cantidad;
                        lista+="<tr id=prod_carrito_det" + data[item].Id + " >";
                        lista+="<td>"+ data[item].Id + "</td>"; 
                        lista+="<td>"+ data[item].Producto + "</td>"; 
                        lista+="<td>"+ data[item].Precio + "</td>";
                        lista+="<td>"+ preciopto + "</td>"; 
                        lista+="<td><input id='iptcant" + data[item].Id + "' class='cant' type=number step=1 data-id=" + data[item].Id +" value="+ cantidad + " min=1 max=99></td>"; 
                        lista+="<td><span id='subtotal" + data[item].Id + "'>"+ subtotal + "</span></td>";
                        lista+="<td><span id='subtotalpto" + data[item].Id+ "'>"+ subtotalpto + "</span></td>";
                        lista+="<td><span class=cerrarcarrito ><p class=cerr_car_det data-id=" + data[item].Id + ">x</p></span></td>";
                        lista+="</tr>";                        
                        total+=subtotal;
                        totalpto+=subtotalpto;
                    });
                    lista+="</table>";
                    $("#detalle").html(lista);                    
                    $("#totaldetcar").html(total);
                    $("#totalptodetcar").html(totalpto);                   
                }else{
                    $("#detalle").html("<span>No hay productos en el carrito</span>");
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
</script>

<!--detalle carrito -->

<span><h3>Detalle Carrito</h3></span>
<div id="detalleCarrito">
    <div id="detalle">
    
    </div>

</div>
<div id="footdetcarrito">
    <table class="tablefootdetcarrito">
<!--        <tr>
            <td style="width: 70%; text-align: right;">Totales:</td>
            <td style="text-align: left;">awqqwe</td>
        </tr>-->
        <tr>
            <td style="width:80%;"><h3>Total: $</h3></td> <td><h3><span id="totaldetcar"></span></h3></td>
        </tr>
        <tr>
            <td><h3>Total Ptos: $</h3></td><td><h3><span id="totalptodetcar"></span></h3></td>
        </tr>
        <tr>
            <td><h3>Total Flete: $</h3></td> <td><h3>0</h3></td>
        </tr>        
        <tr>
            <td class="tdspanalert"><span id="spanAlert"></span></td> <td><div class="botones" id="pagaPuntos" style="margin-left: 90px;position: static; width:50%; ">Comprar con Puntos</div></td>
        </tr>
    </table>   
</div>
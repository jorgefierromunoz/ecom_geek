<script type="text/javascript">
    $(document).ready(function() {
        verdetallecarro();
    });
    $(document).on("change", ".cant", function() {
        var idpro = $(this).attr('data-id');
        var cantidad = $(this).val();
            $.ajax({                
            url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'cantidadcarrito')); ?>/'+idpro + '/'+cantidad ,
            dataType: 'json',
            beforeSend: function() {
                    $("#totaldetcar").html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    $("#totalptodetcar").html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    $("#subtotal" + idpro).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    $("#subtotalpto"+ idpro).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                },    
            success: function(data) {
                $("#subtotal" + idpro).html(data[1]);                
                $("#subtotalpto" + idpro).html(data[2]);
                $("#iptcant"+ idpro).val(data[0]);
            },
            error: function (e,a){
            console.log(e);
            }
            });
    }); 
    function verdetallecarro(){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'versession')); ?>',
                dataType: 'json',
                success: function(data) {
                console.log(data);
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
                        lista+="<tr>";
                        lista+="<td>"+ data[item].Id + "</td>"; 
                        lista+="<td>"+ data[item].Producto + "</td>"; 
                        lista+="<td>"+ data[item].Precio + "</td>";
                        lista+="<td>"+ preciopto + "</td>"; 
                        lista+="<td><input id='iptcant" + data[item].Id + "' class='cant' type=number step=1 data-id=" + data[item].Id +" value="+ cantidad + " min=1 max=99></td>"; 
                        lista+="<td><span id='subtotal" + data[item].Id + "'>"+ subtotal + "</span></td>";
                        lista+="<td><span id='subtotalpto" + data[item].Id+ "'>"+ subtotalpto + "</span></td>";
                        lista+="<td><span class=cerrarcarrito><p class=cerr_car data-id=" + data[item].Id + ">x</p></span></td>";
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
        <tr>
            <td width="70%"><h3>Total: $</h3></td> <td><h3><span id="totaldetcar"></span></h3></td>
        </tr>
        <tr>
            <td><h3>Total Ptos: $</h3></td><td><h3><span id="totalptodetcar"></span></h3></td>
        </tr>
        <tr>
            <td></td> <td><span class="botones">Comprar</span></td>
        </tr>
    </table>   
</div>
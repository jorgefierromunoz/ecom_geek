<?php var_dump($productos); ?>
<script type="text/javascript">
$(document).ready(function(){
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
    $("#adddireccion").click(function() {
            $("#formadddirecciones").trigger("reset");
            $("#iptpestado").val("");      
            llenarlistboxcomunas();
            $("#divadddirecciones").dialog("open");
    });
});
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
     <tr><td style='text-align:right;'>Puntos Disponibles: </td><td><?php echo $productos['usuario']['User']['puntoAcumulado']; ?></td></tr>
 </table>
</div>
<span><h3>Direccion de despacho</h3></span>
<?php if(empty($productos['usuario']['User']['Direccione'])): ?>
<div>No tienes Direcciones asociadas. 
<div class="botones" id="adddireccion" style="display: inline-block;">Agregar una nueva dirección</div>
<!-- AGREGAR  -->
<div id="divadddirecciones" title="Nueva Dirección"> 
    <form id="formadddirecciones" method="POST">
        <label>Calle:</label> 
        <input id="iptcalle" type="text" name="calle">
        <span id="spnaddcalle"></span>
        <label>Número:</label> 
        <input id="iptnumero" type="text" name="numero">
        <span id="spnaddnumero"></span> 
        <label>Departamento:</label> 
        <input id="iptdpto" type="text" name="dpto"> 
        <label>Resto de la Dirección:</label> 
        <input id="iptrestodireccion" type="text" name="restoDireccion">
        <label>Código Postal:</label> 
        <input id="iptcodigoPostal" type="text" name="codigoPostal">
        <label>Geo-Referencia:</label> 
        <input id="iptgeoreferencia" type="text" name="georeferencia"> 
        <br><br>
        <input type="checkbox" id="checkestado"><label for="check">Estado</label>
        <input id="iptestado" type="hidden" name="estado">
        
        <label>Usuario:</label> 
        <input id="iptuser_id" type="text" name="user_id">
        <label>Comuna:</label> 
        <div id="list-comunas"></div>  
        <span id="spnaddcomuna"></span> 
        <hr>
        <p align="right"><button id="adddireccionessave">Guardar</button></p>
    </form>
</div>

</div>
<?php else: ?>
Elije una dirección de despacho
<div id="direcciondespacho">
    

</div>

<?php endif; ?>
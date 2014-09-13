<!DOCTYPE html>
<html>
<head>
	
	<title>
		<?php echo "Geek4y" ?>
	</title>
	<?php
		echo $this->Html->css(array('cake.generic','jquery-ui'));
                echo $this->Html->script(array('jquery','jquery-ui','upload'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <script type="text/javascript">
    $(document).ready(function(){
         $("#cargando").dialog({
            dialogClass: "no-close",
            closeOnEscape: false,
            draggable: false,
            resizable: false,
            height: 'auto',
            width: 'auto',
            autoOpen: false,
            modal: true,
            show: {
                effect: "fade",
                duration: 150
            },
            hide: {
                effect: "fade",
                duration: 150
            }
        }).css("font-size", "15px", "width", "auto");
         $('#cargando').submit(function(e) {
            e.preventDefault();
        });
        $("#prog").hide();
        
        vercarro();
    });
      $(document).on("click", ".cerr_car", function() {
            var idpro = $(this).attr('data-id');
                 $.ajax({
                beforeSend: function() { 
                     $('#divcarrito').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                },
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'eliminarproductocarro')); ?>/'+idpro,
                dataType: 'json',
                success: function(data) {
                if (data!='0'){
                    var lista="";
                    var nombreProducto="";
                    var precio=0;
                    var cantidad=0;                    
                    var subtotal=0;
                    var total=0;
                    $.each(data, function(item) {
                        nombreProducto=data[item].Producto.substring(0,8).toUpperCase();
                        precio=parseInt(data[item].Precio);
                        cantidad=parseInt(data[item].Cantidad);
                        subtotal= precio*cantidad;
                        lista+="<article class=prod_carrito>"; 
                        lista+="<table class=tablecar><tr><td width=90% >" + nombreProducto + "</td><td><span class=cerrarcarrito><p class=cerr_car data-id=" + data[item].Id + ">x</p></span></td></tr></table>";                             
                        lista+="<p>$ " + precio + "</p>"; 
                        lista+="<p>cant: <input class='cant' type=number value="+ cantidad +"></p>"; 
                        lista+="<p>sub-total: " + precio*cantidad + "</p>"; 
                        lista+="</article>";
                        total+=subtotal;
                    });
                    $("#divcarrito").html(lista);                    
                    $("#totalcarrito").html(total);
                    }else{
                    $("#divcarrito").html("<span>No hay productos en el carrito</span>");
                    $("#totalcarrito").html(" 0");
                    }
                    
                }
        });
        });   
   function vercarro(){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'versession')); ?>',
                dataType: 'json',
                beforeSend: function() {
                         $('#divcarrito').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },    
                success: function(data) {
                if (data != '0'){
                    var lista="";
                    var nombreProducto="";
                    var precio=0;
                    var cantidad=0;                    
                    var subtotal=0;
                    var total=0;
                    $.each(data, function(item) {
                        nombreProducto=data[item].Producto.substring(0,8).toUpperCase();
                        precio=parseInt(data[item].Precio);
                        cantidad=parseInt(data[item].Cantidad);
                        subtotal= precio*cantidad;
                        lista+="<article class=prod_carrito>"; 
                        lista+="<table class=tablecar><tr><td width=90% >" + nombreProducto + "</td><td><span class=cerrarcarrito><p class=cerr_car data-id=" + data[item].Id + ">x</p></span></td></tr></table>";                             
                        lista+="<p>$ " + precio + "</p>"; 
                        lista+="<p>cant: <input class='cant' type=number value="+ cantidad +"></p>"; 
                        lista+="<p>sub-total: " + precio*cantidad + "</p>"; 
                        lista+="</article>";
                        total+=subtotal;
                    });
                    $("#divcarrito").html(lista);                    
                    $("#totalcarrito").html(total);
                }else{
                    $("#divcarrito").html("<span>No hay productos en el carrito</span>");
                    $("#totalcarrito").html(" 0");
                    }
                    
                },  
                error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }
                
            });
        }
        
$(function() {
    var offset = $("#carrito").offset();
    var topPadding = 15;
    $(window).scroll(function() {
        if ($("#carrito").height() < $(window).height() && $(window).scrollTop() > offset.top) { /* LINEA MODIFICADA POR ALEX PARA NO ANIMAR SI EL SIDEBAR ES MAYOR AL TAMAÑO DE PANTALLA */
            $("#carrito").stop().animate({
                marginTop: $(window).scrollTop() - offset.top + topPadding
            });
        } else {
            $("#carrito").stop().animate({
                marginTop: 0
            });
        }
        ;
    });
});
    </script>
    <div id="cargando" title="Cargando">
       <p align="center">
        <label >Por favor espere....</label> 
        <?php echo $this->Html->image('ajaxload.gif',array('id' => 'img')); ?>
        <progress id="prog"></progress>
       </p>
    </div>
	<div id="container">
		<div id="header">
                    <nav id="menu">
                        <ul>
                            <li class="nivel1"><?php echo $this->Html->link('Home',array('controller' => 'Pages', 'action' => 'display')) ?></li>
                        <?php if ($this->Session->read('User.0.Tipo_Use')=='admin'): ?>                            
                            <li class="nivel1"><?php echo $this->Html->link('Productos', array('controller' => 'Productos', 'action' => 'index'), array('class' => 'nivel1')) ?>                            
                                <ul>
                                    <li><?php echo $this->Html->link('Fotos', array('controller' => 'Fotos', 'action' => 'index')) ?></li>
                                    <li><?php echo $this->Html->link('Tamaños', array('controller' => 'Tamanos', 'action' => 'index')) ?></li>
                                    <li><?php echo $this->Html->link('Modelos', array('controller' => 'Modelos', 'action' => 'index')) ?></li>
                                </ul>
                            </li>
                            <li class="nivel1"><?php echo $this->Html->link('Categorias', array('controller' => 'Categorias', 'action' => 'index'), array('class' => 'nivel1')) ?>
                            <ul>
                                <li><?php echo $this->Html->link('Sub Categorias', array('controller' => 'SubCategorias', 'action' => 'index')) ?></li>
                            </ul>
                            </li>
                            
                            <li class="nivel1"><?php echo $this->Html->link('Paises', array('controller' => 'Paises', 'action' => 'index'), array('class' => 'nivel1')) ?>
                                <ul>
                                    <li><?php echo $this->Html->link('Regiones', array('controller' => 'Regiones', 'action' => 'index')) ?></li>
                                    <li><?php echo $this->Html->link('Comunas', array('controller' => 'Comunas', 'action' => 'index')) ?></li>
                                    <li><?php echo $this->Html->link('Zonas', array('controller' => 'Zonas', 'action' => 'index')) ?></li>
                                </ul>
                           </li>
                            <li class="nivel1"><?php echo $this->Html->link('Bancos', array('controller' => 'Bancos', 'action' => 'index'), array('class' => 'nivel1')) ?>                                                     
                                <ul>
                                    <li><?php echo $this->Html->link('Tipo de Cuentas Bancarias', array('controller' => 'TipoCuentasBancarias', 'action' => 'index')) ?></li>
                                </ul>
                           </li>
                           <li class="nivel1"><?php echo $this->Html->link('Cat. Vendedores', array('controller' => 'CategoriaVendedores', 'action' => 'index'), array('class' => 'nivel1')) ?></li>                          
                           <li class="nivel1"><?php echo $this->Html->link('Direcciones', array('controller' => 'Direcciones', 'action' => 'index'), array('class' => 'nivel1')) ?></li>                         
                           <li class="nivel1"><?php echo $this->Html->link('Usuarios', array('controller' => 'Users', 'action' => 'index'), array('class' => 'nivel1')) ?></li>  
                        <?php elseif ($this->Session->read('User.0.Tipo_Use')=='cliente'): ?>
                            <li class="nivel1"><?php echo $this->Html->link('Detalle Carrito', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Mi Cuenta', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Historial Compras', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Cerrar Sesión', array('controller' => 'Users', 'action' => 'logout'), array('class' => 'nivel1'))?></li>
                        <?php else: ?>
                            <li class="nivel1"><?php echo $this->Html->link('Detalle Carrito', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Inicio de Sesión', array('controller' => 'Users', 'action' => 'login'),array('class'=>'nivel1'))?></li> 
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php if ($this->Session->check('User')): ?>
                    <div id="datosusu">
                        <span><?php echo $this->Session->read('User.0.Rut'); ?><br></span>
                        <span><?php echo strtoupper($this->Session->read('User.0.Nombre')." ".$this->Session->read('User.0.ApPaterno'));?><br></span> 
                        <span><?php echo $this->Session->read('User.0.Email'); ?><br></span>
                        <span><?php echo $this->Html->link('Cerrar Sesión', array('controller' => 'Users', 'action' => 'logout'))?></span><br>
                    </div>
                    <?php else: ?>
                     <div id="datosusu">
                        <div class="contbotones">
                        <span><?php echo $this->Html->link('Registro Usuario', array('controller' => 'Users', 'action' => 'nuevousuario'),array('class'=>'botones'))?></span><br>
                        </div>
                        <div class="contbotones">
                        <span><?php echo $this->Html->link('Inicio de Sesión', array('controller' => 'Users', 'action' => 'login'),array('class'=>'botones'))?></span> 
                        </div>
                     </div>
                    <?php endif; ?>
		</div>
               
               
		<div id="content">
                        <section id="menucat">
                            <h3>Menú:</h3>
                            <ul>
                                <li>Cat1</li>
                            </ul>
                        </section>
                        <section id="menucentral">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
                        </section>
                        <section id="menuder">
                            <section>                                
                                <!--carrito -->
                                <div id="carrito">
                                    <p class="namepcarr"><h3>Carrito:<br>
                                            $<span id="totalcarrito"></span></h3></p>
                                    <div id="shopping_cart">
                                        
                                        <div id="divcarrito">

                                        </div>
                                    </div>
                                    
                                    <div id=footercarrito>
                                        <span class="btncomprar">Comprar</span>
                                    </div>

                                </div>
                            </section>
                        </section>
                </div>
		<div id="footer">
			<?php echo "GEEK4Y Tecnología con estilo (".date('Y').")- Agustina 972 Oficina 1008, Santiago – (+562) 26981343";  ?>
			<?php echo "rev. 4321082014";  ?>
		</div>
	</div>
	
</body>
</html>
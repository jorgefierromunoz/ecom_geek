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
    });
   //PARA QUE EL CARRITO SIGA LA PANTALLA
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

                        </ul>
                    </nav>
                     <div id="datosusu">
                        <span><?php echo $this->Html->link('Registro Usuario', array('controller' => 'Users', 'action' => 'nuevousuario'))?></span>                                 
                    </div>
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
                                    <div id="shopping_cart">
                                        <p class="namepcarr"><h3>Carrito:<br>
                                            $<span id="totalcarrito"></span></h3></p>
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

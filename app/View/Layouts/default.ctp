<!DOCTYPE html>
<html>
<head>
	
	<title>
		<?php echo "Geek4y" ?>
	</title>
	<?php
		echo $this->Html->css(array('cake.generic','jquery-ui'));
                echo $this->Html->script(array('jquery','jquery-ui','upload','menucat'));
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
        
        $("#entrarLogin").click(function(){
            login("spnalertloginleft","formloginleft");
        });
        $("#passwordlogin").keypress(function(e){
            if(e.which == 13) {
                login("spnalertloginleft","formloginleft");
            }
        });     
         $("#usernamelogin").keypress(function(e){
            if(e.which == 13) {
                login("spnalertloginleft","formloginleft");
            }
        });
      $(document).on("click",".cerr_car", function() {   
        var idpro = $(this).attr('data-id');
        $("#prod_carrito" + idpro).fadeOut("normal", function() {                
               $.ajax({
                   beforeSend: function() { 
                        $("#prod_carrito"+idpro).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                   },
                   url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'eliminarproductocarro')); ?>/'+idpro,
                   type: 'POST',
                   dataType: 'json',
                   success: function(data) {                         
                       if (data=="0"){                            
                           $("#divcarrito").html("<span id='spncarrito_0'>No hay productos en el carrito</span>");
                           $("#totalcarrito").html("0");
                       }else{
                           $("#prod_carrito" + idpro).remove();
                           totalcarrito("totalcarrito","");
                       }
                   }
                });
           });
           
        });
        vercarro();
        
    });
     
    function login(spanalert,formSerialize){
        $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'loguear')); ?>',
                type: "POST",
                dataType: 'json',
                data: $("#"+formSerialize).serialize(),
                beforeSend: function(){$("#" + spanalert).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>Cargando Sesión...')},
                success: function(data) {
                    console.log(data);
                    if (data=='1'){
                         $("#" + spanalert).html("");
                         window.location.href = '<?php echo $this->Html->url(array('controller' => 'Pages', 'action' => 'display')); ?>';
                    }else{
                    $("#" + spanalert).html(data);
                    }
                },
                error: function(e) {  
                    $("#" + spanalert).html("Error interno, contáctese con el Administrador de la página");
                    console.log(e);
                }
            });
    }
    function vercarro(){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'versession')); ?>',
                dataType: 'json',
                beforeSend: function() {
                         $('#divcarrito').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },    
                success: function(data) {
                if (data != '0'){
                    $("#divcarrito").html("");
                    var lista="";
                    var id="";
                    var nombreProducto="";
                    var precio=0;
                    var cantidad=0;                    
                    var subtotal=0;
                    var total=0;
                    $.each(data, function(item) {
                        id= data[item].Id;
                        nombreProducto=data[item].Producto.substring(0,8).toUpperCase();
                        precio=parseInt(data[item].Precio);
                        cantidad=parseInt(data[item].Cantidad);
                        subtotal= precio*cantidad;
                        lista+="<article class=prod_carrito id=prod_carrito" + id + ">"; 
                        lista+="<table class=tablecar><tr><td width=90% >" + nombreProducto + "</td><td><span class=cerrarcarrito><p class=cerr_car data-id=" + id + ">x</p></span></td></tr></table>";                             
                        lista+="<p>$ " + precio + "</p>"; 
                        lista+="<p id=cant" + id + ">cant: "+ cantidad + " </p>"; //<input class=cant data-id=" + data[item].Id  + " type=number value="+ cantidad +"></p>"; 
                        lista+="<p id=subtotal" + id + ">sub-total: " + precio*cantidad + "</p>"; 
                        lista+="</article>";
                        total+=subtotal;                            
                    });
                    $("#divcarrito").html(lista);
                    $("#totalcarrito").html(total);
                }else{
                    $("#divcarrito").html("<span id='spncarrito_0'>No hay productos en el carrito</span>");
                    $("#totalcarrito").html(" 0");
                    }                    
                },  
                error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }
                
            });
        }
        function totalcarrito(target,target2){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'totalcarrito')); ?>',
                dataType: 'json',
                beforeSend: function() {
                         //$('#totalcarrito').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },    
                success: function(data) {
                    $("#"+target).html(data[0]);                    
                    $("#"+target2).html(data[1]);
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
                        <?php if ($this->Session->read('User.0.Tipo_Use')=='admin'): ?>                            
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
                        <?php elseif ($this->Session->read('User.0.Tipo_Use')=='cliente'): ?>
                            <li class="nivel1"><?php echo $this->Html->link('Home',array('controller' => 'Pages', 'action' => 'display')) ?></li>
                        
                            <li class="nivel1"><?php echo $this->Html->link('Detalle Carrito', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Mi Cuenta', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Historial Compras', array('controller' => 'Productos', 'action' => 'detalleCarrito'), array('class' => 'nivel1')) ?></li>                          
                            <li class="nivel1"><?php echo $this->Html->link('Cerrar Sesión', array('controller' => 'Users', 'action' => 'logout'), array('class' => 'nivel1'))?></li>
                        <?php else: ?>
                            <li class="nivel1"><?php echo $this->Html->link('Home',array('controller' => 'Pages', 'action' => 'display')) ?></li>
                            <li class="nivel1"><?php echo $this->Html->link('¿Quienes Somos?',array('controller' => 'QuienesSomos', 'action' => 'index')) ?></li>
                            <li class="nivel1"><?php echo $this->Html->link('Contacto',array('controller' => 'Contacto', 'action' => 'index')) ?></li>
                            <li class="nivel1"><?php echo $this->Html->link('¿Dónde Estamos?',array('controller' => 'DondeEstamos', 'action' => 'index')) ?></li>

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
                    
                    <?php endif; ?>
		</div>
               
               
		<div id="content">
                    <section id="menucat">
                        <?php if (!$this->Session->check('User')): ?>
                        <div id="divloginizq">
                            <span>Inicio Sesión</span>
                            <form id="formloginleft">
                                <table class="logintableizq">
                                    <tr>
                                        <td>Email:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="usernamelogin" name="username"></td>
                                    </tr>
                                    <tr>
                                        <td>Password:</td>
                                    </tr>
                                    <tr>
                                        <td><input type="password" id="passwordlogin" name="password"></td>
                                    </tr>
                                    <tr>
                                        <td><span id="spnalertloginleft"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="centertable">                    
                                            <div class="contbotones"><span id="entrarLogin" class="botones">Entrar</span></div>
                                             <p><?php echo $this->Html->link('¿Olvidó su contraseña?', array('controller' => 'Users', 'action' => 'recuperacionpass'),array('class'=>'alinkolvidocont')); ?></p>
                                             <p><?php echo $this->Html->link('¿Nuevo Usuario?', array('controller' => 'Users', 'action' => 'nuevousuario'),array('class'=>'alinkolvidocont')); ?></p>
                                        </td>
                                    </tr>                                                             
                     </div>
                                </table>
                            </form>
                        </div>
                        <?php endif; ?>
                        <div id='cssmenu'>
                            
                        </div>

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
                                        <span class="spancomprar"><?php echo $this->Html->link('Detalle', array('controller' => 'Productos', 'action' => 'detalleCarrito'),array('class'=>'btncomprar'))?></span> 
                        
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

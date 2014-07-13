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
	<div id="container">
		<div id="header">
                    <nav>
                        <ul>
                            <li><?php echo $this->Html->link('Home','/pages/home') ?></li>
                            <li><?php echo $this->Html->link('Categorias', array('controller' => 'Categorias', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Sub Categorias', array('controller' => 'SubCategorias', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Tamaños', array('controller' => 'Tamanos', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Modelos', array('controller' => 'Modelos', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Paises', array('controller' => 'Paises', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Regiones', array('controller' => 'Regiones', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Comunas', array('controller' => 'Comunas', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Zonas', array('controller' => 'Zonas', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Fotos', array('controller' => 'Fotos', 'action' => 'index')) ?></li>
                            <li><?php echo $this->Html->link('Productos', array('controller' => 'Productos', 'action' => 'index')) ?></li>
                        </ul>
                    </nav>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo "GEEK4Y Tecnología con estilo (".date('Y').")- Agustina 972 Oficina 1008, Santiago – (+562) 26981343" ?>
		</div>
	</div>
	
</body>
</html>

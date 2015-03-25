<?php if ($this->Session->read('User.0.Tipo_Use')=='admin'): ?>         
<script>
    $(document).ready(function() {
        //DECLARACION DIALOG DIV AGREGAR Y EDITAR 
        $("#divaddfoto").dialog({
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
         $('#formaddfoto').submit(function(e) {
            e.preventDefault();
        });
        //SELECCION DE IMAGENES AGREGAR 
        $('#imagenefile').change(function() {
            $("#iptfoto").val(limpiarNombre($('#imagenefile').val()));
        });
        //OPEN DIV NUEVA  BUTTON
        //-----------------------------------
        $("#btnaddfoto").click(function() {
            $("#formaddfoto").trigger("reset");
            $("#imagenefile").val("");            
            ocultarspan();
            $("#divaddfoto").dialog("open");
        });
        //nueva imagen
        $("#addfotosave").click(function(e) {            
        e.preventDefault();
        //imagenefile
          if ( $("#iptfoto").val().trim().length == 0) {
            $("#spnaddfoto").html("Elija una imagen");
            $("#spnaddfoto").show();
            $("#spnaddalert").show();
          }else if ( $("#imagenefile").val().trim().length == 0){
            $("#spnaddalert").show();
          }else {
            $("#cargando").dialog("open");
            $("#prog").show();
            $("#img").hide();
            $("#imagenefile").upload('<?php echo $this->Html->url(array('controller'=>'Fotos','action'=>'subirimagen'));?>',{url:$("#iptfoto").val(),producto_id:$("#iptproductoadd").val()} ,function(listo) {
                 if (listo=="1"){
                    $("#formaddfoto").trigger("reset"); 
                    $("#divaddfoto").dialog("close");
                     location.reload();
                }else{
                    $("#spnaddfoto").html(listo);
                    $("#spnaddfoto").show();
                    $("#spnaddalert").show();
                }                
                $("#cargando").dialog("close");
                $("#prog").hide();
                $("#img").show();
            }, $("#prog"));    


         }
    });       
    });   
     function ocultarspan(){       
        $("#spnaddfoto").hide(); 
        $("#spnaddalert").hide(); 
        $("#spneditfoto").hide(); 
        $("#spneditalert").hide();
        $("#prog").hide();
        $("#progedit").hide();
        
    }
    function limpiarNombre(nombre){
        var e=nombre.split('\\').pop();
        e = e.replace(/\s/g, '');
        return e.substring(0, e.indexOf('.'));
    }
</script>
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="../../js/carousel.conected.css">
<script type="text/javascript" src="../../js/carrousel.min.js"></script>
<script type="text/javascript" src="../../js/carousel.conected.js"></script>

<div class="connected-carousels">
<div class="stage">
    <div class="carousel carousel-stage" data-jcarousel="true">
        <ul class="ulproductosg" style="left: 0px; top: 0px;">
            <?php foreach ($productos['Foto'] as $imagenes): ?> 
                <li><?php echo $this->Html->image("Fotos/".$imagenes["url"]);?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <a href="#" class="prev prev-stage inactive" data-jcarouselcontrol="true"><span>‹</span></a>
    <a href="#" class="next next-stage" data-jcarouselcontrol="true"><span>›</span></a>
</div>
<div class="navigation">
    <a href="#" class="prev prev-navigation inactive" data-jcarouselcontrol="true">‹</a>
    <a href="#" class="next next-navigation" data-jcarouselcontrol="true">›</a>
    <div class="carousel carousel-navigation" data-jcarousel="true">
        <ul class="ulproductos" style="left: 0px; top: 0px;">
            <?php foreach ($productos['Foto'] as $imagenes): ?> 
                <li><?php echo $this->Html->image("Fotos/s_".$imagenes["url"]);?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</div>
<?php if ($this->Session->read('User.0.Tipo_Use')=='admin'): ?>   
<div class="contbotones" style="text-align: center;">
    <button  id="btnaddfoto" class="botones">Agregar Nueva Imagen</button>
</div>
<!-- AGREGAR  -->
<div id="divaddfoto" title="Nueva Imagen"> 
    <form id="formaddfoto" method="POST">
        <label>URL:</label> 
        <input type="file" id="imagenefile" name="imagen" accept="image/jpeg, image/png" /><br>
        <label>Nombre:</label>
        <input id="iptfoto" type="text" name="url">
        <span id="spnaddfoto"></span>
        <label>Producto:</label> 
        <input id="iptproductoadd" type="text" value="<?php echo $productos['Producto']['id'];?>" name="producto_id" style="display:none;">  
        
        <button id="addfotosave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>
<?php endif; ?>
<section class="descripcion">

    
<?php
echo "Producto: ". $productos['Producto']['producto'].'<br>';
echo "Descripcion: ".$productos['Producto']['descripcion'].'<br>';
echo "Stock: ".$productos['Producto']['stock'].'<br>';
echo "Precio: ".$productos['Producto']['precio'].'<br>';

?>
    
</section>
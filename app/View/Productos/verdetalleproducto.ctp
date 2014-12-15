<link rel="stylesheet" type="text/css" href="../../js/carousel.conected.css">
<script type="text/javascript" src="../../js/carrousel.min.js"></script>
<script type="text/javascript" src="../../js/carousel.conected.js"></script>
<div class="connected-carousels">
                <div class="stage">
                    <div class="carousel carousel-stage" data-jcarousel="true">
                        <ul class="ulproductosg" style="left: 0px; top: 0px;">
                            <?php
    $listaProductos="<li>";
     foreach ($productos['Foto'] as $imagenes): 
 $listaProductos.="<img src='../../img/Fotos/{$imagenes["url"]}'></li>";
endforeach;
echo $listaProductos;?>
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
                            <?php
    $listaProductos="<li>";
     foreach ($productos['Foto'] as $imagenes): 
 $listaProductos.="<img src='../../img/Fotos/s_{$imagenes["url"]}'></li>";
endforeach;
echo $listaProductos;?>
                        </ul>
                    </div>
                </div>
            </div>
            <section class="descripcion">
            <?php
            echo "Producto: ". $productos['Producto']['producto'].'<br>';
            echo "Descripcion: ".$productos['Producto']['descripcion'].'<br>';
            echo "Stock: ".$productos['Producto']['stock'].'<br>';
            echo "Precio: ".$productos['Producto']['precio'].'<br>';
            ?>
            </section>
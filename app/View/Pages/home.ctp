<script type="text/javascript">
    $(document).ready(function(){
        TodosProductos("id","asc");
    });
    function TodosProductos(atributo,orden) {
        var flag = false;
        var listaproductos = '';
        $.ajax({
            beforeSend: function() {
                 $('#listado_productos').html("<img src='img/ajaxload2.gif'>");
            },
            url: 'Productos/listaproductos/Producto.'+atributo+'/'+orden,
            dataType: 'json',
            success: function(data) {                
                listaproductos += '<article class=productos_lista><ul>';
                $.each(data, function(item2) {
                    if (data != "") {
                        flag = true;//<br>Precio: $' + data[item2].Producto.precio + '
                        var nombreproducto=data[item2].Producto.producto.toUpperCase();
                        nombreproducto=nombreproducto.substr(0,10);
                        var precio= data[item2].Producto.precio;
                        
                        listaproductos += '<li class="productos" id="slidingProduct' + data[item2].Producto.id + '">';
                        listaproductos += '<span class="preciopro"><p class=precio>$ ' +precio + '</p></span>';
                        var imagenes = data[item2].Foto;
                        $.each(imagenes, function(item3) {
                            listaproductos += '<div class="caja_img" style="background-image:url(img/Fotos/s_' +  imagenes[item3].url + ')" data-id="' + data[item2].Producto.id + '"></div>';
                            return false;
                        });             
                        listaproductos += '<img src="img/ver.png" class="btnver" data-id=' + data[item2].Producto.id + '>';
                        listaproductos += '<img src="img/carrito.png" class="btnadd" data-id=' + data[item2].Producto.id + '>';
                        listaproductos += '</li>';
                    }
                });
                if (flag) {
                    listaproductos += '</ul></article>';
                    $('#listado_productos').html(listaproductos);
                } else {
                    listaproductos = "<p align=center>Actualmente no hay productos en la Base de datos</p>";
                    $('#listado_productos').html(listaproductos);
                }
            }

        });
    }
</script>
    <section id="cuerpo">
        <section id="productpromo">
           <p><h3>productos en promo</h3></p>
        </section>   

        <section id="bodyproductos">
            <div id="menuproductos">a-z seach</div>
            <div id="targetproducto">
                
                <div id="listado_productos">

                </div>
            </div>
        </section>
    </section>    
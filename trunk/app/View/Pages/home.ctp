<script type="text/javascript" src="js/fly-to-basket.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        TodosProductos("id","asc");
    });
    
        $(document).on("click", ".btnadd", function() {
            var idpro = $(this).attr('data-id');
                addToBasket(idpro);
                carrito(idpro);
        });
                
        function carrito(idpro){
        $.ajax({
                beforeSend: function() {
                     $('#divcarrito').html("<img src='img/ajaxload2.gif'>");
                },
                url: 'Productos/carrito/'+idpro,
                dataType: 'json',
                success: function(data) {
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
                }
            });
        }
        
    function TodosProductos(atributo,orden) {
        var flag = false;
        var listaproductos = '';
        var listapromo='';
        $.ajax({
            beforeSend: function() {
                 $('#listado_productos').html("<img src='img/ajaxload2.gif'>");
            },
            url: 'Productos/listaproductos/Producto.'+atributo+'/'+orden,
            dataType: 'json',
            success: function(data) {  
                listaproductos += '<article class=productos_lista ><ul>'; 
                $.each(data, function(item2) {
                    if (data != "") {                        
                        flag = true;
                        var nombreproducto=data[item2].Producto.producto.toUpperCase();
                        nombreproducto=nombreproducto.substr(0,10);
                        var precio= data[item2].Producto.precio;
                        listaproductos += '<li class="productos" id="slidingProduct' + data[item2].Producto.id + '">';                        
                        listaproductos += '<span class="preciopro"><p class=precio>$ ' +precio + '</p></span>';                        
                        var imagenes = data[item2].Foto;
                        $.each(imagenes, function(item3) {
                            listaproductos += '<div class="caja_img" style="background-image:url(img/Fotos/s_' +  imagenes[item3].url + ')" data-id="' + data[item2].Producto.id + '"></div>';
                            if ((data[item2].Producto.prioridadPrecio)){     
                                listapromo+='<li class="productos" ' + data[item2].Producto.id + '">';
                            }else if(data[item2].Producto.prioridadPunto) {
                                listapromo+='<li><img src="img/Fotos/s_' + imagenes[item3].url + '" /></li>';
                            }                           
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
                    $('#listado_product_promo').html('<li>No hay productos en Promoción</li>');
                    $('#listado_productos').html(listaproductos);
                    
                }
            }

        });
    }
</script>
    <section id="cuerpo">
        <section id="productpromo">
        
        </section>   

        <section id="bodyproductos">
            <div id="menuproductos">a-z seach</div>
            <div id="targetproducto">
                
                <div id="listado_productos">

                </div>
            </div>
        </section>
    </section>    
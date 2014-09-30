<script type="text/javascript" src="js/fly-to-basket.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        TodosProductos("id","asc");
    });
    
        $(document).on("click", ".btnadd", function() {
            var idpro = $(this).attr('data-id');
            addToBasket(idpro);
            $.ajax({
                beforeSend: function() {
                     //$('#divcarrito').html("<img src='img/ajaxload2.gif'>");
                },
                url: 'Productos/carrito/'+idpro,
                dataType: 'json',
                success: function(data) {
                    var lista="";                    
                    var id= data[0];
                    var nombreProducto=data[1].substring(0,8).toUpperCase();
                    var precio=parseInt(data[3]);
                    var cantidad=parseInt(data[2]);                    
                    var subtotal=precio*cantidad;
                    var total=0;
                    if ($("#prod_carrito"+id).length){
                        $("#cant" + id).html("cant: " + cantidad);
                        $("#subtotal" + id).html("sub-total: " + subtotal);
                    }else{
                        lista+="<article class=prod_carrito id=prod_carrito" + id + ">"; 
                        lista+="<table class=tablecar><tr><td width=90% >" + nombreProducto + "</td><td><span class=cerrarcarrito><p class=cerr_car data-id=" + id + ">x</p></span></td></tr></table>";                             
                        lista+="<p>$ " + precio + "</p>"; 
                        lista+="<p id=cant" + id + ">cant: "+ cantidad + " </p>"; //<input class=cant data-id=" + data[item].Id  + " type=number value="+ cantidad +"></p>"; 
                        lista+="<p id=subtotal" + id + ">sub-total: " + precio*cantidad + "</p>"; 
                        lista+="</article>";
                        $(lista).hide().appendTo("#divcarrito").fadeIn("normal");

                        //$("#divcarrito").html(lista);
                        //$("#totalcarrito").html(total);            
                    }
                }
        
            });
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
                }
            });
        }
        
    function TodosProductos(atributo,orden) {
        var listaproductos = '';
        var listapromo='';
        $.ajax({
            beforeSend: function() {
                 $('#ullistaproductos').html("<img src='img/ajaxload2.gif'>");
            },
            url: 'Productos/listaproductos/Producto.'+atributo+'/'+orden,
            dataType: 'json',
            success: function(data) {                  
                if (data != "") {
                    $('#ullistaproductos').html("");
                    $.each(data, function(item2) {
                        listaproductos="";
                        var nombreproducto=data[item2].Producto.producto.toUpperCase();
                        nombreproducto=nombreproducto.substr(0,25);
                        var precio= data[item2].Producto.precio;
                        listaproductos += '<li class="productos" id="slidingProduct' + data[item2].Producto.id + '">';                        
                        listaproductos += '<span class="nom_pro"><p>' + nombreproducto + '</p></span><span class="preciopro"><p class=precio>$ ' +precio + '</p></span>';                        
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
                        $('#ullistaproductos').append(listaproductos);                        
                });
                }else{
                    listaproductos = "<p align=center>Actualmente no hay productos en la Base de datos</p>";
                    $('#listado_product_promo').html('<li>No hay productos en Promoción</li>');
                    $('#ullistaproductos').html(listaproductos);
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
                <div id="listado_productos" class="productos_lista">
                    <ul id="ullistaproductos">
                        
                    </ul>
                </div>
            </div>
        </section>
    </section>    



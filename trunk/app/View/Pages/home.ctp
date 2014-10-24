<script type="text/javascript" src="js/fly-to-basket.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        TodosProductos("id","asc",1);
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
          //PAGINA           
        $(document).on("click", ".pagina", function(e) {
            e.preventDefault();
            var boton = $(this).attr('data-id');
            console.log(boton);
            var pa = parseInt($(this).attr('data-pa'));
            console.log(pa);
            if (boton=="atras"){
                TodosProductos("id","asc",pa-1);
            }else if (boton=="siguiente"){
                TodosProductos("id","asc",pa+1);
            }else if (boton=="ultima"||boton=="primera"){
                TodosProductos("id","asc",pa);
            }
         });
        
    function TodosProductos(atributo,orden,pagina) {
        var listaproductos = '';
        var listapromo='';
        $.ajax({
            beforeSend: function() {
                 //$('#ullistaproductos').html("<img src='img/ajaxload2.gif'>");
            },
            url: 'Productos/listaproductos/Producto.'+atributo+'/'+orden+'/'+pagina,
            dataType: 'json',
            success: function(data) {    
                if (data != "") {
                    $('#ullistaproductos').html("");
                    var pagina="";
                    if (data[2]==1){
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td><span class=pagina data-id=primera data-pa=1 > << </span></td>';
                        pagina+='<td>Atrás</td><td><span class=pagina data-id=siguiente data-pa=' + data[2]+' > Siguiente </span></td><td><span class=pagina data-id=ultima data-pa=' + data[3]+' > >> </span></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }else if(data[2]==data[3]){
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td><span class=pagina data-id=primera data-pa=1 > << </span></td><td><span class=pagina data-id=atras data-pa=' + data[2] + ' >Atrás</span></td><td>Siguiente</td><td><span class=pagina data-id=ultima data-pa=' + data[3]+' > >> </span></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }else{
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td><span class=pagina data-id=primera data-pa=1 > << </span></td><td><span class=pagina data-id=atras data-pa=' + data[2] + ' >Atrás</span></td><td><span class=pagina data-id=siguiente data-pa=' + data[2] + ' >Siguiente</span></td><td><span class=pagina data-id=ultima data-pa=' + data[3]+' > >> </span></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }
                    $("#footermenuproductos").html(pagina);
                    $.each(data[0], function(index,item2) {
                        listaproductos="";
                        var nombreproducto=item2.Producto.producto.toUpperCase();
                        nombreproducto=nombreproducto.substr(0,25);
                        var precio= item2.Producto.precio;
                        listaproductos += '<li class="productos" id="slidingProduct' + item2.Producto.id + '">';                        
                        listaproductos += '<span class="nom_pro"><p>' + nombreproducto + '</p></span><span class="preciopro"><p class=precio>$ ' +precio + '</p></span>';                        
                        var imagenes = item2.Foto;
                        $.each(imagenes, function(item3) {                           
                            listaproductos += '<div class="caja_img" style="background-image:url(img/Fotos/s_' +  imagenes[item3].url + ')" data-id="' + item2.Producto.id + '"></div>';
                            if ((item2.Producto.prioridadPrecio)){     
                                listapromo+='<li class="productos" ' + item2.Producto.id + '">';
                            }else if(item2.Producto.prioridadPunto) {
                                listapromo+='<li><img src="img/Fotos/s_' + imagenes[item3].url + '" /></li>';
                            }                           
                            return false;
                        });             
                        listaproductos += '<img src="img/ver.png" class="btnver" data-id=' + item2.Producto.id + '>';
                        listaproductos += '<img src="img/carrito.png" class="btnadd" data-id=' + item2.Producto.id + '>';
                        listaproductos += '</li>';  
                        //$('#ullistaproductos').append(listaproductos); 
                        $(listaproductos).hide().appendTo("#ullistaproductos").fadeIn("normal");
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
            <div id="menuproductos"></div>
            <div id="targetproducto">                
                <div id="listado_productos" class="productos_lista">
                    <ul id="ullistaproductos">
                        
                    </ul>
                </div>
            </div>
            <div id="footermenuproductos"></div>
        </section>
    </section>    



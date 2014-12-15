<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/fly-to-basket.js"></script>
<!--<script type="text/javascript" src="js/CoinSlider.js"></script>
<link rel="stylesheet" type="text/css" href="js/CoinSlider.css">-->
<link rel="stylesheet" type="text/css" href="js/carrousel.css">
<script type="text/javascript" src="js/carrousel.min.js"></script>
<script type="text/javascript" src="js/jcarrousel.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        TodosProductos("id","asc",1);
        vercategorias();
        $(".btnver").click(function(){
            $("#detalle-producto").dialog();
        });
    });
    $(document).on("click", ".btnMenuCat", function() {
       var idsubcategoria = $(this).attr('data-id');
       if (idsubcategoria==""){
            //$('#listado_product_promo').html('<li>No hay productos en Promoción</li>');
            $('#ullistaproductos').html("No hay productos en esta categoria");
       }else if (idsubcategoria==0){
           TodosProductos("id","asc",1);
       }else {
           ListarProductoSubCategoria("id","asc",1,idsubcategoria);
       }
    });
        $(document).on("click", ".btnadd", function() {     
            $("#spncarrito_0").remove();
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
                    if ($("#prod_carrito" + id).length){
                        $("#cant" + id).html("cant: " + cantidad);
                        $("#subtotal" + id).html("sub-total: " + subtotal);
                    }else{
                        lista+="<article class=prod_carrito id=prod_carrito" + id + ">"; 
                        lista+="<table class=tablecar><tr><td width=90% >" + nombreProducto + "</td><td><span class=cerrarcarrito><p class=cerr_car data-id=" + id + ">x</p></span></td></tr></table>";                             
                        lista+="<p>$ " + precio + "</p>"; 
                        lista+="<p id=cant" + id + ">cant: "+ cantidad + " </p>"; //<input class=cant data-id=" + data[item].Id  + " type=number value="+ cantidad +"></p>"; 
                        lista+="<p id=subtotal" + id + ">sub-total: " + subtotal + "</p>"; 
                        lista+="</article>";
                        $(lista).hide().appendTo("#divcarrito").fadeIn("normal");
                    }
                    totalcarrito("totalcarrito","");
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
            var pa = parseInt($(this).attr('data-pa'));
            if (boton=="atras"){
                TodosProductos("id","asc",pa-1);
            }else if (boton=="siguiente"){
                TodosProductos("id","asc",pa+1);
            }else if (boton=="ultima"||boton=="primera"){
                TodosProductos("id","asc",pa);
            }
         });
          //PAGINA SUB CATEGORIA       
        $(document).on("click", ".paginacionsubcat", function(e) {
            e.preventDefault();
            var boton = $(this).attr('data-id');
            var pa = parseInt($(this).attr('data-pa'));
            var subCat = parseInt ($(this).attr('data-subcat'));
            console.log(subCat);
            if (boton=="atras"){
                ListarProductoSubCategoria("id","asc",pa-1,subCat);
            }else if (boton=="siguiente"){
                ListarProductoSubCategoria("id","asc",pa+1,subCat);
            }else if (boton=="ultima"||boton=="primera"){
                ListarProductoSubCategoria("id","asc",pa,subCat);
            }
         });
    function ListarProductoSubCategoria(atributo,orden,pagina,subcategoria){
        
        var listaproductos = '';
        var listapromo='';
        $.ajax({
            beforeSend: function() {
                 $('#ullistaproductos').html("<center><img src='img/ajaxload2.gif'></center>");
            },
            url: 'Productos/listaproductossubcategoria/Producto.'+atributo+'/'+orden+'/'+pagina+'/'+subcategoria,
            dataType: 'json',
            success: function(data) { 
                //console.log("Total producto "+ data[1] +" pagina " + data[2] + " de " + data[3]);
                if (data[0].length != 0) {
                    $('#ullistaproductos').html("");
                    var pagina="";
                    if (data[3] == 1){
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td></td>';
                        pagina+='<td></td><td></td><td></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }else if (data[2]==1){
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td><span class=paginacionsubcat data-id=primera data-pa=1 data-subcat=' + subcategoria + ' > << </span></td>';
                        pagina+='<td>Atrás</td><td><span class=paginacionsubcat data-id=siguiente data-pa=' + data[2]+' data-subcat=' + subcategoria + ' > Siguiente </span></td><td><span class=paginacionsubcat data-id=ultima data-pa=' + data[3]+' data-subcat=' + subcategoria + ' > >> </span></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }else if(data[2]==data[3]){                        
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td><span class=paginacionsubcat data-id=primera data-pa=1 data-subcat=' + subcategoria + ' > << </span></td><td><span class=paginacionsubcat data-id=atras data-pa=' + data[2] + ' data-subcat=' + subcategoria + ' >Atrás</span></td><td>Siguiente</td><td><span class=paginacionsubcat data-id=ultima data-pa=' + data[3]+' data-subcat=' + subcategoria + ' > >> </span></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }else{
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td><span class=paginacionsubcat data-id=primera data-pa=1 data-subcat=' + subcategoria + '> << </span></td><td><span class=paginacionsubcat data-id=atras data-pa=' + data[2] + ' data-subcat=' + subcategoria + ' >Atrás</span></td><td><span class=paginacionsubcat data-id=siguiente data-pa=' + data[2] + ' data-subcat=' + subcategoria + ' >Siguiente</span></td><td><span class=paginacionsubcat data-id=ultima data-pa=' + data[3]+' data-subcat=' + subcategoria + '> >> </span></td></tr>';
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
                                listapromo+='<li class="productos" ' + item2.Producto.id + '"></li>';
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
                    listaproductos = "No hay productos en esta categoria";
                    //$('#listado_product_promo').html('<li>No hay productos en Promoción</li>');
                    $('#ullistaproductos').html(listaproductos);
                }
            }

        });
    }
    
    function TodosProductos(atributo,orden,pagina) {
        var listaproductos = '';
        var listapromo='';
        $.ajax({
            beforeSend: function() {
                 $('#ullistaproductos').html("<center><img src='img/ajaxload2.gif'></center>");
            },
            url: 'Productos/listaproductos/Producto.'+atributo+'/'+orden+'/'+pagina,
            dataType: 'json',
            success: function(data) {    
                if (data != "") {
                    $('#ullistaproductos').html("");
                    var pagina="";
                    if (data[3] == 1){
                        pagina='<table class="paginacion"><tr>';
                        pagina+='<td></td>';
                        pagina+='<td></td><td></td><td></td></tr>';
                        pagina+='<tr><td colspan=4>Página '+data[2] +' de '+ data[3] +'</td></tr>';
                        pagina+='</table>';
                    }else if (data[2]==1){
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
                                listapromo+='<li><img  src="img/Fotos/s_' + imagenes[item3].url + '" /></li>';
                            }else if(item2.Producto.prioridadPunto) {
                                listapromo+='<li><img  src="img/Fotos/s_' + imagenes[item3].url + '" /></li>';
                            }                           
                            return false;
                        });             
                        listaproductos += '<a href="<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'verdetalleproducto')); ?>/'+ item2.Producto.id +'" ><img src="img/ver.png" class="btnver" data-id=' + item2.Producto.id + '></a>';
                        listaproductos += '<img src="img/carrito.png" class="btnadd" data-id=' + item2.Producto.id + '>';
                        listaproductos += '</li>';
                        $("#ulproductpromo").append(listapromo);
                        /*$("#productpromo").coinslider({
                            width:500,
                            height:175,
                            spw: 1, // squares per width
                            sph: 1, // squares per height
                            delay: 3000, // delay between images in ms
                            sDelay: 1, // delay beetwen squares in ms
                            opacity: 0.5, // opacity of title and navigation
                            titleSpeed: 800, // speed of title appereance in ms
                            effect: 'rain', // random, swirl, rain, straight
                            navigation: false, // prev next and buttons
                            links : false, // show images as links
                            hoverPause: true // pause on hover
                        });*/
                        //$('#ullistaproductos').append(listaproductos); 
    $('.jcarousel').jcarousel({
        // Configuration goes here
    });
    $('.jcarousel-prev').jcarouselControl({
        target: '-=1'
    });

    $('.jcarousel-next').jcarouselControl({
        target: '+=1'
    });
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
        function vercategorias(){
        $.ajax({                
                url: '<?php echo $this->Html->url(array('controller'=>'Categorias','action'=>'listacategorias','Categoria.id','asc')); ?>',
                dataType: 'json',
                beforeSend: function() {
                         //$('#cssmenu').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },    
                success: function(data) {
                    var categoriahtm='<ul><li class="btnMenuCat" data-id="0"><p><span>Todos</span></p></li>';
                    $.each(data, function(item) {                        
                        var categoria = data[item].Categoria.categoria;
                        var numSubcat=data[item].SubCategoria.length;
                        if (numSubcat != 0){
                            categoriahtm +='<li class="has-sub"><p><span>' + categoria + '</span></p><ul>';
                            var subcat = data[item].SubCategoria;
                            $.each(subcat, function(item2) {
                                if(item2 + 1 != numSubcat){
                                    categoriahtm += '<li class="btnMenuCat" data-id="' + subcat[item2].id + '"><p><span>' + subcat[item2].subCategoria + '</span></p></li>';
                                }else{
                                    categoriahtm += '<li class="last btnMenuCat" data-id="' + subcat[item2].id + '"><p><span>' + subcat[item2].subCategoria + '</span></p></li>';               
                                }                               
                            });
                            categoriahtm += '</ul>';
                        }else{                                                
                            var class_last = (data.length == item + 1)? "class='last btnMenuCat' data-id=''":"";
                            categoriahtm +='<li ' + class_last + '><p><span>' + categoria + '</span></p></li>';
                        }
                    });
                    categoriahtm += '</ul>';
                    $("#cssmenu").html(categoriahtm);
                    $('#cssmenu>ul>li.has-sub>p').append('<span class="holder"></span>');
                    $('#cssmenu li.has-sub>p').on('click', function(){
                        //$(this).removeAttr('href');
                        var element = $(this).parent('li');
                        if (element.hasClass('open')) {
                                element.removeClass('open');
                                element.find('li').removeClass('open');
                                element.find('ul').slideUp();
                        }
                        else {
                                element.addClass('open');
                                element.children('ul').slideDown();
                                element.siblings('li').children('ul').slideUp();
                                element.siblings('li').removeClass('open');
                                element.siblings('li').find('li').removeClass('open');
                                element.siblings('li').find('ul').slideUp();
                        }
                });
                },  
                error: function(xhr, status, error){
                    //var err = eval("(" + xhr.responseText + ")");
                    console.log(xhr.responseText );
                }                
            });
        }
            
(function getColor() {
    var r, g, b;
    var textColor = $('#cssmenu').css('color');
    textColor = textColor.slice(4);
    r = textColor.slice(0, textColor.indexOf(','));
    textColor = textColor.slice(textColor.indexOf(' ') + 1);
    g = textColor.slice(0, textColor.indexOf(','));
    textColor = textColor.slice(textColor.indexOf(' ') + 1);
    b = textColor.slice(0, textColor.indexOf(')'));
    var l = rgbToHsl(r, g, b);
    if (l > 0.7) {
            $('#cssmenu>ul>li>p').css('text-shadow', '0 1px 1px rgba(0, 0, 0, .35)');
            $('#cssmenu>ul>li>p>span').css('border-color', 'rgba(0, 0, 0, .35)');
    }
    else
    {
            $('#cssmenu>ul>li>p').css('text-shadow', '0 1px 0 rgba(255, 255, 255, .35)');
            $('#cssmenu>ul>li>p>span').css('border-color', 'rgba(255, 255, 255, .35)');
    }
})();

function rgbToHsl(r, g, b) {
    r /= 255, g /= 255, b /= 255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;

    if(max == min){
        h = s = 0;
    }
    else {
        var d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch(max){
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }
    return l;
}
</script>
    <section id="cuerpo">
    <div id="contenedor-slide" class="jcarousel-wrapper">
        <div id="productpromo" class="jcarousel">
        <ul id="ulproductpromo" style="left: -400px; top: 0px;">
        </ul>
        </div>
        <a class="jcarousel-prev" href="#">Prev</a>
    <a class="jcarousel-next" href="#">Next</a>
        </div>   

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
<div id="detalle-producto"></div>


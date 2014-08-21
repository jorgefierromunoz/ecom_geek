 $(document).ready(function(){
   //SELECCION DEL COMBOBOX ON CHANGE ADD
        $("#list-categorias").change(function() {
            if ($("#select-categorias").val()==""){
              $("#list-subcategorias").html("<select id=select-subcategorias><option value=''>Seleccione una Sub Categoria</option>");
            }
            else{
               llenarlistboxsubCategorias("x", $("#select-categorias").val()); 
            }    
        });   
        
  
 });

function llenarlistboxsubCategorias(resp,idcat) {
        $.ajax({
            url: 'SubCategorias/listasubcategoriasComboBox/'+idcat,
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ if (resp=="x"){
                    $('#list-subcategorias').html("<img src='img/ajaxload2.gif'>");}
                else{
                    $('#list-editsubcategorias').html("<img src='img/ajaxload2.gif'>");
                }},
            success: function(data) {                    
                    if(data!=""){
                        var list =""; 
                        var flag=true;
                        if (resp=="x") {
                            list = '<select id="select-subcategorias" name="sub_categoria_id"><option value="">Seleccione una Sub Categoria</option>';
                        }else{
                            list ='<select id="select-editsubcategorias" name="sub_categoria_id">';
                        } 
                        $.each(data, function(item) {                        
                            if(resp==data[item].SubCategoria.id){ 
                                list += '<option selected=selected value=' + data[item].SubCategoria.id + '>' + data[item].SubCategoria.subCategoria + '</option>';
                                llenarlistboxCategorias(data[item].Categoria.id);
                            }else{
                                if ((resp=="x20")&&(flag)){
                                    llenarlistboxProductos("xa",data[item].SubCategoria.id);
                                    flag=!flag;                                  
                                }
                                list += '<option value=' +  data[item].SubCategoria.id + '>' + data[item].SubCategoria.subCategoria + '</option>';
                            }                       
                        });
                        list += '</select>';
                        if (resp=="x") {
                            $('#list-subcategorias').html(list);
                        }else{
                            $('#list-editsubcategorias').html(list);
                        }
                    }else{
                        var list = '<select id="select-editsubcategorias"><option>No hay Sub Categorias en la BD</option>';
                        if (resp=="x"){
                           $('#list-subcategorias').html(list);
                        }else{
                           $('#list-editsubcategorias').html(list);
                        }
                    }
               }
         });
    }
     function llenarlistboxCategorias(resp) {
           $.ajax({
            url: 'Categorias/listacategoriasComboBox',
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ if (resp=="x"){
                    $('#list-categorias').html("<img src='img/ajaxload2.gif'>");}
                else{
                    $('#list-editcategorias').html("<img src='img/ajaxload2.gif'>");
                }},
            success: function(data){
                    if(data!=""){
                        if (resp=="x") {
                            list = '<select id="select-categorias"><option value="">Seleccione una Categoria</option>';
                        }else{
                            list ='<select id="select-editcategorias">';
                        }
                        $.each(data, function(item) {
                            if(resp==data[item].Categoria.id){ 
                                list += '<option selected=selected value=' + data[item].Categoria.id + '>' + data[item].Categoria.categoria + '</option>';
                            }else{
                                list += '<option value=' +  data[item].Categoria.id + '>' + data[item].Categoria.categoria + '</option>';
                            }                       
                        });
                        list += '</select>';
                        if (resp=="x") {
                            $('#list-categorias').html(list);
                        }else{
                            $('#list-editcategorias').html(list);                            
                        }
                    }else{
                        var list = '<select id="select-editcategorias"><option>No hay Categorias en la BD</option>';
                        if (resp=="x"){
                             $('#list-categorias').html(list);
                        }else{
                             $('#list-editcategorias').html(list);
                        }
                    }
               }
         });
    }
    
function llenarlistboxProductos(resp,idsubcat) {
        $.ajax({
            url: 'Productos/productosidsubcategoria/'+idsubcat,
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ if (resp=="x"){
                    $('#list-productos').html("<img src='img/ajaxload2.gif'>");}
                else{
                    $('#list-editproductos').html("<img src='img/ajaxload2.gif'>");
                }},
            success: function(data) {     
                    if(data!=""){
                        var list =""; 
                        if (resp=="x") {
                            list = '<select id="select-productos" name="producto_id"><option value="">Seleccione un producto</option>';
                        }else{
                            list ='<select id="select-editproductos" name="producto_id">';
                        }     
                        $.each(data, function(item) {                        
                            if(resp==data[item].Producto.id){ 
                                list += '<option selected=selected value=' + data[item].Producto.id + '>' + data[item].Producto.producto + '</option>';
                            }else{
                                list += '<option value=' +  data[item].Producto.id + '>' + data[item].Producto.producto + '</option>';
                            }                       
                        });
                        list += '</select>';
                        if (resp=="x") {
                            $('#list-productos').html(list);
                        }else{
                            $('#list-editproductos').html(list);
                        }
                    }else{
                        var list = '<select id="select-editproductos"><option>No hay Productos en la BD</option>';
                        if (resp=="x"){
                           $('#list-productos').html(list);
                        }else{
                           $('#list-editproductos').html(list);
                        }
                    }
               }
         });
    }
    function llenarcatsubcat(idpro) {
        $.ajax({
            url: 'Productos/catsubcat/'+idpro,
            dataType: 'json',
            type:'POST',
            success: function(data) {   
                    llenarlistboxsubCategorias(data[0].SubCategoria.id,data[0].SubCategoria.categoria_id);
                    llenarlistboxProductos(idpro,data[0].SubCategoria.id);
            }
         });        
    }
    
<script type="text/javascript" src="js/addFoto.js"></script>
<script type="text/javascript" src="js/categoria_sub_categoria.js"></script>
<div class="contbotones">
    <button  id="btnaddfoto" class="botones">Nueva Foto</button>
</div>
<!-- LISTA  -->
<div id="listafotos"></div>
 
<!-- AGREGAR  -->
<div id="divaddfoto" title="Nueva Foto"> 
    <form id="formaddfoto" method="POST">
        <label>URL:</label> 
        <input type="file" id="imagenefile" name="imagen" accept="image/jpeg, image/png" /><br>
        <label>Nombre:</label>
        <input id="iptfoto" type="text" name="url">
        <span id="spnaddfoto"></span>
        
        <label>Categoria:</label> 
        <div id="list-categorias"></div>
        
        <label>Sub Categoria:</label> 
        <div id="list-subcategorias"></div>           

        <label>Producto:</label> 
        <div id="list-productos"></div>    
        
        <button id="addfotosave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditfoto" title="Editar Fotos">
    <form id="formeditfoto" method="POST">        
        <input type="checkbox" id="checkededitimagen"><label for="check">Editar Imagen</label>
        <label> URL: </label>
        <input type="file" id="imagenefileedit" name="imagen" accept="image/jpeg, image/png" disabled /><br>
        <label>Nombre:</label>
        <input id="editfotoinput" type="text" name="url" disabled>
        <span id="spneditfoto"></span>
        
        <label>Categoria:</label> 
        <div id="list-editcategorias"></div>
        
        <label>Sub Categoria:</label> 
        <div id="list-editsubcategorias"></div>
        
        <label>Producto:</label> 
        <div id="list-editproductos"></div>
        
        <button id="editfotosave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
    </form>
</div>
<script type="text/javascript" src="js/addFoto.js"></script>

<!-- LISTA  -->
<div id="listafotos"></div>
 
<!-- AGREGAR  -->
<button  id="btnaddfoto" class="botones">Nueva Foto</button>
<div id="divaddfoto" title="Nueva Foto"> 
    <form id="formaddfoto" method="POST">
        <label>URL:</label> 
        <input type="file" id="imagenefile" name="imagen" accept="image/jpeg, image/png" /><br>
        <progress id="prog" value="0" min="0" max="100"></progress><br>
        <label>Nombre:</label>
        <input id="iptfoto" type="text" name="url">
        <span id="spnaddfoto"></span>
        <label>Producto:</label> 
        <div id="list-productos"></div>    
        <button id="addfotosave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditfoto" title="Editar Fotos">
    <form id="formeditfoto" method="POST">
        <label> URL: </label><input type="checkbox" id="checkededitimagen"><label for="check">Editar Imagen</label>
        <input type="file" id="imagenefileedit" name="imagen" accept="image/jpeg, image/png" disabled /><br>
        <progress id="progedit" value="0" min="0" max="100"></progress><br>
        <input id="editfotoinput" type="text" name="url" disabled>
        <span id="spneditfoto"></span>
        <label>Producto:</label> 
        <div id="list-editproductos"></div>    
        <button id="editfotosave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
    </form>
</div>
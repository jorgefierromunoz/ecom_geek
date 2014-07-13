<script type="text/javascript" src="js/addFoto.js"></script>

<!-- LISTA  -->
<div id="listafotos"></div>
 
<!-- AGREGAR  -->
<button  id="btnaddfoto" class="botones">Nueva Foto</button>
<div id="divaddfoto" title="Nueva Foto"> 
    <form id="formaddfoto" method="POST">
        <label>URL:</label> 
        <input type="file" id="imagenefile" name="imagen" /><br>
        <progress id="prog" value="0" min="0" max="100"></progress><br>
        <input id="iptfoto" type="hidden" name="url">
        <span id="spnaddfoto"></span> 
        <label>mime:</label> 
        <input id="iptmime" type="text" name="mime">
        <span id="spnaddmime"></span> 
        <label>descripcion:</label> 
        <input id="iptdescripcion" type="text" name="descripcion">
        <span id="spnadddescripcion"></span> 
        <label>Producto:</label> 
        <div id="list-productos"></div>        
        <input id="iptproducto_id" type="hidden" name="producto_id" >
        <button id="addfotosave">Guardar</button>
        <span id="spnaddalert">Debe llenar los campos correctamente</span>
    </form>
</div>

<!--EDITAR  -->
<div id="diveditfoto" title="Editar Fotos">
    <form id="formeditfoto" method="POST">
        <label> URL: </label>
        <input id="editfotoinput" type="text" name="url" disabled>
        <span id="spneditfoto"></span>
        <label> Mime: </label>
        <input id="editmimeinput" type="text" name="mime">
        <span id="spneditmime"></span>
        <label> Descripcion: </label>
        <input id="editdescripcioninput" type="text" name="descripcion">
        <span id="spneditdescripcion"></span>
        <label>Producto:</label> 
        <div id="list-editproductos"></div>        
        <input id="ipteditproducto_id" type="hidden" name="producto_id" >
        <button id="editfotosave">Guardar</button>
        <span id="spneditalert">Debe llenar los campos correctamente</span>
    </form>
</div>
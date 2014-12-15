
Esto es un .ctp (cake template)<br>
la estructura html ya esta hecha por lo que ahora estamos en el body <?php echo "<br>"; ?>
como puedes ver puedo abrir en cualquier parte la etiqueta <?php echo "PHP"; ?><br>
así como las etiquetas de html <a link >Ejemplo</a>


<br>
PD: nota las tíldes que se ponen normal, sin nomenclatura html 
<br>
PD2:El controlador que envia el arreglo $productos se encuentra en la raiz <br>
controller/ProductosController.php donde pide un nuero que sera el id del producto
<br>
http://localhost:26/geek4y/productos/verdetalleproducto/11
<br>
y lo recibe esta página 
<br>

En esta página trabajaras definiras tus estructuras con div section o article según<br>
la etiqueta que te acomode..
<br>
como mostrar un dato de la variable $productos
<br>
<a link>
<?php echo $productos['Producto']['producto']; ?>
</a>
<br>
si la variable es un arreglo<br>
esto es un ejemplo de como se puede hacer un foreach que recorra el producto

<br>
Con este foreach se pueden recorrer todas las imagenes asociadas al producto
<table>    
    <?php foreach ($productos['Foto'] as $imagenes): ?>
    <tr>
        <td><?php echo $imagenes['url']; ?>
            <?php ?></td>        
    </tr>
    <?php endforeach; ?>
</table>
<br>
aca te dejo un poco de que es lo que te mando
<?php var_dump($productos); ?>
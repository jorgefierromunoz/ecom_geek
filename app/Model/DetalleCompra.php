<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categoria
 *
 * @author MASTER
 */
class DetalleCompra extends AppModel{
    //put your code here
    public $name='DetalleCompra';
    public $belongsTo=array('OrdenesCompra','Producto');
}

?>

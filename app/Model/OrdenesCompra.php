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
class OrdenesCompra extends AppModel{
    //put your code here
    public $name='OrdenesCompra';
    public $belongsTo='User';
    public $hasMany='DetalleCompra';
   
}

?>

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
class Modelo extends AppModel{
    //put your code here
    public $name='Modelo';
    public $hasMany='Producto';
    function hasProductos($id){
        $count = $this->Producto->find("count", array("conditions" => array("modelo_id" => $id)));
        return $count;
    }
}

?>

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
class Tamano extends AppModel{
    //put your code here
    public $name='Tamano';
    public $hasOne='Producto';
     function hasProductos($id){
        $count = $this->Producto->find("count", array("conditions" => array("tamano_id" => $id)));
        return $count;
    }
}

?>

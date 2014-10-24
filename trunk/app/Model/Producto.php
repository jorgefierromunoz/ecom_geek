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
class Producto extends AppModel{
    //put your code here
    public $name='Producto';
    public $hasMany='Foto';
    public $belongsTo=array('SubCategoria','Modelo','Tamano');
    
    function hasFotos($id){
        $count = $this->Foto->find("count", array("conditions" => array("producto_id" => $id)));
        return $count;
    }
     function totalProductos() {
        $count=$this->find("count");
        return $count;
    }
}

?>

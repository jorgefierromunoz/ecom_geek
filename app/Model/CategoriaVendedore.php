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
class CategoriaVendedore extends AppModel{
    //put your code here
    public $name='CategoriaVendedore';
    public $hasMany='User';

    function hasUser($id){
        $count = $this->User->find("count", array("conditions" => array("categoria_vendedore_id" => $id)));
        return $count;
    }
}

?>

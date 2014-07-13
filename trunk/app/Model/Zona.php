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
class Zona extends AppModel{
    //put your code here
    public $name='Zona';
    public $hasMany='Comuna';
    function hasComunas($id){
        $count = $this->Comuna->find("count", array("conditions" => array("zona_id" => $id)));
        return $count;
    }
}

?>

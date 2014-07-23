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
class Banco extends AppModel{
    //put your code here
    public $name='Banco';
    public $hasMany='TipoCuentasBancaria';
function hastipocuentas($id){
        $count = $this->TipoCuentasBancaria->find("count", array("conditions" => array("banco_id" => $id)));
        return $count;
    }
    
}

?>

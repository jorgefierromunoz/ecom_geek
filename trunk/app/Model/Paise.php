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
class Paise extends AppModel{
    //put your code here
    public $name='Paise';
    public $hasMany='Regione';
    
     function hasRegiones($region_id){
        $count = $this->Regione->find("count", array("conditions" => array("paise_id" => $region_id)));
        return $count;
    }
}

?>

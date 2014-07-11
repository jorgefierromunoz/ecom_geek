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
class Regione extends AppModel{
    //put your code here
    public $name='Regione';
    public $hasMany='Comuna';
    public $belongsTo='Paise';
    
    function hasComunas($region_id){
        $count = $this->Comuna->find("count", array("conditions" => array("regione_id" => $region_id)));
        return $count;
    }  
}

?>

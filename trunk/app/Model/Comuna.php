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
class Comuna extends AppModel{
    //put your code here
    public $name='Comuna';
    public $hasMany='Direccione';
    public $belongsTo=array('Regione','Zona');
}

?>

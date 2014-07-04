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

}

?>

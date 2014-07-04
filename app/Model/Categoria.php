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
class Categoria extends AppModel{
    //put your code here
    public $name='Categoria';
    public $hasMany='SubCategoria';
}

?>

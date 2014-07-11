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
class SubCategoria extends AppModel{
    //put your code here
    public $name='SubCategoria';
    public $belongsTo = 'Categoria';

}

?>

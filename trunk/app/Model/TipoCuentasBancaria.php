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
class TipoCuentasBancaria extends AppModel{
    //put your code here
    public $name='TipoCuentasBancaria';
    public $hasMany='User';
    public $belongsTo='Banco';
}

?>

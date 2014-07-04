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
class User extends AppModel{
    //put your code here
    public $name='User';
    public $hasMany=array('OrdenesCompra','Direccione');
    public $belongsTo=array('TipoCuentasBancaria','CategoriaVendedore');
}

?>

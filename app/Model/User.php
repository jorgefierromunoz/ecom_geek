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
    
    public function beforeSave($options = array()) {
       if(isset($this->data['user']['password']) ){
            $this->data['user']['password'] = Security::hash($this->data['user']['password'], null, true);
       }
//       if(isset($this->data['user']['rut'])){
//            $this->data['user']['codigo'] = Security::hash($this->data['user']['rut'], null, true);
//       }
       return true;
   }
}

?>

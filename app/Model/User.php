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
    
    function hasdirecciones($id){
        return $this->Direccione->find("count", array("conditions" => array("user_id" => $id)));
    }
//    function hasordenescompras($id){
//        $count = $this->OrdenesCuenta->find("count", array("conditions" => array("user_id" => $id)));
//        return $count;
//    }
    
    public function beforeSave($options = array()) {
        if(!isset($this->data['User']['rut'])){
            $this->data['User']['rut'] = "Sin Rut";
       }
       if(isset($this->data['User']['password']) ){
            $this->data['User']['password'] = Security::hash($this->data['User']['password'], null, true);
       }
       if(isset($this->data['User']['email'])){
            $cod=Security::hash($this->data['User']['email'], null, true);
            $this->data['User']['codigo'] =$cod;
            $this->data['User']['codigo2'] =$cod;
       }
       
       if(!isset($this->data['User']['tipo'])){
            $this->data['User']['tipo'] = "cliente";
       }
       if(!isset($this->data['User']['puntoAcumulado'])){
            $this->data['User']['puntoAcumulado'] = 0;
       }
       if(!isset($this->data['User']['referido'])){
            $this->data['User']['referido'] = 0;
       }
       if(!isset($this->data['User']['estado'])){
            $this->data['User']['estado'] = "deshabilitado";
       }
       
       return true;
   }
}

?>

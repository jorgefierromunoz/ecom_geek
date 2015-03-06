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
    function hasFotos($id){
        $count = $this->Foto->find("count", array("conditions" => array("producto_id" => $id)));
        return $count;
    }
     function totalProductos() {
        $count=$this->find("count");
        return $count;
    }
    
     function totalProductosSubcategoria($id) {
        $count=$this->find("count",array("conditions"=>array("sub_categoria_id"=>$id)));
        return $count;
    }
    function validausuario($id,$pass) {
        $User = ClassRegistry::init('User');
        $user = $User->find('all', array('conditions' => array(
            'User.id' => $id, 'User.password' => $pass),
            'fields' => array('id', 'username', 'tipo', 'rut', 'nombre', 'apellidoPaterno',
            'apellidoMaterno', 'email', 'estado','referido','puntoAcumulado','categoria_vendedore_id')));
        return $user;
    }
    function totalcompra($array){
        $precio=0;
        $totalP=0;        
        foreach ($array as $p) {  
            $idproducto=$p['Id'];
            $precio= $this->find('all', array('conditions' => array(
            'id' => $idproducto)));
            $cant=$p['Cantidad'];
            $subtota=$precio*$cant;
            $totalP=$totalP + $subtota;
        }
    return $precio;
    }
}

?>

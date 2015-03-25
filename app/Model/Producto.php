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
    public $hasMany=array('Foto','DetalleCompra');
    public $belongsTo=array('SubCategoria','Modelo','Tamano');
    
    function pagarpuntos(){
        $OrdenesCompra = ClassRegistry::init('OrdenesCompra');
        $oc = $OrdenesCompras->save('all', array('conditions' => array(
            'User.id' => $id, 'User.password' => $pass),
            'fields' => array('id', 'username', 'tipo', 'rut', 'nombre', 'apellidoPaterno',
            'apellidoMaterno', 'email', 'estado','referido','puntoAcumulado','categoria_vendedore_id')));
    }
    
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
        $totalPrecio=0;  
        $totalPrecioPuntos=0;
        foreach ($array as $p) {  
            $idproducto=$p['Id'];
            $producto= $this->find('first', 
                    array(
                        'conditions' => array('Producto.id' => $idproducto),
                        'recursive'=>-1
                        )
            );
            $precio=$producto['Producto']['precio'];
            $preciopto=$producto['Producto']['precioPunto'];
            $cant=$p['Cantidad'];
            $subtota=$precio*$cant;
            $subtotapto=$preciopto*$cant;
            $totalPrecio=$totalPrecio + $subtota;
            $totalPrecioPuntos = $totalPrecioPuntos +$subtotapto;
        }
    return array('totalprecio'=>$totalPrecio,'totalpuntos'=>$totalPrecioPuntos);
    }
    function validaproductoscarro($array){
        $totalPrecio=0;  
        $totalPrecioPuntos=0;
        $respuesta=array();
        foreach ($array as $p) {             
            $idproducto=$p['Id'];
            $producto= $this->find('first', 
                    array(
                        'conditions' => array('Producto.id' => $idproducto),
                        'recursive'=>-1
                        )
            );
            $precio=$producto['Producto']['precio'];
            $preciopto=$producto['Producto']['precioPunto'];
            $cant=$p['Cantidad'];
            $subtota=$precio*$cant;
            $subtotapto=$preciopto*$cant;
            $totalPrecio=$totalPrecio + $subtota;
            $totalPrecioPuntos = $totalPrecioPuntos +$subtotapto;
            $arr= array("id"=>$idproducto,"cantidad"=>$cant,"precio"=>$precio,"subtotalprecio"=>$subtota,"subtotalpunto"=>$subtotapto);
            array_push($respuesta,$arr);
        }
        return $respuesta;

    }
}

?>

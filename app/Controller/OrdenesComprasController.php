<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BancosController
 *
 * @author MASTER
 */
App::import('Controller','DetalleCompras');
App::import('Controller','Users');
App::import('Controller','Productos');
class OrdenesComprasController extends AppController{
    //put your code here
    public $name = 'OrdenesCompras';
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('agregarcompraorden');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
    //public $uses =array('OrdenesCompras','DetalleCompra');
    function agregarcompraorden($tFlete=0,$tipoPunto=0,$estPago='C',$estado='B',$nomTransp='',$nsegui=''){
    $valida=0;
    $arregloprecios=$this->Session->read('Tot_Compra');
    $totalCompraPrecio=$arregloprecios['precios']['totalprecio']; 
    $totalCompraPtos=$arregloprecios['precios']['totalpuntos'];
    $usuarioPtosDispo=floatval($arregloprecios['usuario']['User']['puntoAcumulado']);
    $suma= floatval($tFlete) + floatval($totalCompraPtos);
    if ($usuarioPtosDispo > $suma ){
        $fecha=date("d.m.y H:i:s");        
        $this->OrdenesCompra->create();
        $data = array(
            'OrdenesCompra' => array(
                'fecha' => $fecha,
                'user_id' => $arregloprecios['usuario']['User']['id'],
                'total' => $totalCompraPrecio,
                'totalPunto' => $totalCompraPtos,
                'totalFlete' => $tFlete,
                'tipoPunto' => $tipoPunto,
                'estadoPago' => $estPago,
                'estado' => $estado,
                'nombreTransporte' => $nomTransp,
                'numeroSeguimiento' => $nsegui                
        ));      
        if ($this->OrdenesCompra->save($data)) {
            $ModelProducto = ClassRegistry::init('Producto');
            $sessioncarrito= $this->Session->read('carrito');
            $arregloProductos = $ModelProducto->validaproductoscarro($sessioncarrito);
            //$ultimaid=2;
            $ultimaid = $this->OrdenesCompra->getLastInsertId();       
            $validaguardado = 0;
            $subtotalpreciofe=0;
            $totalpreciofe=0;
            $subtotalprecioPtofe=0;
            $totaprecioptofe=0;
            
            // Instantiation // mention within cron function
            $det = new DetalleComprasController;
            if(count($this->Session->read('carrito.0'))!=0){                      
                foreach ($arregloProductos as $p) {               
                    $precio=$p['precio'];
                    $preciopto=$p['preciopunto'];  
                    $cant=$p['cantidad'];
                    $datadet = array(
                        'DetalleCompras' => array(
                            'ordenes_compra_id' => $ultimaid,
                            'producto_id' => $p['id'],
                            'cantidad' =>$cant,
                            'precio' =>$precio ,
                            'preciopto'=>$preciopto,
                            'subtotal' => $p['subtotalprecio'],
                            'subtotalpunto' =>$p['subtotalpunto']
                    ));
                    
                    if($det->add($datadet['DetalleCompras'])) {
                        $validaguardado++;
                        $subtotalpreciofe=floatval($precio) * floatval($cant);
                        $totalpreciofe=$totalpreciofe + $subtotalpreciofe;
                        $subtotalprecioPtofe=floatval($preciopto) * floatval($cant);
                        $totaprecioptofe=$totaprecioptofe + $subtotalprecioPtofe;
                    }else{
                        $valida++;
                    }                         
                } 
                if ((count($arregloProductos) != $validaguardado) || ($totalpreciofe != $totalCompraPrecio)||($totaprecioptofe != $totalCompraPtos)){
                        $valida++;
                    }            
                }
              }else{
                  $valida++;          
              }
              if ($valida==0){
                  $UserController = new UsersController;
                  if($UserController->updateptosusuariocompra($arregloprecios['usuario']['User']['id'],$totalCompraPtos,$usuarioPtosDispo)){
                      $ProductosController = new ProductosController;
                      foreach ($arregloProductos as $p) {  
                          if(!$ProductosController->editstockproductos($p['id'],$p['cantidad'])){
                              $this->set('ordencompra', 'Error actualizar stock de productos');
                              $valida++;
                          }
                      }
                      if ($valida==0){
                          $this->set('ordencompra', 'La compra se ha efectuado con éxito');
                      }
                  }else{
                      $this->set('ordencompra', 'No se pudo actualizar puntos de usuario');
                  }
              }else{
                  $this->set('ordencompra', 'Error valida > 0');
              }   
    }else{
        $this->set('ordencompra', 'No tienes puntos suficientes para realizar esta compra');
    }
      //$this->set('ordencompra', $usuarioPtosDispo);    
      $this->layout = 'ajax';
    }
}

?>

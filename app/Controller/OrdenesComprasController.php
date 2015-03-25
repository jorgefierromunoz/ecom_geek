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
App::import('Controller', 'DetalleCompras'); // mention at top
class OrdenesComprasController extends AppController{
    //put your code here
    public $name = 'OrdenesCompras';
    //public $uses =array('OrdenesCompras','DetalleCompra');
    function agregarcompraorden($user_id=1,$total=0,$tPuntos=0,$tFlete=0,$tipoPunto=0,$estPago='C',$estado='B',$nomTransp='chileexp',$nsegui='000'){
    //function agregarcompraorden(){
    $fecha=date("d.m.y H:i:s");        
    $this->OrdenesCompra->create();
    $data = array(
        'OrdenesCompra' => array(
            'fecha' => $fecha,
            'user_id' => $user_id,
            'total' => $total,
            'totalPunto' => $tPuntos,
            'totalFlete' => $tFlete,
            'tipoPunto' => $tipoPunto,
            'estadoPago' => $estPago,
            'estado' => $estado,
            'nombreTransporte' => $nomTransp,
            'numeroSeguimiento' => $nsegui                
    ));
    $ModelProducto = ClassRegistry::init('Producto');
    $sessioncarrito= $this->Session->read('carrito');
    $arregloProductos = $ModelProducto->validaproductoscarro($sessioncarrito);
    
    if ($this->OrdenesCompra->save($data)) {
        //$ultimaid=2;
        $ultimaid = $this->OrdenesCompra->getLastInsertId();       
        $asdf = 0;
    // Instantiation // mention within cron function
    $det = new DetalleComprasController;
        if(count($this->Session->read('carrito.0'))!=0){                      
            foreach ($arregloProductos as $p) {               
                $datadet = array(
                    'DetalleCompras' => array(
                        'ordenes_compra_id' => $ultimaid,
                        'producto_id' => $p['id'],
                        'cantidad' =>$p['cantidad'],
                        'precio' => $p['precio'],
                        'subtotal' => $p['subtotalprecio'],
                        'subtotalpunto' =>$p['subtotalpunto']
                ));
                
             if($det->add($datadet['DetalleCompras'])) {
                 $asdf++;
             }               
            }
            $this->set('ordencompra', $asdf);
        }
      }else{
          $this->set('ordencompra', 'no se guardo compra');
      }
      
      $this->layout = 'ajax';
    }
}

?>

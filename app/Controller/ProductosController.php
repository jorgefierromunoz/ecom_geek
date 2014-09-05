<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductosController
 *
 * @author MASTER
 */
class ProductosController extends AppController{
    //put your code here
    public $name = 'Productos';
    public function index(){
      
    }
        public function carrito($id = null) {
        if ($id != null) {
            $this->Producto->id = $id;
            //$arreglo= $this->Producto->field('precioVenta');
            if (isset($_SESSION['carrito'])) { //SI EXISTE LA SESSION CARRITO
                $arreglo = $_SESSION['carrito'];
                $encontro = false;
                $numero = 0;
                for ($i = 0; $i < count($arreglo); $i++) {
                    if (isset($arreglo[$i]['Id'])) {
                        if ($arreglo[$i]['Id'] == $id) {
                            $encontro = true;
                            $numero = $i;
                        }
                    }
                }
                if ($encontro == true) {
                    $arreglo[$numero]['Cantidad'] = $arreglo[$numero]['Cantidad'] + 1;
                    $_SESSION['carrito'] = $arreglo;
                } else {
                    $idp = $this->Producto->field('id');
                    $nombre = $this->Producto->field('producto');
                    $precio = $this->Producto->field('precio');
                    $preciopto = $this->Producto->field('precioPunto');
                    $datosNuevos = array('Id' => $idp,
                        'Producto' => $nombre,
                        'Precio' => $precio,
                        'PrecioPunto' => $preciopto,
                        'Cantidad' => 1);
                    array_push($arreglo, $datosNuevos);
                    $_SESSION['carrito'] = $arreglo;
                }
            } else {//SI NO EXISTE LA SESSION CARRITO
                 $idp = $this->Producto->field('id');
                    $nombre = $this->Producto->field('producto');
                    $precio = $this->Producto->field('precio');
                    $preciopto = $this->Producto->field('precioPunto');
                   
                $arreglo = array('Id' => $idp,
                    'Producto' => $nombre,
                    'Precio' => $precio,                    
                    'PrecioPunto' => $preciopto,
                    'Cantidad' => 1);
                $_SESSION['carrito'][0] = $arreglo;
            }
             $arreglo = $_SESSION['carrito'];
        }else{
            $arreglo="asdf";
        }
        $this->set('productos', $arreglo);
        $this->layout = 'ajax';
    }
    function borrarcarro(){
        session_destroy();
        $this->set('productos','1');
        $this->layout = 'ajax';
    }
function versession(){
    if (isset($_SESSION['carrito'])){
        $this->set('productos',$_SESSION['carrito']);     
    }else{
        $this->set('productos','0'); 
    }$this->layout = 'ajax';
}
    function listaproductos($atributo=null,$orden=null) {
        $this->set('productos', $this->Producto->find('all',array('order'=>array($atributo=> $orden))));
        $this->layout = 'ajax';
    }
     function catsubcat($id=null) {
        $this->set('productos', $this->Producto->find('all',array('recursive'=>0,'conditions'=>array('Producto.id'=>$id),'order'=>array('Producto.producto'=> 'asc'))));
        $this->layout = 'ajax';
    }
     function listaproductosComboBox() {
        $this->set('productos', $this->Producto->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
    function productosidsubcategoria($id){
          $arreglo= array('recursive'=>-1,'conditions'=>array('Producto.sub_categoria_id'=>$id),'order'=>array('Producto.producto'=> 'asc'));
           $this->set('productos',$this->Producto->find('all',$arreglo));
        $this->layout = 'ajax'; 
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Producto->create();
                if ($this->Producto->save($this->data)) {
                   $this->set('productos','1');
                }else{
                     $this->set('productos','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
    
    public function view($id = null) {
        $this->Producto->id = $id;
        $this->Producto->recursive = -1;
        $this->set('productos', $this->Producto->read());
        $this->layout = 'ajax';
    }
    public function ver($id = null) {
        $this->Producto->id = $id;
        $this->Producto->recursive = 1;
        $this->set('productos', $this->Producto->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Producto->id = $id;
        if ($this->Producto->save($this->request->data)) {
            $this->set('productos', '1');
        }else{
            $this->set('productos', '0');
        }
        $this->layout = 'ajax';
    }
  
    function delete($id) {
        $cant=$this->Producto->hasFotos($id);
        if ($cant==0){
            $this->Producto->delete($id);
            $this->set('productos', 't');
        }else{
            $this->set('productos', $cant);
        }
        $this->layout = 'ajax';
    }
}

?>

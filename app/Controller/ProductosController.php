<?php
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
     public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('validarcompra','todosproductos', 'pagoPuntos','verdetalleproducto','totalcarrito','retornartotalescarro','detalle_carrito','cantidadcarrito','carrito','borrarcarro','detalleCarrito','eliminarproductocarro','versession','view','listaproductos','catsubcat','listaproductosComboBox','productosidsubcategoria','ver','listaproductossubcategoria');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
    public function index(){
      
    }
    public function validarcompra(){
        if ($this->Session->check('carrito')){
            
        }
        if ($this->Session->check('User')){
            $idusu= $this->Session->read('User.0.IdUsu'); 
           $pass= $this->Session->read('User.0.Pass'); 
           $user = $this->Producto->validausuario($idusu,$pass);
           
           if (!$user == null) {
              $this->set('productos', $this->Producto->totalcompra($this->Session->read('carrito')));
           }         
        }else{
            $this->set('productos', '0');
            
        }
        $this->layout = 'ajax';
    }
    public function confirmacionCompra(){
                    
      
    }
    public function verdetalleproducto($id){
        $this->Producto->id = $id;
        $this->set('productos', $this->Producto->read());
    }
    public function detalleCarrito(){
        
    }
    public function carrito($id = null) {
        if ($id != null) {
            $this->Producto->id = $id;
            //$arreglo= $this->Producto->field('precioVenta');
            if ($this->Session->check('carrito')) { //SI EXISTE LA SESSION CARRITO
                $arreglo =$this->Session->read('carrito');
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
                    $this->Session->write('carrito',$arreglo);
                    $nombre=$this->Session->read('carrito.'.$numero.'.Producto');
                    $cantidad=$this->Session->read('carrito.'.$numero.'.Cantidad');
                    $precio=$this->Session->read('carrito.'.$numero.'.Precio');
                    $factor=$this->Session->read('carrito.'.$numero.'.Factor');
                    $subtotal= $cantidad * $precio;
                    $arreglo=array($id,$nombre,$cantidad,$precio,$subtotal,$factor*$cantidad);
                    //arreglo= id nombre cantidad precio/unitario precio/unitario*cantidad factor*cantidad 
                } else {
                    $idp = $this->Producto->field('id');
                    $nombre = $this->Producto->field('producto');
                    $precio = $this->Producto->field('precio');
                    $preciopto = $this->Producto->field('precioPunto');
                    $factor= $this->Producto->find('all',array('conditions'=>array('Producto.id'=>$idp)));
                    $datosNuevos = array('Id' => $idp,
                        'Producto' => $nombre,
                        'Precio' => $precio,
                        'PrecioPunto' => $preciopto,
                        'Cantidad' => 1,
                        'Factor'=>$factor[0]['Tamano']['factor']
                        );
                    array_push($arreglo, $datosNuevos);
                    $this->Session->write('carrito',$arreglo); 
                    $arreglo=array($idp,$nombre,1,$precio,$precio,$factor[0]['Tamano']['factor']);
                    //arreglo= id nombre cantidad precio/unitario precio/unitario*cantidad factor*cantidad
                }
            } else {//SI NO EXISTE LA SESSION CARRITO
                $idp = $this->Producto->field('id');
                $nombre = $this->Producto->field('producto');
                $precio = $this->Producto->field('precio');
                $preciopto = $this->Producto->field('precioPunto');
                //$factor= $this->Producto->find('all',array('conditions'=>array('Producto.id'=>$idp,'AND'=>array('Producto.tamano_id'=>$this->Producto->field('tamano_id')))));
                $factor= $this->Producto->find('all',array('conditions'=>array('Producto.id'=>$idp)));                   
                $arreglo = array('Id' => $idp,
                    'Producto' => $nombre,
                    'Precio' => $precio,                    
                    'PrecioPunto' => $preciopto,
                    'Cantidad' => 1,
                    'Factor'=>$factor[0]['Tamano']['factor']
                    );
                $this->Session->write('carrito',array($arreglo));
                $arreglo=array($idp,$nombre,1,$precio,$precio,$factor[0]['Tamano']['factor']);
                //arreglo= id nombre cantidad precio/unitario precio/unitario*cantidad factor*cantidad
            }
             //$arreglo = $this->Session->read('carrito');
        }else{
            $arreglo="0";
        }
        $this->set('productos', $arreglo);
        $this->layout = 'ajax';
    }
    public function totalcarrito(){
        $total=0;
        $totalptos=0;
        $totalfactor=0;
        if ($this->Session->check('carrito')){
            $arreglo = $this->Session->read('carrito'); //PASO ACTUAL CARRITO A UN ARREGLO
            for ($i = 0; $i < count($arreglo); $i++) {
                $cantidad=$arreglo[$i]['Cantidad'];
                $precio=$arreglo[$i]['Precio'];
                $preciopto=$arreglo[$i]['PrecioPunto'];
                $factor= $arreglo[$i]['Factor'];
                $subtotalprecio=$precio*$cantidad;
                $subtotalpto=$preciopto*$cantidad;
                $subtotalfactor=$factor *$cantidad;
                $total = $total + $subtotalprecio;
                $totalptos = $totalptos + $subtotalpto;
                $totalfactor= $totalfactor + $subtotalfactor;
            }
        }
        $this->set('productos', array($total,$totalptos,$totalfactor));
        $this->layout = 'ajax';
    }
    public function eliminarproductocarro($id = null) {
        if (($this->Session->check('carrito')) && ($id)) {
            $arreglo = $this->Session->read('carrito'); //PASO ACTUAL CARRITO A UN ARREGLO
            $encontro = false;
            $numero = 0;
            for ($i = 0; $i < count($arreglo); $i++) {
                if (isset($arreglo[$i]['Id'])) { //BUSCO SI EL PRODUCTO ENVIADO EXISTE EN EL CARRITO
                    if ($arreglo[$i]['Id'] == $id) {
                        $encontro = true;
                        $numero = $i;
                    }
                }
            }
            if ($encontro == true) {//SI EL PRODUCTO ENVIADO EXISTE 
                unset($arreglo[$numero]);
                $arreglo = array_values($arreglo);//REORDENAR ARREGLO
                $this->Session->write('carrito',$arreglo);
            }
        }
        if (count($arreglo)==0){
            $arreglo="0";            
        }
        $this->set('productos', $arreglo);
        $this->layout = 'ajax';
    }
    public function cantidadcarrito($id = null, $cant = null) {//CAMBIAR LA CANTIDAD DEL CARRO CON EL INPUT
        if (($this->Session->check('carrito')) && ($id)) {
            $arreglo = $this->Session->read('carrito'); //PASO ACTUAL CARRITO A UN ARREGLO
            $encontro = false;
            $numero = 0;
            for ($i = 0; $i < count($arreglo); $i++) {
                if (isset($arreglo[$i]['Id'])) { //BUSCO SI EL PRODUCTO ENVIADO EXISTE EN EL CARRITO
                    if ($arreglo[$i]['Id'] == $id) {
                        $encontro = true;
                        $numero = $i;
                    }
                }
            }
            if ($encontro == true) {//SI EL PRODUCTO ENVIADO EXISTE 
                if (is_numeric($cant)){
                    $arreglo[$numero]['Cantidad'] = $cant;
                    if (($arreglo[$numero]['Cantidad']) > 0) {
                        $this->Session->write('carrito',$arreglo);                               
                    }
                }    
            }
        }
        $cantidad=$this->Session->read('carrito.'.$numero.'.Cantidad');
        $precio=$this->Session->read('carrito.'.$numero.'.Precio');
        $preciopto=$this->Session->read('carrito.'.$numero.'.PrecioPunto');
        $subtotalprecio=$precio*$cantidad;
        $subtotalpto=$preciopto*$cantidad;
        
        $this->set('productos',array($cantidad,$subtotalprecio,$subtotalpto)); 
        $this->layout = 'ajax';
    }
    public function borrarcarro(){
        $this->Session->delete('carrito');
        $this->set('productos','1');
        $this->layout = 'ajax';
    }
    public function versession(){
    if ($this->Session->check('carrito')){
        if(count($this->Session->read('carrito.0'))!=0){
            $this->set('productos',$this->Session->read('carrito')); 
        }else{
            $this->set('productos','0');    
        }
    }else{
        $this->set('productos','0'); 
    }
    $this->layout = 'ajax';
}
    function listaproductos($atributo='Producto.id',$orden='asc',$pagina=1) {
        $totalProductos = $this->Producto->totalProductos();
        $this->set('productos',array($this->Producto->find('all',array('order'=>array($atributo=> $orden),'limit'=>20,'page'=>$pagina)),$totalProductos,$pagina, ceil($totalProductos / 20)));
        $this->layout = 'ajax';
    }
    function todosproductos($id) {       
        $this->set('asdf',$this->Producto->find('all',array('condition'=>array('Producto.id'=>$id))));
    }
    function listaproductossubcategoria($atributo='Producto.id',$orden='asc',$pagina=1,$subCategoria) {
        $totalProductos = $this->Producto->totalProductosSubcategoria($subCategoria);
        $this->set('productos',array($this->Producto->find('all',array('conditions'=>array('Producto.sub_categoria_id'=>$subCategoria),'order'=>array($atributo=> $orden),'limit'=>20,'page'=>$pagina)),$totalProductos,$pagina, ceil($totalProductos / 20)));
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
    function pagoPuntos()
    {

    }
}

?>

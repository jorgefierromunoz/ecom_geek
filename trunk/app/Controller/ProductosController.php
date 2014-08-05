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
    public function index(){
      
    }
    function listaproductos($atributo=null,$orden=null) {
        $this->set('productos', $this->Producto->find('all',array('order'=>array($atributo=> $orden))));
        $this->layout = 'ajax';
    }
     function listaproductosComboBox() {
        $this->set('productos', $this->Producto->find('all',array('recursive'=>-1)));
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

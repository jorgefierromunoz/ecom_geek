<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriasController
 *
 * @author MASTER
 */
class TamanosController extends AppController{
    //put your code here
    public $name = 'Tamanos';
         
    public function index(){
      
    }
    function listatamanos($atributo=null,$orden=null) {
        $this->set('tamanos', $this->Tamano->find('all',array('order'=>array($atributo=> $orden))));
        $this->layout = 'ajax';
    }
     function listatamanosComboBox() {
        $this->set('tamanos', $this->Tamano->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Tamano->create();
                if ($this->Tamano->save($this->data)) {
                   $this->set('tamanos','1');
                }else{
                     $this->set('tamanos','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Tamano->id = $id;
        $this->Tamano->recursive = -1;
        $this->set('tamanos', $this->Tamano->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Tamano->id = $id;
        if ($this->Tamano->save($this->request->data)) {
            $this->set('tamanos', '1');
        }else{
            $this->set('tamanos', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        $cant=$this->Tamano->hasProductos($id);
        if ($cant==0){
            $this->Tamano->delete($id);
            $this->set('tamanos', 't');
        }else{
            $this->set('tamanos', $cant);
        }
        $this->layout = 'ajax';
    }
   
}

?>

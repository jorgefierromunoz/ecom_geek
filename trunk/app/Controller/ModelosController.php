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
class ModelosController extends AppController{
    //put your code here
    public $name = 'Modelos';
        
    public function index(){
      
    }
    function listamodelos() {
        $this->set('modelos', $this->Modelo->find('all'));
        $this->layout = 'ajax';
    }
      function listamodelosComboBox() {
        $this->set('modelos', $this->Modelo->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
    public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Modelo->create();
                if ($this->Modelo->save($this->data)) {
                   $this->set('modelos','1');
                }else{
                     $this->set('modelos','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Modelo->id = $id;
        $this->Modelo->recursive = -1;
        $this->set('modelos', $this->Modelo->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Modelo->id = $id;
        if ($this->Modelo->save($this->request->data)) {
            $this->set('modelos', '1');
        }else{
            $this->set('modelos', '0');
        }
        $this->layout = 'ajax';
    }
    
   function delete($id) {
        $cant=$this->Modelo->hasProductos($id);
        if ($cant==0){
            $this->Modelo->delete($id);
            $this->set('modelos', 't');
        }else{
            $this->set('modelos', $cant);
        }
        $this->layout = 'ajax';
    }
}

?>

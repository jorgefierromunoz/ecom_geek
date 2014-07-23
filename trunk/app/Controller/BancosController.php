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
class BancosController extends AppController{
    //put your code here
    public $name = 'Bancos';
   
    public function index(){
      
    }
    function listabancos() {
        $this->set('bancos', $this->Banco->find('all'));
        $this->layout = 'ajax';
    }
     function listabancosComboBox() {
        $this->set('bancos', $this->Banco->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Banco->create();
                if ($this->Banco->save($this->data)) {
                   $this->set('bancos','1');
                }else{
                     $this->set('bancos','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Banco->id = $id;
        $this->Banco->recursive = -1;
        $this->set('bancos', $this->Banco->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Banco->id = $id;
        if ($this->Banco->save($this->request->data)) {
            $this->set('bancos', '1');
        }else{
            $this->set('bancos', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        $cant=$this->Banco->hastipocuentas($id);
        if ($cant==0){
            $this->Banco->delete($id);
            $this->set('bancos', 't');
        }else{
            $this->set('bancos', $cant);
        }
        $this->layout = 'ajax';
    }
}

?>

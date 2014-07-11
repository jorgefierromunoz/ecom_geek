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
class ComunasController extends AppController{
    //put your code here
    public $name = 'Comunas';
    public function index(){
      
    }
    function listacomunas() {
        $this->set('comunas', $this->Comuna->find('all'));
        $this->layout = 'ajax';
    }
    function listacomunasComboBox() {
        $this->set('comunas', $this->Comuna->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Comuna->create();
                if ($this->Comuna->save($this->data)) {
                   $this->set('comunas','1');
                }else{
                     $this->set('comunas','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Comuna->id = $id;
        $this->Comuna->recursive = -1;
        $this->set('comunas', $this->Comuna->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Comuna->id = $id;
        if ($this->Comuna->save($this->request->data)) {
            $this->set('comunas', '1');
        }else{
            $this->set('comunas', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        if ($this->Comuna->delete($id)) {
            $this->set('comunas', '1');
        }else{
            $this->set('comunas', '0');
        }
            $this->layout = 'ajax';
        }
}

?>

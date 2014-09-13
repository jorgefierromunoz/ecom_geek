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
class ZonasController extends AppController{
    //put your code here
    public $name = 'Zonas';
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('listazonas','listazonasComboBox','view');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
     public function index(){
      
    }
    function listazonas() {
        $this->set('zonas', $this->Zona->find('all'));
        $this->layout = 'ajax';
    }
     function listazonasComboBox() {
        $this->set('zonas', $this->Zona->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Zona->create();
                if ($this->Zona->save($this->data)) {
                   $this->set('zonas','1');
                }else{
                     $this->set('zonas','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Zona->id = $id;
        $this->Zona->recursive = -1;
        $this->set('zonas', $this->Zona->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Zona->id = $id;
        if ($this->Zona->save($this->request->data)) {
            $this->set('zonas', '1');
        }else{
            $this->set('zonas', '0');
        }
        $this->layout = 'ajax';
    }
    
       function delete($id) {
        $cant=$this->Zona->hasComunas($id);
        if ($cant==0){
            $this->Zona->delete($id);
            $this->set('zonas', 't');
        }else{
            $this->set('zonas', $cant);
        }
        $this->layout = 'ajax';
    }
   
}

?>

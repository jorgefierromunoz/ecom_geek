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
class CategoriaVendedoresController extends AppController{
    //put your code here
    public $name = 'CategoriaVendedores';
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('listacatvendedoresComboBox', 'listacatvendedores','view');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
     public function index(){
      
    }
    function listacatvendedores() {
        $this->set('catvendedores', $this->CategoriaVendedore->find('all',array('order'=>array('CategoriaVendedore.categoriaVendedor'=> 'asc'))));
        $this->layout = 'ajax';
    }
     function listacatvendedoresComboBox() {
        $this->set('catvendedores', $this->CategoriaVendedore->find('all',array('recursive'=>-1,'order'=>array('CategoriaVendedore.categoriaVendedor'=> 'asc'))));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->CategoriaVendedore->create();
                if ($this->CategoriaVendedore->save($this->data)) {
                   $this->set('catvendedores','1');
                }else{
                     $this->set('catvendedores','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->CategoriaVendedore->id = $id;
        $this->CategoriaVendedore->recursive = -1;
        $this->set('catvendedores', $this->CategoriaVendedore->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->CategoriaVendedore->id = $id;
        if ($this->CategoriaVendedore->save($this->request->data)) {
            $this->set('catvendedores', '1');
        }else{
            $this->set('catvendedores', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        $cant=$this->CategoriaVendedore->hasUser($id);
        if ($cant==0){
            $this->CategoriaVendedore->delete($id);
            $this->set('catvendedores', 't');
        }else{
            $this->set('catvendedores', $cant);
        }
        $this->layout = 'ajax';
    }
}

?>

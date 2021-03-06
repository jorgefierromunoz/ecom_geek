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
class CategoriasController extends AppController{
    //put your code here
    public $name = 'Categorias';

    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('listacategorias', 'listacategoriasComboBox','view');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
    public function index(){
      
    }
    function listacategorias($atributo=null,$orden=null) {
        $this->set('categorias', $this->Categoria->find('all',array('order'=>array($atributo=> $orden))));
        $this->layout = 'ajax';
    }
   
     function listacategoriasComboBox() {
        $this->set('categorias', $this->Categoria->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Categoria->create();
                if ($this->Categoria->save($this->data)) {
                   $this->set('categorias','1');
                }else{
                     $this->set('categorias','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Categoria->id = $id;
        $this->Categoria->recursive = -1;
        $this->set('categorias', $this->Categoria->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Categoria->id = $id;
        if ($this->Categoria->save($this->request->data)) {
            $this->set('categorias', '1');
        }else{
            $this->set('categorias', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        $cant=$this->Categoria->hasSubCat($id);
        if ($cant==0){
            $this->Categoria->delete($id);
            $this->set('categorias', 't');
        }else{
            $this->set('categorias', $cant);
        }
        $this->layout = 'ajax';
    }
    
}

?>

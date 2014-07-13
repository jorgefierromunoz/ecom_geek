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
class SubCategoriasController extends AppController{
    //put your code here
    public $name = 'SubCategorias';
            
    public function index(){
      
    }
    function listasubcategorias() {
        $this->set('subcategorias', $this->SubCategoria->find('all'));
        $this->layout = 'ajax';
    }
    function listasubcategoriasComboBox() {
        $this->set('subcategorias', $this->SubCategoria->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->SubCategoria->create();
                if ($this->SubCategoria->save($this->data)) {
                   $this->set('subcategorias','1');
                }else{
                     $this->set('subcategorias','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->SubCategoria->id = $id;
        $this->SubCategoria->recursive = -1;
        $this->set('subcategorias', $this->SubCategoria->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->SubCategoria->id = $id;
        if ($this->SubCategoria->save($this->request->data)) {
            $this->set('subcategorias', '1');
        }else{
            $this->set('subcategorias', '0');
        }
        $this->layout = 'ajax';
    }
    
        function delete($id) {
        $cant=$this->SubCategoria->hasProducto($id);
        if ($cant==0){
            $this->SubCategoria->delete($id);
            $this->set('subcategorias', 't');
        }else{
            $this->set('subcategorias', $cant);
        }
        $this->layout = 'ajax';
    }

}

?>

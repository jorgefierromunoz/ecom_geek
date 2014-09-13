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
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('listasubcategorias','listasubcategoriasComboBox','view');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }         
    public function index(){
      
    }
    function listasubcategorias($atributo=null,$orden=null) {
        $this->set('subcategorias', $this->SubCategoria->find('all',array('order'=>array($atributo=> $orden))));;
        $this->layout = 'ajax';
    }
    function listasubcategoriasComboBox($id) {
        if ($id!="x"){
        $arreglo= array('recursive'=>0,'conditions'=>array('SubCategoria.categoria_id'=>$id),'order'=>array('SubCategoria.subCategoria'=> 'asc'));
        }
        else{
        $arreglo= array('recursive'=>0,'order'=>array('SubCategoria.subCategoria'=> 'asc'));
        }
        $this->set('subcategorias', $this->SubCategoria->find('all',$arreglo));
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

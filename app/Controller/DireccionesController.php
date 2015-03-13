<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DireccionesController
 *
 * @author MASTER
 */
class DireccionesController extends AppController{
    //put your code here
    public $name = 'Direcciones';
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('misdirecciones','listadirecciones', 'listadireccionesComboBox','view','add','edit','delete');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
    public function index(){
        
    }
    public function misdirecciones(){
        $id_usu=$this->Session->read('Tot_Compra.usuario.User.id');
        $this->set('direcciones',$this->Direccione->misdirecciones($id_usu)); 
        $this->layout = 'ajax';  
    }
    function listadirecciones($atributo=null,$orden=null) {
        $this->set('direcciones', $this->Direccione->find('all',array('order'=>array($atributo=> $orden))));
        $this->layout = 'ajax';
    }
     function listadireccionesComboBox() {
        $this->set('direcciones', $this->Direccione->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Direccione->create();
                if ($this->Direccione->save($this->data)) {
                   $this->set('direcciones','1');
                }else{
                     $this->set('direcciones','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
    public function view($id = null) {
        $this->Direccione->id = $id;
        $this->Direccione->recursive = -1;
        $this->set('direcciones', $this->Direccione->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Direccione->id = $id;
        if ($this->Direccione->save($this->request->data)) {
            $this->set('direcciones', '1');
        }else{
            $this->set('direcciones', '0');
        }
        $this->layout = 'ajax';
    }
  
    function delete($id) {
        if ($this->Direccione->delete($id)) {
           $this->set('direcciones','1');   
        }else{
            $this->set('direcciones','0');    
        } 
        $this->layout = 'ajax';
    }
   
}

?>

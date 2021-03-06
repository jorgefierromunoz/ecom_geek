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
class TipoCuentasBancariasController extends AppController{
    //put your code here
    public $name = 'TipoCuentasBancarias';
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('listatcbancarias','listatcbancariasComboBox','view');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }      
    public function index(){
      
    }
    function listatcbancarias() {
        $this->set('tipocuentasbancarias', $this->TipoCuentasBancaria->find('all'));
        $this->layout = 'ajax';
    }
    function listatcbancariasComboBox($id="x") {         
        if ($id!="x"){
        $arreglo= array('recursive'=>0,'conditions'=>array('TipoCuentasBancaria.banco_id'=>$id),'order'=>array('TipoCuentasBancaria.tipoCuentaBancaria'=> 'asc'));
        }
        else{
        $arreglo= array('recursive'=>0,'order'=>array('TipoCuentasBancaria.tipoCuentaBancaria'=> 'asc'));
        }
        $this->set('tipocuentasbancarias', $this->TipoCuentasBancaria->find('all',$arreglo));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->TipoCuentasBancaria->create();
                if ($this->TipoCuentasBancaria->save($this->data)) {
                   $this->set('tipocuentasbancarias','1');
                }else{
                     $this->set('tipocuentasbancarias','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->TipoCuentasBancaria->id = $id;
        $this->TipoCuentasBancaria->recursive = -1;
        $this->set('tipocuentasbancarias', $this->TipoCuentasBancaria->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->TipoCuentasBancaria->id = $id;
        if ($this->TipoCuentasBancaria->save($this->request->data)) {
            $this->set('tipocuentasbancarias', '1');
        }else{
            $this->set('tipocuentasbancarias', '0');
        }
        $this->layout = 'ajax';
    }
    
        function delete($id) {
        $cant=$this->TipoCuentasBancaria->hasusuarios($id);
        if ($cant==0){
            $this->TipoCuentasBancaria->delete($id);
            $this->set('tipocuentasbancarias', 't');
        }else{
            $this->set('tipocuentasbancarias', $cant);
        }
        $this->layout = 'ajax';
    }
}

?>

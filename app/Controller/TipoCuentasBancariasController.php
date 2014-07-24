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
        public function index(){
      
    }
    function listatcbancarias() {
        $this->set('tipocuentasbancarias', $this->TipoCuentasBancaria->find('all'));
        $this->layout = 'ajax';
    }
    function listatcbancariasComboBox() {
        $this->set('tipocuentasbancarias', $this->TipoCuentasBancaria->find('all',array('recursive'=>-1)));
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

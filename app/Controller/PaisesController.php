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
class PaisesController extends AppController{
    //put your code here
    public $name = 'Paises';
    public function beforeFilter() {
        parent::beforeFilter();
        if ((!$this->Session->check('User')) || ($this->Session->read('User.0.Tipo_Use')=='cliente')) {
            $this->Auth->allow('listapaises','listapaisesComboBox','view');
        }elseif (($this->Session->check('User')) && ($this->Session->read('User.0.Tipo_Use') == 'admin')) {
            $this->Auth->allow();
        }
    }
    public function index(){
      
    }
    function listapaises($atributo,$orden,$pagina=1) {
        $totalPaises = $this->Paise->totalPaises();
        $this->set('paises',array($this->Paise->find('all',array('order'=>array($atributo=> $orden),'limit'=>20,'page'=>$pagina)),$totalPaises,$pagina, ceil($totalPaises / 20)));
        $this->layout = 'ajax';
    }

      function listapaisesComboBox() {
        $this->set('paises', $this->Paise->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
    public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Paise->create();
                if ($this->Paise->save($this->data)) {
                   $this->set('paises','1');
                }else{
                     $this->set('paises','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Paise->id = $id;
        $this->Paise->recursive = -1;
        $this->set('paises', $this->Paise->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Paise->id = $id;
        if ($this->Paise->save($this->request->data)) {
            $this->set('paises', '1');
        }else{
            $this->set('paises', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        $cant=$this->Paise->hasRegiones($id);
        if ($cant==0){
            $this->Paise->delete($id);
            $this->set('paises', 't');
        }else{
            $this->set('paises', $cant);
        }
        $this->layout = 'ajax';
    }
}

?>

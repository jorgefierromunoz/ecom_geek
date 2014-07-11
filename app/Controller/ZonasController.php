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
        if ($this->Zona->delete($id)) {
            $this->set('zonas', '1');
        }else{
            $this->set('zonas', '0');
        }
            $this->layout = 'ajax';
        }
   
}

?>

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
class RegionesController extends AppController{
    //put your code here
    public $name = 'Regiones';
            
    public function index(){
      
    }
    function listaregiones() {
        $this->set('regiones', $this->Regione->find('all'));
        $this->layout = 'ajax';
    }
     function listaregionesComboBox() {
        $this->set('regiones', $this->Regione->find('all',array('recursive'=>-1)));
        $this->layout = 'ajax';
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Regione->create();
                if ($this->Regione->save($this->data)) {
                   $this->set('regiones','1');
                }else{
                     $this->set('regiones','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Regione->id = $id;
        $this->Regione->recursive = -1;
        $this->set('regiones', $this->Regione->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Regione->id = $id;
        if ($this->Regione->save($this->request->data)) {
            $this->set('regiones', '1');
        }else{
            $this->set('regiones', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        if ($this->Regione->delete($id)) {
            $this->set('regiones', '1');
        }else{
            $this->set('regiones', '0');
        }
            $this->layout = 'ajax';
        }
}

?>

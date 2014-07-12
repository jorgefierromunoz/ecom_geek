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
class FotosController extends AppController{
    //put your code here
    public $name = 'Fotos';
    
    function listafotos() {
        $this->set('fotos', $this->Foto->find('all'));
        $this->layout = 'ajax';
    }
    function subirimagen() {
        if ($_FILES['imagen']) {
           $destino = WWW_ROOT . 'img\Fotos' . DS;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino . $_FILES['imagen']['name'])) {
                $resp = "1";
            } else {
                $resp = "0";
            }
        } else {
            $resp = "Inserte una imagen";
        }
        $this->set('fotos', $resp);
        $this->layout = 'ajax';
    }

    function index(){
        
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->Foto->create();
                if ($this->Foto->save($this->data)) {
                   $this->set('fotos','1');
                }else{
                     $this->set('fotos','0');
                }
            }
         }
         $this->layout = 'ajax';
    }
      public function view($id = null) {
        $this->Foto->id = $id;
        $this->Foto->recursive = -1;
        $this->set('fotos', $this->Foto->read());
        $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->Foto->id = $id;
        if ($this->Foto->save($this->request->data)) {
            $this->set('fotos', '1');
        }else{
            $this->set('fotos', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        if ($this->Foto->delete($id)) {
            $this->set('fotos', '1');
        }else{
            $this->set('fotos', '0');
        }
            $this->layout = 'ajax';
        }
}

?>

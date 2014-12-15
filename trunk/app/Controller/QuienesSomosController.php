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
class QuienesSomosController extends AppController{
    //put your code here
    public $name = 'QuienesSomos';
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }    
    public function index(){
        
    }
    
}

?>

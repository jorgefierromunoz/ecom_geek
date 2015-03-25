<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BancosController
 *
 * @author MASTER
 */
class DetalleComprasController extends AppController{
    //put your code here
    public $name = 'DetalleCompras';
    //public $scaffold;
   
    public function add($data) {
            if (!empty($data)) {
                $this->DetalleCompra->create();
                if ($this->DetalleCompra->save($data)) {
                   return true;
                }else{
                   return false;
                }
            }
    }
}

?>

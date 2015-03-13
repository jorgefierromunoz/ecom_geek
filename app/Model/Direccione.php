<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categoria
 *
 * @author MASTER
 */
class Direccione extends AppModel{
    //put your code here
    public $name='Direccione';
    public $belongsTo=array('User','Comuna');
    public function beforeSave($options = array()) { 
        $user=CakeSession::read('Tot_Compra.usuario.User.id');
        if($user){
          $this->data['Direccione']['user_id'] = $user;
        }
        return true;
    }
    function misdirecciones($id){
        $direcciones= $this->find('all', 
                    array(
                        'conditions' => array('Direccione.user_id' => $id),
                        'recursive'=>-1
                        )
            );
        return $direcciones;
    }
    
}

?>

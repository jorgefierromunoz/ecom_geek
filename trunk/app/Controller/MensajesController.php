<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mensajesController
 *
 * @author MASTER
 */
App::uses('CakeEmail', 'Network/Email');

class mensajesController extends AppController {

    //put your code here
    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function send() {
        if (!empty($this->request->data)) {
            $rutus = $_POST['rutusu'];
            $emailus = $_POST['emailusu'];
            
            $rut = Security::hash($rutus, null, true);
            $titulo = "Resgistro nuevo usuario";
            $email = new CakeEmail('gmail');
            $email->template('email_tpl')
                    ->emailFormat('html')
                    ->viewVars(array('rutS' => $rut))
                    ->from(array('pruebaecomercejorge@gmail.com' => 'Jorge Fierro Felipe Candia'))
                    ->to($emailus)
                    ->subject($titulo);
            if ($email->send()) {
               $this->set('mails','Mensaje de confirmación enviado a '.$emailus);
            }else{
                  $this->set('mails','Mensaje no fue enviado intentalo de nuevo');
            }
            $this->layout = 'ajax';
        }
    }

    public function detallecarritomail() {
        if (!empty($this->request->data)) {
            $rutus = $_POST['rutusu'];
            $emailus = $_POST['emailusu'];
            $idv=$_POST['idventa'];
            $rut = Security::hash($rutus, null, true);
            $titulo = "Resgistro nuevo usuario";
            $email = new CakeEmail('gmail');
            $email->template('email_detalle_venta')
                    ->emailFormat('html')
                    ->viewVars(array('rutS' => $rut))
                    ->from(array('pruebaecomercejorge@gmail.com' => 'Jorge Fierro'))
                    ->to($emailus)
                    ->subject($titulo);
            if ($email->send()) {
               $this->set('mails','Tu detalle de compra fue enviado a '.$emailus);
            }else{
                  $this->set('mails','Mensaje no fue enviado intentalo de nuevo');
            }
            $this->layout = 'ajax';
        }
    }
}

?>

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

class MensajesController extends AppController {

    //put your code here
    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('send','detallecarritomail','emailnuevopass');
    }
     public function send() {
        if (!empty($this->request->data)) {
            $username = $this->data['email'];
            $emailus = $this->data['email']; 
            $nombre= $this->data['nombre'];
            $usercod = Security::hash($username, null, true);
            $titulo = "Resgistro nuevo usuario";
            $email = new CakeEmail('gmail');
            $email->template('email_tpl')
                    ->emailFormat('html')
                    ->viewVars(array('cod_usuario' => $usercod,'username'=>$username,'nombre'=>$nombre))
                    ->from(array('pruebaecomercejorge@gmail.com' => 'Jorge Fierro'))
                    ->to($emailus)
                    ->subject($titulo);
            if ($email->send()) {
                $this->set('mails','1');
            }else{
                $this->set('mails','0');
            }            
        }else{
             $this->set('mails','0');
        }
        $this->layout = 'ajax';
    }
    public function emailnuevopass() {
        if (!empty($this->request->data)) {  
            $emailus = $this->data['email'];  
            $usercod = Security::hash($emailus, null, true);
            $titulo = "Geek4y Nueva Contraseña";
            $email = new CakeEmail('gmail');
            $email->template('email_tpl_recuperacion')
                    ->emailFormat('html')
                    ->viewVars(array('cod_usuario' => $usercod,'email'=>$emailus))
                    ->from(array('pruebaecomercejorge@gmail.com' => 'Jorge Fierro'))
                    ->to($emailus)
                    ->subject($titulo);
            if ($email->send()) {
                $this->set('mails','1');
            }else{
                $this->set('mails','0');
            }            
        }else{
             $this->set('mails','0');
        }
        $this->layout = 'ajax';
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

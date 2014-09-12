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
class UsersController extends AppController{
    //put your code here
    public $name = 'Users';

    public function micuentajson() {
        if ($this->Session->check('user')) {
            $id = $_SESSION['user'][0]['IdUsu'];
            $user = $this->user->find('all', array('conditions' => array('user.id' => $id),
                'fields' => array('id', 'username', 'rut', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'email')
            ));
            $this->set('users', $user);
            $this->layout = 'ajax';
        }
    }
    
    public function checkuser($user) {
        $userbd = $this->User->find('all', array('conditions' => array('User.username' => $user)));
        if ($userbd) {            
            $this->set('users', $userbd);           
        }else {
            $userbd=0;
            $this->set('users', $userbd);           
        }
         $this->layout = 'ajax';
    }
     public function checkemail($email) {
        $userbd = $this->User->find('all', array('conditions' => array('User.email' => $email)));
        if ($userbd) {            
            $this->set('users', '1');           
        }else {
            $userbd=0;
            $this->set('users', $userbd);           
        }
         $this->layout = 'ajax';
    }

    public function logout() {
        $this->Session->delete('User');
        $this->redirect(array('controller' => 'pages', 'action' => 'display'));
    }

    public function habilitar($link = null) {
        
        $userbd = $this->User->find('all', array('conditions' => array('User.codigo' => $link),
                'fields' => array('id', 'username', 'tipo', 'rut', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'email','codigo')));
        $cod = $userbd[0]['User']['codigo'];
        if (($userbd) && ($cod != "codhabxmailgeek4y")) {
            $id = $userbd[0]['User']['id'];
            $this->User->id = $id;
            $this->User->saveField("estado", "habilitado");
            $this->User->saveField("codigo", "codhabxmailgeek4y");
            $arreglouser = array(
                        'IdUsu' => $userbd[0]['User']['id'],
                        'Username' => $userbd[0]['User']['username'],
                        'Tipo' => $userbd[0]['User']['tipo'],
                        'Rut' => $userbd[0]['User']['rut'],
                        'Nombre' => $userbd[0]['User']['nombre'],
                        'ApPaterno' => $userbd[0]['User']['apellidoPaterno'],
                        'ApMaterno' => $userbd[0]['User']['apellidoMaterno'],
                        'Email' => $userbd[0]['User']['email'],
                        'Referido' => $userbd[0]['User']['referido'],
                        'PtosAcumu' => $userbd[0]['User']['puntoAcumulado'],
                        'CatVenId'=> $userbd[0]['User']['categoria_vendedore_id'],                        
                    );
                    $this->Session->write('User', array($arreglouser));

            if (($this->Session->check('User')) && ( $userbd[0]['User']['tipo'] == 'admin')) {
                $this->set('users', $userbd);         
            } else {
                $this->set('users', $userbd);         
            }
        } else {
            $this->set('users', 'codigo erroneo');
        }
        $this->layout = 'ajax';
    }

    public function loguear() {
        if (!empty($this->request->data)) {
            $username = $this->data['username'];
            $password = $this->data['password'];;
        }
        if (($username != "") && ($password != "")) {
            $pas = Security::hash($password, null, true);
            $user = $this->User->find('all', array('conditions' => array(
                    'User.username' => $username, 'User.password' => $pas),
                'fields' => array('id', 'username', 'tipo', 'rut', 'nombre', 'apellidoPaterno',
                    'apellidoMaterno', 'email', 'estado','referido','puntoAcumulado','categoria_vendedore_id')));
            if (!$user == null) {
                if ($user[0]['User']['estado'] == "habilitado") {
                    $arreglouser = array(
                        'IdUsu' => $user[0]['User']['id'],
                        'Username' => $user[0]['User']['username'],
                        'Tipo' => $user[0]['User']['tipo'],
                        'Rut' => $user[0]['User']['rut'],
                        'Nombre' => $user[0]['User']['nombre'],
                        'ApPaterno' => $user[0]['User']['apellidoPaterno'],
                        'ApMaterno' => $user[0]['User']['apellidoMaterno'],
                        'Email' => $user[0]['User']['email'],
                        'Referido' => $user[0]['User']['referido'],
                        'PtosAcumu' => $user[0]['User']['puntoAcumulado'],
                        'CatVenId'=> $user[0]['User']['categoria_vendedore_id'],                        
                    );
                    $this->Session->write('User', array($arreglouser));
                    $this->set('users','1');
                } else{ //if ($user[0]['user']['estado'] == "deshabilitado") {
                    $a = 'Usuario deshabilitado, revise su correo';
                    $this->set('users', $a);
               }
            } else {
                $a = 'Usuario o Password introducidos no son correctos';
                $this->set('users', $a);
            //}
        }
        
            } else {
            $a = 'Ingrese un nombre de usuario y un password';
            $this->set('users', $a);
        }
        $this->layout = "ajax";
    }

    public function index() {
    }
    public function nuevousuario(){
        
    }
    public function login() {
        
    }
     public function add() {
         if ($this->request->is('post')) {
            if (!empty($this->data)) {
                $this->User->create();
                if ($this->User->save($this->data)) {
                    $this->set('users','1');
                }else{
                    $this->set('users','0');
                }
            }
         }
         $this->layout = 'ajax';
    }

    function listausers($atributo=null,$orden=null) {
        $this->set('users', $this->User->find('all',array('order'=>array($atributo=> $orden))));
        $this->layout = 'ajax';
    }

    public function view($id = null) {
      $this->User->id = $id;
      $this->User->recursive = -1;
      $this->set('users', $this->User->read());
      $this->layout = 'ajax';
    }
    function edit($id = null) {
        $this->User->id = $id;
        if ($this->User->save($this->request->data)) {
            $this->set('users', '1');
        }else{
            $this->set('users', '0');
        }
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        $cantdir=$this->User->hasdirecciones($id);
        //$cantcompra=$this->User->hasordenescompras($id);
        if ($cantdir==0){
            $this->User->delete($id);
            $this->set('users', 't');
        }else{
            $this->set('users', $cantdir);
        }
        $this->layout = 'ajax';
    }
}

?>

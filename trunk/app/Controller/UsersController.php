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
    
//    function beforeFilter() {
//        parent::beforeFilter();
//        if ((!$this->Session->check('user'))) {
//            $this->Auth->allow('subirimagen', 'add', 'login', 'loguear', 'habilitar', 'checkuser');
//        } elseif (($_SESSION['user'][0]['Tipo'] == 'cliente')) {
//            $this->Auth->allow('subirimagen', 'logout', 'edit', 'micuenta', 'micuentajson');
//        } elseif (($this->Session->check('user')) && ($_SESSION['user'][0]['Tipo'] == 'admin')) {
//            $this->Auth->allow();
//        }
//    }

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

    public function checkuser() {
        $user=$_POST['Id'];
        $userbd = $this->user->find('all', array('conditions' => array('user.username' => $user)
        ));
        if (!$userbd) {
            $userbd=0;
            $this->set('users', $userbd);
           
        } else {
            $this->set('users', $userbd);
           
        }
         $this->layout = 'ajax';
    }

    public function logout() {
        $this->Session->delete('user');
        $this->redirect(array('controller' => 'pages', 'action' => 'display'));
    }

    public function habilitar($link = null) {
        $userbd = $this->user->find('all', array('conditions' => array('user.codigo' => $link),
                'fields' => array('id', 'username', 'tipo', 'rut', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'email',
                'filename', 'codigo')));
        $cod = $userbd[0]['user']['codigo'];
        if (($userbd) && ($cod != "codhabxmailgeek4y")) {
            $id = $userbd[0]['user']['id'];
            $this->user->id = $id;
            $this->user->saveField("estado", "habilitado");
            $this->user->saveField("codigo", "codhabxmailgeek4y");
            $arreglouser = array(
                'IdUsu' => $userbd[0]['user']['id'],                
                'Rutu' => $userbd[0]['user']['rut'],                
                'Email' => $userbd[0]['user']['email'],
                'Username' => $userbd[0]['user']['username'],
                'Tipo' => $userbd[0]['user']['tipo'],
                'Nombre' => $userbd[0]['user']['nombre'],
                'ApPaterno' => $userbd[0]['user']['apellidoPaterno'],
                'ApMaterno' => $userbd[0]['user']['apellidoMaterno'],
                'CatVendedor' => $userbd[0]['user']['catVendedor']
                    );
            $this->Session->write('user', array($arreglouser));

            if (($this->Session->check('user')) && ($_SESSION['user'][0]['Tipo'] == 'admin')) {
                $this->redirect(array('controller' => 'pages', 'action' => 'admin'));
            } else {
                $this->redirect(array('controller' => 'pages', 'action' => 'display'));
            }
        } else {
            $this->set('users', 'codigo erroneo');
            $this->redirect(array('controller' => 'pages', 'action' => 'display'));
        }
    }

    public function loguear() {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
        }
        if (($username != "") && ($password != "")) {
            $pas = Security::hash($password, null, true);
            $user = $this->user->find('all', array('conditions' => array(
                    'user.username' => $username, 'user.password' => $pas),
                'fields' => array('id', 'username', 'tipo', 'rut', 'nombre', 'apellidoPaterno',
                    'apellidoMaterno', 'email', 'filename', 'estado')));
            if (!$user == null) {
                if ($user[0]['user']['estado'] == "habilitado") {
                    $arreglouser = array(
                        'IdUsu' => $user[0]['user']['id'],
                        'Username' => $user[0]['user']['username'],
                        'Tipo' => $user[0]['user']['tipo'],
                        'Rut' => $user[0]['user']['rut'],
                        'Nombre' => $user[0]['user']['nombre'],
                        'ApPaterno' => $user[0]['user']['apellidoPaterno'],
                        'ApMaterno' => $user[0]['user']['apellidoMaterno'],
                        'Email' => $user[0]['user']['email'],
                        'Filename' => $user[0]['user']['filename'],
                    );
                    $this->Session->write('user', array($arreglouser));
                    $this->set('users', $arreglouser);
                } elseif ($user[0]['user']['estado'] == "deshabilitado") {
                    $a = array('2');
                    $this->set('users', $a);
                }
            } else {
                $a = array('1');
                $this->set('users', $a);
            }
        } else {
            $a = array('0');
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

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
        $valido=false;
        if ($this->request->is('post')) {            
            if ($_FILES['imagen']['type'] == "image/jpeg") {
                $nombreimag=$_POST['url'].".jpg";
                $valido=true;
            }else if($_FILES['imagen']['type'] == "image/png"){
                $nombreimag=$_POST['url'].".png";
                $valido=true;
            }
            if ($valido){
                if($_FILES['imagen']['size'] <= 2048000){
                        if (!empty($this->request->data)) {                            
                           $this->Foto->create();                              
                            if ($this->Foto->save(array('url'=>$nombreimag,'mime'=>$_FILES['imagen']['type'],'descripcion'=>'Peso: '.$_FILES['imagen']['size']."/kB",'producto_id'=>$_POST['producto_id']))) {
                                $idImagen=$this->Foto->getLastInsertID();
                                $destino = WWW_ROOT . 'img\Fotos' . DS;
                                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino .$idImagen."_".$nombreimag)) {
                                    $this->Foto->id = $idImagen;                                    
                                    if ($this->Foto->save(array('url'=>$idImagen."_".$nombreimag))){
                                         $resp = '1';
                                    }else{
                                        $resp = 'Error editando nombre registro';
                                    }                       
                                } else {
                                    $resp = "No se pudo guardar la imagen ";
                                }
                            }else{
                                 $resp="No se pudo guardar los datos";
                            }
                        }else{
                            $resp="Data viene vacio";
                        }                    
                }else{
                        $resp = "La imagen (".ceil($_FILES['imagen']['size']/1000) ."/kB) debe pesar menos de 2048/kB ";
                }          
            } else {
                $resp = "Debe ser una imagen JPEG - PNG";
            }
            $this->set('fotos',$resp);
        }    
        $this->layout = 'ajax';
    }

    function index(){
        
    }
  
      public function view($id = null) {
        $this->Foto->id = $id;
        $this->Foto->recursive = -1;
        $this->set('fotos', $this->Foto->read());
        $this->layout = 'ajax';
    }
    function edit($id = null,$flag=1) {
        if ($flag){
            $this->Foto->id = $id;
            if ($this->Foto->save(array('producto_id'=>$_POST['idproducto']))) {
                $resp='1';
            }else{
                $resp='0';
            }
        }else{ 
           if($this->eliminarImagen($id)==1){
            //si se elimina la imagen antigua procedemos a subir la nueva
            $valido=false;
            if ($_FILES['imagen']['type'] == "image/jpeg") {
                 $nombreimag=$_POST['url'].".jpg";
                 $valido=true;
             }else if($_FILES['imagen']['type'] == "image/png"){
                 $nombreimag=$_POST['url'].".png";
                 $valido=true;
             }
             if ($valido){
                if($_FILES['imagen']['size'] <= 2048000){
                        if (!empty($this->request->data)) {   
                            $this->Foto->id = $id;
                            if ($this->Foto->save(array('url'=>$nombreimag,'mime'=>$_FILES['imagen']['type'],'descripcion'=>'Peso: '.$_FILES['imagen']['size']."/kB",'producto_id'=>$_POST['idproducto']))) { 
                                $destino = WWW_ROOT . 'img\Fotos' . DS;
                                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino .$id."_".$nombreimag)) {
                                    $this->Foto->id = $id;                                    
                                    if ($this->Foto->save(array('url'=>$id."_".$nombreimag))){
                                         $resp = '1';
                                    }else{
                                        $resp = 'Error editando nombre registro';
                                    }                       
                                } else {
                                    $resp = "No se pudo guardar la imagen ";
                                }
                            }else{
                                 $resp="No se pudo guardar los datos";
                            }
                        }else{
                            $resp="Data viene vacio";
                        }                    
                }else{
                        $resp = "La imagen (".ceil($_FILES['imagen']['size']/1000) ."/kB) debe pesar menos de 2048/kB ";
                }          
            } else {
                $resp = "Debe ser una imagen JPEG - PNG";
            }
          }else{
              $resp='No se pudo eliminar imagen antigua';
          }
        }
        $this->set('fotos',$resp);    
        $this->layout = 'ajax';
    }
    
    function delete($id) {
        if ($this->eliminarImagen($id)){
            if ($this->Foto->delete($id)) {
               $this->set('fotos','1');   
            }else{
                $this->set('fotos','0');    
            } 
        }else{
            if ($this->Foto->delete($id)) {
               $this->set('fotos','2');   
            }else{
                $this->set('fotos','-1');    
            } 
        }        
        $this->layout = 'ajax';
    }

    function eliminarImagen($id){
      $this->Foto->id = $id;
      $this->Foto->recursive = -1;       
      $Foto =  $this->Foto->read();
      $destino = WWW_ROOT . 'img\Fotos' . DS;
      $url=$destino.$Foto['Foto']['url']; 
      if(file_exists($url)){ 
          if(unlink($url)){
              return "1";
          }else{
              return "0";
          }
      }else{
           return "-1";
      }
    }  
}

?>

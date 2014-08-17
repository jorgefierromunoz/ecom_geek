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
    function redimImagen($direccion,$idima,$nombreima){        
        $nameimagen= $_FILES['imagen']['name'];
        $tmpimagen= $_FILES['imagen']['tmp_name'];
        $ancho = 250;
        $info = pathinfo($nameimagen);
	$tamano = getimagesize($tmpimagen);
	$width 	= $tamano[0];		
	$height	= $tamano[1];
	if($width > $ancho){
            $alto = intval($height * $ancho / $width);
            //$alto=250;
            if($info['extension'] =="jpg"){
                $viejaimagen = imagecreatefromjpeg($tmpimagen);
                $nuevaimagen = imagecreatetruecolor($ancho, $alto); 
                imagecopyresized($nuevaimagen, $viejaimagen, 0,0,0,0,$ancho,$alto, $width, $height);
                $original=$direccion.$idima."_".$nombreima;
                $copia=$direccion."s_".$idima."_".$nombreima;
                copy($tmpimagen, $original);
                imagejpeg($nuevaimagen, $copia);
                return true;
            }else if($info['extension'] =="png"){
                $viejaimagen = imagecreatefrompng($tmpimagen);
                $nuevaimagen = imagecreatetruecolor($ancho, $alto); 
                imagecopyresized($nuevaimagen, $viejaimagen, 0,0,0,0,$ancho,$alto, $width, $height);
                $original=$direccion.$idima."_".$nombreima;
                $copia=$direccion."s_".$idima."_".$nombreima;
                copy($tmpimagen, $original);	
                imagepng($nuevaimagen, $copia);
                return true;
            }else{
                return false;
            }	
	}        
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
                                $destino = WWW_ROOT . 'img'.DS.'Fotos' . DS;
                                //if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino .$idImagen."_".$nombreimag)) {
                                if ($this->redimImagen($destino,$idImagen,$nombreimag)){
                                    $this->Foto->id = $idImagen;                                    
                                    if ($this->Foto->save(array('url'=>$idImagen."_".$nombreimag))){
                                         $resp = '1';
                                    }else{
                                        $resp = 'Error editando nombre registro';
                                    }                       
                                } else {
                                    $resp = "No se pudo redimensionar la imagen ";
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
                                $destino = WWW_ROOT . 'img'.DS.'Fotos' . DS;
                                //if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino .$id."_".$nombreimag)) {
                                if ($this->redimImagen($destino,$id,$nombreimag)){  
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
      $destino = WWW_ROOT . 'img'.DS.'Fotos' . DS;
      $url=$destino.$Foto['Foto']['url'];
      $urls=$destino."s_".$Foto['Foto']['url'];
      if(file_exists($url)){ 
          if(unlink($url)){
              if (unlink($urls)){
                  return "1";
              }
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

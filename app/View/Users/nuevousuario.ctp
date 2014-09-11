<script type="text/javascript"> 
$(document).ready(function(){
        $("#usuario").blur(function() {
          if ($("#usuario").val().trim().length == 0){
                $("#valido").html("Campo requerido");
                $("#valido").show();
                $("#spnaalert").show();  
           }else{
            checkus($("#usuario").val(),'#valido');
           }
        });
        $("#email").blur(function() {
           if ($("#email").val().trim().length == 0){
                $("#spnaddemail").html("Campo requerido");
                $("#spnaddemail").show();
                $("#spnaalert").show();  
           }else{
               checkemail($("#email").val(),'#imgemail');
           }
        });
        repas=false;
        $("#repassword").blur(function() {
            if($("#password").val()== $("#repassword").val()){
                repas=true;
                $("#spnaddrepassword").html("");
            }else{
                repas=false;
                $("#spnaddrepassword").html("Password no coinciden");
            }
        });
     //GUARDAR BUTTON ADD DIALOG
        $("#adduserssave").click(function(e) {
            e.preventDefault();
        if ( $("#nombre").val().trim().length == 0 ){
                $("#spnaddnombre").html("Campo requerido");
                $("#spnaddnombre").show();
                $("#spnaalert").show();     
        }else if ( $("#apellidopaterno").val().trim().length == 0 ){
                $("#spnaddappaterno").html("Campo requerido");
                $("#spnaddappaterno").show();
                $("#spnaalert").show();
        }else if ( $("#apellidomaterno").val().trim().length == 0 ){
                $("#spnaddapmaterno").html("Campo requerido");
                $("#spnaddapmaterno").show();
                $("#spnaalert").show();      
        }else if ( $("#email").val().trim().length == 0){
                $("#spnaddemail").html("Campo requerido");
                $("#spnaddemail").show();
                $("#spnaalert").show();      
        }else if (!chkemail){
                $("#spnaalert").show();      
        }else if ( $("#usuario").val().trim().length == 0 ) {
                $("#spnaddusuario").html("Campo requerido");
                $("#spnaddusuario").show();                
                $("#spnaalert").show();             
        }else if (!chkusu){
            $("#spnaalert").show();
        }else if ( $("#password").val().trim().length == 0 ){
            $("#spnaddpassword").html("Campo requerido");
            $("#spnaddpassword").show();
            $("#spnaalert").show();
        }else if ( $("#repassword").val().trim().length == 0 ){
            $("#spnaddrepassword").html("Campo requerido");
            $("#spnaddrepassword").show();
            $("#spnaalert").show();
        }else if (!repas){
            $("#spnaalert").show();
        }else{
                $.ajax({
                    url: "add",
                    type: "POST",
                    data: $("#formadduser").serialize(),
                    dataType:'json',
                    beforeSend:function(){ $("#cargando").dialog("open");},
                    success: function(n) {
                        $("#spnaalert").html('<?php echo $this->Html->image('ajaxload2.gif'); ?>Enviando correo de activación de cuenta');
                        if (n==1){    
                             $.ajax({
                                url: '<?php echo $this->Html->url(array('controller'=>'Mensajes','action'=>'send')); ?>',
                                type: "POST",
                                data: {username: $("#usuario").val(), email: $("#email").val(), nombre: $("#nombre").val()+ " " + $("#apellidopaterno").val()},
                                dataType:'json',
                                beforeSend:function(){ $("#cargando").dialog("open");},
                                success: function(n) {
                                    if(n=="1"){
                                        $("#spnaalert").html("Se ha enviado un correo de activación a su cuenta");
                                    }else{
                                        $("#spnaalert").html("No se pudo enviar correo, contactese con el administrador de la página");
                                    }
                                },
                                error: function(n){"error mensaje: "+ console.log(n);}
                            });
                            $("#formadduser").trigger("reset");                              
                            $("#cargando").dialog("close");
                        }else if (n==0){
                            $("#spnaalert").html("No se pudo guardar, intentelo de nuevo");
                            $("#spnaalert").show();
                            $("#cargando").dialog("close");
                        }                        
                           
                    },
                    error: function(n) {
                        console.log(n);
                        $("#spnaalert").html("No se pudo guardar, intentelo de nuevo");
                        $("#spnaalert").show();
                        $("#cargando").dialog("close");
                    }
                });
            }
        });
});
     function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (!emailReg.test($email)) {
                return false;
            } else {
                return true;
            }
        }
    chkusu=false;    
    function checkus(us,target){
            if (us) {
                $.ajax({
                    url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'checkuser')); ?>/' + us,
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $(target).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },
                    success: function(data) {
                        if (data == 0) {
                            $(target).html('<?php echo $this->Html->image('aceptar.png'); ?>');  
                            $("#spnaddusuario").html("");
                            chkusu=true;
                        } else {                            
                            $(target).html('<?php echo $this->Html->image('cancelar.png'); ?>');
                            $("#spnaddusuario").html("Nombre de usuario ya existe");
                            chkusu=false;
                        }
                    }
                });
            }else{
                $(target).html("Campo obligatorio");
            }
        }
        chkemail=false;
        function checkemail(us,target){
        if (validateEmail(us)){
            $.ajax({
                    url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'checkemail')); ?>/' + us,
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $(target).html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },
                    success: function(data) {
                        if (data == 0) {
                            $(target).html('<?php echo $this->Html->image('aceptar.png'); ?>');   
                            $("#spnaddemail").html("Email aparentemente válido");
                            $("#spnaddemail").show();
                            chkemail=true;
                        } else {                            
                            $(target).html('<?php echo $this->Html->image('cancelar.png'); ?>');
                            $("#spnaddemail").html("Este mail ya existe en nuestra base de datos");
                            $("#spnaddemail").show();
                            chkemail=false;
                        }
                    }
                });            
            }
            else{
                $(target).html('<?php echo $this->Html->image('cancelar.png'); ?>');
                $("#spnaddemail").html("El email no es válido");
                $("#spnaddemail").show();
                chkemail=false;
            }
        }
</script>

    <div id="divuser" title="Nuevo Usuario">
        <form id="formadduser" method="POST">
            <table class="nuevousuario">
                <tr>
                    <td><h3>Nuevo Usuario</h3></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><label class="label">Nombre:</label></td>
                    <td><label class="label">Ap. Paterno:</label></td>
                    <td><label class="label">Ap. Materno:</label></td>
                </tr>
                <tr>
                    <td><input id="nombre" type="text" name="nombre"></td>
                    <td><input id="apellidopaterno" type="text" name="apellidoPaterno"></td>
                    <td><input id="apellidomaterno" type="text" name="apellidoMaterno"></td>
                </tr>
                <tr> 
                    <td><span id="spnaddnombre"></span></td>
                    <td><span id="spnaddappaterno"></span></td>
                    <td><span id="spnaddapmaterno"></span></td>
                </tr>
               
                <tr>
                    <td><label class="label">Sexo:</label></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="radio" value="M" name="sexo" checked>Masculino <br>
                        <input type="radio" value="F" name="sexo">Femenino</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr> 
                    <td><span id="spnaddsexo"></span></td>
                    <td></td>
                    <td></td>
                </tr>
                
                <tr>
                    <td><label class="label">Email:</label></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input id="email" type="text" name="email"><span id="imgemail"></span></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr> 
                    <td><span id="spnaddemail"></span></td>
                    <td></td>
                    <td></td>
                </tr>             
                
                <tr>
                    <td><label class="label">User:</label></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input id="usuario" type="text" name="username" value=""><span id="valido"></span></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span id="spnaddusuario"></span></td>
                    <td></td>
                    <td></td>
                </tr> 
                <tr>
                     <td><label class="label">Password:</label></td>
                     <td><label class="label">Repita Password:</label></td>
                     <td></td>

                </tr>
                <tr>
                    <td><input id="password" type="password" name="password" value=""></td>
                    <td><input id="repassword" type="password" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span id="spnaddpassword"></span></td>
                    <td><span id="spnaddrepassword"></span></td>
                    <td></td>
                </tr>
                <tr>    
                    <td><button id="adduserssave" type="button">Registrarse</button></td>
                </tr>
                <tr>
                    <td><span id="spnaalert"></span></td>
                </tr>
            </table>
        </form>
    </div>

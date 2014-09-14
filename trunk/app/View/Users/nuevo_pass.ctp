<script type="text/javascript">
 $(document).ready(function(){
     $("#entrar").click(function(){
           if ( $("#password").val().trim().length == 0 ) {
               $('#spnalertnuevopass').html("Complete los campos correctamente");
           }else if ( $("#repassword").val().trim().length == 0 ) {
               $('#spnalertnuevopass').html("Complete los campos correctamente");
           }else if ( $("#repassword").val()!= $("#password").val() ) {
               $('#spnalertnuevopass').html("No coinciden los password");              
           }else{
               $.ajax({                   
                url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'newPass')); ?>',
                type: "POST",
                data: {link:'<?php echo $users[1]; ?>', pass:$("#password").val()},
                dataType:'json', 
                beforeSend:function(){ $('#spnalertnuevopass').html('<?php echo $this->Html->image('ajaxload2.gif'); ?>Guardando...');},
                success: function(n) {
                    $('#spnalertnuevopass').html("Ahora puede ingresar con su nueva contraseña");
                    
                },
                error: function(n){ $('#spnalertnuevopass').html("Error contactese con el administrador");console.log(n);}
             });
            }
     });
 }); 
   
</script>
<?php if ($users[0]==1): ?>
<div id="divlogin">
    <h3>Nueva Contraseña</h3>
    <form id="formNuevoPass">
        <table class="logintable">
            <tr>
                <td><h3>Password:</h3></td>
            </tr>
            <tr>
                <td><input type="password" id="password" name="password"></td>
            </tr>
            <tr>
                <td><h3>Repita Password:</h3></td>
            </tr>
            <tr>
                <td><input type="password" id="repassword"></td>
            </tr>
            <tr>
                <td class="centertable">                    
                    <div class="contbotones"><span id="entrar" class="botones">Nueva Contraseña</span></div>
                </td>
            </tr>
             <tr>
                <td><span id="spnalertnuevopass"></span></td>
            </tr>
        </table>
    </form>
</div>
<?php endif; ?>
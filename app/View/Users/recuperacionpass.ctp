<script type='text/javascript'>
$(document).ready(function(){        
    $("#entrar").click(function(){
        enviar();
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
function enviar(){
        if (($("#email").val().trim().length != 0 ) && (validateEmail($("#email").val()))){
            $.ajax({
                    url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'checkemail')); ?>/' + $("#email").val(),
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $("#spnalertrecuperacion").html('<?php echo $this->Html->image('ajaxload2.gif'); ?>');
                    },
                    success: function(data) {
                        if (data != 0) {
                            $.ajax({
                                url: '<?php echo $this->Html->url(array('controller'=>'Mensajes','action'=>'emailnuevopass')); ?>',
                                type: "POST",
                                data: {email: $("#email").val()},
                                dataType:'json',
                                beforeSend: function() {
                                    $("#spnalertrecuperacion").html('<?php echo $this->Html->image('ajaxload2.gif'); ?> Enviando correo..');
                                },
                                success: function(n) {
                                    if(n=="1"){
                                        $("#spnalertrecuperacion").html("Se ha enviado un correo de recuperación a su cuenta");
                                    }else{
                                        $("#spnalertrecuperacion").html("No se pudo enviar correo, contactese con el administrador de la página");
                                    }
                                },
                                error: function(n){$("#spnalertrecuperacion").html("Error al enviar mensaje "); console.log(n);}
                            });                              
                        } else {                            
                            $("#spnalertrecuperacion").html('<?php echo $this->Html->image('cancelar.png'); ?> Email no existe en nuestros registros');          
                        }
                    }
                });            
            }
            else{
                $("#spnalertrecuperacion").html('<?php echo $this->Html->image('cancelar.png'); ?>Ingrese un correo válido');
            }
}
</script>
<div id="divlogin">
    <h3>Recuperación de Contraseña</h3>
    <form id="formlogin">
        <table class="logintable">
            <tr>
                <td><h3>Email</h3></td>
            </tr>
            <tr>
                <td><input type="text" id="email" name="email"><span id="spnalertrecuperacion"></span></td>
            </tr>
            
            <tr>
                <td class="centertable">                    
                    <div class="contbotones"><span id="entrar" class="botones">Enviar Email</span></div>
                </td>
            </tr>
             <tr>
                <td></td>
            </tr>
        </table>
    </form>
</div>
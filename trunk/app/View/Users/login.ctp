<script>
    $(document).on('ready', function() {
        $("#entrar").click(function(){
              log();
        });
        $("#password").keypress(function(e){
            if(e.which == 13) {
                log();
            }
        });     
         $("#username").keypress(function(e){
            if(e.which == 13) {
                log();
            }
        });     
    });
    function log(){
        $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'loguear')); ?>',
                type: "POST",
                dataType: 'json',
                data: $("#formlogin").serialize(),
                beforeSend: function(){$("#spnalertlogin").html('<?php echo $this->Html->image('ajaxload2.gif'); ?>Iniciando Sesión...')},
                success: function(data) {
                    if (data=='1'){
                         $("#spnalertlogin").html("");
                         window.location.href = '<?php echo $this->Html->url(array('controller' => 'Pages', 'action' => 'display')); ?>';
                    }else{
                    $("#spnalertlogin").html(data);
                    }
                },
                error: function(e) {  
                    $("#spnalertlogin").html("Error interno, contáctese con el Administrador de la página");
                    console.log(e);
                }
            });
    }
</script>
<div id="divlogin">
    <h3>Inicio Sesión</h3>
    <form id="formlogin">
        <table class="logintable">
            <tr>
                <td><h3>Nombre Usuario:</h3></td>
            </tr>
            <tr>
                <td><input type="text" id="username" name="username"></td>
            </tr>
            <tr>
                <td><h3>Password:</h3></td>
            </tr>
            <tr>
                <td><input type="password" id="password" name="password"></td>
            </tr>
            <tr>
                <td class="centertable">                    
                    <div class="contbotones"><span id="entrar" class="botones">Entrar</span></div>
                </td>
            </tr>
             <tr>
                <td><span id="spnalertlogin"></span></td>
            </tr>
        </table>
    </form>
</div>
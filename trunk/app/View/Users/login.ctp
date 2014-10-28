<script>
    $(document).on('ready', function() {
        $("#entrar").click(function(){
            login("spnalertloginrigth","formloginrigth");
        });
        $("#password").keypress(function(e){
            if(e.which == 13) {
                login("spnalertloginrigth","formloginrigth");
            }
        });     
         $("#username").keypress(function(e){
            if(e.which == 13) {
                login("spnalertloginrigth","formloginrigth");
            }
        });     
    });
</script>
<div id="divlogin">
    <h3>Inicio Sesión</h3>
    <form id="formloginrigth">
        <table class="logintable">
            <tr>
                <td><h3>Email:</h3></td>
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
                     <?php echo $this->Html->link('¿Olvidó su contraseña?', array('controller' => 'Users', 'action' => 'recuperacionpass')) ?>
                </td>
            </tr>
             <tr>
                <td><span id="spnalertloginrigth"></span></td>
            </tr>
        </table>
    </form>
</div>
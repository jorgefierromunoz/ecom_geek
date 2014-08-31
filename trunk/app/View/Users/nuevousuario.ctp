<script type="text/javascript">
$(document).ready(function(){
    
});
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
                    <td></td>
                </tr>
               
                <tr>
                    <td><label class="label">Sexo:</label></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="radio" value="M" name="sexo">Masculino <br>
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
                    <td><input id="email" type="text" name="email"></td>
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
                    <td><input id="usuario" type="text" name="username" value=""></td>
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
            </table>
        </form>
    </div>

 
                
               
                
                                    
                    
                   
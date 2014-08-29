<script>
    $(document).on('ready', function() {
        $("#entrar").click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "http://localhost:26/ecomerce/users/loguear",
                type: "POST",
                dataType: 'json',
                data: $("#formlogin").serialize(),
                success: function(data) {
              
                    if (data == 0) {
                        alert("Debe llenar ambos campos");
                    } else if (data == 1) {
                        alert("Usuario y/o contraseña no existen");
                    } else if (data == 2) {
                        alert("Usuario no habilitado, revise su correo");
                    } else if (data.Tipo == "admin") {
                        window.location.href = "http://localhost:26/ecomerce/admins";
                    } else if (data.Tipo == "cliente") {
                         window.location.href = "http://localhost:26/ecomerce";
                    }

                },
                error: function() {
                    alert("No se pudo loguear");
                }
            });
        });

    });
</script>
<br><br>
<hr>
<form id="formlogin">
    Username: <input type="text" id="username" name="username"><br>
    Password: <input type="password" id="password" name="password"><br>

    <button id="entrar" type="button">Entrar</button>
</form>
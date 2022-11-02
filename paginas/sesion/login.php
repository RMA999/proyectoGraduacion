<?php
session_start();

if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario']['id_rol'] > 2) {
        header("Location: /paginas/usuario/principal.php");
        return;
    } else {
        header("Location: /paginas/administrador/principal.php");
        return;
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>

    <?php
    include("headers/headerBootstrap.php");
    include("headers/headerFirebase.php");
    ?>


    <link rel="stylesheet" href="css/login.css">

</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="https://w7.pngwing.com/pngs/770/246/png-transparent-judge-lawyer-gavel-training-course-hand-logo-law-firm.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            Iniciar Sesion
        </div>
        <form class="p-3 mt-3" onsubmit="event.preventDefault(); iniciarSesion();">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="inputUsuario" id="inputUsuario" placeholder="Usuario" value="">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="inputContrasenia" id="inputContrasenia" placeholder="Contraseña" value="">
            </div>
            <button class="btn mt-3">Acceder</button>
            <!-- <p class="text-center text-muted mt-5 mb-0">No tiesnes un Usuario? <a href="/paginas/administrador/registro.php" class="fw-bold text-body"><u>Registrate</u></a></p> -->

        </form>
        <!-- <div class="text-center fs-6">
            <a href="#">Forget password?</a> or <a href="#">Sign up</a>
        </div> -->
    </div>

    <script>
        function iniciarSesion() {
            const username = document.getElementById("inputUsuario").value;
            const contrasenia = document.getElementById("inputContrasenia").value;
            const usuario = {
                username,
                contrasenia,
                funcion: 'login'
            };
            Swal.fire({
                title: 'Iniciando sesion',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });

            console.log(usuario);

            $.ajax({
                type: "POST",
                url: '/funcionesphp/sesion.php',
                data: usuario,
                success: function(response) {
                    console.log(response);
                    var pagina = "/paginas/administrador/principal.php";

                    if (response.mensaje === "Sesion iniciada") {

                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sesion iniciada',
                                showConfirmButton: false
                            });
                        }, 1200);

                        if (response.usuario.id_rol > 2) {
                            pagina = "/paginas/usuario/principal.php";
                        }
                        setTimeout(() => {
                            window.location.href = pagina;
                        }, 3000);

                    } else {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Revisar su usuario o contraseña',
                                showConfirmButton: false
                            });
                        }, 1200);
                    }


                },
                error: function(xhr, status) {
                    console.log('HUBO UN ERROR');
                    console.log(xhr, status);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el servidor',
                        showConfirmButton: false,
                        showCloseButton: true,
                    });
                }
            });

        }
    </script>

</body>

</html>
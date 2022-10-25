<?php
include '../../funcionesphp/detallesUsuario.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>

    <link rel="stylesheet" href="css/formescanear.css">

    <!-- <script src="/proyectoChalen/paginas/administrador/js/checkAuth.js"></script> -->


    <?php
    include 'headers/headerBootstrap.php';
    include 'headers/headerFirebase.php';
    include 'headers/headerNav.php';
    ?>

</head>

<body>

    <div class="container mt-2">

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        Modificar usuario
                    </div>
                    <div class="card-body">

                        <div class="row">

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpi" class="form-label">Dpi</label>
                                    <input type="text" class="form-control" id="idInputDpi" value="<?php echo $usuario['dpi'] ?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="idInputNombre" value="<?php echo $usuario['nombre'] ?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputUsuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="idInputUsuario" onkeyup="validadUsuarioExiste(this.value)" value="<?php echo $usuario['nombre_usuario'] ?>">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        Usuario ya existe
                                    </div>
                                </div>
                            </div>

                       


                        </div>


                    </div>
                </div>
            </div>




        </div>

    </div>

    <a class="float" onclick="modificarUsuario()">
        <i class="fa fa-save fa-lg my-float"></i>
        <br>
        <label>Guardar</label>
    </a>

    <script>
        var existeUsuario = false;

        function validadUsuarioExiste(value) {
            const usuarioActual = "<?php echo $usuario['nombre_usuario']; ?>";
            if (value == usuarioActual) {
                return;
            }
            $.ajax({
                type: "POST",
                url: '/funcionesphp/validadUsuarioExiste.php',
                data: {
                    nombreUsuario: value
                },
                success: function(response) {
                    if (response.estado === "ok") {
                        $("#idInputUsuario").removeClass("is-invalid");
                        existeUsuario = false;
                    }
                    if (response.estado === "error") {
                        $("#idInputUsuario").addClass("is-invalid");
                        existeUsuario = true;
                    }
                },
                error: function(xhr, status) {
                    console.log('HUBO UN ERROR');
                    console.log(xhr, status);
                }
            });
        }

      


        function modificarUsuario() {

            if (existeUsuario) {
                Swal.fire({
                    icon: 'error',
                    title: 'Verifique el Usuario',
                    showConfirmButton: false,
                    showCloseButton: true,
                });
                return;
            }

            Swal.fire({
                title: 'Guardando...',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });


            var usuario = {
                idPersona: "<?php echo $_GET['idPersona']; ?>",
                idUsuario: "<?php echo $_GET['idUsuario']; ?>",
                dpi: document.getElementById('idInputDpi').value,
                nombre: document.getElementById('idInputNombre').value,
                username: document.getElementById('idInputUsuario').value,
                funcion: "modificarUsuario"
            }

            console.log(usuario);

            $.ajax({
                        type: "POST",
                        url: '/funcionesphp/funcionesUsuario.php',
                        data: usuario,
                        success: function(response) {
                            console.log(response);

                            if (response.estado === "ok") {

                                setTimeout(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Usuarion modificado',
                                        showConfirmButton: false
                                    });
                                }, 1200);

                                setTimeout(() => {
                                    window.location.href = "/paginas/administrador/listarusuarios.php";
                                }, 3000);

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
<?php
include '../funcionesphp/listarRoles.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>

    <link rel="stylesheet" href="css/formescanear.css">

    <!-- <script src="/proyectoChalen/paginas/js/checkAuth.js"></script> -->


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
                        Crear usuario
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpi" class="form-label">Dpi</label>
                                    <input type="text" class="form-control" id="idInputDpi">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="idInputNombre">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputUsuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="idInputUsuario" onkeyup="validadUsuarioExiste(this.value)">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        Usuario ya existe
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputContrasenia" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="idInputContrasenia">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputContraseniaConfirm" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="idInputContraseniaConfirm" onkeyup="validarContrasenia(this.value)">
                                    <div id="validationServer01Feedback" class="invalid-feedback">
                                        Las contraseñas no coinciden
                                    </div>
                                    <div id="validationServer02Feedback" class="valid-feedback">
                                        Las contraseñas coinciden
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idSelectRol" class="form-label">Rol</label>
                                    <select class="form-select" id="idSelectRol" aria-label="Default select example">
                                        <option selected>Seleccione un rol</option>
                                        <?php
                                        if (count($roles) > 0) {
                                            foreach ($roles as $rol) {
                                        ?>
                                                <option value="<?php echo $rol['id'] ?>"><?php echo $rol['nombre_rol'] ?></option>

                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>

                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>




        </div>

    </div>

    <a class="float" onclick="crearUsuario()">
        <i class="fa fa-save fa-lg my-float"></i>
        <br>
        <label>Guardar</label>
    </a>

    <script>
        var existeUsuario = true;
        var contraseniaValida = false;

        function validadUsuarioExiste(value) {
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


        function validarContrasenia(value) {
            const contrasenia = document.getElementById("idInputContrasenia").value;
            if (value.length >= contrasenia.length) {
                if (contrasenia === value) {
                    contraseniaValida = true;
                    $("#idInputContraseniaConfirm").removeClass("is-invalid");
                    $("#idInputContraseniaConfirm").addClass("is-valid");

                }

                if (contrasenia !== value) {
                    contraseniaValida = false;
                    $("#idInputContraseniaConfirm").removeClass("is-valid");
                    $("#idInputContraseniaConfirm").addClass("is-invalid");
                }

            }
        }


        function crearUsuario() {

            if (existeUsuario) {
                Swal.fire({
                    icon: 'error',
                    title: 'Verifique el Usuario',
                    showConfirmButton: false,
                    showCloseButton: true,
                });
                return;
            }


            if (!contraseniaValida) {
                Swal.fire({
                    icon: 'error',
                    title: 'Verifique la contraseña',
                    showConfirmButton: false,
                    showCloseButton: true,
                });
                return;
            }


            var usuario = {
                dpi: document.getElementById('idInputDpi').value,
                nombre: document.getElementById('idInputNombre').value,
                username: document.getElementById('idInputUsuario').value,
                password: document.getElementById('idInputContrasenia').value,
                idRol: document.getElementById('idSelectRol').value,
                funcion: "crearUsuario"
            }

            console.log(usuario);

            if (isNaN(usuario.idRol) || usuario.idRol <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Seleccione un rol',
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
                                title: 'Usuarion creado',
                                showConfirmButton: false
                            });
                        }, 1200);

                        setTimeout(() => {
                            window.location.href = "/paginas/listarusuarios.php";
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
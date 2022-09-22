<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <?php
    include("headers/headerBootstrap.php");
    include("headers/headerFirebase.php");
    ?>

    <link rel="stylesheet" href="css/registro.css">
</head>

<body>
    <section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-200 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Crear Usuario</h2>

                                <form>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputNombres">Nombres</label>
                                        <input type="text" id="idInputNombres" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputApellidos">Apellidos</label>
                                        <input type="text" id="idInputApellidos" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputNombreUsuario">Nombre Usuario</label>
                                        <input type="text" id="idInputNombreUsuario" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputEmail">Email</label>
                                        <input type="email" id="idInputEmail" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputPassword">Contraseña</label>
                                        <input type="password" id="idInputPassword" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputPasswordRepeat">Repetir contraseña</label>
                                        <input type="password" id="idInputPasswordRepeat" class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="idInputRol">Seleccionar Rol</label>
                                        <select id="idInputRol" class="form-select" aria-label="Default select example">
                                            <option selected></option>
                                            <option value="Usuario">Usuario</option>
                                            <option value="Administrador">Administrador</option>
                                        </select>

                                    </div>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox" value="" id="idInputAccept" />
                                        <label class="form-check-label" for="form2Example3g">
                                            Aceptar <a href="#!" class="text-body"><u>Terminos y Servicios</u></a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="button" onclick="registrarUsuario()" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Registrar</button>
                                    </div>

                                    <p class="text-center text-muted mt-5 mb-0">Tiesnes un Usuario? <a href="/paginas/login.php" class="fw-bold text-body"><u>login</u></a></p>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        var inputNombres = document.getElementById("idInputNombres");
        var inputApellidos = document.getElementById("idInputApellidos");
        var inputNombreUsuario = document.getElementById("idInputNombreUsuario");
        var inputEmail = document.getElementById("idInputEmail");
        var inputPassword = document.getElementById("idInputPassword");
        var inputPasswordRepeat = document.getElementById("idInputPasswordRepeat");
        var inputRol = document.getElementById("idInputRol");
        var inputAccept = document.getElementById("idInputAccept");

        const app = firebase.initializeApp(firebaseConfig);


        function registrarUsuario() {
            var nuevoUsuario = {
                nombres: inputNombres.value,
                apellidos: inputApellidos.value,
                email: inputEmail.value,
                contrasenia: "",
                rol: inputRol.value,
            };

            if (inputPassword.value !== inputPasswordRepeat.value) {
                console.log("Non son guales");
                return;
            }

            if (inputAccept.checked !== true) {
                console.log(inputAccept.checked);
                console.log("NO ACEPTO LOS TERMINOS");
                return;
            }

            $.ajax({
                type: "POST",
                url: 'funcionesphp/hashpassword.php',
                data: {
                    pass: inputPassword.value
                },
                success: function(response) {
                    console.log(response);
                    nuevoUsuario.contrasenia = response;

                    app.firestore().collection("usuarios").doc(inputNombreUsuario.value).set(nuevoUsuario)
                        .then(() => {
                            console.log("Document successfully written!");
                            window.location.href = "/paginas/login.php";
                        })
                        .catch((error) => {
                            console.error("Error writing document: ", error);
                        });
                }
            });

        }
    </script>

</body>

</html>
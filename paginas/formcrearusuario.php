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
                                    <input type="password" class="form-control" id="idInputContrasenia" >
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
        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        // Initialize Cloud Storage and get a reference to the service
        const storage = app.storage();
        const inputArchivo = document.getElementById("idInputFile");
        var bytesArchivo;
        var existeUsuario = false;
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

        function fileSelected(event) {
            console.log(event.files[0].name);
            const url = window.URL.createObjectURL(event.files[0]);
            document.getElementById('idembed').src = url;
            bytesArchivo = event.files[0];
        }

        function realizarEscaneo() {
            console.log("Comienza escaneo");
            inputArchivo.value = '';
            document.getElementById("idembed").src = "";

            Swal.fire({
                title: 'Escaneando, por favor espere...',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://192.168.1.101:3000/scan", true);
            xhr.responseType = "blob";
            xhr.onload = function(e) {
                if (this.status === 200) {
                    var file = window.URL.createObjectURL(this.response);
                    document.getElementById("idembed").src = file;
                    bytesArchivo = this.response;

                    Swal.close();

                }
                console.log("Termina escaneo");
            };
            xhr.send();
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


            if (!contraseniaValida) {
                Swal.fire({
                    icon: 'error',
                    title: 'Verifique la contraseña',
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

            var documento = {
                tipoDocumento: 2,
                nombreDeclarador: document.getElementById('idInputUsuario').value,
                dpiDeclarador: document.getElementById('idInputContrasenia').value,
                fecha: document.getElementById('idInputFecha').value,
                numEscritura: document.getElementById('idInputNumEscritura').value,
                urlArchivo: ""
            }

            console.log(documento);
            const nombreArchivo = 'documento-' + Number(new Date().getTime() / 1000).toFixed(0).toString() + '.pdf';


            const storageRef = storage.ref('escaneos/declaracionesJuradas/' + nombreArchivo);
            const task = storageRef.put(bytesArchivo);
            task.on('state_changed', function progress(snapshot) {
                var percentage = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                // uploader.value = percentage;
                console.log(percentage);

            }, function error(err) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error al subir el archivo',
                    showConfirmButton: false,
                    showCloseButton: true,
                });

            }, function complete(data) {
                console.log("ARCHIVO SUBIDO");
                storageRef.getDownloadURL().then((url) => {
                    documento.urlArchivo = url;
                    console.log(documento);

                    $.ajax({
                        type: "POST",
                        url: '/funcionesphp/guardarDocumentoDeclaracionJurada.php',
                        data: documento,
                        success: function(response) {
                            console.log(response);

                            if (response.estado === "ok") {

                                setTimeout(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Documento guardado',
                                        showConfirmButton: false
                                    });
                                }, 1200);

                                setTimeout(() => {
                                    window.location.href = "/paginas/principal.php";
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


                });
            });

        }
    </script>

</body>

</html>
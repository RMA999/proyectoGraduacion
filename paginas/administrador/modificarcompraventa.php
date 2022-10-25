<?php
include '../../funcionesphp/detallesDocumento.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compraventa</title>

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
                        Datos Compraventa
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombreVendedor" class="form-label">Nombre vendedor</label>
                                    <input type="text" class="form-control" id="idInputNombreVendedor" value="<?php echo $vendedor['nombre']?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombreComprador" class="form-label">Nombre comprador</label>
                                    <input type="text" class="form-control" id="idInputNombreComprador" value="<?php echo $comprador['nombre']?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpiVendedor" class="form-label">No. DPI vendedor</label>
                                    <input type="text" class="form-control" id="idInputDpiVendedor" value="<?php echo $vendedor['dpi']?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpiComprador" class="form-label">No. DPI comprador</label>
                                    <input type="text" class="form-control" id="idInputDpiComprador" value="<?php echo $comprador['dpi']?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputFecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="idInputFecha" value="<?php echo $documento['fecha_documento']?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNumEscritura" class="form-label">No. De Escritura</label>
                                    <input type="text" class="form-control" id="idInputNumEscritura" value="<?php echo $documento['numero_escritura']?>" onkeyup="validarNumeroEscritura(this.value)">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        Numero de escritura ya existe
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>



            <div class="col-12">
                <div class="card mt-2 mb-3">
                    <div class="card-header text-center">
                        Documento
                    </div>
                    <div class="card-body">

                        <button type="button" class="btn btn-dark mb-3" onclick="realizarEscaneo()">Escanear</button>
                        <label class="btn btn-dark mb-3">
                            Seleccionar archivo
                            <input style="opacity: 0;" type="file" id="idInputFile" onchange="fileSelected(this)" accept="application/pdf" hidden>
                        </label>

                        <div class="d-flex justify-content-center">

                            <embed src="<?php echo $documento['url_archivo'] ?>" id="idembed" width="80%" height="500" type="application/pdf">


                        </div>





                    </div>
                </div>


            </div>

        </div>

    </div>

    <a class="float" onclick="guardarDocumento()">
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
        var existeNumeroEscritura = false;
        var cambioArchivo = false;



        function validarNumeroEscritura(value) {
            var numerEscrituraActual = <?php echo $documento['numero_escritura']; ?>;
            if (numerEscrituraActual == value) {
                return;
            }
            $.ajax({
                type: "POST",
                url: '/funcionesphp/validarNumeroEscritura.php',
                data: {
                    numEscritura: value,
                    validNumEscritura: 'si'
                },
                success: function(response) {
                    if (response.estado === "ok") {
                        $("#idInputNumEscritura").removeClass("is-invalid");
                        existeNumeroEscritura = false;
                    }
                    if (response.estado === "error") {
                        $("#idInputNumEscritura").addClass("is-invalid");
                        existeNumeroEscritura = true;
                    }
                },
                error: function(xhr, status) {
                    console.log('HUBO UN ERROR');
                    console.log(xhr, status);
                }
            });
        }

        function fileSelected(event) {
            cambioArchivo = true;
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


        function guardarDocumento() {

            if (existeNumeroEscritura) {
                Swal.fire({
                    icon: 'error',
                    title: 'El numero de escritura ya existe',
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
                numEscrituraAnt: <?php echo $documento['numero_escritura'] ?>,
                idTipoDocumento: 1,
                nombreVendedor: document.getElementById('idInputNombreVendedor').value,
                nombreComprador: document.getElementById('idInputNombreComprador').value,
                dpiVendedor: document.getElementById('idInputDpiVendedor').value,
                dpiComprador: document.getElementById('idInputDpiComprador').value,
                fecha: document.getElementById('idInputFecha').value,
                numEscritura: document.getElementById('idInputNumEscritura').value,
                urlArchivo: ""
            }

            if (!cambioArchivo) {
                documento.urlArchivo = "<?php echo $documento['url_archivo'] ?>";
                $.ajax({
                    type: "POST",
                    url: '/funcionesphp/modificarDocumento.php',
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
                                window.location.href = "/paginas/administrador/listardocumentos.php";
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
                return;
            }

            const nombreArchivo = 'documento-' + Number(new Date().getTime() / 1000).toFixed(0).toString() + '.pdf';
            const storageRef = storage.ref('escaneos/compraVentas/' + nombreArchivo);
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
                        url: '/funcionesphp/modificarDocumento.php',
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
                                    window.location.href = "/paginas/administrador/listardocumentos.php";
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
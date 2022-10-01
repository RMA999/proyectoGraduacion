<?php
include '../funcionesphp/detallesDocumentoHerencia.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Herencia</title>

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
                        Detalle Herencia
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombreCedente" class="form-label">Nombre cedente</label>
                                    <input type="text" class="form-control" id="idInputNombreCedente" value="<?php echo $cedente['nombre'] ?>" readonly>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpiCedente" class="form-label">No. DPI cedente</label>
                                    <input type="text" class="form-control" id="idInputDpiCedente" value="<?php echo $cedente['dpi'] ?>" readonly>
                                </div>
                            </div>


                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputFecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="idInputFecha" value="<?php echo $documento['fecha_documento'] ?>" readonly>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNumEscritura" class="form-label">No. De Escritura</label>
                                    <input type="text" class="form-control" id="idInputNumEscritura" value="<?php echo $documento['numero_escritura'] ?>" readonly>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>



            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        Cesionarios
                    </div>

                    <div class="card-body">

                        <!-- <div class="row mb-3">
                            <div class="col-3">
                                <button class="btn btn-dark" onclick="agregarCesionarios()">Agregar Cesionario</button>
                            </div>

                            <div class="col-3">
                                <button class="btn btn-dark" onclick="eliminarCesionarios()">Eliminar Cesionario</button>
                            </div>
                        </div> -->

                        <div id="idCardCesionarios">


                            <?php
                            $numeroCesionario = 1;
                            if (count($cesionarios) > 0) {
                                foreach ($cesionarios as $cesionario) {
                            ?>
                                    <div class="row">

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="mb-3">
                                                <label for="idInputNombreCesionario1" class="form-label">Nombre cesionario <?php echo $numeroCesionario ?></label>
                                                <input type="text" class="form-control" id="idInputNombreCesionario1" readonly value="<?php echo $cesionario['nombre'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="mb-3">
                                                <label for="idInputDpiCesionario1" class="form-label">No. DPI cesionario <?php echo $numeroCesionario ?></label>
                                                <input type="text" class="form-control" id="idInputDpiCesionario1" readonly value="<?php echo $cesionario['dpi'] ?>">
                                            </div>
                                        </div>


                                    </div>


                            <?php
                                    $numeroCesionario++;
                                }
                            }
                            ?>




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

                        <!-- <button type="button" class="btn btn-dark mb-3" onclick="realizarEscaneo()">Escanear</button>
                        <label class="btn btn-dark mb-3">
                            Seleccionar archivo
                            <input style="opacity: 0;" type="file" id="idInputFile" onchange="fileSelected(this)" accept="application/pdf" hidden>
                        </label> -->

                        <div class="d-flex justify-content-center">

                            <embed src="<?php echo $documento['url_archivo'] ?>" id="idembed" width="80%" height="500" type="application/pdf">


                        </div>


                    </div>
                </div>


            </div>

        </div>

    </div>

    <a href="#" class="float" onclick="history.back()">
        <i class="fa fa-arrow-left fa-lg my-float"></i>
        <br>
        <label>Regresar</label>
    </a>

    <script>
        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        // Initialize Cloud Storage and get a reference to the service
        const storage = app.storage();

        const inputArchivo = document.getElementById("idInputFile");

        var bytesArchivo;

        var cantidadCesionarios = 1;

        var cardCesionarios = document.getElementById("idCardCesionarios");

        function eliminarCesionarios() {
            if (cantidadCesionarios <= 1) {
                return;
            }
            cantidadCesionarios -= 1;
            cardCesionarios.innerHTML = "";
            for (let index = 1; index <= cantidadCesionarios; index++) {

                cardCesionarios.innerHTML = cardCesionarios.innerHTML +
                    `
            <div class="row">

<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
    <div class="mb-3">
        <label for="idInputNombreCesionario${index}" class="form-label">Nombre cesionario ${index}</label>
        <input type="text" class="form-control" id="idInputNombreCesionario${index}" placeholder="">
    </div>
</div>

<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
    <div class="mb-3">
        <label for="idInputDpiCesionario${index}" class="form-label">No. DPI cesionario ${index}</label>
        <input type="text" class="form-control" id="idInputDpiCesionario${index}" placeholder="">
    </div>
</div>

</div>  `;

            }
        }

        function agregarCesionarios() {
            cantidadCesionarios += 1;
            cardCesionarios.innerHTML = cardCesionarios.innerHTML +
                `
            <div class="row">

<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
    <div class="mb-3">
        <label for="idInputNombreCesionario${cantidadCesionarios}" class="form-label">Nombre cesionario ${cantidadCesionarios}</label>
        <input type="text" class="form-control" id="idInputNombreCesionario${cantidadCesionarios}" placeholder="">
    </div>
</div>

<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
    <div class="mb-3">
        <label for="idInputDpiCesionario${cantidadCesionarios}" class="form-label">No. DPI cesionario ${cantidadCesionarios}</label>
        <input type="text" class="form-control" id="idInputDpiCesionario${cantidadCesionarios}" placeholder="">
    </div>
</div>

</div>  `;

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


        function guardarDocumento() {

            var cesionarios = [];

            for (var index = 1; index <= cantidadCesionarios; index++) {
                cesionarios.push({
                    nombre: document.getElementById(`idInputNombreCesionario${index}`).value,
                    dpi: document.getElementById(`idInputDpiCesionario${index}`).value
                });
            }

            console.log(cesionarios);

            // Swal.fire({
            //     title: 'Guardando...',
            //     timerProgressBar: true,
            //     allowOutsideClick: false,
            //     didOpen: () => {
            //         Swal.showLoading()
            //     },
            // });

            var documento = {
                tipoDocumento: 3,
                nombreCedente: document.getElementById('idInputNombreCedente').value,
                dpiCedente: document.getElementById('idInputDpiCedente').value,
                cesionarios: cesionarios,
                fecha: document.getElementById('idInputFecha').value,
                numEscritura: document.getElementById('idInputNumEscritura').value,
                urlArchivo: ""
            }

            console.log(documento);

            $.ajax({
                type: "POST",
                url: '/funcionesphp/guardarDocumentoHerencia.php',
                data: documento,
                success: function(response) {
                    console.log(response);


                },
                error: function(xhr, status) {
                    console.log('HUBO UN ERROR');
                    console.log(xhr, status);

                }
            });


            return;
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
                        url: '/funcionesphp/guardarDocumentoDonacion.php',
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
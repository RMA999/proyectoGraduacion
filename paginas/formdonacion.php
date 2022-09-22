<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar</title>

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
                        Datos Documento
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombreVendedor" class="form-label">Nombre donante</label>
                                    <input type="text" class="form-control" id="idInputNombreVendedor" placeholder="">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNombreComprador" class="form-label">Nombre donatario</label>
                                    <input type="text" class="form-control" id="idInputNombreComprador" placeholder="">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpiVendedor" class="form-label">No. DPI donante</label>
                                    <input type="text" class="form-control" id="idInputDpiVendedor" placeholder="">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputDpiComprador" class="form-label">No. DPI donatario</label>
                                    <input type="text" class="form-control" id="idInputDpiComprador" placeholder="">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputFecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="idInputFecha" placeholder="">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="idInputNumEscritura" class="form-label">No. De Escritura</label>
                                    <input type="text" class="form-control" id="idInputNumEscritura" placeholder="">
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

                        <div class="row d-flex justify-content-center">

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="mb-3">
                                    <label for="idInputFile" class="form-label">Documento Escaneado</label>
                                    <input class="form-control" type="file" id="idInputFile" onchange="fileSelected(this)" accept="application/pdf">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">

                                <embed src="" id="idembed" width="100%" height="500" type="application/pdf">

                            </div>

                        </div>


                    </div>
                </div>


            </div>

        </div>

    </div>

    <a href="#" class="float" onclick="guardarDocumento()">
        <i class="fa fa-save fa-lg my-float"></i>
        <br>
        <label>Subir</label>
    </a>

    <script>
        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        // Initialize Cloud Storage and get a reference to the service
        const storage = app.storage();

        const inputArchivo = document.getElementById("idInputFile");


        function fileSelected(event) {
            console.log(event.files[0].name);
            const url = window.URL.createObjectURL(event.files[0]);
            document.getElementById('idembed').src = url;
        }


        function guardarDocumento() {

            Swal.fire({
                title: 'Guardando...',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });

            var documento = {
                tipoDocumento: document.getElementById('idInputTipoDoc').value,
                nombreVendedor: document.getElementById('idInputNombreVendedor').value,
                nombreComprador: document.getElementById('idInputNombreComprador').value,
                dpiVendedor: document.getElementById('idInputDpiVendedor').value,
                dpiComprador: document.getElementById('idInputDpiComprador').value,
                fecha: document.getElementById('idInputFecha').value,
                numEscritura: document.getElementById('idInputNumEscritura').value,
                urlArchivo: ""
            }

            // const inputArchivo = document.getElementById("idInputFile");
            const archivo = inputArchivo.files[0];

            const nombreArchivo = archivo.name.split('.')[0] + '-' + Number(new Date().getTime() / 1000).toFixed(0).toString() + '.' + archivo.name.split('.')[1];


            const storageRef = storage.ref('escaneos/' + nombreArchivo);
            const task = storageRef.put(archivo);
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
                        url: 'funcionesphp/guardardocumento.php',
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
                                    window.location.href = "/paginas/listardocumentos.php";
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla documentos</title>

    <?php
    include 'headers/headerBootstrap.php';
    include 'headers/headerNav.php';
    ?>




</head>

<body>

    <div class="container mt-2">

        <table id="idTabladocumentos" class="table table-striped" width="100%"></table>

    </div>


    <script>
        $(document).ready(function() {
            var tabla = $('#idTabladocumentos').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '/funcionesphp/listarDocumentos.php'
                },
                'columns': [{
                        title: '#',
                        "defaultContent": ""
                    },
                    {
                        title: 'No. Escritura',
                        data: 'numero_escritura'
                    },
                    {
                        title: 'Tipo Documento',
                        data: 'tipo_documento'
                    },

                    {
                        title: 'Fecha',
                        data: 'fecha_documento'
                    },

                    {
                        title: "Acciones",
                        data: 'url_archivo',
                        "render": function(data, type, full) {
                            return '<div class="btn-group">' +
                                '<button type="button" id="idAccionMostrarPdf" class="btn btn-outline-secondary" > <i class="fa-solid fa-eye" data-toggle="tooltip" data-placement="top" title="Ver documento"></i> Solicitar Visualización </button>' +
                                // '<button type="button" id="idAccionModificar" class="btn btn-outline-secondary" > <i class="fa-solid fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="Modificar"></i> </button>' +
                                // '<button type="button" id="idAccionDetalles" class="btn btn-outline-secondary" > <i class="fa-solid fa-info-circle" data-toggle="tooltip" data-placement="top" title="Detalles"></i> </button>' +
                                // '<button type="button" id="idAccionEliminar" class="btn btn-outline-secondary" > <i class="fa-solid fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i> </button>' +
                                '</div>'
                        },
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                // columnDefs: [
                //     {
                //         target: 0,
                //         visible: false,
                //         searchable: false,
                //     }
                // ],

                order: [
                    [1, 'asc']
                ],
            });

            tabla.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            tabla.on('order.dt search.dt draw', function() {
                let i = 1;

                tabla.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });

            }).draw();


            $('#idTabladocumentos tbody').on('click', '#idAccionMostrarPdf', function() {
                var data = tabla.row($(this).parents('tr')).data();
                const peticion = {
                    id_documento: data.id_documento,
                    id_usuario: <?php echo $_SESSION['usuario']['id_usuario']; ?>,
                    funcion: 'crear'
                };

                Swal.fire({
                    title: '¿Estas seguro?',
                    text: `Solicitar visualización del documento con numero de escritura ${data['numero_escritura']}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'Solicitando...',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        $.ajax({
                            type: "POST",
                            url: '/funcionesphp/peticiones.php',
                            data: peticion,
                            success: function(response) {
                                console.log(response);

                                if (response.estado === "ok") {

                                    setTimeout(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Petición enviada',
                                            showConfirmButton: false
                                        });
                                    }, 1200);


                                }

                                if (response.mensaje === "existe") {
                                    setTimeout(() => {
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Este documento ya fue solicitado',
                                            showConfirmButton: false,
                                            showCloseButton: true,
                                        });
                                    }, 1200);
                                    return;
                                }

                                if (response.estado === "error") {
                                    setTimeout(() => {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error al intentar crear la peticion',
                                            showConfirmButton: false,
                                            showCloseButton: true,
                                        });
                                    }, 1200);
                                    return;
                                }


                            },
                            error: function(xhr, status) {
                                console.log('HUBO UN ERROR');
                                console.log(xhr, status);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error al intentar crear la peticion',
                                    showConfirmButton: false,
                                    showCloseButton: true,
                                });
                            }
                        });


                    }
                });


                // var xhr = new XMLHttpRequest();
                // xhr.open("GET", data['url_archivo'], true);
                // xhr.responseType = "blob";
                // xhr.onload = function(e) {
                //     if (this.status === 200) {
                //         var url = window.URL.createObjectURL(this.response);
                //         window.open(url, '_blank').focus();
                //     }
                // };
                // xhr.send();
            });


            $('#idTabladocumentos tbody').on('click', '#idAccionEliminar', function() {
                var data = tabla.row($(this).parents('tr')).data();
                console.log(data);

                // if (data['tipo_documento'] !== "Declaración jurada" && data['tipo_documento'] !== "Compraventa" && 
                // data['tipo_documento'] !== "Donacion Entre Vivos" && data['tipo_documento'] !== "Cesion de Derechos Hereditarios") {
                //     Swal.fire({
                //         icon: 'info',
                //         title: 'Atencion',
                //         text: 'Aun no se puede eliminar este tipo de documento'
                //     })
                //     return;
                // }

                Swal.fire({
                    title: '¿Estas seguro?',
                    text: `Eliminar el documento con numero de escritura ${data['numero_escritura']}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Borrarlo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'Eliminando...',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        $.ajax({
                            type: "POST",
                            url: '/funcionesphp/eliminarDocumento.php',
                            data: data,
                            success: function(response) {
                                console.log(response);

                                if (response.estado === "ok") {

                                    setTimeout(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Documento eliminado',
                                            showConfirmButton: false
                                        });
                                        tabla.ajax.reload();
                                    }, 1200);


                                }


                            },
                            error: function(xhr, status) {
                                console.log('HUBO UN ERROR');
                                console.log(xhr, status);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error al intentar eliminar el documento',
                                    showConfirmButton: false,
                                    showCloseButton: true,
                                });
                            }
                        });


                    }
                });

            });


        });
    </script>

</body>

</html>
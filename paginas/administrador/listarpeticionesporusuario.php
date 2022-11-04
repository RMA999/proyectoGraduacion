<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peticiones</title>

    <?php
    include 'headers/headerBootstrap.php';
    include 'headers/headerNav.php';
    ?>




</head>

<body>

    <div class="container mt-2">

        <?php if (isset($_GET['nombreUsuario'])) : ?>
            <h2>Peticiones del usuario: <?php echo $_GET['nombreUsuario']; ?></h2>
        <?php else : ?>
            <h2>Mostrando todas las peticiones</h2>
        <?php endif; ?>

        <table id="idTabladocumentos" class="table table-striped" width="100%"></table>

    </div>


    <script>
        $(document).ready(function() {
            var tabla = $('#idTabladocumentos').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '/funcionesphp/listarPeticionesAdminPorUsuario.php',
                    'data': {
                        id_usuario: <?php echo $_GET['idUsuario']; ?>
                    },
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
                        title: 'Estado',
                        data: 'estado'
                    },

                    {
                        title: "Acciones",
                        data: 'url_archivo',
                        "render": function(data, type, full) {
                            return '<div class="btn-group">' +
                                '<button type="button" id="idAccionAprobar" class="btn btn-outline-success" > <i class="fa-solid fa-check" data-toggle="tooltip" data-placement="top" title="Aprovar"></i> </button>' +
                                '<button type="button" id="idAccionRechazar" class="btn btn-outline-danger" > <i class="fa-solid fa-x" data-toggle="tooltip" data-placement="top" title="Rechazar"></i> </button>' +
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

            function modificarPeticion(idPeticion, estado) {
                const peticion = {
                    id_peticion: idPeticion,
                    estado,
                    funcion: 'aprobarRechazar'
                };
                var mensaje = {
                    pregunta: '',
                    respuesta: ''
                };
                if (estado == 'Aprobada') {
                    mensaje.pregunta = 'Esta seguro de aprobar esta petición';
                    mensaje.respuesta = 'Petición Aprobada';
                }
                if (estado == 'Rechazada') {
                    mensaje.pregunta = 'Esta seguro de rechazar esta petición';
                    mensaje.respuesta = 'Petición Rechazada';

                }
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: mensaje.pregunta,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'Procesando...',
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
                                            title: mensaje.respuesta,
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
                                    title: 'Error al intentar modificar la petición',
                                    showConfirmButton: false,
                                    showCloseButton: true,
                                });
                            }
                        });


                    }
                });
            }


            $('#idTabladocumentos tbody').on('click', '#idAccionAprobar', function() {
                var data = tabla.row($(this).parents('tr')).data();
                modificarPeticion(data.id_peticion, 'Aprobada');
            });

            $('#idTabladocumentos tbody').on('click', '#idAccionRechazar', function() {
                var data = tabla.row($(this).parents('tr')).data();
                modificarPeticion(data.id_peticion, 'Rechazada');
            });


        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de usuarios</title>

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
                    'url': '/funcionesphp/listarUsuarios.php'
                },
                'columns': [{
                        title: '#',
                        "defaultContent": ""
                    },
                    {
                        title: 'Dpi',
                        data: 'dpi'
                    },
                    {
                        title: 'Nombre',
                        data: 'nombre'
                    },
                    {
                        title: 'Usuario',
                        data: 'nombre_usuario'
                    },

                    {
                        title: 'Rol',
                        data: 'nombre_rol'
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
                                '<button type="button" id="idAccionModificar" class="btn btn-outline-secondary" > <i class="fa-solid fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="Modificar"></i> </button>' +
                                '<button type="button" id="idAccionEliminar" class="btn btn-outline-secondary" > <i class="fa-solid fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i> </button>' +
                                '<button type="button" id="idAccionMostrarPeticiones" class="btn btn-outline-secondary" > <i class="fa-solid fa-list" data-toggle="tooltip" data-placement="top" title="Mostrar Peticiones"></i> </button>' +
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

            $('#idTabladocumentos tbody').on('click', '#idAccionMostrarPeticiones', function() {
                var data = tabla.row($(this).parents('tr')).data();
                console.log(data);

                Swal.fire({
                    icon: 'info',
                    title: 'Funcion no disponible',
                    showConfirmButton: false
                });

            });

            $('#idTabladocumentos tbody').on('click', '#idAccionModificar', function() {
                var data = tabla.row($(this).parents('tr')).data();
                console.log(data);
                window.location.href = `/paginas/administrador/modificarusuario.php?idUsuario=${data['id_usuario']}&&idPersona=${data['id_persona']}`;
            });

            $('#idTabladocumentos tbody').on('click', '#idAccionEliminar', function() {
                var data = tabla.row($(this).parents('tr')).data();
                console.log(data);

                if (data['nombre_rol'] == "Super Administrador") {
                    Swal.fire({
                        icon: 'error',
                        title: 'No es permitido eliminar usuario Super Administrador',
                        showConfirmButton: false,
                        showCloseButton: true,
                    });
                    return;
                }

                const usuarioAEliminar = {
                    idUsuario: data['id_usuario'],
                    idPersona: data['id_persona'],
                    funcion: 'eliminarUsuario'
                };

                Swal.fire({
                    title: '¿Estas seguro?',
                    text: `Eliminar el Usuario: ${data['nombre_usuario']}`,
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
                            url: '/funcionesphp/funcionesUsuario.php',
                            data: usuarioAEliminar,
                            success: function(response) {
                                console.log(response);

                                if (response.estado === "ok") {

                                    setTimeout(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Usuario eliminado',
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
                                    title: 'Error al intentar eliminar el usuario',
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
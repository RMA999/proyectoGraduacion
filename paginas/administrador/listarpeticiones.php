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
                    'url': '/funcionesphp/listarPeticionesAdmin.php',
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
                                '<button type="button" id="idAccionMostrarPdf" class="btn btn-outline-success" > <i class="fa-solid fa-check" data-toggle="tooltip" data-placement="top" title="Aprovar"></i> </button>' +
                                '<button type="button" id="idAccionMostrarPdf" class="btn btn-outline-danger" > <i class="fa-solid fa-x" data-toggle="tooltip" data-placement="top" title="Rechazar"></i> </button>' +
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


                if (data.estado == "pendiente") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Esta peticion aun esta pendiente',
                        showConfirmButton: false,
                        showCloseButton: true,
                    });
                    return;
                }


                if (data.estado == "aprobada") {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", data['url_archivo'], true);
                    xhr.responseType = "blob";
                    xhr.onload = function(e) {
                        if (this.status === 200) {
                            var url = window.URL.createObjectURL(this.response);
                            window.open(url, '_blank').focus();
                        }
                    };
                    xhr.send();
                    return;
                }


            });


        });
    </script>

</body>

</html>
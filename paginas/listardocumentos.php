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
                                '<button type="button" id="idAccion1" class="btn btn-outline-secondary" > <i class="fa-solid fa-eye" data-toggle="tooltip" data-placement="top" title="Ver documento"></i> </button>' +
                                '<button type="button" id="idAccion2" class="btn btn-outline-secondary" > <i class="fa-solid fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="Modificar"></i> </button>' +
                                '<button type="button" id="idAccion3" class="btn btn-outline-secondary" > <i class="fa-solid fa-info-circle" data-toggle="tooltip" data-placement="top" title="Detalles"></i> </button>' +
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


            $('#idTabladocumentos tbody').on('click', '#idAccion1', function() {
                var data = tabla.row($(this).parents('tr')).data();
                // window.open(data['url_archivo'], '_blank').focus();

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
            });

            $('#idTabladocumentos tbody').on('click', '#idAccion2', function() {
                console.log("accion2");
                var data = tabla.row($(this).parents('tr')).data();
                console.log(data);
            });

            $('#idTabladocumentos tbody').on('click', '#idAccion3', function() {
                var data = tabla.row($(this).parents('tr')).data();
                console.log(data);

                if (data['tipo_documento'] === "Cesion de Derechos Hereditarios") {
                    window.location.href = `/paginas/detallesherencia.php?id_documento=${data['id_documento']}`;
                }

            });


        });

        function abrirArchivoEnOtraPestania(e) {
            console.log(e);
            // var url = e;
            // var w1 = window.open(url, '_blank').focus();
        }

        function enviarRegistroAModificar() {
            setTimeout(() => {
                console.log(filaTabla);
            }, 200);
            // setTimeout(() => {
            //     console.log(filaTabla);
            //     window.open(url, '_blank').focus();s
            // }, 150);
        }


        // setTimeout(() => {
        //     console.log(dataSet);
        //     dataSet = [];
        //     dataSet.push(['Unity Butler', 'Marketing Designer', 'San Francisco', '5384', '2009/12/09', '$85,675']);
        //     console.log(dataSet );
        //     tabla.clear().rows.add(dataSet).draw();

        // }, 3000);

        // Swal.fire({
        //   title: 'Auto close alert!',
        //   timerProgressBar: true,
        // //   allowOutsideClick: false,
        //   didOpen: () => {
        //     Swal.showLoading()
        //   },
        // });
    </script>

</body>

</html>
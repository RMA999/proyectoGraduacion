<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>


    <?php
    include "headers/headerBootstrap.php";
    include "headers/headerChartJS.php";
    include "headers/headerNav.php";
    ?>

</head>

<body>

    <div class="container">
        <h1>Bienvenido <?php echo $_SESSION['usuario']['nombre']; ?></h1>

        <div class="row">

            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                <div class="card text-center">
                    <div class="card-header">
                        Peticiones
                    </div>
                    <div class="card-body">
                        <canvas id="graficaPeticiones" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                <div class="card text-center">
                    <div class="card-header">
                        Documentos Escaneados
                    </div>
                    <div class="card-body">
                        <canvas id="graficaDocumentos" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>



        </div>


    </div>


    <script>
        const ctxPeticiones = document.getElementById('graficaPeticiones');
        const ctxDocumentos = document.getElementById('graficaDocumentos');

        function getRandomIntInclusive(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        var dataPeticiones = {
            datasets: [{
                label: 'My First Dataset',
                data: [0, 0, 0],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }],
            labels: [
                'Aprobadas',
                'Rechazadas',
                'Pendientes'
            ]
        };


        var dataDocumentos = {
            labels: ['Compraventa', 'Declaración Jurada', 'Cesión de Derechos Hereditarios', 'Donación Entre Vivos'],
            datasets: [{
                label: 'Documentos',
                data: [65, 59, 80, 20],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(153, 102, 255)',
                    'rgb(75, 192, 192)'
                ],
                borderWidth: 1
            }]
        };

        const configPeticiones = {
            type: 'pie',
            data: dataPeticiones,
        };

        const configDocumentos = {
            type: 'bar',
            data: dataDocumentos,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };


        const graficaPeticiones = new Chart(ctxPeticiones, configPeticiones);
        const graficaDocumentos = new Chart(ctxDocumentos, configDocumentos);


        // setInterval(() => {

        //     var newData = [
        //         getRandomIntInclusive(1, 100),
        //         getRandomIntInclusive(1, 100),
        //         getRandomIntInclusive(1, 100)
        //     ];

        //     // console.log(newData);
        //     graficaPeticiones.data.datasets[0].data = newData;
        //     graficaPeticiones.update();

        // }, 3000);


        function getPeticiones() {
            $.ajax({
                type: "POST",
                url: '/funcionesphp/datosGraficas.php',
                success: function(response) {
                    const newDataPeticiones = [
                        response.peticiones.aprobadas,
                        response.peticiones.rechazadas,
                        response.peticiones.pendientes
                    ];
                    const newDataDocumentos = [
                        response.documentos.compraventa,
                        response.documentos.declaracion,
                        response.documentos.herencia,
                        response.documentos.donacion,
                    ];
                    graficaPeticiones.data.datasets[0].data = newDataPeticiones;
                    graficaDocumentos.data.datasets[0].data = newDataDocumentos;
                    graficaPeticiones.update();
                    graficaDocumentos.update();
                },
                error: function(xhr, status) {
                    console.log('HUBO UN ERROR');
                    console.log(xhr, status);
                }
            });
        }

        getPeticiones();

        setInterval(getPeticiones, 2000);
    </script>

</body>

</html>
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

            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="card text-center">
                    <div class="card-header">
                        Peticiones
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

        </div>


    </div>


    <script>
        const ctx = document.getElementById('myChart');

        var data = {
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
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

        const config = {
            type: 'pie',
            data: data,
        };

        const myChart = new Chart(ctx, config);
    </script>

</body>

</html>
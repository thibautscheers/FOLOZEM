<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphic</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
</head>

<body>
    <?php
    require_once("Modele.php");

    ?>
    <div><canvas id="graph1"></canvas></div>

</body>

</html>


<script>
    let ctx = document.getElementById('graph1').getContext('2d')

    let data = {
        labels: ["Pending", "InProgress", "OnHold", "Complete", "Cancelled"],
        datasets: [{
            data: [21, 39, 10, 14, 16],
            backgroundColor: [
                "#FF6384",
                "#4BC0C0",
                "#FFCE56",
                "#E7E9ED",
                "#36A2EB"
            ],
            hoverOffset: 4,
            borderColor:['#2338'],
            circumference:[180],
            rotation:[270],
            
        }]
    }
    let options = {
        responsive: false,
    }
    let config = {
        type: 'pie',
        data: data,
        options: options
    }
    
    let graph1 = new Chart(ctx, config)
</script>
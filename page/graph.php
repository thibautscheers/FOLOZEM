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

    <body style=" background-color: beige;">
        <?php
        require_once("Modele.php");
        //graph1
        $nbrPremiereAnnee = $_POST['nbrPremiereAnnee'];
        $nbrSecondAnnee = $_POST['nbrSecondAnnee'];

        //Graph 2
        $SLAM = $_POST['SLAM'];
        $SISR = $_POST['SISR'];
        $sansOption = $_POST['sansOption'];
        ?>
        <div><canvas id="graph1"></canvas></div>
        <div><canvas id="graph2"></canvas></div>

    </body>

</html>

<script>

    //Graph 1
    let ctx1 = document.getElementById('graph1').getContext('2d')
    let nbrPremiereAnnee = <?php echo($nbrPremiereAnnee) ?>;
    let nbrSecondAnnee = <?php echo($nbrSecondAnnee) ?>;
    let labels1 = ["Première années", "Seconde années"]
    let data1 = {
        labels: labels1,
        datasets: [{
            data: [nbrPremiereAnnee, nbrSecondAnnee],
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
    let options1 = {
        responsive: false,
    }
    let config1 = {
        type: 'pie',
        data: data1,
        options: options1
    }
    
    let graph1 = new Chart(ctx1, config1)


    //Graph 2
    let ctx2 = document.getElementById('graph2').getContext('2d')
    let SLAM = <?php echo($SLAM) ?>;
    let SISR = <?php echo($SISR) ?>;
    let sansOption = <?php echo($sansOption) ?>;
    let labels2 = ["SLAM", "SISR", "Sans options"]
    let data2 = {
        labels: labels2,
        datasets: [{
            data: [SLAM, SISR, sansOption],
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
    let options2 = {
        responsive: false,
    }
    let config2 = {
        type: 'pie',
        data: data2,
        options: options2
    }
    
    let graph2 = new Chart(ctx2, config2)
</script>
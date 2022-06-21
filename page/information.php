<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="style/navbar.css">


</head>

<body>
    <div>
        <ul>
            <li><a href="liste-eleve.php">Liste des Elève</a></li>
            <li><a href="importation-eleve.php">Importation des Elèves</a></li>
            <li><a href="statistiques.php">Statistiques</a></li>
            <li><a href="#">Information du site</a></li>
            <li><a id="deco" onclick="deco()">Déconnecxion</a></li>
        </ul>
    </div>
    <?php 
    require_once("modele.php");
    session_start();

    if (isset($_SESSION["error"]) && ($_SESSION["error"] != ""))
        echo ("<br/><div style=\"background-color: #f44; padding: 6px;\">" . ($_SESSION["error"]) . "</div>");
    $_SESSION["error"] = "";

    if (isset($_SESSION["info"]) && ($_SESSION["info"] != ""))
        echo ("<br/><div style=\"background-color: #4f4; padding: 6px;\">" . ($_SESSION["info"]) . "</div>");
    $_SESSION["info"] = "";
    ?>
    <h1>Information </h1>
    <div id="expoitCSV">
        <h3>Exploitation des fichier CSV</h3>
    </div>
    <div id="créateur">
        <p>Site créer leur du stage de 1er année des SIO de la promation 2021-2023 par Allan ESCOLANO & Thibaut SCHEERS.
        </p>

    </div>
    <form  method="POST" action="modifacces.php">
        <div id="access">
            <h3>
                Modifier la clè d'accès

                <input type="password" name="cleacces">
                <input type="submit" value="Modifier">
            </h3>
        </div>
    </form>

    <div id="RGPD">
        <h3>RGPD</h3>
        <p>Pour réspecté la loi sur la protection des données il faudrait gradé les données minimun pendant 3 ans maximun pandant 5 ans.</p>
    </div>



</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
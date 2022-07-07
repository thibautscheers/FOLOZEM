<!-- Cette page est dédié au info principal du site créées par Thibaut Scheers -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="style/navbar.css" type="text/css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="body">

    <div>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link"  href="liste-eleve.php">Liste des Etudiants</a></li>
                <li class="nav-item active"><a class="nav-link" href="importation-eleve.php">Importation des Elèves</a></li>
                <li class="nav-item active"><a class="nav-link" href="statistiques.php">Statistiques</a></li>
                <li class="nav-item active"><a class="navbar-brand" href="#">Information du site</a></li>
                <li class="nav-item active"><a class="nav-link" id="deco" onclick="deco()">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <?php 
    require_once("Modele.php");
    session_start();

    if (isset($_SESSION["error"]) && ($_SESSION["error"] != ""))
        echo ("<br/><div style=\"background-color: #f44; padding: 6px;\">" . ($_SESSION["error"]) . "</div>");
    $_SESSION["error"] = "";

    if (isset($_SESSION["info"]) && ($_SESSION["info"] != ""))
        echo ("<br/><div style=\"background-color: #4f4; padding: 6px;\">" . ($_SESSION["info"]) . "</div>");
    $_SESSION["info"] = "";
    ?>
    <h1 class="text-decoration-underline text-center  h3" > Information </h1>
    <div id="expoitCSV">
        <h3 class="text-decoration-underline">Importation des fichier CSV</h3>
        <p> Pour importer un fichier CSV, il faut d'abord le prendre de parcoursup puis l'importer sur le site à partir de la page Importation, puis le site fait le reste pour vous.</p>
    </div>
    <!-- <div id="créateur">
    <h3 class="text-decoration-underline">Créateur du site</h3>
        <p >Site créer pendant stage de 1ère année de SIO de la promotion 2021-2023 par Allan ESCOLANO & Thibaut SCHEERS.
        </p>

    </div> -->
    <form  method="POST" action="modifacces.php">
        <div id="access">
            <h3 class="text-decoration-underline">
                Modifier la clè d'accès
            </h3> <input type="password" class="input-group-sm" name="cleacces">
                <input type="submit" class="btn btn-outline-primary btn-sm" value="Modifier">
        </div>
    </form>

    <footer>
    <h6>Créateur du site:</h6>
        <p class="text-sm" >Site créé pendant stage de 1ʳᵉ année de SIO de la promotion 2021-2023 par Allan ESCOLANO & Thibaut SCHEERS. 
        </p>&nbsp;
        <h6>RGPD:</h6>
        <p class="fz-sm-6">Pour respecter la loi sur la protection des données, il faudrait garder les données minimum pendant 3 ans, maximum pendant 5 ans. Si vous rencontrez un problème, veuillez nous contacter sur notre adresse électronique :
             <a href='mailto: folozem@proton.me'>folozem@proton.me<a></p>
    </footer>



</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
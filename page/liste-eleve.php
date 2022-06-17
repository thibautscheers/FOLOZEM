<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Elèves</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link rel="stylesheet" href="style/navbar.css">
    </head>
        <div>
            <ul>
                <li><a href="#">Liste des Elève</a></li>
                <li><a href="importation-eleve.php">Importation des Elèves</a></li>
                <li><a href="statistiques.php">Statistiques</a></li>
                <li><a href="information.php">Information du site</a></li>
                <li><a id="deco" onclick="deco()">Déconnection</a></li>
            </ul>
        </div>
    <body>

        <h3>Liste des élève </h3>
        <?php

            require_once("Modele.php");
            $Etudiants = getEtudiants();
            foreach ($Etudiants as $Etudiant) {
                echo($Etudiant["nom"]);
            }

        ?>
    </body>
    <script type="text/javascript" src="js/script.js"></script>
</html>
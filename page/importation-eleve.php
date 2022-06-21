<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importation des élèves</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="style/navbar.css">

</head>

<body>
    <div>
        <ul>
            <li><a href="liste-eleve.php">Liste des Elève</a></li>
            <li><a href="#">Importation des Elèves</a></li>
            <li><a href="statistiques.php">Statistiques</a></li>
            <li><a href="information.php">Information du site</a></li>
            <li><a id="deco" onclick="deco()">Déconnexion</a></li>
        </ul>
        <?php
        require_once("modele.php");
        session_start();

        if (isset($_SESSION["error"]) && ($_SESSION["error"] != ""))
            echo ("<br/><div style=\"background-color: #f44; padding: 6px;\">" . ($_SESSION["error"]) . "</div>");
        $_SESSION["error"] = "";

        if (isset($_SESSION["info"]) && ($_SESSION["info"] != ""))
            echo ("<br/><div style=\"background-color: #4f4; padding: 6px;\">" . ($_SESSION["info"]) . "</div>");
        $_SESSION["info"] = ""; ?>
    </div>
    <h3>Importation des élève </h3>

    <form action="importEleves.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file" accept=".csv">
        <input type="submit" value="Importer" name="submit">
    </form>























    <h3>Ajout Elèves</h3>


    <form action="ajoutEleve.php" method="POST">
        N°Etudiant : <input type="number" name="noEtudiant">
        Nom : <input type="text" name="nom">
        Prenom : <input type="text" name="prenom">

        <select name='anneeSIO'>
            <option value='1'>SIO 1</option>
            <option value='0'>SIO 2</option>
        </select>
        <select name='optionBTS'>
            <option value='1'>SLAM</option>
            <option value='0'>SISR</option>
        </select>
        Année d'arrivé : <input type="number" name="anneeArrivee">
        Département : <input type="number" name="departement">
        <select name='alternance'>
            <option value='1'>fait une alternance</option>
            <option value='0'>ne fait pas d'alternance</option>
        </select>
        Option D'origine :
        <select name="idOption">
            <?php

            $optionsB = lireOption();

            foreach ($optionsB as $optionB) {
                $idOption = $optionB['idOption'];
                $nomOption  = $optionB['nomOption'];
                echo ("<option value='$idOption'>$nomOption</option>");
            }
            ?>
        </select>
        <input type="submit" value="Ajouter">
    </form>


    <h3>Ajout d'origine</h3>
    <form action="ajoutOrigine.php" method="POST">
        Nom de l'origine : <input type="text" name="nomOrigine">
        <input type="submit" value="ajouter">
    </form>

    <h3>Ajout d'option</h3>
    <form action="ajoutOption.php" method="POST">
        Nom de l'option : <input type="text" name="nomOption">
        <select name="idOrigine">
            <?php

            $origines = lireOrigine();

            foreach ($origines as $origine) {
                $idOrigine = $origine['idOrigine'];
                $nomOrigine  = $origine['nomOrigine'];
                echo ("<option value='$idOrigine'>$nomOrigine</option>");
            }
            ?>
        <input type="submit" value="ajouter">
    </form>

</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
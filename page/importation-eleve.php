<!-- Cette page est dédié à l'ajout des élèves, d'origine et d'option créées par Thibaut Scheers & Allan Escolano -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importation des élèves</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="style/navbar.css" type="text/css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>


</head>

<body class="body">
    <div>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="liste-eleve.php">Liste des Etudiants</a></li>
                <li class="nav-item active"><a class="navbar-brand" href="#">Importation des Elèves</a></li>
                <li class="nav-item active"><a class="nav-link" href="statistiques.php">Statistiques</a></li>
                <li class="nav-item active"><a class="nav-link" href="information.php">Information du site</a></li>
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
    $_SESSION["info"] = ""; ?>
    </div>
    <h3 class="h3">Importation des élèves </h3>
    <div class="col-auto">
        <form action="importEleves.php" method="post" class="form-inline" enctype="multipart/form-data">
            <input type="file" class="btn btn-outline-secondary btn-sm" name="file" id="file" accept=".csv">
            <input type="submit" class="btn btn-outline-primary btn-sm" value="Importer" name="submit">
        </form>
        <br>
        <form method="get" action="Modele_CSV.csv">
            <button type="submit" class="btn btn-success btn-sm">Télécharger un modèle de fichier CSV</button>
        </form>
    </div>
    <br> </br>
    <h3>Ajout étudiants</h3>

    <div class="col-auto">
        <form action="ajoutEleve.php" class="form-inline" method="POST">
            <label for="etud"> Id Etudiant:</label> <input id="etud" type="number" class="input-group-sm" name="noEtudiant"><br>
            <label for="nom"> Nom:</label> <input id="nom" type="text" class="input-group-sm" name="nom"><br>
            <label for="prenom"> Prenom:</label><input id="prenom" type="text" class="input-group-sm" name="prenom"><br>
            <label for="sexes">Sexe : </label>
            <select id="sexes" name="sexe" class="form-select-sm">
                <option value="1">Masculin</option>
                <option value="0">Féminin</option>
            </select><br>
            <label for="classe"> Classe : </label>
            <select id="classe" name='anneeSIO' class="form-select-sm">
                <option value='1'>SIO 1</option>
                <option value='0'>SIO 2</option>
            </select><br>
            <label for="spé">Spécialité du BTS:</label>
            <select id="spe" name='optionBTS' class="form-select-sm">
                <option value="NULL"></option>
                <option value='1'>SLAM</option>
                <option value='0'>SISR</option>
            </select><br>
            <label for="annee">Année d'arrivé :</label> <input id="annee" type="number" class="input-group-sm" name="anneeArrivee"><br>
            <label for="dep"> Département:</label> <input id="dep" type="number" class="input-group-sm" name="departement"><br>
            <label for="alter">alternance:</label>
            <select id="alter" name='alternance' class="form-select-sm">
                <option value='1'>fait une alternance</option>
                <option value='0'>ne fait pas d'alternance</option>
            </select><br>
            <label for="op">Option D'origine :</label>
            <select id="op" name="idOption" class="form-select-sm">
                <?php

                $optionsB = lireOption();

                foreach ($optionsB as $optionB) {
                    $idOption = $optionB['idOption'];
                    $nomOption  = $optionB['nomOption'];
                    echo ("<option value='$idOption'>$nomOption</option>");
                }
                ?>
            </select><br>
            <input type="submit" class="btn btn-outline-primary btn-sm" value="Ajouter">
        </form>
    </div>
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    <br> </br>
    <div class="col-auto">
        <h3>Ajout d'origine</h3>
        <form action="ajoutOrigine.php" class="form-inline" method="POST">
            Nom de l'origine : <input type="text" name="nomOrigine">
            <input type="submit" class="btn btn-outline-primary btn-sm" value="ajouter">
        </form>
    </div>
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    <br> </br>
    <div class="col-auto">
        <h3>Ajout d'option</h3>
        <form action="ajoutOption.php" class="form-inline" method="POST">
            Nom de l'option : <input type="text" name="nomOption">
            <select name="idOrigine" class="form-select-sm">
                <?php

                $origines = lireOrigine();

                foreach ($origines as $origine) {
                    $idOrigine = $origine['idOrigine'];
                    $nomOrigine  = $origine['nomOrigine'];
                    echo ("<option value='$idOrigine'>$nomOrigine</option>");
                }
                ?>
                <input type="submit" class="btn btn-outline-primary btn-sm" value="ajouter">
        </form>
    </div>
</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
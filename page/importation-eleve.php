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
            <li><a id="deco" onclick="deco()">Déconnecxion</a></li>
        </ul>
    </div>
    <h3>Importation des élève </h3>

    <h4>Importation d'un fichier csv<h4>   

    <form action="Importer.php" method="post" enctype="multipart/form-data">
       <input type="file" name="file" id="file" accept=".csv">
       <input type="submit" value="Importer" name="submit">
    </form>


</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
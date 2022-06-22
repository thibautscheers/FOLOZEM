<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link"  href="liste-eleve.php">Liste des Elève</a></li>
                <li class="nav-item active"><a class="nav-link" href="importation-eleve.php">Importation des Elèves</a></li>
                <li class="nav-item active"><a class="navbar-brand" href="#">Statistiques</a></li>
                <li class="nav-item active"><a class="nav-link" href="information.php">Information du site</a></li>
                <li class="nav-item active"><a class="nav-link" id="deco" onclick="deco()">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <h3>Statistiques </h3>

    <?php
    
        require_once('Modele.php');
        $pdo = connexion();
        $Etudiants = getEtudiants();
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        foreach($Etudiants as $Etudiant) {
            $Rows = $Rows + 1;
            if($Etudiant['premiereAnnee'] == 1) {
                $nbrPremiereAnnee = $nbrPremiereAnnee + 1;
            }

            if($Etudiant['optionSLAM'] === 1) {
                $SLAM = $SLAM + 1;
            } elseif($Etudiant['optionSLAM'] === 0) {
                $SISR = $SISR + 1;
            } else {
                $PasOption = $PasOption + 1;
            }

            if($Etudiant['semAbandon'] !== NULL) {
                $nbrAbandon = $nbrAbandon + 1;
            }

            if($Etudiant['departement'] !== NULL) {
                array_push($departements, $Etudiant['departement']);
            }

            if($Etudiant['alternance'] == 1) {
                $nbrAlternance = $nbrAlternance + 1;
            }

            if($Etudiant['departement'] === NULL) {
                $pasDepartement = $pasDepartement + 1;
            }
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
                <td>Pourcentage de premiere année</td>
                <td>Pourcentage de deuxième année</td>
                <td>Pourcentage de SLAM</td>
                <td>Pourcentage de SISR</td>
                <td>Pourcentage de sans option</td>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
            </tr>
            <tr>
                <td>".round(($nbrPremiereAnnee / $Rows) * 100, 2)."%</td>
                <td>". 100 - round(($nbrPremiereAnnee / $Rows) * 100, 2)."%</td>
                <td>".round(($SLAM / $Rows) * 100, 2)."%</td>
                <td>".round(($SISR / $Rows) * 100, 2)."%</td>
                <td>".round(($PasOption / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
            </tr>
        </table>
        ");
    ?>

</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
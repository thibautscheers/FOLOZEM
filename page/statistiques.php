<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="style/navbar.css" type="text/css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
</head>

<body class="body">
    <div>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link"  href="liste-eleve.php">Liste des Elèves</a></li>
                <li class="nav-item active"><a class="nav-link" href="importation-eleve.php">Importation des Elèves</a></li>
                <li class="nav-item active"><a class="navbar-brand" href="#">Statistiques</a></li>
                <li class="nav-item active"><a class="nav-link" href="information.php">Information du site</a></li>
                <li class="nav-item active"><a class="nav-link" id="deco" onclick="deco()">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <form action="" id="formGetPromotion" method="get">
        Filtre : 
        <input name="filtreAnnee" type='number' placeholder='<?php
         if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            echo("Promotion ".$_GET['filtreAnnee']."-".$_GET['filtreAnnee'] + 2);
        } else {
            echo("Indiquez une promotion");
        }
        ?>
        '>
        <input type='submit' value="Appliquez filtre">
    </form>

    <h3 class="h3">Statistiques Générales</h3>

    <?php
    
        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, NULL, NULL);
        } else {
            $Etudiants = getEtudiants();
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL) {
                $nbrDeBtsPassee = $nbrDeBtsPassee + 1;
            }

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage de SIO 1</td>
                <td>Pourcentage de SIO 2</td>
                <td>Pourcentage de SLAM</td>
                <td>Pourcentage de SISR</td>
                <td>Pourcentage de sans option</td>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($nbrPremiereAnnee / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrPremiereAnnee == 0) {
                    $nbrSecondAnnee = 0;
                    print_r($nbrSecondAnnee);
                } else{
                    $nbrSecondAnnee = $Rows - $nbrPremiereAnnee;
                    echo(100 - round(($nbrPremiereAnnee / $Rows) * 100, 2));
                }
                echo(
                "%</td>
                <td>".round(($SLAM / $Rows) * 100, 2)."%</td>
                <td>".round(($SISR / $Rows) * 100, 2)."%</td>
                <td>".round(($PasOption / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                        unset($vals[$UnDepartement]);
                        $i = 0;
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
        echo(
                "</td>
                <td>");
                if(count($idSorties) == 0) {
                    print_r("<br>Sortie Non Précisée : 100%");
                } else {
                    for($i = 0; $i<$Rows; $i++) {
                    
                        if($idSorties[$i] == 6) {
                            $licenceOuMaster = $licenceOuMaster + 1;
                        }
                        if($idSorties[$i] == 7) {
                            $licenceOuCertification = $licenceOuCertification + 1;
                        }
                        if($idSorties[$i] == 8) {
                            $reorientation = $reorientation + 1;
                        }
                        if($idSorties[$i] == 9) {
                            $activiteProfessionelle = $activiteProfessionelle + 1;
                        }
                        if($idSorties[$i] == 10) {
                            $sansActivite = $sansActivite + 1;
                        }
                        if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                            $sortieNonPrecise = $sortieNonPrecise + 1;
                        }
                    }
                    print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                    print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                    print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                    print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                    print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                    print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                }
        echo(
                "</td>
            </tr>
        </table>
        ");
    ?>

    <div>Afficher graphiques</div>
    <input type='checkbox' value='' id='graphCheckbox'>
    <div id='graphsPlacement' hidden='true'>
        <canvas id='graphAnnee' style='display: inline;'> </canvas>
        <canvas id='graphOptions' style='display: inline;'> </canvas>
    </div>

    <script>
        //graph de la repartition des sio1/sio2
        let ctx1 = document.getElementById('graphAnnee').getContext('2d')
        let nbrPremiereAnnee = <?php echo ($nbrPremiereAnnee) ?>;
        let nbrSecondAnnee = <?php echo ($nbrSecondAnnee) ?>;
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
                borderColor: ['#2338'],
                circumference: [180],
                rotation: [270],

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



        //graph de la repartition des Options
        let ctx2 = document.getElementById('graphOptions').getContext('2d')
        let labels2 = ["SLAM", "SISR", "Sans option"]
        let slam = <?php echo($SLAM) ?>;
        let sisr = <?php echo($SISR) ?>;
        let sansOption = <?php echo($PasOption) ?>;
        let data2 = {
            labels: labels2,
            datasets: [{
                data: [slam, sisr, sansOption],
                backgroundColor: [
                    "#FF6384",
                    "#4BC0C0",
                    "#FFCE56",
                    "#E7E9ED",
                    "#36A2EB"
                ],
                hoverOffset: 4,
                borderColor: ['#2338'],
                circumference: [180],
                rotation: [270],

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


        let graphCheckbox = document.getElementById("graphCheckbox")
        let graphsPlacement = document.getElementById("graphsPlacement")
        graphCheckbox.addEventListener("change", showgraph => {
            if(showgraph.target.checked == true) {
                graphsPlacement.hidden = false
            } else {
                graphsPlacement.hidden = true
            }
        })

    </script>


    <br><hr></br>

    <h3 class="h3">Statistiques SIO1</h3>

    <?php

        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, NULL, NULL);
        } else {
            $Etudiants = getEtudiantAnneeOption(NULL, 1, NULL);
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['reussiteBTS'] === 1 ) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage de SLAM</td>
                <td>Pourcentage de SISR</td>
                <td>Pourcentage de sans option</td>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($SLAM / $Rows) * 100, 2)."%</td>
                <td>".round(($SISR / $Rows) * 100, 2)."%</td>
                <td>".round(($PasOption / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                        unset($vals[$UnDepartement]);
                        $i = 0;
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
                echo(
                    "</td>
                    <td>");
                    if(count($idSorties) == 0) {
                        print_r("<br>Sortie Non Précisée : 100%");
                    } else {
                        for($i = 0; $i<$Rows; $i++) {
                        
                            if($idSorties[$i] == 6) {
                                $licenceOuMaster = $licenceOuMaster + 1;
                            }
                            if($idSorties[$i] == 7) {
                                $licenceOuCertification = $licenceOuCertification + 1;
                            }
                            if($idSorties[$i] == 8) {
                                $reorientation = $reorientation + 1;
                            }
                            if($idSorties[$i] == 9) {
                                $activiteProfessionelle = $activiteProfessionelle + 1;
                            }
                            if($idSorties[$i] == 10) {
                                $sansActivite = $sansActivite + 1;
                            }
                            if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                                $sortieNonPrecise = $sortieNonPrecise + 1;
                            }
                        }
                        print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                        print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                        print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                        print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                        print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                        print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                    }
            echo(
                "</td>
            </tr>
        </table>
        ");
    ?>

    <h4>Statistiques SIO1 SLAM</h4>

    <?php

        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, 1, 1);
        } else {
            $Etudiants = getEtudiantAnneeOption(NULL, 1, 1);
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL) {
                $nbrDeBtsPassee = $nbrDeBtsPassee + 1;
            }

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
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
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
                echo(
                    "</td>
                    <td>");
                    if(count($idSorties) == 0) {
                        print_r("<br>Sortie Non Précisée : 100%");
                    } else {
                        for($i = 0; $i<$Rows; $i++) {
                        
                            if($idSorties[$i] == 6) {
                                $licenceOuMaster = $licenceOuMaster + 1;
                            }
                            if($idSorties[$i] == 7) {
                                $licenceOuCertification = $licenceOuCertification + 1;
                            }
                            if($idSorties[$i] == 8) {
                                $reorientation = $reorientation + 1;
                            }
                            if($idSorties[$i] == 9) {
                                $activiteProfessionelle = $activiteProfessionelle + 1;
                            }
                            if($idSorties[$i] == 10) {
                                $sansActivite = $sansActivite + 1;
                            }
                            if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                                $sortieNonPrecise = $sortieNonPrecise + 1;
                            }
                        }
                        print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                        print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                        print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                        print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                        print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                        print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                    }
            echo(
                    "</td>
            </tr>
        </table>
        ");
    ?>

    <h4>Statistiques SIO1 SISR</h4>

    <?php

        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, 1, 0);
        } else {
            $Etudiants = getEtudiantAnneeOption(NULL, 1, 0);
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL) {
                $nbrDeBtsPassee = $nbrDeBtsPassee + 1;
            }

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                        unset($vals[$UnDepartement]);
                        $i = 0;
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
                echo(
                    "</td>
                    <td>");
                    if(count($idSorties) == 0) {
                        print_r("<br>Sortie Non Précisée : 100%");
                    } else {
                        for($i = 0; $i<$Rows; $i++) {
                        
                            if($idSorties[$i] == 6) {
                                $licenceOuMaster = $licenceOuMaster + 1;
                            }
                            if($idSorties[$i] == 7) {
                                $licenceOuCertification = $licenceOuCertification + 1;
                            }
                            if($idSorties[$i] == 8) {
                                $reorientation = $reorientation + 1;
                            }
                            if($idSorties[$i] == 9) {
                                $activiteProfessionelle = $activiteProfessionelle + 1;
                            }
                            if($idSorties[$i] == 10) {
                                $sansActivite = $sansActivite + 1;
                            }
                            if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                                $sortieNonPrecise = $sortieNonPrecise + 1;
                            }
                        }
                        print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                        print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                        print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                        print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                        print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                        print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                    }
            echo(
                    "</td>
            </tr>
        </table>
        ");
    ?>

    <br><hr></br>

    <h3 class="h3">Statistiques SIO2</h3>

    <?php

        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, 0, NULL);
        } else {
            $Etudiants = getEtudiantAnneeOption(NULL, 0, NULL);
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL) {
                $nbrDeBtsPassee = $nbrDeBtsPassee + 1;
            }

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage de SLAM</td>
                <td>Pourcentage de SISR</td>
                <td>Pourcentage de sans option</td>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($SLAM / $Rows) * 100, 2)."%</td>
                <td>".round(($SISR / $Rows) * 100, 2)."%</td>
                <td>".round(($PasOption / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                        unset($vals[$UnDepartement]);
                        $i = 0;
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
                echo(
                    "</td>
                    <td>");
                    if(count($idSorties) == 0) {
                        print_r("<br>Sortie Non Précisée : 100%");
                    } else {
                        for($i = 0; $i<$Rows; $i++) {
                        
                            if($idSorties[$i] == 6) {
                                $licenceOuMaster = $licenceOuMaster + 1;
                            }
                            if($idSorties[$i] == 7) {
                                $licenceOuCertification = $licenceOuCertification + 1;
                            }
                            if($idSorties[$i] == 8) {
                                $reorientation = $reorientation + 1;
                            }
                            if($idSorties[$i] == 9) {
                                $activiteProfessionelle = $activiteProfessionelle + 1;
                            }
                            if($idSorties[$i] == 10) {
                                $sansActivite = $sansActivite + 1;
                            }
                            if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                                $sortieNonPrecise = $sortieNonPrecise + 1;
                            }
                        }
                        print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                        print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                        print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                        print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                        print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                        print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                    }
            echo(
                    "</td>
            </tr>
        </table>
        ");
    ?>

    <h4>Statistiques SIO2 SLAM</h4>

    <?php

        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, 0, 1);
        } else {
            $Etudiants = getEtudiantAnneeOption(NULL, 0, 1);
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL) {
                $nbrDeBtsPassee = $nbrDeBtsPassee + 1;
            }

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                        unset($vals[$UnDepartement]);
                        $i = 0;
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
                echo(
                    "</td>
                    <td>");
                    if(count($idSorties) == 0) {
                        print_r("<br>Sortie Non Précisée : 100%");
                    } else {
                        for($i = 0; $i<$Rows; $i++) {
                        
                            if($idSorties[$i] == 6) {
                                $licenceOuMaster = $licenceOuMaster + 1;
                            }
                            if($idSorties[$i] == 7) {
                                $licenceOuCertification = $licenceOuCertification + 1;
                            }
                            if($idSorties[$i] == 8) {
                                $reorientation = $reorientation + 1;
                            }
                            if($idSorties[$i] == 9) {
                                $activiteProfessionelle = $activiteProfessionelle + 1;
                            }
                            if($idSorties[$i] == 10) {
                                $sansActivite = $sansActivite + 1;
                            }
                            if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                                $sortieNonPrecise = $sortieNonPrecise + 1;
                            }
                        }
                        print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                        print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                        print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                        print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                        print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                        print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                    }
            echo(
                    "</td>
            </tr>
        </table>
        ");
    ?>

    <h4>Statistiques SIO2 SISR</h4>

    <?php

        require_once('Modele.php');
        $pdo = connexion();
        if(isset($_GET['filtreAnnee']) and $_GET['filtreAnnee'] != "") {
            $filtreAnnee = $_GET['filtreAnnee'];
            $Etudiants = getEtudiantAnneeOption($filtreAnnee, 0, 0);
        } else {
            $Etudiants = getEtudiantAnneeOption(NULL, 0, 0);
        }
        $Rows = 0;
        $nbrPremiereAnnee = 0;
        $SLAM = 0;
        $SISR = 0;
        $PasOption = 0;
        $nbrAbandon = 0;
        $departements = [];
        $nbrAlternance = 0;
        $pasDepartement = 0;
        $nbrDeBtsPassee = 0;
        $reussiteBTS = 0;
        $nbrDeFille = 0;
        $nbdrDeGarcon = 0;
        $nbrRedoublant1Annee = 0;
        $nbrRedoublant2Annee = 0;
        $nbrNonRedoublant = 0;
        $idSorties = [];
        $licenceOuMaster = 0;
        $licenceOuCertification = 0;
        $reorientation = 0;
        $activiteProfessionelle = 0;
        $sansActivite = 0;
        $sortieNonPrecise = 0;
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

            if($Etudiant['reussiteBTS'] !== NULL) {
                $nbrDeBtsPassee = $nbrDeBtsPassee + 1;
            }

            if($Etudiant['reussiteBTS'] !== NULL and $Etudiant['reussiteBTS'] !== 0) {
                $reussiteBTS = $reussiteBTS + 1;
            }

            if($Etudiant['sexe'] ===  0) {
                $nbrDeFille = $nbrDeFille + 1;
            } else{
                $nbdrDeGarcon = $nbdrDeGarcon + 1;
            }

            if($Etudiant['redoublantPremAnnee'] === 1) {
                $nbrRedoublant1Annee = $nbrRedoublant1Annee + 1;
            } elseif($Etudiant['redoublantPremAnnee'] === 0) {
                $nbrRedoublant2Annee = $nbrRedoublant2Annee + 1;
            } else {
                $nbrNonRedoublant = $nbrNonRedoublant + 1;
            }

            array_push($idSorties, $Etudiant['idSortie#']);

        }
        if($Rows == 0) {
            $Rows = 1;
        }
        echo("
        <table class='table table-bordered table-sm'>
            <tr>
            <thead class='table-dark'>
                <td>Pourcentage d'abandons</td>
                <td>Départements/Pourcentage</td>
                <td>Pourcentage d'alternance</td>
                <td>Taux de réussite au BTS</td>
                <td>Taux de garçons</td>
                <td>Taux de filles</td>
                <td>Redoublants</td>
                <td>Sortie du BTS</td>
                </thead>
            </tr>
            <tr>
                <td>".round(($nbrAbandon / $Rows) * 100, 2)."%</td>
                <td>");
                $vals = array_count_values($departements); //Recupere le nombre de chaque departement
                for($i = 0; $i<$Rows + 1; $i++) { //Pour le nombre d'eleve
                    $UnDepartement = array_search($i, $vals); //trouver un departement
                    print_r($UnDepartement);
                    if($UnDepartement) { //Si unDepartement
                        $nbrDeUnDepartement = $vals[$UnDepartement]; //Trouver le nbrDeunDepartement
                        print_r(" / ".round(($nbrDeUnDepartement / $Rows) * 100, 2) .'%'); //Afficher les pourcentage
                        print_r("<br>");
                        unset($vals[$UnDepartement]);
                        $i = 0;
                    }
                };
                print_r("Non spécifié / ".round(($pasDepartement / $Rows) * 100, 2) .'%');
        echo(
                "</td>
                <td>".round(($nbrAlternance / $Rows) * 100, 2)."%</td>
                <td>");
                if($nbrDeBtsPassee === 0) {
                    echo("Aucun BTS passé");
                } else {
                    echo(round(($reussiteBTS / $nbrDeBtsPassee) * 100, 2). "%");
                }
        echo(
                "</td>
                <td>".round(($nbdrDeGarcon / $Rows) * 100, 2)."%</td>
                <td>".round(($nbrDeFille / $Rows) * 100, 2)."%</td>
                <td>");
                print_r("1ère année : ". round(($nbrRedoublant1Annee / $Rows) * 100, 2). "%");
                print_r("<br>2ême année : ". round(($nbrRedoublant2Annee / $Rows) * 100, 2). "%");
                print_r("<br>Pas redoublé: ". round(($nbrNonRedoublant / $Rows) * 100, 2). "%");
                echo(
                    "</td>
                    <td>");
                    if(count($idSorties) == 0) {
                        print_r("<br>Sortie Non Précisée : 100%");
                    } else {
                        for($i = 0; $i<$Rows; $i++) {
                        
                            if($idSorties[$i] == 6) {
                                $licenceOuMaster = $licenceOuMaster + 1;
                            }
                            if($idSorties[$i] == 7) {
                                $licenceOuCertification = $licenceOuCertification + 1;
                            }
                            if($idSorties[$i] == 8) {
                                $reorientation = $reorientation + 1;
                            }
                            if($idSorties[$i] == 9) {
                                $activiteProfessionelle = $activiteProfessionelle + 1;
                            }
                            if($idSorties[$i] == 10) {
                                $sansActivite = $sansActivite + 1;
                            }
                            if($idSorties[$i] == NULL or $idSorties[$i] == "") {
                                $sortieNonPrecise = $sortieNonPrecise + 1;
                            }
                        }
                        print_r("Licence ou Master : ". round(($licenceOuMaster / $Rows) * 100, 2). "%");
                        print_r("<br>Licence ou Certification : ". round(($licenceOuCertification / $Rows) * 100, 2). "%");
                        print_r("<br>Réorientation : ". round(($reorientation / $Rows) * 100, 2). "%");
                        print_r("<br>Activité Professionelle : ". round(($activiteProfessionelle / $Rows) * 100, 2). "%");
                        print_r("<br>Sans Activité : ". round(($sansActivite / $Rows) * 100, 2). "%");
                        print_r("<br>Sortie Non Précisée : ". round(($sortieNonPrecise / $Rows) * 100, 2). "%");
                    }
            echo(
                    "</td>
            </tr>
        </table>
        ");
    ?>


    <br> </br>
</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
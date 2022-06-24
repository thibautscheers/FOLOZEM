<head>
    <style>
        table, td, th {
        border: 1px solid black;
        }
    </style>
</head>

<?php
        //définition des tables néccessaires pour la suite
        $NomsPrenoms = [];
        $Noms = [];
        $Prenoms = [];

        $Dates = [];
        $Annees = [];

        $Dossiers = [];
        $IdEtudiants = [];

        $EtabOrigines = [];
        $Departements = [];

    if(isset( $_FILES['file'])) {
        $csvFile = $_FILES['file'];
    }
    $tmpName = $_FILES['file']['tmp_name'];
    $csvAsArray = array_map('str_getcsv', file($tmpName)); //Recupere le fichier CSV sous forme de tableau

    echo("<table>");

        for ($i=0; $i<count($csvAsArray); $i++) { // Pour chaque ligne
            echo("<tr>");

            for ($v=0; $v<count($csvAsArray[0]); $v++) { // Pour chaque colonne de la ligne
                //print_r($csvAsArray[$i][$v]);
                echo("<td>".$csvAsArray[$i][$v]."</td>");
                if(preg_match('(Nom|nom|Prénom|Prenom|prenom|prénom)', $csvAsArray[$i][$v]) === 1) {
                    $ColonnePrenomsNoms = $v; // Recupere la colonne des prenoms
                }

                if(preg_match('(Date du oui)', $csvAsArray[$i][$v]) === 1) {
                    $ColonneDates = $v;
                }

                if(preg_match('(Dossier|dossier)', $csvAsArray[$i][$v]) === 1) {
                    $ColonneDossier = $v;
                }

                if(preg_match('(Etab|etab)',$csvAsArray[$i][$v]) ===1 ) {
                    $ColonneEtabOrigines = $v;
                }

                if(isset($ColonnePrenomsNoms)) { //Si la colonne a été trouver
                    if($i > 0) { //Si la ligne n'est pas la premiere ligne (car la peremiere ligne est la legende)
                        if($v == $ColonnePrenomsNoms) { //Si l'incrément arrive sur la colonne des prenoms
                            array_push($NomsPrenoms, $csvAsArray[$i][$v]); //Rajouter le nom et prenom dans le tableau
                        }
                    }
                }

                if(isset($ColonneDates)) { //Si la colonne a été trouver
                    if($i > 0) { //Si la ligne n'est pas la premiere ligne (car la peremiere ligne est la legende)
                        if($v == $ColonneDates) { //Si l'incrément arrive sur la colonne des Dates
                            array_push($Dates, $csvAsArray[$i][$v]); //Rajouter la date dans le tableau
                        }
                    }
                }

                if(isset($ColonneDossier)) { //Si la colonne a été trouver
                    if($i > 0) { //Si la ligne n'est pas la premiere ligne (car la peremiere ligne est la legende)
                        if($v == $ColonneDossier) { //Si l'incrément arrive sur la colonne des Dossiers
                            array_push($Dossiers, $csvAsArray[$i][$v]); //Rajouter le dossier dans le tableau
                        }
                    }
                }

                if(isset($ColonneEtabOrigines)) { //Si la colonne a été trouver
                    if($i > 0) { //Si la ligne n'est pas la premiere ligne (car la peremiere ligne est la legende)
                        if($v == $ColonneEtabOrigines) { //Si l'incrément arrive sur la colonne des Etablissement d'origine
                            if($csvAsArray[$i][$v] != "") { //Si la case n'est pas vide
                                array_push($EtabOrigines, $csvAsArray[$i][$v]); //Rajouter le dossier dans le tableau
                            } else {
                                array_push($EtabOrigines, "Aucune Origine");
                            }
                        }
                    }
                }

            }

            echo("</tr>");
        }

    echo("</table>");

    for($i = 0; $i < count($NomsPrenoms); $i++) { //Pour la longeur du tableau
        $NomPrenom = explode(" ", $NomsPrenoms[$i]); //Séparé la string en deux partie au niveau de l'éspace
        $Nom = $NomPrenom[0]; //Recupere la premiere partie de la string aka le nom
        $Prenom = $NomPrenom[1]; //Recupere la deuxieme partie de la string aka le prenom

        array_push($Noms, $Nom);
        array_push($Prenoms, $Prenom);
        //print_r($Nom);
        //print_r($Prenom);
    }
    //print_r($NomsPrenoms);
    //print_r($Prenoms);
    //print_r($Noms);

    for($i = 0; $i < count($Dates); $i++) { //Pour la longeur du tableau
        $Date = explode(" ", $Dates[$i]); //Séparé la string en plusieurs partie au niveau de l'éspace
        $Annee = $Date[2]; //Recupere la troisieme partie de la string aka l'année
        array_push($Annees, $Annee);
        //print_r($Annee);
    }
    //print_r($Dates);

    for($i = 0; $i < count($Dossiers); $i++) { //Pour la longeur du tableau
        $Dossier = $Dossiers[$i]; //Recupere la troisieme partie de la string aka l'année
        //print_r($Dossier);
    }
    //print_r($Dossiers);

    for($i = 0; $i < count($Dossiers); $i++) { //Pour la longeur du tableau
        $IdEtudiant = $Dossiers[$i]; //. $Annees[$i]; A voir si modification possible
        array_push($IdEtudiants, $IdEtudiant);
        //print_r($IdEtudiant);
    }
    //print_r($IdEtudiants);


    for($i = 0; $i < count($EtabOrigines); $i++) { //Pour la longeur du tableau
        $pos = strpos($EtabOrigines[$i], "("); // Recupere l'endroit ou se situe la parenthese (Aka juste avant le département)
        if($pos) {
            $EtabOrigine = $EtabOrigines[$i]; //Recupere chaque département d'origine
            $Departement = $EtabOrigine[$pos+1]. $EtabOrigine[$pos+2]; //Recupere les 2 character apres la parenthese (exemple : Lycée VAUCANSON (38)) -> 38
            array_push($Departements, $Departement); // Met le departement dans la table
            //print_r($Departement);
        } else {
            array_push($Departements, NULL); //Si il n'y a pas de parenthese, alors mettre aucune origine
        }
    }
    //print_r($EtabOrigines);
    //print_r($Departements);

    //print_r($IdEtudiants);
    //print_r($Noms);
    //print_r($Prenoms);
    //Option Bts
    //Semestre d'abandon
    //print_r($Annees);
    //print_r($Departements);
    //Alternance
    //Origine
    //Option d'origine

    require_once("Modele.php");

    $pdo = connexion();

    for($i=0; $i<count($IdEtudiants);$i++) {
        $IdEtudiant = $IdEtudiants[$i];
        $Nom = $Noms[$i];
        $Prenom = $Prenoms[$i];
        $premiereAnne = 1;
        $optionSLAM = NULL;
        $semAbandon = NULL;
        $Annee = $Annees[$i];
        $Departement = $Departements[$i];
        $alternance = 0;
        $idOption = 4; //L'option 4 est celle non définie
        $res =  $pdo->prepare("INSERT INTO  etudiant (`noEtudiant`, `nom`, `prenom`, `premiereAnnee`, `optionSLAM`,  `anneeArrivee`, `departement`, `alternance`,`idOption#`) VALUES (:noEtudiant,:nom,:prenom,:premiereAnnee,:optionSLAM,:anneeArrivee,:departement,:alternance,:idOptions)");
        $res->bindParam("noEtudiant", $IdEtudiant, PDO::PARAM_INT);
        $res->bindParam("nom", $Nom, PDO::PARAM_STR, 20);
        $res->bindParam("prenom", $Prenom, PDO::PARAM_STR, 20);
        $res->bindParam("premiereAnnee", $premiereAnne, PDO::PARAM_BOOL);
        $res->bindParam("optionSLAM", $optionSLAM, PDO::PARAM_BOOL);
        $res->bindParam("anneeArrivee", $Annee, PDO::PARAM_INT, 4);
        $res->bindParam("departement", $Departement, PDO::PARAM_INT);
        $res->bindParam("alternance", $alternance, PDO::PARAM_BOOL);
        $res->bindParam("idOptions", $idOption, PDO::PARAM_INT);
        $res->execute();
    }

    session_start();
    $_SESSION["info"] = "Importation reussi";

    header("location:importation-eleve.php");

?>
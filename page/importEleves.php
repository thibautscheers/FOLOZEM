<head>
    <style>
        table, td, th {
        border: 1px solid black;
        }
    </style>
</head>

<?php

        $NomsPrenoms = [];
        $Dates = [];

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

                if(isset($ColonnePrenomsNoms)) { //Si la colonne a été trouver
                    if($i > 1) { //Si la ligne n'est pas la premiere ligne (car la peremiere ligne est la legende)
                        if($v == $ColonnePrenomsNoms) { //Si l'incrément arrive sur la colonne des prenoms
                            array_push($NomsPrenoms, $csvAsArray[$i][$v]); //Rajouter le nom et prenom dans le tableau
                        }
                    }
                }

                if(isset($ColonneDates)) { //Si la colonne a été trouver
                    if($i > 1) { //Si la ligne n'est pas la premiere ligne (car la peremiere ligne est la legende)
                        if($v == $ColonneDates) { //Si l'incrément arrive sur la colonne des prenoms
                            array_push($Dates, $csvAsArray[$i][$v]); //Rajouter le nom et prenom dans le tableau
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
        //print_r($Nom);
        //print_r($Prenom);
    }
    //print_r($NomsPrenoms)

    for($i = 0; $i < count($Dates); $i++) { //Pour la longeur du tableau
        $Date = explode(" ", $Dates[$i]); //Séparé la string en plusieurs partie au niveau de l'éspace
        $Annee = $Date[2]; //Recupere la troisieme partie de la string aka l'année
        //print_r($Annee);
    }

    //print_r($Dates);
?>
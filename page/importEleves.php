<head>
    <style>
        table, td, th {
        border: 1px solid black;
        }
    </style>
</head>

<?php

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
            }

            echo("</tr>");
        }

    echo("</table>");
?>
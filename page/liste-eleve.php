<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Elèves</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link rel="stylesheet" href="style/navbar.css">

        <style>
            table, td, th {
            border: 1px solid black;
            }
        </style>
    </head>
        <div>
            <ul>
                <li><a href="#">Liste des Elève</a></li>
                <li><a href="importation-eleve.php">Importation des Elèves</a></li>
                <li><a href="statistiques.php">Statistiques</a></li>
                <li><a href="information.php">Information du site</a></li>
            </ul>
        </div>
    <body>

        <h3>Liste des élève </h3>

        <?php

            require_once("Modele.php");
            $Etudiants = getEtudiants();
            foreach ($Etudiants as $Etudiant) {
                $noEtudiant = $Etudiant['noEtudiant'];
                $nom = $Etudiant['nom'];
                $prenom = $Etudiant['prenom'];
                $premiereAnnee = $Etudiant['premiereAnnee'];
                $optionSLAM = $Etudiant['optionSLAM'];
                $semAbandon = $Etudiant['semAbandon'];
                $anneeArrivee = $Etudiant['anneeArrivee'];
                $departement = $Etudiant['departement'];
                $alternance = $Etudiant['alternance'];

                echo(
                    "<table>

                        <tr>

                            <td>Numéro étudiant</td>
                            <td>Nom</td>
                            <td>Prenom</td>
                            <td>Année BTS</td>
                            <td>Option BTS</td>
                            <td>Semestre d'abandon</td>
                            <td>Année d'arriver</td>
                            <td>Département</td>
                            <td>Alternance</td>

                        </tr>

                        <tr>

                            <td>".$noEtudiant."</td>
                            <td>".$nom."</td>
                            <td>".$prenom."</td>
                            <td>".$premiereAnnee."</td>
                            <td>".$optionSLAM."</td>
                            <td>".$semAbandon."</td>
                            <td>".$anneeArrivee."</td>
                            <td>".$departement."</td>
                            <td>".$alternance."</td>

                        </tr>

                    </table>"
                );
            }

        ?>
    </body>

</html>
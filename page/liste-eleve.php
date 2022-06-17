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
    <body>

        <div>
            <ul>
                <li><a href="#">Liste des Elève</a></li>
                <li><a href="importation-eleve.php">Importation des Elèves</a></li>
                <li><a href="statistiques.php">Statistiques</a></li>
                <li><a href="information.php">Information du site</a></li>
                <li><a id="deco" onclick="deco()">Déconnecxion</a></li>
            </ul>
        </div>

        <h3>Liste des élève </h3>
        <table>
            <tr>

                <td><b>Numéro étudiant</td>
                <td><b>Nom</td>
                <td><b>Prenom</td>
                <td><b>Année BTS</td>
                <td><b>Option du BTS</td>
                <td><b>Semestre d'abandon</td>
                <td><b>Année d'arriver</td>
                <td><b>Département</td>
                <td><b>Alternance</td>
                <td><b>Origine</td>
                <td><b>Option d'origine</td>

            </tr>
        <?php

            require_once("Modele.php");
            $Etudiants = getEtudiants();
            foreach ($Etudiants as $Etudiant) {
                $noEtudiant = $Etudiant['noEtudiant'];
                $nom = $Etudiant['nom'];
                $prenom = $Etudiant['prenom'];

                if ($Etudiant['premiereAnnee'] == 1) { // Affiche dynamiquement l'année de l'étudiant
                    $premiereAnnee = 'Première Année';
                } elseif ($Etudiant['premiereAnnee'] == 0) {
                    $premiereAnnee = 'Seconde Année';
                } else {
                    $premiereAnnee = 'Erreur // Non renseigné';
                }
                //$premiereAnnee = $Etudiant['premiereAnnee'];


                if ($Etudiant['optionSLAM'] == 1) { // Affiche dynamiquement l'année de l'étudiant
                    $optionSLAM = "Option SLAM";
                } elseif ($Etudiant['optionSLAM'] == 0) {
                    $optionSLAM = "Option SISR";
                } else {
                    $optionSLAM = "Erreur // Non renseigné";
                }
                //$optionSLAM = $Etudiant['optionSLAM'];


                if (isset($Etudiant['semAbandon'])) { // Affiche dynamiquement l'abandon de l'étudiant
                    $semAbandon = "Adanbdon de l'élève au semestre ".$Etudiant['semAbandon'];
                } elseif (!isset($Etudiant['semAbandon'])) {
                    $semAbandon = "Pas d'abandon de l'élève";
                } else {
                    $semAbandon = "Erreur // Non renseigné";
                }
                //$semAbandon = $Etudiant['semAbandon'];

                $anneeArrivee = $Etudiant['anneeArrivee'];
                $departement = $Etudiant['departement'];

                if ($Etudiant['alternance'] == 1) { // Affiche dynamiquement l'alternance de l'étudiant
                    $alternance = "Cette élève fait une alternance";
                } elseif ($Etudiant['alternance'] == 0) {
                    $alternance = "Cette élève ne fait pas d'alternance";
                } else {
                    $alternance = "Erreur // Non renseigné";
                }
                //$alternance = $Etudiant['alternance'];

                $id_Option = $Etudiant['idOption#']; // L'id de l'option de l'origine de l'eleve
                $Options = getOptions($id_Option); //retourne un tableau bugger ??? (a fix)
                $Option = $Options['nomOption']; // Recupere le nom de l'option

                $id_Origine = $Options['idOrigine#'];
                $Origines = getOrigines($id_Origine);
                $Origine = $Origines['nomOrigine'];

                echo(
                        "<tr>

                            <td>".$noEtudiant."</td>
                            <td>".$nom."</td>
                            <td>".$prenom."</td>
                            <td>".$premiereAnnee."</td>
                            <td>".$optionSLAM."</td>
                            <td>".$semAbandon."</td>
                            <td>".$anneeArrivee."</td>
                            <td>".$departement."</td>
                            <td>".$alternance."</td>
                            <td>".$Origine."</td>
                            <td>".$Option."</td>

                        </tr>"
                    );
            }

        ?>
        </table>
    </body>
    <script type="text/javascript" src="js/script.js"></script>
</html>
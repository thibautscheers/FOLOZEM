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
        table,
        td,
        th {
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
            <li><a id="deco" onclick="deco()">Déconnexion</a></li>
        </ul>
    </div>

    <h3>Liste des élève </h3>
    <table>
        <tr>

            <td><b>ID étudiant</td>
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
            <td><b>Modification</b></td>

        </tr>
        <?php

        require_once("modele.php");
        session_start();

        if (isset($_SESSION["error"]) && ($_SESSION["error"] != ""))
            echo ("<br/><div style=\"background-color: #f44; padding: 6px;\">" . ($_SESSION["error"]) . "</div>");
        $_SESSION["error"] = "";

        if (isset($_SESSION["info"]) && ($_SESSION["info"] != ""))
            echo ("<br/><div style=\"background-color: #4f4; padding: 6px;\">" . ($_SESSION["info"]) . "</div>");
        $_SESSION["info"] = "";

        session_destroy();
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


            if (!isset ($Etudiant['optionSLAM'])) { // Affiche dynamiquement l'année de l'étudiant
                $optionSLAM = "Pas d'option";

            } elseif ($Etudiant['optionSLAM'] == 0) {
                $optionSLAM = "Option SISR";
            } elseif ($Etudiant['optionSLAM'] == 1) {
                $optionSLAM = "Option SLAM";
            }
            else {
                $optionSLAM = "Erreur // Non renseigné";
            }
            //$optionSLAM = $Etudiant['optionSLAM'];


            if (isset($Etudiant['semAbandon'])) { // Affiche dynamiquement l'abandon de l'étudiant
                $semAbandon = "Adanbdon de l'élève au semestre " . $Etudiant['semAbandon'];
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
        ?>

            <form method='POST' action='modifEleves.php'>
                <tr>

                    <td><input type="hidden" name="noEtudiant" value="<?php echo ($noEtudiant) ?>"><?php echo ($noEtudiant) ?></td>
                    <td><?php echo ($nom) ?></td>
                    <td><?php echo ($prenom) ?></td>
                    <td><?php echo ($premiereAnnee) ?></td>
                    <td><?php echo ($optionSLAM) ?></td>
                    <td><?php echo ($semAbandon) ?></td>
                    <td><?php echo ($anneeArrivee) ?></td>
                    <td><?php echo ($departement) ?></td>
                    <td><?php echo ($alternance) ?></td>
                    <td><?php echo ($Origine) ?></td>
                    <td><?php echo ($Option) ?></td>
                    <td> <select name='anneeSIO'>
                            <option value='1'>SIO 1</option>
                            <option value='0'>SIO 2</option>
                        </select>
                        <select name='optionBTS'>
                            <option value="NULL"></option>
                            <option value='1'>SLAM</option>
                            <option value='0'>SISR</option>
                        </select>
                        Semestre d'abandon :
                        <input type="number" name="SemAbandon" value="Semestre">
                        <select name='alternance'>
                            <option value='1'>fait une alternance</option>
                            <option value='0'>ne fait pas d'alternance</option>
                        </select>
                        <input type='submit' value='Modifier'>
                    </td>
            </form>
            <td>
                <form action="supprimerEleve.php" method="POST">
                    <input type="hidden" name="noEtudiant" value="<?php echo ($noEtudiant) ?>">
                    <input type="submit" value="Supprimer">
                </form>
                </tr>


            <?php
            
        }

            ?>

    </table>





</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
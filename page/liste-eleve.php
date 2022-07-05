<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Elèves</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="style/navbar.css" type="text/css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>


</head>

<body class="body">

    <div>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="navbar-brand" href="#">Liste des Elèves</a></li>
                <li class="nav-item active"><a class="nav-link" href="importation-eleve.php">Importation des Elèves</a></li>
                <li class="nav-item active"><a class="nav-link" href="statistiques.php">Statistiques</a></li>
                <li class="nav-item active"><a class="nav-link" href="information.php">Information du site</a></li>
                <li class="nav-item active"><a class="nav-link" id="deco" onclick="deco()">Déconnexion</a></li>
            </ul>
        </nav>
    </div>

    <h3 class="h3">Liste des élève </h3>
    <div class="table-responsive -sm">
        <table class="table table-bordered table-sm">
            <tr>
                <thead class="table-dark">
                    <td colspan="1"><b>ID étudiant</td>
                    <td colspan="1"><b>Nom</td>
                    <td colspan="1"><b>Prenom</td>
                    <td colspan="1"><b>Sexe</td>
                    <td colspan="1"><b>Année BTS</td>
                    <td colspan="1"><b>Redoublement</b></td>
                    <td colspan="1"><b>Option du BTS</td>
                    <td colspan="1"><b>Semestre d'abandon</td>
                    <td colspan="1"><b>Année d'arriver</td>
                    <td colspan="1"><b>Département</td>
                    <td colspan="1"><b>Alternance</td>
                    <td colspan="1"><b>Réussite BTS</td>
                    <td colspan="1"><b>Origine</td>
                    <td colspan="1"><b>Option d'origine</td>
                    <td colspan="1"><b>Après BTS</b>
                    <td colspan="1"><b>Modification</b></td>
                    <td></td>
                </thead>
            </tr>
            <?php

            require_once("Modele.php");
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

                if ($Etudiant['sexe'] == 1) { // Affiche dynamiquement l'année de l'étudiant
                    $sexe = 'Homme';
                } else {
                    $sexe = 'Femme';
                }

                if ($Etudiant['premiereAnnee'] == 1) { // Affiche dynamiquement l'année de l'étudiant
                    $premiereAnnee = 'SIO 1';
                } elseif ($Etudiant['premiereAnnee'] == 0) {
                    $premiereAnnee = 'SIO 2';
                } else {
                    $premiereAnnee = 'Erreur // Non renseigné';
                }
                //$premiereAnnee = $Etudiant['premiereAnnee'];


                if (!isset($Etudiant['optionSLAM'])) { // Affiche dynamiquement l'année de l'étudiant
                    $optionSLAM = "Pas d'option";
                } elseif ($Etudiant['optionSLAM'] == 0) {
                    $optionSLAM = "SISR";
                } elseif ($Etudiant['optionSLAM'] == 1) {
                    $optionSLAM = "SLAM";
                } else {
                    $optionSLAM = "Erreur // Non renseigné";
                }
                //$optionSLAM = $Etudiant['optionSLAM'];

                if (!isset($Etudiant['redoublantPremAnnee'])) { // Affiche dynamiquement l'année de l'étudiant
                    $redoublantPremAnnee = "Non redoublé";
                } elseif ($Etudiant['redoublantPremAnnee'] == 1) {
                    $redoublantPremAnnee = "Redoublant SIO 1";
                } elseif ($Etudiant['redoublantPremAnnee'] == 0) {
                    $redoublantPremAnnee = "Redoublant SIO 2";
                } else {
                    $redoublantPremAnnee = "Erreur // Non renseigné";
                }

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
                if ($departement == NULL) {
                    $departement = "Non spécifié";
                }

                if (!isset($Etudiant['reussiteBTS'])) { // Affiche dynamiquement l'année de l'étudiant
                    $reussiteBTS = "Non passé";
                } elseif ($Etudiant['reussiteBTS'] == 0) {
                    $reussiteBTS = "Non Réussit";
                } else {
                    $reussiteBTS = "BTS Réussit l'année " . $Etudiant['reussiteBTS'];
                }

                if ($Etudiant['alternance'] == 1) { // Affiche dynamiquement l'alternance de l'étudiant
                    $alternance = "Cet élève fait une alternance";
                } elseif ($Etudiant['alternance'] == 0) {
                    $alternance = "Cet élève ne fait pas d'alternance";
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
                
                
                $id_Sortie= $Etudiant['idSortie#'];
                if ($id_Sortie == NULL) {
                    $Sortie = "Non spécifié";
                }else{$Sorties = getSortie($id_Sortie);
                    $Sortie = $Sorties['labelSortie'];
                }
                
                
            
            ?>

                <form method='POST' action='modifEleves.php' class="form-inline">
                    <tr>

                        <td><input type="hidden" name="noEtudiant" value="<?php echo ($noEtudiant) ?>"><?php echo ($noEtudiant) ?></td>
                        <td><?php echo ($nom) ?></td>
                        <td><?php echo ($prenom) ?></td>
                        <td><?php echo ($sexe) ?></td>
                        <td><?php echo ($premiereAnnee) ?></td>
                        <td><?php echo ($redoublantPremAnnee) ?></td>
                        <td><?php echo ($optionSLAM) ?></td>
                        <td><?php echo ($semAbandon) ?></td>
                        <td><?php echo ($anneeArrivee) ?></td>
                        <td><?php echo ($departement) ?></td>
                        <td><?php echo ($alternance) ?></td>
                        <td><?php echo ($reussiteBTS) ?>
                        <td><?php echo ($Origine) ?></td>
                        <td><?php echo ($Option) ?></td>
                        <td><?php echo ($Sortie) ?></td>
                        <td> <select name="sexe" class="form-select-sm">
                                <option value="1">Masculin</option>
                                <option value="0">Féminin</option>
                            </select>
                            <select name='anneeSIO' class="form-select-sm">
                                <option value='1'>SIO 1</option>
                                <option value='0'>SIO 2</option>
                            </select>
                            <select name='redoublantPremAnnee' class="form-select-sm">
                                <option value="NULL">Non redoublé</option>
                                <option value='1'>Redoublant SIO 1</option>
                                <option value='0'>Redoublant SIO 2</option>
                            </select>
                            <select name='optionBTS' class="form-select-sm">
                                <option value="NULL"></option>
                                <option value='1'>SLAM</option>
                                <option value='0'>SISR</option>
                            </select>
                            Semestre d'abandon :
                            <select name="SemAbandon" class="form-select-sm">
                                <option value="NULL"></option>
                                <option value='1'>1er semestre</option>
                                <option value='2'>2nd semestre</option>
                                <option value="3">3eme semestre</option>
                                <option value="4">4eme semestre</option>
                            </select>

                            <select name='alternance' class="form-select-sm">
                                <option value='1'>fait une alternance</option>
                                <option value='0'>ne fait pas d'alternance</option>
                            </select><br>
                            reussite du BTS en :
                            <input type="number" name="reussiteBTS" class="input-group-sm"><br>
                            Après BTS:
                            <select name="sortie" class="form-select-sm">
                                <option value="NULL"></option>
                                <?php

                                $sorties = lireSortie();

                                foreach ($sorties as $sortie) {
                                    $idOption = $sortie['idSortie'];
                                    $nomOption  = $sortie['labelSortie'];
                                    echo ("<option value='$idOption'>$nomOption</option>");
                                }
                                ?>
                            <input type='submit' class="btn btn-outline-primary btn-sm" value='Modifier'>
                            
                        </td>
                </form>
                <td>
                    <form action="supprimerEleve.php" method="POST" class="form-inline">
                        <input type="hidden" name="noEtudiant" value="<?php echo ($noEtudiant) ?>">
                        <input type="submit" class="btn btn-outline-danger btn-sm" value="Supprimer">
                    </form>
                    </tr>


                <?php

            }

                ?>

        </table>
    </div>





</body>
<script type="text/javascript" src="js/script.js"></script>

</html>
<?php

function connexion() //function de connexion a la base de donnée
{
    return new PDO("mysql:host=db4free.net:3306;dbname=folozem;charset=utf8", "folozemadmin", "Folozem123!");
}

function getPassword()
{
    $pdo = connexion();
    $res = $pdo->query("SELECT * from motDePasses");
    return $res->fetch();
}

function getEtudiants() //funtion pour lire les Etudiant
{
    $pdo = connexion();
    $res = $pdo->query("SELECT * from etudiant ORDER BY nom");
    return $res->fetchAll();
}

function getOptions($id_Option) //funtion pour lire les option
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM options where idOption=:id_Option");
    $res->bindParam(":id_Option", $id_Option, PDO::PARAM_INT);
    $res->execute();
    return $res->fetch();
}

function getOrigines($id_Origine) //funtion pour lire les origine
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM origine where idOrigine=:id_Origine");
    $res->bindParam(":id_Origine", $id_Origine, PDO::PARAM_INT);
    $res->execute();
    return $res->fetch();
}
function getSortie($id_Sortie) //function pour lire les sortie avec contrainte utilisé pour une liste déroulante
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM `Sortie` WHERE idSortie=:id_Sortie");
    $res->bindParam(":id_Sortie", $id_Sortie, PDO::PARAM_INT);
    $res->execute();
    return $res->fetch();
}
function modifaccess($cleacces) // fonction pour modifier le MDP
{
    $pdo = connexion();
    $res = $pdo->prepare("UPDATE `motDePasses` SET `cleacces`='$cleacces' WHERE 1");
    $res->execute();
}

function modifEleve($noEtudiant, $anneeSIO, $optionBTS, $semAbandon, $alternance, $reussiteBTS, $sexe, $redoublantPremAnnee,$Sortie) //function pour modifier les information des élève
{
    $pdo = connexion();
    $res = $pdo->prepare("UPDATE `etudiant` SET `premiereAnnee`=:anneeSIO,`optionSLAM`=:optionBTS,`semAbandon`=:semAbandon,`alternance`=:alternance,`reussiteBTS`=:reussiteBTS,`sexe`=:sexe,`redoublantPremAnnee`=:redoublantPremAnnee,`idSortie#`=:Sortie  WHERE `noEtudiant`= :noEtudiant");
    $res->bindParam("noEtudiant", $noEtudiant, PDO::PARAM_INT);
    $res->bindParam("anneeSIO", $anneeSIO, PDO::PARAM_BOOL);
    if ($optionBTS == 'NULL') {
        $res->bindParam("optionBTS", $optionBTS, PDO::PARAM_NULL);
    } else {
        $res->bindParam("optionBTS", $optionBTS, PDO::PARAM_BOOL);
    }
    if ($semAbandon == 'NULL') {
        $res->bindParam("semAbandon", $semAbandon, PDO::PARAM_NULL);
    } else {
        $res->bindParam("semAbandon", $semAbandon, PDO::PARAM_INT);
    }
    $res->bindParam("alternance", $alternance, PDO::PARAM_BOOL);
    if ($reussiteBTS == 'NULL') {
        $res->bindParam("reussiteBTS", $reussiteBTS, PDO::PARAM_NULL);
    } else {
        $res->bindParam("reussiteBTS", $reussiteBTS, PDO::PARAM_INT);
    }

    $res->bindParam("sexe", $sexe, PDO::PARAM_BOOL);
    if ($redoublantPremAnnee == 'NULL') {
        $res->bindParam("redoublantPremAnnee", $redoublantPremAnnee, PDO::PARAM_NULL);
    } else {
        $res->bindParam("redoublantPremAnnee", $redoublantPremAnnee, PDO::PARAM_BOOL);
    }
    if ($Sortie == 'NULL') {
        $res->bindParam("Sortie", $Sortie, PDO::PARAM_NULL);
    } else {
        $res->bindParam("Sortie", $Sortie, PDO::PARAM_INT);
    }

    $res->execute();
}
function supprimerEleve($noEtudiant) //function pour supprimer les élève
{
    $pdo = connexion();
    $res = $pdo->prepare("DELETE FROM `etudiant` WHERE `noEtudiant`= :noEtudiant");
    $res->bindParam("noEtudiant", $noEtudiant, PDO::PARAM_INT);
    $res->execute();
}

function ajoutEleve($noEtudiant, $nom, $prenom, $premiereAnnee, $optionSLAM, $anneeArrivee, $departement, $alternance, $sexe, $idOptions) //function pour ajouter des élève
{
    $pdo = connexion();
    $res =  $pdo->prepare("INSERT INTO `etudiant`(`noEtudiant`, `nom`, `prenom`, `premiereAnnee`, `optionSLAM`, `anneeArrivee`, `departement`, `alternance`, `sexe`, `idOption#`) VALUES (:noEtudiant,:nom,:prenom,:premiereAnnee,:optionSLAM,:anneeArrivee,:departement,:alternance,:sexe,:idOptions)");
    $res->bindParam("noEtudiant", $noEtudiant, PDO::PARAM_INT);
    $res->bindParam("nom", $nom, PDO::PARAM_STR, 20);
    $res->bindParam("prenom", $prenom, PDO::PARAM_STR, 20);
    $res->bindParam("optionSLAM", $optionSLAM, PDO::PARAM_INT);
    $res->bindParam("premiereAnnee", $premiereAnnee, PDO::PARAM_BOOL);
    $res->bindParam("anneeArrivee", $anneeArrivee, PDO::PARAM_INT, 4);
    $res->bindParam("departement", $departement, PDO::PARAM_INT);
    $res->bindParam("alternance", $alternance, PDO::PARAM_BOOL);
    $res->bindParam("sexe", $sexe, PDO::PARAM_BOOL);
    $res->bindParam("idOptions", $idOptions);
    $res->execute();
}
function lireOption() //function pour lire les option sans contrainte utilisé pour une liste déroulante
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM `options`");
    $res->execute();
    return $res;
}

function ajoutOrigine($nomOrigine) //function pour ajouter des origine
{
    $pdo = connexion();
    $res =  $pdo->prepare("INSERT INTO `origine`(`nomOrigine`) VALUES (:nomOrigine)");
    $res->bindParam("nomOrigine", $nomOrigine, PDO::PARAM_STR, 20);
    return $res->execute();
}
function lireOrigine() //function pour lire les origine sans contrainte utilisé pour une liste déroulante
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM `origine`");
    $res->execute();
    return $res;
}
function ajoutOption($nomOption, $idOrigine) //function pour ajouter des options
{
    $pdo = connexion();
    $res =  $pdo->prepare("INSERT INTO `options`( `nomOption`, `idOrigine#`) VALUES ('$nomOption','$idOrigine')");
    $res->execute();
    return $res;
}

function getEtudiantAnneeOption($filtreAnnee, $premiereAnnee, $optionSLAM)
{
    $pdo = connexion();


    //Pour stats general en fonction d'une annee
    if (isset($filtreAnnee) and $optionSLAM === NULL and $premiereAnnee === NULL) {
        $res = $pdo->prepare("SELECT * FROM etudiant WHERE anneeArrivee=$filtreAnnee");
    }

    //Pour stats en fonction d'une annee et de l'annee du bts des eleves
    if (isset($filtreAnnee) and $optionSLAM === NULL and isset($premiereAnnee)) {
        $res = $pdo->prepare("SELECT * FROM etudiant WHERE anneeArrivee=$filtreAnnee and premiereAnnee=$premiereAnnee");
    }
    if ($filtreAnnee === NULL and $optionSLAM === NULL and isset($premiereAnnee)) {
        $res = $pdo->prepare("SELECT * FROM etudiant WHERE premiereAnnee=$premiereAnnee");
    }

    //Pareil mais avec l'option
    if (isset($filtreAnnee) and isset($optionSLAM) and isset($premiereAnnee)) {
        $res = $pdo->prepare("SELECT * FROM etudiant WHERE anneeArrivee=$filtreAnnee and premiereAnnee=$premiereAnnee and optionSLAM=$optionSLAM");
    }
    if ($filtreAnnee === NULL and isset($optionSLAM) and isset($premiereAnnee)) {
        $res = $pdo->prepare("SELECT * FROM etudiant WHERE premiereAnnee=$premiereAnnee and optionSLAM=$optionSLAM");
    }

    $res->execute();
    return $res;
}
function lireSortie() //function pour lire les sortie sans contrainte utilisé pour une liste déroulante
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM `Sortie`");
    $res->execute();
    return $res;
}

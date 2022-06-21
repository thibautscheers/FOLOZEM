<?php

function connexion() //function de connexion a la base de donnée
{
    return new PDO("mysql:host=db4free.net:3306;dbname=folozem;charset=utf8", "folozemadmin", "Folozem123!");
}

function getPassword()
{
    $pdo = connexion();
    $res = $pdo->query("SELECT * from motdepasses ORDER BY cleacces");
    return $res->fetchAll();
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

function modifaccess($cleacces) // fonction pour modifier le MDP
{
    $pdo = connexion();
    $res = $pdo->prepare("UPDATE `motdepasses` SET `cleacces`='$cleacces' WHERE 1");
    $res->execute();
}

function modifEleve($noEtudiant, $anneeSIO, $alternance, $optionBTS, $semAbandon) //function pour modifier les information des élève
{
    $pdo = connexion();
    $res = $pdo->prepare("UPDATE `etudiant` SET `premiereAnnee`='$anneeSIO',`optionSLAM`='$optionBTS',`alternance`='$alternance',`semAbandon`=$semAbandon WHERE `noEtudiant`= '$noEtudiant'");
    $res->execute();
}
function supprimerEleve($noEtudiant) //function pour supprimer les élève
{
    $pdo = connexion();
    $res = $pdo->prepare("DELETE FROM `etudiant` WHERE `noEtudiant`= '$noEtudiant'");
    $res->execute();
}

function ajoutEleve($noEtudiant, $nom, $prenom, $premiereAnnee, $optionSLAM, $alternance, $anneeArrivee, $departement, $idOptions) //function pour ajouter des élève
{
    $pdo = connexion();
    $res =  $pdo->prepare("INSERT INTO  etudiant (`noEtudiant`, `nom`, `prenom`, `premiereAnnee`, `optionSLAM`,  `anneeArrivee`, `departement`, `alternance`,`idOption#`) VALUES (:noEtudiant,:nom,:prenom,:premiereAnnee,:optionSLAM,:anneeArrivee,:departement,:alternance,:optionbac)");
    $res->bindParam("noEtudiant", $noEtudiant, PDO::PARAM_INT);
    $res->bindParam("nom", $nom, PDO::PARAM_STR, 20);
    $res->bindParam("prenom", $prenom, PDO::PARAM_STR, 20);
    $res->bindParam("premiereAnnee", $premiereAnnee, PDO::PARAM_BOOL);
    $res->bindParam("optionSLAM", $optionSLAM, PDO::PARAM_BOOL);
    $res->bindParam("anneeArrivee", $anneeArrivee, PDO::PARAM_INT, 4);
    $res->bindParam("departement", $departement, PDO::PARAM_INT);
    $res->bindParam("alternance", $alternance, PDO::PARAM_BOOL);
    $res->bindParam("optionbac", $idOptions);
    return $res->execute();
}
function lireOption() //function pour lire les option sans contrainte utilisé pour une liste déroulante
{
    $pdo = connexion();
    $res = $pdo->prepare("SELECT * FROM `options`");
    $res->execute();
    return $res;
}

function ajoutOrigine($nomOrigine)//function pour ajouter des origine
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
function ajoutOption($nomOption, $idOrigine)//function pour ajouter des options
{
    $pdo = connexion();
    $res =  $pdo->prepare("INSERT INTO `options`( `nomOption`, `idOrigine#`) VALUES ('$nomOption','$idOrigine')");
    $res->execute();
    return $res;
}

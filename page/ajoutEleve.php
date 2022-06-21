<?php
// 
try {
  require_once("Modele.php");
  session_start();

  // test pour savoir si tout les champs sont rempli


  if (!isset($_POST["noEtudiant"]) ||  !isset($_POST["nom"]) || !isset($_POST["prenom"]) || !isset($_POST["departement"])) {
    $_SESSION["error"] = "Saisir tous les champs";
  } else {
    $noEtudiant = ($_POST["noEtudiant"]);
    $nom = ($_POST["nom"]);
    $prenom = ($_POST["prenom"]);
    $premiereAnnee = ($_POST["anneeSIO"]);
    $optionSLAM = ($_POST["optionBTS"]);
    $anneeArrivee = ($_POST["anneeArrivee"]);
    $departement = ($_POST["departement"]);
    $alternance = ($_POST["alternance"]);
    $idOptions = ($_POST["idOption"]);
  }
  if ($nom == "" || $noEtudiant == "" || $departement == "" || $prenom == "") {
    $_SESSION["error"] = "nom, prenom, N°Etudiant,département non renseigné";
    header("location:importation-eleve.php");
  } else {
    ajoutEleve($noEtudiant, $nom, $prenom, $premiereAnnee, $optionSLAM, $alternance, $anneeArrivee, $departement, $idOptions);

    $_SESSION["info"] = "Etudiant Ajouter";
    header("location:importation-eleve.php");
  }


  // 




} catch (Exception $e) {
  $_SESSION["error"] = "Houston, on a un problème : " . $e->getMessage();
  header("location:importation-eleve.php");
}

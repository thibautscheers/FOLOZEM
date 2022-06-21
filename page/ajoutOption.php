<?php
// 
try {
  require_once("Modele.php");
  session_start();

  // test pour savoir si tout les champs sont rempli


  if (!isset($_POST["nomOption"])) {
    $_SESSION["error"] = "Saisir tous les champs";
  } else {
    
    $nomOption = ($_POST["nomOption"]);
    $idOrigine = ($_POST["idOrigine"]);
    
  }
  if ($nomOption == "" ) {
    $_SESSION["error"] = "nom, non renseigné";
    header("location:importation-eleve.php");
  } else {
    ajoutOption($nomOption,$idOrigine);
    echo($nomOption." ".$idOrigine);
    $_SESSION["info"] = "Option Ajouter";
    header("location:importation-eleve.php");
  }


} catch (Exception $e) {
  $_SESSION["error"] = "Houston, on a un problème : " . $e->getMessage();
  header("location:importation-eleve.php");
}

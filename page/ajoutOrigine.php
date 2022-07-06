<!-- Cette page est dédié à l'ajout d'orignie créées par Thibaut Scheers -->
<?php
// 
try {
  require_once("Modele.php");
  session_start();

  // test pour savoir si tout les champs sont rempli


  if (!isset($_POST["nomOrigine"])) {
    $_SESSION["error"] = "Saisir tous les champs";
  } else {
    
    $nomOrigine = ($_POST["nomOrigine"]);
    
  }
  if ($nomOrigine == "" ) {
    $_SESSION["error"] = "nom, non renseigné";
    header("location:importation-eleve.php");
  } else {
    ajoutOrigine($nomOrigine);

    $_SESSION["info"] = "Origine Ajouter";
    header("location:importation-eleve.php");
  }


} catch (Exception $e) {
  $_SESSION["error"] = "Houston, on a un problème : " . $e->getMessage();
  header("location:importation-eleve.php");
}

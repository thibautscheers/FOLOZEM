<?php
// 
try {
    require_once("Modele.php");
    session_start();
    
    $noEtudiant = ($_POST ["noEtudiant"]);
    
    supprimerEleve($noEtudiant);
    $_SESSION ["info"]="Etudiant supprimer";
    
    header("location:liste-eleve.php");
  }
catch (Exception $e) {
  $_SESSION ["error"]="Houston, on a un problème : " . $e->getMessage ();

}
   
?> 

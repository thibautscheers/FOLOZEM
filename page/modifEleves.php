<?php
// 
try {
    require_once("Modele.php");
    session_start();
    
    $noEtudiant = ($_POST ["noEtudiant"]);
    $anneeSIO=($_POST ["anneeSIO"]);
    $optionBTS=($_POST ["optionBTS"]);
    $alternance=($_POST ["alternance"]);
    $semAbandon = ($_POST["SemAbandon"]);
  if($semAbandon == ""){
    $semAbandon = 'NULL';
  }



    echo($noEtudiant."".$anneeSIO."".$alternance."".$optionBTS."".$semAbandon);
    modifEleve ($noEtudiant,$anneeSIO,$alternance,$optionBTS,$semAbandon);
    $_SESSION ["info"]="Etudiant modifier";
    
    header("location:liste-eleve.php");
  }
catch (Exception $e) {
  $_SESSION ["error"]="Houston, on a un problème : " . $e->getMessage ();

}
   
?> 
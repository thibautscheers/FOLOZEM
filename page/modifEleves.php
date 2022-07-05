<!-- Cette page est dédié à la modificarion des élèves créées par Thibaut Scheers -->

<?php
 
try {
  require_once("Modele.php");
  session_start();

  $noEtudiant = ($_POST["noEtudiant"]);
  $anneeSIO = ($_POST["anneeSIO"]);
  $optionBTS = ($_POST["optionBTS"]);
  $alternance = ($_POST["alternance"]);
  $semAbandon = ($_POST["SemAbandon"]);
  $reussiteBTS = ($_POST["reussiteBTS"]);
  $redoublantPremAnnee = ($_POST["redoublantPremAnnee"]);
  $sexe = ($_POST["sexe"]);
  $Sortie= ($_POST['sortie']);

if ($reussiteBTS==""){
  $reussiteBTS=NULL;
}
  



  modifEleve($noEtudiant, $anneeSIO, $optionBTS, $semAbandon, $alternance, $reussiteBTS, $sexe, $redoublantPremAnnee,$Sortie);
  $_SESSION["info"] = "Etudiant modifier";
  echo ($reussiteBTS );
  echo (  modifEleve($noEtudiant, $anneeSIO, $optionBTS, $semAbandon, $alternance, $reussiteBTS, $sexe, $redoublantPremAnnee,$Sortie));

  header("location:liste-eleve.php");
} catch (Exception $e) {
  $_SESSION["error"] = "Houston, on a un problème : " . $e->getMessage();
  echo ($e);
  echo (  modifEleve($noEtudiant, $anneeSIO, $optionBTS, $semAbandon, $alternance, $reussiteBTS, $sexe, $redoublantPremAnnee,$Sortie));

  header("location:liste-eleve.php");
}

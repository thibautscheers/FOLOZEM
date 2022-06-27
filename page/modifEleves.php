<?php
// 
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

  echo ($noEtudiant . "" . $anneeSIO . "" . $alternance . "" . $optionBTS . "" . $semAbandon);
  modifEleve($noEtudiant, $anneeSIO, $optionBTS, $semAbandon, $alternance, $reussiteBTS, $sexe, $redoublantPremAnnee);
  $_SESSION["info"] = "Etudiant modifier";

  header("location:liste-eleve.php");
} catch (Exception $e) {
  $_SESSION["error"] = "Houston, on a un problème : " . $e->getMessage();
  header("location:liste-eleve.php");
}

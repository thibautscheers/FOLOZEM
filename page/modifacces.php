<?php
// 
try {
    require_once("Modele.php");
    session_start();
    if (!isset($_POST["cleacces"])) {
      $_SESSION["error"] = "Cle acces vide";
  }
    $cleacces=($_POST ["cleacces"]);
    $cleacces = hash('sha256', $cleacces);
    modifaccess ($cleacces);
    $_SESSION ["info"]="MDP modifier";
    header("location:information.php");
  }
catch (Exception $e) {
  $_SESSION ["error"]="Houston, on a un problème : " . $e->getMessage ();
  header("location:information.php");
}
   
?> 

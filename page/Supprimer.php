<?php
    if(isset($_GET['noEtudiant'])) {
        $noEtudiant = $_GET['noEtudiant'];
    }
    require_once('Modele.php');
    $pdo = connexion();
    $res = $pdo->query("DELETE FROM etudiant WHERE noEtudiant = $noEtudiant");
    $res->execute();
    header('Location: liste-eleve.php')
?>
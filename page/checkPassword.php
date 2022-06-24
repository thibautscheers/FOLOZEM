<?php
    if(isset($_POST['LogInText'])) { //Recupere le mot de passe entrer dans l'input password
        $Value = $_POST['LogInText'];
    }
    require_once("Modele.php"); //Recupere le modele
    $pdo = connexion();
    $res = $pdo->query("SELECT * from motDePasses");
    $password = $res->fetch();
    $cleacces = $password['cleacces'];

    if ($Value == $cleacces) { //Verifie que le mot de passe est le meme que celui de la bdd
        header("Location: liste-eleve.php");
        exit();
    } else { //Si ce n'est pas le bon, ce script envoie un cookie nommé 'WrongPass'
        header("Location: index.php");
        session_start();
        $_SESSION['WrongPass'] = "True";
        exit();
    }
?>
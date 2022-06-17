<?php

    function connexion() {
        return new PDO("mysql:host=localhost;dbname=folozem;charset=utf8","root","");
    }

    function getPassword () {
        $pdo = connexion();
        $res = $pdo->query("select * from motdepasses order by cleacces");
        return $res->fetchAll ();
    }

    function getEtudiants () {
        $pdo = connexion();
        $res = $pdo->query("select * from Etudiant");
        return $res->fetchAll();
    }

      
?>
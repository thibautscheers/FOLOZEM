<?php

    function connexion() {
        return new PDO("mysql:host=localhost;dbname=folozem;charset=utf8","root","");
    }
    
    function getPassword () {
        $pdo = connexion();
        $res = $pdo->query("SELECT * from motdepasses ORDER BY cleacces");
        return $res->fetchAll ();
    }

    function getEtudiants () {
        $pdo = connexion();
        $res = $pdo->query("SELECT * from Etudiant ORDER BY nom");
        return $res->fetchAll();
    }
    
    function getOptions($id_Option) {
        $pdo = connexion();
        $res = $pdo->prepare("SELECT * FROM options where idOption=:id_Option");
        $res->bindParam(":id_Option",$id_Option,PDO::PARAM_INT);
        $res->execute();
        return $res->fetch();
    }

    function getOrigines($id_Origine) {
        $pdo = connexion();
        $res = $pdo->prepare("SELECT * FROM origine where idOrigine=:id_Origine");
        $res->bindParam(":id_Origine",$id_Origine,PDO::PARAM_INT);
        $res->execute();
        return $res->fetch();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folozem</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php
        require_once("Modele.php");
        $pdo = connexion();
        $res = $pdo->query("SELECT * from motDePasses");
        $password = $res->fetchAll();
        foreach($password as $pass) {
            echo(json_encode($pass));
        }

    ?>
    <LogInFrame class="LogInFrame">
        Entrez la clé d'accés
        <br>
        <input type="Text" class="LogInText">
        <input type="Button" id="Submit" value="Se Connecter">
    </LogInFrame>

    <script>
        function Redirect() {
            window.location.replace("liste-eleve.php")
        }
        document.getElementById("Submit").addEventListener("click", Redirect)
    </script>
</body>
</html>
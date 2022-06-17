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
    <LogInFrame class="LogInFrame">
        Entrez la clé d'accés
        <br>
        <form method="post" action="checkPassword.php">
            <input type="password" name="LogInText" class="button">
            <input type="submit" name="LogInBtn" class="button" value="Se Connecter">
            <?php
                session_start();
                if(isset($_SESSION['WrongPass'])) { // Check si le cookie WrongPass est definie
                    echo("<div> Le mot de passe entré n'est pas le bon </div>");
                }
                session_destroy(); // Permet de clear le cookie si on refresh la page
            ?>
        </form>
    </LogInFrame>
</body>

</html>
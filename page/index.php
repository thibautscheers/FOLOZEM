<!-- Cette page est dédié à la connecxion créées par Allan Escolano -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folozem</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="style/style.css">
    <!-- <link rel="stylesheet" href="style/navbar.css"> -->
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body class="body">

    <LogInFrame class="LogInFrame ">
        <p class="fs-5 fw-bold  "> Entrez la clé d'accés </p>
        <br>
        <form method="post" action="checkPassword.php">
            <input type="password" name="LogInText" class="form-inline">
            <br> </br>
            <input type="submit" name="LogInBtn" class="button btn btn-success" value="Se Connecter">
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
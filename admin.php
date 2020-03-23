<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();
    
    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include 'assets/php/connect_PDO.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bord'Irlande - ADMIN</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>
        <h1>Administrateur</h1>

        <!-- Menu différent car admin est à la racine -->
        <ul>
            <li><a href="articles/index.php">Articles</a></li>
            <li><a href="commentaires/index.php">Commentaires</a></li>
            <li><a href="utilisateurs/index.php">Utilisateurs</a></li>
            <li><a href="angles/index.php">Angles</a></li>
            <li><a href="mots_cles/index.php">Mots clés</a></li>
            <li><a href="thematiques/index.php">Thématiques</a></li>
            <li><a href="langues/index.php">Langues</a></li>
        </ul>

        <!-- Include des menus -->
        <?php include 'assets/php/btnConnexion.php'; ?>
        <?php include 'assets/php/menu.php'; ?>
        
        <?php

            // Check si l'admin est connecté
            if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true) {
                $admin = true;
            } else {
                $admin = false;
            }

            // Redirige si admin pas connecté
            if(!$admin) {
                header('Location: index.php');
            }

            

        ?>

        <script src="assets/js/script.js"></script>
    </body>

</html>
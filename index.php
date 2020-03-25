<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include 'assets/php/connect_PDO.php';
    include 'assets/php/dateChangeFormat.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bord'Irlande - BLOG</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>
        <!-- Menus -->
        <?php include 'assets/php/menu.php'; ?>

        <div class="body">
                <?php include 'assets/php/btnConnexion.php'; ?>

            <?php 

                // Affiche le dernier article
                $req = $bdd->query('SELECT * FROM article ORDER BY DtCreA DESC LIMIT 1');

                while ($donnees = $req->fetch())
                {
                    echo "<img src='articles.php?UrlPhotoA=" . $donnees['UrlPhotoA'] . "/>";
                    echo $donnees['LibTitrA'] . ' - ';
                    echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y");
                    echo '<br><br>';
                    echo "<a href='articles.php?numArt=" . $donnees['NumArt'] . "'>En savoir plus</a>";
                }

                $req->closeCursor();

            ?>

            <script src="assets/js/script.js"></script>
        </div>
    </body>

</html>
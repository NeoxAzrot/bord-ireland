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
        
        <!-- Search bar -->
        <?php include 'assets/php/search.php'; ?>

        <div class="contact">
            <div class="btnContact">
                <?php include 'assets/php/btnConnexion.php'; ?>
            </div>
            
            <div class="indexContent">

                <?php 

                    // Affiche le dernier article
                    $req = $bdd->query('SELECT * FROM article ORDER BY DtCreA DESC LIMIT 1');

                    while ($donnees = $req->fetch())
                    {
                        ?>
                        <img src="assets/uploads/<?php echo $donnees['UrlPhotA'];?>" alt="Image de l'article">
                        <div class="lastPub">
                            <h2>Dernière publication</h2>
                            <p><?php echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y");?></p>
                        </div>
                        <h1><?php echo $donnees['LibTitrA']; ?></h1>
                        <p><?php echo $donnees['LibChapoA'] ?></p>
                        <div class="decouvrir">
                            <a href="articles.php?numArt=<?php echo $donnees['NumArt']; ?>">Découvrir</a>
                        </div>
                        <?php
                    }

                    $req->closeCursor();

                ?>

                <script src="assets/js/script.js"></script>
            </div>
        </div>
    </body>

</html>
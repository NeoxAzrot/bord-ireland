<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include 'assets/php/connect_PDO.php';
    include 'assets/php/dateChangeFormat.php';
    include 'assets/php/ctrlSaisies.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bord'Irlande - BLOG</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>
        <h1>Les articles</h1>

        <?php include 'assets/php/btnConnexion.php'; ?>
        <?php include 'assets/php/menu.php'; ?>

        <?php 

        if(isset($_GET['numArt']) && !empty($_GET['numArt'])) {
            $numArt = ctrlSaisies($_GET['numArt']);

            $req = $bdd->prepare('SELECT * FROM article WHERE NumArt = ?');
            $req->execute(array($numArt));
            $donnees = $req->fetch();

            if(empty($donnees)) {
                header('Location: articles.php');
            } else {
                $nb_like = $donnees['Likes'];

                $req = $bdd->prepare('SELECT COUNT(*) AS nb_comm FROM comment WHERE NumArt = ?');
                $req->execute(array($numArt));
                $donnees = $req->fetch();

                $nb_comment = $donnees['nb_comm'];

                $req = $bdd->prepare('SELECT * FROM article WHERE NumArt = ?');
                $req->execute(array($numArt));
                $donnees = $req->fetch();

                echo $donnees['LibTitrA'] . ' - ';
                echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y");

        ?>

        <h2><?php echo $donnees['Likes'] ?> mention<?php echo $donnees['Likes'] > 1 ? "s" : "" ?> j'aime</h2>
        <h2><?php echo $nb_comment ?> commentaire<?php echo $nb_comment > 1 ? "s" : "" ?></h2>

            <?php

                $req = $bdd->prepare('SELECT * FROM comment WHERE NumArt = ?');
                $req->execute(array($numArt));

                while($donnees = $req->fetch())
                {
                    echo $donnees['PseudoAuteur'] . ' : ' . $donnees['LibCom'] . '<br><br>';
                }

                // Check si l'user est connecté
                if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user'] == true) {
                    $user = true;
                } else {
                    $user = false;
                }

                // Affichage en fonction de si user connecté ou pas
                if($user) {

                    ?>

                    <form action="" method="post">

                        <label for="title_comment">Titre</label>
                        <input type="text" id="title_comment" name="title_comment" placeholder="Sur 60 car." size="60" maxlength="60" required>

                        <label for="comment">Commentaire</label>
                        <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>
                        <input type="submit">

                    </form>

                <?php

                } else {

                ?>
                    
                    <p>Vous devez être connectés pour laisser un commentaire.</p>
                    <a href="inscription.php">S'inscrire</a>
                    <a href="connexion.php">Se connecter</a>

            <?php
                }

            }

            $req->closeCursor();

        } else {
            $req = $bdd->query('SELECT * FROM article ORDER BY DtCreA DESC');

            while ($donnees = $req->fetch())
            {
                echo $donnees['LibTitrA'] . ' - ';
                echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y");
                echo '<br><br>';
                echo "<a href='articles.php?numArt=" . $donnees['NumArt'] . "'>En savoir plus</a>";
                echo '<hr>';
            }

            $req->closeCursor();
        }

        ?>

        <script src="assets/js/script.js"></script>
    </body>

</html>
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

        <!-- Menus -->
        <?php include 'assets/php/menu.php'; ?>

            <div class="btnContact">
                <?php include 'assets/php/btnConnexion.php'; ?>
            </div>

        <div class="SavoirPlus">
        <div class="SavoirPlusContent">
            
            <?php

            // Vérifie si on affiche un article ou tout les articles
            if(isset($_GET['numArt']) && !empty($_GET['numArt'])) {
                $numArt = ctrlSaisies($_GET['numArt']);

                // Vérifie si l'utilisateur a mis un commentaire
                if($_POST) {
                    // Vérifie si tous les input ont été remplis et contrôle la saisie
                    if((isset($_POST['title_comment']) && !empty($_POST['title_comment'])) AND
                    (isset($_POST['comment']) && !empty($_POST['comment']))) {
                        $title_comment = ctrlSaisies($_POST['title_comment']);
                        $comment = ctrlSaisies($_POST['comment']);

                        // Récupère les informations de l'utilisateur
                        $req = $bdd->prepare('SELECT * FROM user WHERE Login = ?');
                        $req->execute(array($_SESSION['login']));
                        $donnees = $req->fetch();

                        $pseudo = $donnees['Login'];
                        $email = $donnees['EMail'];
                        $date_comm = date("Y-m-d H:i:s");

                        // Vérifie si c'est le premier commentaire de la table
                        $req = $bdd->query('SELECT * FROM comment');
                        $donnees = $req->fetch();
            
                        if(empty($donnees)) {
                            // Ajoute le commentaire si c'est le premier de la table
                            $req = $bdd->prepare('INSERT INTO comment(NumCom, DtCreC, PseudoAuteur, EmailAuteur, TitrCom, LibCom, NumArt) VALUES(:NumCom, :DtCreC, :PseudoAuteur, :EmailAuteur, :TitrCom, :LibCom, :NumArt)');
                            $req->execute(array(
                                'NumCom' => "001",
                                'DtCreC' => $date_comm,
                                'PseudoAuteur' => $pseudo,
                                'EmailAuteur' => $email,
                                'TitrCom' => $title_comment,
                                'LibCom' => $comment,
                                'NumArt' => $numArt
                                ));
                        } else {
                            // Récupère la clé primaire maximale du commentaire et lui ajoute 1
                            $req = $bdd->query('SELECT MAX(NumCom) AS NumComMax FROM comment');
                            $donnees = $req->fetch();

                            $comm_max = $donnees['NumComMax'];
                            $comm_max = (int) $comm_max + 1;
                            
                            // Rajoute un 0 devant si on est entre 1 et 9
                            if($comm_max < 10) {
                                $comm_max = "0" . $comm_max;
                            }

                            // Rajoute un 0 devant si on est entre 1 et 99
                            if($comm_max < 100) {
                                $comm_max = "0" . $comm_max;
                            }

                            // Ajoute le commentaire
                            $req = $bdd->prepare('INSERT INTO comment(NumCom, DtCreC, PseudoAuteur, EmailAuteur, TitrCom, LibCom, NumArt) VALUES(:NumCom, :DtCreC, :PseudoAuteur, :EmailAuteur, :TitrCom, :LibCom, :NumArt)');
                            $req->execute(array(
                                'NumCom' => $comm_max,
                                'DtCreC' => $date_comm,
                                'PseudoAuteur' => $pseudo,
                                'EmailAuteur' => $email,
                                'TitrCom' => $title_comment,
                                'LibCom' => $comment,
                                'NumArt' => $numArt
                                ));

                            $req->closeCursor();
                        }
                        // Redirige vers l'article en question
                        header('Location: articles.php?numArt=' . $numArt);
                    }
                }

                // Vérifie que l'article existe
                $req = $bdd->prepare('SELECT * FROM article WHERE NumArt = ?');
                $req->execute(array($numArt));
                $donnees = $req->fetch();

                if(empty($donnees)) {
                    // Redirige si l'article n'existe pas
                    header('Location: articles.php');
                } else {
                    // Récupère le nombre de like et le nombre de commentaire
                    $nb_like = $donnees['Likes'];

                    $req = $bdd->prepare('SELECT COUNT(*) AS nb_comm FROM comment WHERE NumArt = ?');
                    $req->execute(array($numArt));
                    $donnees = $req->fetch();

                    $nb_comment = $donnees['nb_comm'];

                    $req = $bdd->prepare('SELECT * FROM article WHERE NumArt = ?');
                    $req->execute(array($numArt));
                    $donnees = $req->fetch();

                    // Affiche l'article
                    echo "<h1>L'article</h1>";

                    echo $donnees['LibTitrA'] . ' - ';
                    echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y");

            ?>

            <h2><?php echo $donnees['Likes'] ?> mention<?php echo $donnees['Likes'] > 1 ? "s" : "" ?> j'aime</h2>
            <h2><?php echo $nb_comment ?> commentaire<?php echo $nb_comment > 1 ? "s" : "" ?></h2>

                <?php

                    // Check si l'user est connecté
                    if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user'] == true) {
                        $user = true;
                    } else {
                        $user = false;
                    }

                    $req = $bdd->prepare('SELECT * FROM comment WHERE NumArt = ? ORDER BY DtCreC');
                    $req->execute(array($numArt));

                    // Affiche les commentaires et autorise la suppression si c'est l'auteur du commentaire
                    while($donnees = $req->fetch())
                    {
                        echo dateChangeFormat($donnees['DtCreC'], "Y-m-d H:i:s", "d/m/Y H:i:s") . ' - ' . $donnees['PseudoAuteur'] . ' : ' . $donnees['LibCom'] . '<br><br>';
                        if($user) {
                            if($donnees['PseudoAuteur'] == $_SESSION['login']) {
                                echo '<a href="supprimerCom.php?numCom=' . $donnees['NumCom'] . '&numArt=' . $donnees['NumArt'] . '">Supprimer</a>';
                            }
                        }
                    }

                    // Affiche le formulaire de commentaire si l'utilisateur est connecté
                    if($user) {

                        ?>
                        <form action="" method="post">

                            <label for="title_comment">Titre</label>
                            <input type="text" id="title_comment" name="title_comment" placeholder="Sur 60 car." size="60" maxlength="60" required><br><br>

                            <label for="comment">Commentaire</label><br>
                            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>
                            
                            <input type="submit">

                        </form>
        
                    <?php

                    // Affiche des liens pour se connecter sinon
                    } else {

                    ?>
                        
                        <p>Vous devez être connectés pour laisser un commentaire.</p>
                        <a href="inscription.php">S'inscrire</a>
                        <a href="connexion.php">Se connecter</a>
            </div>
        </div>
                <?php
                    }

                }

                $req->closeCursor();

            } else {
                // Affiches tout les articles en ordre décroissant, si on ne précise pas un article
                $req = $bdd->query('SELECT * FROM article ORDER BY DtCreA DESC');

                echo "<h1>Les articles</h1>";

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
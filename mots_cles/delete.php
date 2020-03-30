<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include '../assets/php/connect_PDO.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bord'Irlande - ADMIN</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
    </head>

    <body>
        

        <?php include '../assets/php/menuInAdminShow.php'; ?>
        <div class="thematiques">
            <?php include '../assets/php/menuAdmin.php'; ?>
            <div class="Update">
            <h1>Supprimez le mot clés <span><?php echo $_GET['id']; ?></span>.</h1>

                <div class="UpdateContent"> 
                    <?php

                        if(isset($_GET['id']) && !empty($_GET['id'])) {

                            $req = $bdd->prepare('SELECT * FROM motclearticle WHERE NumMoCle = :id');
                            $req->execute(array(
                                'id' => $_GET['id']
                            ));
                            $donnees = $req->fetch();

                            if(empty($donnees)) {
                                // Supprime le mot clés en utilisant la clés primaire
                                $req = $bdd->prepare('DELETE FROM motcle WHERE NumMoCle = :id');
                                $req->execute(array(
                                    'id' => $_GET['id']
                                ));

                                $req->closeCursor();

                                // Redirection avec un message personnalisé
                                $_SESSION['answer'] = "<span><b>" . $_GET['id'] . "</b> a bien été supprimé !</span>";
                                header('Location: index.php');

                            } else {
                                ?>

                                <?php

                                    $req = $bdd->prepare('SELECT * FROM motclearticle WHERE NumMoCle = :id');
                                    $req->execute(array(
                                        'id' => $_GET['id']
                                    ));

                                ?>

                                <p>Pour supprimer le mot clés <?php echo $_GET['id']; ?>, vous devrez d'abord supprimer le mot clés relié à cette liste (allez dans « Modifier » de l'article en question et supprimer le mot clés) :</p>
                                <ul>

                                <?php

                                while($donnees = $req->fetch())
                                {
                                    echo "<li>Article : " . $donnees['NumArt'] ."</li>";
                                }

                                ?>
                                
                                </ul>

                                <?php
                            }

                        } else {
                            // Redirection avec un message personnalisé
                            $_SESSION['answer'] = "<span>Ce mot clés est introuvable !</span>";
                            header('Location: index.php');
                        }

                    ?>

                    <div class="Margin validerInput">
                        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
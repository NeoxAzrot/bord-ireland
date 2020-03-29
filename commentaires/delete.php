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
            
            <h1>Supprimez le commentaire <span><?php echo $_GET['id']; ?></span>.</h1>
            
            <?php

                // Supprime le commentaire en utilisant la clés primaire
                if(isset($_GET['id']) && !empty($_GET['id'])) {
                    $req = $bdd->prepare('DELETE FROM comment WHERE NumCom = :id');
                    $req->execute(array(
                        'id' => $_GET['id']
                    ));

                    $req->closeCursor();
                    $_SESSION['answer'] = "<span><b>" . $_GET['id'] . "</b> a bien été supprimé !</span>";
                } else {
                    $_SESSION['answer'] = "<span><b>Ce commentaire est introuvable !</span>";
                }

                // Redirection avec un message personnalisé
                header('Location: index.php');

            ?>

            <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
        </div>
    </body>

</html>
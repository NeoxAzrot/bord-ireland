<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include '../assets/php/connect_PDO.php';
    include '../assets/php/ctrlSaisies.php';

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
        <?php

            // Affiche le formulaire seulement la première fois
            if($_POST) {
                // Vérifie si tous les input ont été remplis et contrôle la saisie
                if((isset($_POST['LibThem']) && !empty($_POST['LibThem']))) {
                    $LibThem = ctrlSaisies($_POST['LibThem']);

                    // Met à jour la thématique
                    $req = $bdd->prepare('UPDATE thematique SET LibThem = :LibThem WHERE NumThem = :ID');
                    $req->execute(array(
                        'LibThem' => $LibThem,
                        'ID' => $_GET['id']
                        ));
                        
                    $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

            if(isset($_GET['id']) && !empty($_GET['id'])) {
                $req = $bdd->prepare('SELECT * FROM thematique WHERE NumThem = :id');
                $req->execute(array(
                    'id' => $_GET['id']
                ));

                $donnees = $req->fetch();

                $NumLangThem = $donnees['NumLang'];

                // Affiche le formulaire et le pré remplie que si la thématique existe
                if(!empty($donnees)) {
                    ?>
                        <h1>Modifiez la thématique <span><?php echo $_GET['id']; ?></span>.</h1>

                        <?php include '../assets/php/menuAdmin.php'; ?>
                        <?php include '../assets/php/btnConnexionInAdminShow.php'; ?>
                        <?php include '../assets/php/menuInAdminShow.php'; ?>

                        <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                            <label for="NumThem">ID :</label>
                            <input type="text" id="NumThem" name="NumThem" placeholder="Sur 8 car." size="8" minlength="7" value="<?php echo $donnees['NumThem']; ?>" required disabled>

                            <label for="LibThem">Libellé thématique :</label>
                            <input type="text" id="LibThem" name="LibThem" placeholder="Sur 60 car." size="60" maxlength="60" autofocus="autofocus" value="<?php echo $donnees['LibThem']; ?>" required>

                            <label for="NumLang">NumLang :</label>
                            <select name="NumLang" id="NumLang" required disabled>
                                <option value="" disabled>-- Choisir un pays --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['NumLang']; ?>" <?php echo $donnees['NumLang'] == $NumLangThem ? "selected" : ""; ?>><?php echo $donnees['Lib1Lang']; ?></option>
                                
                                <?php
                                    }

                                    $req->closeCursor();

                                ?>
                            </select>

                            <input type="submit">
                        </form>

                        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                    <?php
                } else {
                    $_SESSION['answer'] = "<span>Cette thématique est introuvable !</span>";

                    // Redirection avec un message personnalisé
                    header('Location: index.php');
                }
            } else {
                // Redirection avec un message personnalisé
                $_SESSION['answer'] = "<span>Cette thématique est introuvable !</span>";
                header('Location: index.php');
            }

        ?>
    </body>

</html>
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
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
    </head>

    <body>
        <?php

            // Affiche le formulaire seulement la première fois
            if($_POST) {
                // Vérifie si tous les input ont été remplis et contrôle la saisie
                if((isset($_POST['num_lang']) && !empty($_POST['num_lang'])) AND
                (isset($_POST['lib_court']) && !empty($_POST['lib_court'])) AND
                (isset($_POST['lib_long']) && !empty($_POST['lib_long'])) AND
                (isset($_POST['pays']) && !empty($_POST['pays']))) {
                    $lib_court = ctrlSaisies($_POST['lib_court']);
                    $lib_long = ctrlSaisies($_POST['lib_long']);
                    $pays = ctrlSaisies($_POST['pays']);
                    $pays = strtoupper($pays);

                    // Met à jour la langue
                    $req = $bdd->prepare('UPDATE langue SET Lib1Lang = :Lib1Lang, Lib2Lang = :Lib2Lang, NumPays = :NumPays WHERE NumLang = :ID');
                    $req->execute(array(
                        'Lib1Lang' => $lib_court,
                        'Lib2Lang' => $lib_long,
                        'NumPays' => $pays,
                        'ID' => $_GET['id']
                        ));
                }

                // Redirection avec un message personnalisé
                $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";
                header('Location: index.php');
            }

            if(isset($_GET['id']) && !empty($_GET['id'])) {
                $req = $bdd->prepare('SELECT * FROM langue WHERE NumLang = :id');
                $req->execute(array(
                    'id' => $_GET['id']
                ));

                $donnees = $req->fetch();

                // Affiche le formulaire et le pré remplie que si la langue existe
                if(!empty($donnees)) {
                    ?>
                        <h1>Modifiez la langue <span><?php echo $_GET['id']; ?></span>.</h1>

                        <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                            <label for="num_lang">ID :</label>
                            <input type="text" id="num_lang" name="num_lang" placeholder="Sur 6 car." size="6" minlength="6" value="<?php echo $donnees['NumLang']; ?>" required disabled>

                            <label for="lib_court">Libellé court :</label>
                            <input type="text" id="lib_court" name="lib_court" placeholder="Sur 25 car." size="25" maxlength="25" autofocus="autofocus" value="<?php echo $donnees['Lib1Lang']; ?>" required>

                            <label for="lib_long">Libellé long :</label>
                            <input type="text" id="lib_long" name="lib_long" placeholder="Sur 45 car." size="45" maxlength="45" value="<?php echo $donnees['Lib2Lang']; ?>" required>

                            <label for="pays">Quel pays :</label>
                            <select name="pays" id="pays" required>
                                <option value="" disabled>-- Choisir un pays --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM pays ORDER BY numPays');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['numPays']; ?>" <?php echo $donnees['numPays'] == str_split($_GET['id'], 4)[0] ? "selected" : ""; ?>><?php echo $donnees['frPays']; ?></option>
                                
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
                    // Permet de renvoyer le message personnalisé quand on change la langue de base. Exemple : ITAL --> FRAN (car l'id n'était plus trouvé)
                    if(isset($_POST['num_lang'])) {
                        $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";
                    } else {
                        $_SESSION['answer'] = "<span>Cette langue est introuvable !</span>";
                    }
                    // Redirection avec un message personnalisé
                    header('Location: index.php');
                }
            } else {
                // Redirection avec un message personnalisé
                $_SESSION['answer'] = "<span>Cette langue est introuvable !</span>";
                header('Location: index.php');
            }

        ?>
    </body>

</html>
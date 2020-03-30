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
                if((isset($_POST['lib_court']) && !empty($_POST['lib_court'])) AND
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
                        
                        <?php include '../assets/php/menuInAdminShow.php'; ?>
                    <div class="thematiques">
                                        <?php include '../assets/php/menuAdmin.php'; ?>
                        <div class="Update">                
                                                <h1>Modifier la langue <span><?php echo $_GET['id']; ?></span>.</h1>
                            <div class="UpdateContent"> 
                                                <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                                                    <div class="Margin"> 
                                                        <label for="num_lang">ID :</label>
                                                        <input type="text" id="num_lang" name="num_lang" placeholder="Identifiant de la langue" size="6" minlength="6" value="<?php echo $donnees['NumLang']; ?>" required disabled><br>
                                                    </div>
                                                    <div class="Margin"> 
                                                        <label for="lib_court">Libellé court :</label>
                                                        <input type="text" id="lib_court" name="lib_court" placeholder="Entrer le nom de la langue" size="25" maxlength="25" autofocus="autofocus" value="<?php echo $donnees['Lib1Lang']; ?>" required><br>
                                                    </div>
                                                    <div class="Margin">
                                                        <label for="lib_long">Libellé long :</label>
                                                        <input type="text" id="lib_long" name="lib_long" placeholder="Entrer le nom de la langue" size="45" maxlength="45" value="<?php echo $donnees['Lib2Lang']; ?>" required><br>
                                                    </div>
                                                    <div class="Margin">
                                                        <label for="pays">Pays :</label>
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
                                                        </select><br>
                                                    </div>
                                                    <div class="validerInput">
                                                        <input type="submit">
                                                    </div>
                                                </form>
                                            <div class="Margin validerInput">
                                                <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                                            </div>
                                            <?php
                                        } else {
                                            $_SESSION['answer'] = "<span>Cette langue est introuvable !</span>";

                                            // Redirection avec un message personnalisé
                                            header('Location: index.php');
                                        }
                                    } else {
                                        // Redirection avec un message personnalisé
                                        $_SESSION['answer'] = "<span>Cette langue est introuvable !</span>";
                                        header('Location: index.php');
                                    }

                                ?>
                            </div>
                        </div>
                    </div>
    </body>

</html>
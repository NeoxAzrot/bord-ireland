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
                if((isset($_POST['LibMoCle']) && !empty($_POST['LibMoCle'])) AND
                (isset($_POST['NumLang']) && !empty($_POST['NumLang']))) {
                    $LibMoCle = ctrlSaisies($_POST['LibMoCle']);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);

                    $req = $bdd->query('SELECT * FROM motcle WHERE NumLang = "' . $NumLang . '"');
                    $donnees = $req->fetch();
        
                    // Vérifie si le mot clés existe déjà
                    if(empty($donnees)) {
                        // Récupère la clé primaire maximale du mot clés et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumMoCle) AS NumMoCleMax FROM motcle');
                        $donnees = $req->fetch();

                        $NumMoCle_split = str_split($donnees['NumMoCleMax'], 4);
                        $NumMoCle_split_id = str_split($NumMoCle_split[1], 2);
                        $NumMoCle_next_id = (int) $NumMoCle_split_id[0] + 1;

                        // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : MTCL2 et non MTCL02
                        if($NumMoCle_next_id < 10) {
                            $NumMoCle_next_id = "0" . $NumMoCle_next_id;
                        }

                        $req = $bdd->prepare('INSERT INTO motcle(NumMoCle, LibMoCle, NumLang) VALUES(:NumMoCle, :LibMoCle, :NumLang)');
                        $req->execute(array(
                            'NumMoCle' => "MTCL" . $NumMoCle_next_id . "01",
                            'LibMoCle' => $LibMoCle,
                            'NumLang' => $NumLang
                            ));

                        $_SESSION['answer'] = "<b>" . "MTCL" . $NumMoCle_next_id . "01" . "</b> vient d'être ajouté à la table !";
                    } else {
                        // Récupère la clé primaire maximale du mot clés par rapport à la langue et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumMoCle) AS NumMoCleMax FROM motcle WHERE NumLang = "' . $NumLang . '"');
                        $donnees = $req->fetch();

                        $NumMoCle_split = str_split($donnees['NumMoCleMax'], 4);
                        $NumMoCle_split_id = str_split($NumMoCle_split[1], 2);
                        $NumMoCle_next_id = (int) $NumMoCle_split_id[1] + 1;
                        
                        // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : MTCL2 et non MTCL02
                        if($NumMoCle_next_id < 10) {
                            $NumMoCle_next_id = "0" . $NumMoCle_next_id;
                        }

                        // Ajoute le mot clés
                        $req = $bdd->prepare('INSERT INTO motcle(NumMoCle, LibMoCle, NumLang) VALUES(:NumMoCle, :LibMoCle, :NumLang)');
                        $req->execute(array(
                            'NumMoCle' => "MTCL" . $NumMoCle_split_id[0] . $NumMoCle_next_id,
                            'LibMoCle' => $LibMoCle,
                            'NumLang' => $NumLang
                            ));

                        $_SESSION['answer'] = "<b>" . "MTCL" . $NumMoCle_split_id[0] . $NumMoCle_next_id . "</b> vient d'être ajouté à la table !";

                        $req->closeCursor();
                    }

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

        ?>
        
        <h1>Ajoutez un mot clés.</h1>

        <?php include '../assets/php/menuAdmin.php'; ?>
        <?php include '../assets/php/btnConnexionInAdminShow.php'; ?>
        <?php include '../assets/php/menuInAdminShow.php'; ?>

        <form action="new.php" method="POST">
            <label for="LibMoCle">Libellé mot clés :</label>
            <input type="text" id="LibMoCle" name="LibMoCle" placeholder="Sur 30 car." size="30" maxlength="30" autofocus="autofocus" required>

            <label for="NumLang">NumLang :</label>
            <select name="NumLang" id="NumLang" required>
                <option value="" disabled selected>-- Choisir une langue --</option>
                <?php 
                
                    $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                    while($donnees = $req->fetch()) {
                ?>

                        <option value="<?php echo $donnees['NumLang']; ?>"><?php echo $donnees['Lib1Lang']; ?></option>
                
                <?php
                    }

                    $req->closeCursor();

                ?>
            </select>

            <input type="submit">
        </form>

        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
    </body>

</html>
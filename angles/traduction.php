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
                if((isset($_POST['NumAngl']) && !empty($_POST['NumAngl'])) AND
                (isset($_POST['LibAngl']) && !empty($_POST['LibAngl'])) AND
                (isset($_POST['NumLang']) && !empty($_POST['NumLang']))) {
                    $NumAngl = ctrlSaisies($_POST['NumAngl']);
                    $NumAngl = strtoupper($NumAngl);
                    $LibAngl = ctrlSaisies($_POST['LibAngl']);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);

                    $req = $bdd->query('SELECT * FROM angle WHERE NumAngl = "' . $NumAngl . '"');
                    $donnees = $req->fetch();
        
                    // Vérifie si l'angle existe déjà
                    if(!empty($donnees)) {
                        $NumAngl_split = str_split($donnees['NumAngl'], 4);
                        $NumAngl_split_id = str_split($NumAngl_split[1], 2);

                        // Récupère la clé primaire maximale de l'angle et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumAngl) AS NumAnglMax FROM angle WHERE NumAngl LIKE "' . $NumAngl_split[0] . $NumAngl_split_id[0] . '%"');
                        $donnees = $req->fetch();

                        $NumAngl_split = str_split($donnees['NumAnglMax'], 4);
                        $NumAngl_split_id = str_split($NumAngl_split[1], 2);
                        $NumAngl_next_id = (int) $NumAngl_split_id[1] + 1;
                        
                        // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : ANGL2 et non ANGL02
                        if($NumAngl_next_id < 10) {
                            $NumAngl_next_id = "0" . $NumAngl_next_id;
                        }

                        $req = $bdd->prepare('SELECT * FROM angle WHERE NumAngl LIKE :NumAngl AND NumLang = :NumLang');
                        $req->execute(array(
                            'NumAngl' => $NumAngl_split[0] . $NumAngl_split_id[0] . "%",
                            'NumLang' => $NumLang
                        ));
                        $donnees = $req->fetch();

                        if(empty($donnees)) {
                            // Ajoute l'angle
                            $req = $bdd->prepare('INSERT INTO angle(NumAngl, LibAngl, NumLang) VALUES(:NumAngl, :LibAngl, :NumLang)');
                            $req->execute(array(
                                'NumAngl' => $NumAngl_split[0] . $NumAngl_split_id[0] . $NumAngl_next_id,
                                'LibAngl' => $LibAngl,
                                'NumLang' => $NumLang
                                ));

                            $_SESSION['answer'] = "<b>" . $NumAngl . "</b> vient d'être traduit !";

                            $req->closeCursor();
                        } else {
                            $_SESSION['answer'] = "<span><b>La traduction de " . $NumAngl . "</b> en <b>" . $NumLang . "</b> existe déjà !</span>";
                        }

                    }

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

        ?>
        
        
        <?php include '../assets/php/menuInAdminShow.php'; ?>
        <div class="thematiques">
            <?php include '../assets/php/menuAdmin.php'; ?>
            <div class="Update">
                    <h1>Traduire un angle.</h1>
                    <div class="UpdateContent"> 
                        <form action="traduction.php" method="POST">
                            <div class="Margin">
                                <label for="NumAngl">Angle :</label>
                                <select name="NumAngl" id="NumAngl" required autofocus="autofocus">
                                    <option value="" disabled selected>-- Choisir un angle --</option>
                                    <?php 
                                    
                                        $req = $bdd->query('SELECT * FROM angle WHERE NumAngl LIKE "%01" ORDER BY NumAngl');

                                        while($donnees = $req->fetch()) {
                                    ?>

                                            <option value="<?php echo $donnees['NumAngl']; ?>"><?php echo $donnees['LibAngl']; ?></option>
                                    
                                    <?php
                                        }

                                        $req->closeCursor();

                                    ?>
                                </select><br>
                            </div>
                            <div class="Margin">
                                <label for="LibAngl">Traduction de l'angle :</label>
                                <input type="text" id="LibAngl" name="LibAngl" placeholder="Traduire l'angle" size="60" maxlength="60" required><br>
                            </div>
                            <div class="Margin">
                                <label for="NumLang">Langue :</label>
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
                            </div>
                            <div class="validerInput">
                                <input type="submit">
                            </div>
                        </form>
                    <div class="Margin validerInput">
                        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
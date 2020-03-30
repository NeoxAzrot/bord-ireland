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
                if((isset($_POST['LibThem']) && !empty($_POST['LibThem'])) AND
                (isset($_POST['NumLang']) && !empty($_POST['NumLang']))) {
                    $LibThem = ctrlSaisies($_POST['LibThem']);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);

                    $req = $bdd->query('SELECT * FROM thematique WHERE NumLang = "' . $NumLang . '"');
                    $donnees = $req->fetch();
        
                    // Vérifie si la thématique existe déjà
                    if(empty($donnees)) {
                        // Récupère la clé primaire maximale de la thématique et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumThem) AS NumThemMax FROM thematique');
                        $donnees = $req->fetch();

                        $NumThem_split = str_split($donnees['NumThemMax'], 3);
                        $NumThem_split_id = str_split($NumThem_split[1] . $NumThem_split[2], 2);
                        $NumThem_next_id = (int) $NumThem_split_id[0] + 1;

                        // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : THE2 et non THE02
                        if($NumThem_next_id < 10) {
                            $NumThem_next_id = "0" . $NumThem_next_id;
                        }

                        $req = $bdd->prepare('INSERT INTO thematique(NumThem, LibThem, NumLang) VALUES(:NumThem, :LibThem, :NumLang)');
                        $req->execute(array(
                            'NumThem' => "THE" . $NumThem_next_id . "01",
                            'LibThem' => $LibThem,
                            'NumLang' => $NumLang
                            ));

                        $_SESSION['answer'] = "<b>" . "THE" . $NumThem_next_id . "01" . "</b> vient d'être ajouté à la table !";
                    } else {
                        // Récupère la clé primaire maximale de la thématique par rapport à la langue et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumThem) AS NumThemMax FROM thematique WHERE NumLang = "' . $NumLang . '"');
                        $donnees = $req->fetch();

                        $NumThem_split = str_split($donnees['NumThemMax'], 3);
                        $NumThem_split_id = str_split($NumThem_split[1] . $NumThem_split[2], 2);
                        $NumThem_next_id = (int) $NumThem_split_id[1] + 1;
                        
                        // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : THE2 et non THE02
                        if($NumThem_next_id < 10) {
                            $NumThem_next_id = "0" . $NumThem_next_id;
                        }

                        // Ajoute la thématique
                        $req = $bdd->prepare('INSERT INTO thematique(NumThem, LibThem, NumLang) VALUES(:NumThem, :LibThem, :NumLang)');
                        $req->execute(array(
                            'NumThem' => "THE" . $NumThem_split_id[0] . $NumThem_next_id,
                            'LibThem' => $LibThem,
                            'NumLang' => $NumLang
                            ));

                        $_SESSION['answer'] = "<b>" . "THE" . $NumThem_split_id[0] . $NumThem_next_id . "</b> vient d'être ajouté à la table !";

                        $req->closeCursor();
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
                <h1>Ajouter une thématique.</h1>

                <div class="UpdateContent">    
                    <form action="new.php" method="POST">
                        <div class="Margin">
                            <label for="LibThem">Thématique :</label>
                            <input type="text" id="LibThem" name="LibThem" placeholder="Entrer votre thématique" size="60" maxlength="60" autofocus="autofocus" required><br>
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
                        <br>

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
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        
        <h1>Ajoutez un article.</h1>

        <?php include '../assets/php/menuAdmin.php'; ?>
        <?php include '../assets/php/btnConnexionInAdminShow.php'; ?>
        <?php include '../assets/php/menuInAdminShow.php'; ?>

        <form action="new.php" method="POST">
            <label for="DtCreA">Date de l'article :</label>
            <input type="date" id="DtCreA" name="DtCreA" autofocus="autofocus" required>

            <label for="LibTitrA">Libellé titre :</label>
            <textarea name="LibTitrA" id="LibTitrA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>
                       
            <label for="LibChapoA">Libellé chapo :</label>
            <textarea name="LibChapoA" id="LibChapoA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="LibAccrochA">Libellé accroche :</label>
            <textarea name="LibAccrochA" id="LibAccrochA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="Parag1A">Libellé paragraphe 1 :</label>
            <textarea name="Parag1A" id="Parag1A" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="LibSsTitr1">Libellé sous-titre 1 :</label>
            <textarea name="LibSsTitr1" id="LibSsTitr1" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="Parag2A">Libellé paragraphe 2 :</label>
            <textarea name="Parag2A" id="Parag2A" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="LibSsTitr2">Libellé sous-titre 2 :</label>
            <textarea name="LibSsTitr2" id="LibSsTitr2" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="Parag3A">Libellé paragraphe 3 :</label>
            <textarea name="Parag3A" id="Parag3A" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="LibConclA">Libellé conlusion :</label>
            <textarea name="LibConclA" id="LibConclA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="UrlPhotA">URL photo :</label>
            <input type="text" id="UrlPhotA" name="UrlPhotA" placeholder="Sur 62 car." size="62" maxlength="62" required>

            <label for="NumAngl">NumAngl :</label>
            <select name="NumAngl" id="NumAngl" required>
                <option value="" disabled selected>-- Choisir un angle --</option>
                <?php 
                
                    $req = $bdd->query('SELECT * FROM angle ORDER BY NumAngl');

                    while($donnees = $req->fetch()) {
                ?>

                        <option value="<?php echo $donnees['NumAngl']; ?>"><?php echo $donnees['LibAngl']; ?></option>
                
                <?php
                    }

                    $req->closeCursor();

                ?>
            </select>

            <label for="NumThem">NumThem :</label>
            <select name="NumThem" id="NumThem" required>
                <option value="" disabled selected>-- Choisir une thématique --</option>
                <?php 
                
                    $req = $bdd->query('SELECT * FROM thematique ORDER BY NumThem');

                    while($donnees = $req->fetch()) {
                ?>

                        <option value="<?php echo $donnees['NumThem']; ?>"><?php echo $donnees['LibThem']; ?></option>
                
                <?php
                    }

                    $req->closeCursor();

                ?>
            </select>

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

            <!-- Génération mot clés avec JavaScript -->
            <div id="MotCleJS">
                <div class="MotCleContainer">
                    <label for="MotCle">Mot clés :</label>
                    <select name="MotCle[]" id="MotCle" required>
                        <option value="" disabled selected>-- Choisir un mot clés --</option>
                        <?php 
                        
                            $req = $bdd->query('SELECT * FROM motcle ORDER BY NumMoCle');

                            while($donnees = $req->fetch()) {
                        ?>

                                <option value="<?php echo $donnees['NumMoCle']; ?>"><?php echo $donnees['LibMoCle']; ?></option>
                        
                        <?php
                            }

                            $req->closeCursor();

                        ?>
                    </select>

                    <button type="button" class="removeMotCleJS" onclick="$(this).parents('.MotCleContainer').remove();">Supprimer <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <button type="button" class="addMotCleJS">Ajouter un mot clés <i class="fas fa-plus"></i></button>

            <input type="submit">
        </form>

        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>

        <script src="../assets/js/script.js"></script>
    </body>

</html>
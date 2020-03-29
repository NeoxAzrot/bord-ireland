<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    ini_set('upload_max_filesize', '10M');

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
                if((isset($_POST['DtCreA']) && !empty($_POST['DtCreA'])) AND
                (isset($_POST['LibTitrA']) && !empty($_POST['LibTitrA'])) AND
                (isset($_POST['LibChapoA']) && !empty($_POST['LibChapoA'])) AND
                (isset($_POST['LibAccrochA']) && !empty($_POST['LibAccrochA'])) AND
                (isset($_POST['Parag1A']) && !empty($_POST['Parag1A'])) AND
                (isset($_POST['LibSsTitr1']) && !empty($_POST['LibSsTitr1'])) AND
                (isset($_POST['Parag2A']) && !empty($_POST['Parag2A'])) AND
                (isset($_POST['LibSsTitr2']) && !empty($_POST['LibSsTitr2'])) AND
                (isset($_POST['Parag3A']) && !empty($_POST['Parag3A'])) AND
                (isset($_POST['LibConclA']) && !empty($_POST['LibConclA'])) AND
                (isset($_FILES["UrlPhotA"]) && !empty($_FILES["UrlPhotA"])) AND
                (isset($_POST['NumAngl']) && !empty($_POST['NumAngl'])) AND
                (isset($_POST['NumThem']) && !empty($_POST['NumThem'])) AND
                (isset($_POST['NumLang']) && !empty($_POST['NumLang'])) AND
                (isset($_POST['MotCle']) && !empty($_POST['MotCle']))) {
                    $DtCreA = ctrlSaisies($_POST['DtCreA']);
                    $LibTitrA = ctrlSaisies($_POST['LibTitrA']);
                    $LibChapoA = ctrlSaisies($_POST['LibChapoA']);
                    $LibAccrochA = ctrlSaisies($_POST['LibAccrochA']);
                    $Parag1A = ctrlSaisies($_POST['Parag1A']);
                    $LibSsTitr1 = ctrlSaisies($_POST['LibSsTitr1']);
                    $Parag2A = ctrlSaisies($_POST['Parag2A']);
                    $LibSsTitr2 = ctrlSaisies($_POST['LibSsTitr2']);
                    $Parag3A = ctrlSaisies($_POST['Parag3A']);
                    $LibConclA = ctrlSaisies($_POST['LibConclA']);
                    $NumAngl = ctrlSaisies($_POST['NumAngl']);
                    $NumAngl = strtoupper($NumAngl);
                    $NumThem = ctrlSaisies($_POST['NumThem']);
                    $NumThem = strtoupper($NumThem);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);
                    $MotCle = $_POST['MotCle']; // On ne peut pas controler la saisie de tout l'array (on doit faire cas par cas)
                    $NbMotCle = count($MotCle);

                    $uploadIsOk = true;

                    // Upload l'image
                    $uploads_dir = '../assets/uploads';

                    $path = $_FILES['UrlPhotA']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $tmp_name = $_FILES["UrlPhotA"]["tmp_name"];

                    // Vérifie la taille du fichier
                    if ($_FILES["UrlPhotA"]["size"] > 10000000) { // 10 Mo
                        $_SESSION['answer'] = "<span>L'article n'a pas pu être ajouté à la table car l'image faisait plus de 10 Mo !</span>";
                        $uploadIsOk = false;
                    }

                    // Vérifie si il y a une erreur
                    if ($_FILES["UrlPhotA"]["error"] > 0) {
                        $_SESSION['answer'] = "<span>L'article n'a pas pu être ajouté à la table. La mise en ligne de l'image a rencontré une erreur !</span>";
                        $uploadIsOk = false;
                    }

                    if($uploadIsOk) {

                        $req = $bdd->query('SELECT * FROM article');
                        $donnees = $req->fetch();

                        // Vérifie si c'est le premier article de la table
                        if(empty($donnees)) {
                            // Change le nom de l'image
                            $name = basename("article01." . $ext); // basename() peut empêcher les attaques de système de fichiers
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");

                            // Ajoute l'article dans la table si c'est le premier
                            $req = $bdd->prepare('INSERT INTO article(NumArt, DtCreA, LibTitrA, LibChapoA, LibAccrochA, Parag1A, LibSsTitr1, Parag2A, LibSsTitr2, Parag3A, LibConclA, UrlPhotA, Likes, NumAngl, NumThem, NumLang)
                                                VALUES(:NumArt, :DtCreA, :LibTitrA, :LibChapoA, :LibAccrochA, :Parag1A, :LibSsTitr1, :Parag2A, :LibSsTitr2, :Parag3A, :LibConclA, :UrlPhotA, :Likes, :NumAngl, :NumThem, :NumLang)');
                            $req->execute(array(
                                'NumArt' => "01",
                                'DtCreA' => $DtCreA,
                                'LibTitrA' => $LibTitrA,
                                'LibChapoA' => $LibChapoA,
                                'LibAccrochA' => $LibAccrochA,
                                'Parag1A' => $Parag1A,
                                'LibSsTitr1' => $LibSsTitr1,
                                'Parag2A' => $Parag2A,
                                'LibSsTitr2' => $LibSsTitr2,
                                'Parag3A' => $Parag3A,
                                'LibConclA' => $LibConclA,
                                'UrlPhotA' => $name,
                                'Likes' => 0,
                                'NumAngl' => $NumAngl,
                                'NumThem' => $NumThem,
                                'NumLang' => $NumLang
                                ));

                            // Ajout des mots clés
                            for($i = 0; $i < $NbMotCle; $i++) {
                                $req = $bdd->prepare('INSERT INTO motclearticle(NumArt, NumMoCle) VALUES(:NumArt, :NumMoCle)');
                                $req->execute(array(
                                    'NumArt' => "01",
                                    'NumMoCle' => $MotCle[$i]
                                    ));
                            }

                            $_SESSION['answer'] = "<b>" . "01" . "</b> vient d'être ajouté à la table !";
                        } else {
                            // Récupère la clé primaire maximale de l'article et lui ajoute 1
                            $req = $bdd->query('SELECT MAX(NumArt) AS NumArtMax FROM article');
                            $donnees = $req->fetch();

                            $NumArt_next_id = (int) $donnees['NumArtMax'] + 1;
                            
                            // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : 2 et non 02
                            if($NumArt_next_id < 10) {
                                $NumArt_next_id = "0" . $NumArt_next_id;
                            }

                            // Change le nom de l'image
                            $name = basename("article" . $NumArt_next_id . "." . $ext); // basename() peut empêcher les attaques de système de fichiers
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");

                            // Ajoute l'article
                            $req = $bdd->prepare('INSERT INTO article(NumArt, DtCreA, LibTitrA, LibChapoA, LibAccrochA, Parag1A, LibSsTitr1, Parag2A, LibSsTitr2, Parag3A, LibConclA, UrlPhotA, Likes, NumAngl, NumThem, NumLang)
                                                VALUES(:NumArt, :DtCreA, :LibTitrA, :LibChapoA, :LibAccrochA, :Parag1A, :LibSsTitr1, :Parag2A, :LibSsTitr2, :Parag3A, :LibConclA, :UrlPhotA, :Likes, :NumAngl, :NumThem, :NumLang)');
                            $req->execute(array(
                                'NumArt' => $NumArt_next_id,
                                'DtCreA' => $DtCreA,
                                'LibTitrA' => $LibTitrA,
                                'LibChapoA' => $LibChapoA,
                                'LibAccrochA' => $LibAccrochA,
                                'Parag1A' => $Parag1A,
                                'LibSsTitr1' => $LibSsTitr1,
                                'Parag2A' => $Parag2A,
                                'LibSsTitr2' => $LibSsTitr2,
                                'Parag3A' => $Parag3A,
                                'LibConclA' => $LibConclA,
                                'UrlPhotA' => $name,
                                'Likes' => 0,
                                'NumAngl' => $NumAngl,
                                'NumThem' => $NumThem,
                                'NumLang' => $NumLang
                                ));

                            // Ajout des mots clés
                            for($i = 0; $i < $NbMotCle; $i++) {
                                $req = $bdd->prepare('INSERT INTO motclearticle(NumArt, NumMoCle) VALUES(:NumArt, :NumMoCle)');
                                $req->execute(array(
                                    'NumArt' => $NumArt_next_id,
                                    'NumMoCle' => $MotCle[$i]
                                    ));
                            }

                            $_SESSION['answer'] = "<b>" . $NumArt_next_id . "</b> vient d'être ajouté à la table !";
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
            <div class="article1">
                        <h1>Ajoutez un article.</h1>
                <div class="UpdateContent">
                        <form action="new.php" method="POST" enctype="multipart/form-data">
                            <label for="DtCreA">Date de l'article :</label> 
                            <input type="date" id="DtCreA" name="DtCreA" autofocus="autofocus" required><br><br>

                            <label for="LibTitrA">Libellé titre :</label><br>
                            <textarea name="LibTitrA" id="LibTitrA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>
                                    
                            <label for="LibChapoA">Libellé chapo :</label><br>
                            <textarea name="LibChapoA" id="LibChapoA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="LibAccrochA">Libellé accroche :</label><br>
                            <textarea name="LibAccrochA" id="LibAccrochA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="Parag1A">Libellé paragraphe 1 :</label><br>
                            <textarea name="Parag1A" id="Parag1A" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="LibSsTitr1">Libellé sous-titre 1 :</label><br>
                            <textarea name="LibSsTitr1" id="LibSsTitr1" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="Parag2A">Libellé paragraphe 2 :</label><br>
                            <textarea name="Parag2A" id="Parag2A" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="LibSsTitr2">Libellé sous-titre 2 :</label><br>
                            <textarea name="LibSsTitr2" id="LibSsTitr2" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="Parag3A">Libellé paragraphe 3 :</label><br>
                            <textarea name="Parag3A" id="Parag3A" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="LibConclA">Libellé conlusion :</label><br>
                            <textarea name="LibConclA" id="LibConclA" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea><br><br>

                            <label for="UrlPhotA">URL photo (10 Mo. MAX) :</label><br>
                            <input type="file" id="UrlPhotA" name="UrlPhotA" accept="image/*" required><br><br>

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
                            </select><br><br>

                            <label for="NumAngl">NumAngl :</label>
                            <select name="NumAngl" id="NumAngl" required>
                                <option value="" disabled selected>-- Choisir un angle --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM angle ORDER BY NumAngl');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['NumAngl']; ?>" data-lang="<?php echo $donnees['NumLang']; ?>"><?php echo $donnees['LibAngl']; ?></option>
                                
                                <?php
                                    }

                                    $req->closeCursor();

                                ?>
                            </select><br><br>

                            <label for="NumThem">NumThem :</label>
                            <select name="NumThem" id="NumThem" required>
                                <option value="" disabled selected>-- Choisir une thématique --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM thematique ORDER BY NumThem');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['NumThem']; ?>" data-lang="<?php echo $donnees['NumLang']; ?>"><?php echo $donnees['LibThem']; ?></option>
                                
                                <?php
                                    }

                                    $req->closeCursor();

                                ?>
                            </select><br><br>

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
                                    </select><br>

                                    <button type="button" class="removeMotCleJS" onclick="$(this).parents('.MotCleContainer').remove();">Supprimer <i class="fas fa-minus"></i></button><br>
                                </div>
                            </div>
                            <br>
                            <button type="button" class="addMotCleJS">Ajouter un mot clés <i class="fas fa-plus"></i></button><br>
                            <br>
                            <input type="submit">
                        </form>
                        <br>
                        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>

                        <script src="../assets/js/script.js"></script>
                </div>
            </div>
        </div>
    </body>

</html>
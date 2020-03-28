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
                (isset($_POST['Likes'])) AND
                (isset($_POST['NumAngl']) && !empty($_POST['NumAngl'])) AND
                (isset($_POST['NumThem']) && !empty($_POST['NumThem'])) AND
                (isset($_POST['NumLang']) && !empty($_POST['NumLang']))) {
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
                    $Likes = ctrlSaisies($_POST['Likes']);
                    $NumAngl = ctrlSaisies($_POST['NumAngl']);
                    $NumAngl = strtoupper($NumAngl);
                    $NumThem = ctrlSaisies($_POST['NumThem']);
                    $NumThem = strtoupper($NumThem);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);

                    if($Likes < 0) {
                        $Likes = 0;
                    }

                    // Récupère le nom de la photo si on upload pas
                    $req = $bdd->prepare('SELECT UrlPhotA FROM article WHERE NumArt = ?');
                    $req->execute(array($_GET['id']));
                    $donnees = $req->fetch();

                    $name = $donnees['UrlPhotA'];

                    // Vérifie si une image a été upload ou non
                    $uploadIsOk = true;
                    $changeIsOk = true;

                    if(isset($_FILES["UrlPhotA"]) && !empty($_FILES["UrlPhotA"])) {
                        // Upload l'image
                        $uploads_dir = '../assets/uploads';

                        $path = $_FILES['UrlPhotA']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $tmp_name = $_FILES["UrlPhotA"]["tmp_name"];

                        // Vérifie la taille du fichier
                        if ($_FILES["UrlPhotA"]["size"] > 10000000) { // 10 Mo
                            $_SESSION['answer'] = "<span>L'article n'a pas pu être modifé car l'image faisait plus de 10 Mo !</span>";
                            $uploadIsOk = false;
                            $changeIsOk = false;
                        }

                        // Vérifie si il y a une erreur
                        if ($_FILES["UrlPhotA"]["error"] > 0) {
                            // On vérifie si c'est une autre erreur que "Un fichier n'a pas été téléchargé", ce qui est normal
                            if($_FILES["UrlPhotA"]["error"] != 4) {
                                $_SESSION['answer'] = "<span>L'article n'a pas pu être modifé. La mise en ligne de l'image a rencontré une erreur !</span>";
                                $uploadIsOk = false;
                            }
                            $changeIsOk = false;
                        }
                    }

                    if($uploadIsOk) {
                        if($changeIsOk) {
                            // Supprime l'ancienne image
                            unlink("$uploads_dir/$name");

                            // Change le nom de l'image si on a upload une
                            $name = basename("article" . $_GET['id'] . "." . $ext); // basename() peut empêcher les attaques de système de fichiers
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");
                        }

                        // Met à jour l'article
                        $req = $bdd->prepare('UPDATE article SET DtCreA = :DtCreA, LibTitrA = :LibTitrA, LibChapoA = :LibChapoA, LibAccrochA = :LibAccrochA, Parag1A = :Parag1A,
                                                                LibSsTitr1 = :LibSsTitr1, Parag2A = :Parag2A, LibSsTitr2 = :LibSsTitr2, Parag3A = :Parag3A, LibConclA = :LibConclA,
                                                                UrlPhotA = :UrlPhotA, Likes = :Likes, NumAngl = :NumAngl, NumThem = :NumThem, NumLang = :NumLang WHERE NumArt = :ID');
                        $req->execute(array(
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
                            'Likes' => $Likes,
                            'NumAngl' => $NumAngl,
                            'NumThem' => $NumThem,
                            'NumLang' => $NumLang,
                            'ID' => $_GET['id']
                            ));
                            
                        $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";
                    }

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

            if(isset($_GET['id']) && !empty($_GET['id'])) {
                $req = $bdd->prepare('SELECT * FROM article WHERE NumArt = :id');
                $req->execute(array(
                    'id' => $_GET['id']
                ));

                $donnees = $req->fetch();

                $NumLangArt = $donnees['NumLang'];
                $NumAnglArt = $donnees['NumAngl'];
                $NumThemArt = $donnees['NumThem'];

                // Affiche le formulaire et le pré remplie que si l'article existe
                if(!empty($donnees)) {
                    ?>
                        
                        <?php include '../assets/php/menuInAdminShow.php'; ?>
                        <?php include '../assets/php/menuAdmin.php'; ?>
                        
                        <h1>Modifiez l'article <span><?php echo $_GET['id']; ?></span>.</h1>
                        
                        <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
                            <label for="NumArt">NumArt :</label>
                            <input type="text" id="NumArt" name="NumArt" placeholder="Sur 6 car." size="6" maxlength="6" value="<?php echo $donnees['NumArt']; ?>" required disabled>

                            <label for="DtCreA">Date de l'article :</label>
                            <input type="date" id="DtCreA" name="DtCreA" autofocus="autofocus" value="<?php echo $donnees['DtCreA']; ?>" required>

                            <label for="LibTitrA">Libellé titre :</label>
                            <textarea name="LibTitrA" id="LibTitrA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibTitrA']; ?></textarea>
                                    
                            <label for="LibChapoA">Libellé chapo :</label>
                            <textarea name="LibChapoA" id="LibChapoA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibChapoA']; ?></textarea>

                            <label for="LibAccrochA">Libellé accroche :</label>
                            <textarea name="LibAccrochA" id="LibAccrochA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibAccrochA']; ?></textarea>

                            <label for="Parag1A">Libellé paragraphe 1 :</label>
                            <textarea name="Parag1A" id="Parag1A" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['Parag1A']; ?></textarea>

                            <label for="LibSsTitr1">Libellé sous-titre 1 :</label>
                            <textarea name="LibSsTitr1" id="LibSsTitr1" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibSsTitr1']; ?></textarea>

                            <label for="Parag2A">Libellé paragraphe 2 :</label>
                            <textarea name="Parag2A" id="Parag2A" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['Parag2A']; ?></textarea>

                            <label for="LibSsTitr2">Libellé sous-titre 2 :</label>
                            <textarea name="LibSsTitr2" id="LibSsTitr2" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibSsTitr2']; ?></textarea>

                            <label for="Parag3A">Libellé paragraphe 3 :</label>
                            <textarea name="Parag3A" id="Parag3A" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['Parag3A']; ?></textarea>

                            <label for="LibConclA">Libellé conlusion :</label>
                            <textarea name="LibConclA" id="LibConclA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibConclA']; ?></textarea>

                            <label for="Likes">Likes :</label>
                            <input type="number" id="Likes" name="Likes" min="0" placeholder="Nombre de like" value="<?php echo $donnees['Likes']; ?>" required>

                            <label for="UrlPhotA">Remplir seulement si vous voulez changer l'image (10 Mo. MAX) :</label>
                            <input type="file" id="UrlPhotA" name="UrlPhotA" accept="image/*">

                            <label for="NumLang">NumLang :</label>
                            <select name="NumLang" id="NumLang" required>
                                <option value="" disabled selected>-- Choisir une langue --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['NumLang']; ?>" <?php echo $donnees['NumLang'] == $NumLangArt ? "selected" : ""; ?>><?php echo $donnees['Lib1Lang']; ?></option>
                                
                                <?php
                                    }

                                    $req->closeCursor();

                                ?>
                            </select>

                            <label for="NumAngl">NumAngl :</label>
                            <select name="NumAngl" id="NumAngl" required>
                                <option value="" disabled selected>-- Choisir un angle --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM angle ORDER BY NumAngl');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['NumAngl']; ?>" data-lang="<?php echo $donnees['NumLang']; ?>" <?php echo $donnees['NumAngl'] == $NumAnglArt ? "selected" : ""; ?>><?php echo $donnees['LibAngl']; ?></option>
                                
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

                                        <option value="<?php echo $donnees['NumThem']; ?>" data-lang="<?php echo $donnees['NumLang']; ?>" <?php echo $donnees['NumThem'] == $NumThemArt ? "selected" : ""; ?>><?php echo $donnees['LibThem']; ?></option>
                                
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
                    $_SESSION['answer'] = "<span>Cet article est introuvable !</span>";

                    // Redirection avec un message personnalisé
                    header('Location: index.php');
                }
            } else {
                // Redirection avec un message personnalisé
                $_SESSION['answer'] = "<span>Cet article est introuvable !</span>";
                header('Location: index.php');
            }

        ?>

        <script src="../assets/js/script.js"></script>
    </body>

</html>
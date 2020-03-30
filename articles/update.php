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
                    $Likes = ctrlSaisies($_POST['Likes']);
                    $NumAngl = ctrlSaisies($_POST['NumAngl']);
                    $NumAngl = strtoupper($NumAngl);
                    $NumThem = ctrlSaisies($_POST['NumThem']);
                    $NumThem = strtoupper($NumThem);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);
                    $MotCle = $_POST['MotCle']; // On ne peut pas controler la saisie de tout l'array (on doit faire cas par cas)
                    $NbMotCle = count($MotCle);

                    // Supprime tous les mots clés reliés avant de les remettre
                    $req = $bdd->prepare('DELETE FROM motclearticle WHERE NumArt = :id');
                    $req->execute(array(
                        'id' => $_GET['id']
                    ));

                    // Ajoute tous les mots clés de l'article
                    for($i = 0; $i < $NbMotCle; $i++)
                    {
                        $req = $bdd->prepare('INSERT INTO motclearticle(NumArt, NumMoCle) VALUES(:NumArt, :NumMoCle)');
                        $req->execute(array(
                            'NumArt' => $_GET['id'],
                            'NumMoCle' => $MotCle[$i]
                            ));
                    }

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

                } else {
                    $_SESSION['answer'] = "Un mot clés est obligatoire par article pour le référencement dans le blog !";
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

                // Récupère le nombre de mots clés
                $reqMotClesArticle = $bdd->prepare('SELECT COUNT(*) AS nbMotCle FROM motclearticle WHERE NumArt = ?');
                $reqMotClesArticle->execute(array($_GET['id']));
                $donneesMotClesArticle = $reqMotClesArticle->fetch();

                $nbMotCle = $donneesMotClesArticle['nbMotCle'];

                // Les mets dans un tableau pour la suite
                $reqMotCles = $bdd->prepare('SELECT * FROM motclearticle WHERE NumArt = ?');
                $reqMotCles->execute(array($_GET['id']));
                $arrayMotCles = array();
                while($donneesMotCles = $reqMotCles->fetch())
                {
                    array_push($arrayMotCles, $donneesMotCles['NumMoCle']);
                }

                $NumLangArt = $donnees['NumLang'];
                $NumAnglArt = $donnees['NumAngl'];
                $NumThemArt = $donnees['NumThem'];

                // Affiche le formulaire et le pré remplie que si l'article existe
                if(!empty($donnees)) {
                    ?>
                        
                        <?php include '../assets/php/menuInAdminShow.php'; ?>
                        <div class="thematiques">
                                            <?php include '../assets/php/menuAdmin.php'; ?>
                            <div class="article1">
                                            <h1>Modifier l'article <span><?php echo $_GET['id']; ?></span>.</h1><br>
                                <div class="UpdateContent">             
                                            <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
                                                <div class="Margin">
                                                    <label for="NumArt">ID :</label>
                                                    <input type="text" id="NumArt" name="NumArt" placeholder="Identifiant de l'article" size="6" maxlength="6" value="<?php echo $donnees['NumArt']; ?>" required disabled><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="DtCreA">Date :</label>
                                                    <input type="date" id="DtCreA" name="DtCreA" autofocus="autofocus" value="<?php echo $donnees['DtCreA']; ?>" required><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="LibTitrA">Libellé titre :</label><br>
                                                    <textarea name="LibTitrA" id="LibTitrA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibTitrA']; ?></textarea><br><br>
                                                </div>    
                                                
                                                <div class="Margin">
                                                    <label for="LibChapoA">Libellé chapo :</label><br>
                                                    <textarea name="LibChapoA" id="LibChapoA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibChapoA']; ?></textarea><br><br>
                                                </div> 

                                                <div class="Margin">
                                                    <label for="LibAccrochA">Libellé accroche :</label><br>
                                                    <textarea name="LibAccrochA" id="LibAccrochA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibAccrochA']; ?></textarea><br><br>
                                                </div> 

                                                <div class="Margin">
                                                    <label for="Parag1A">Libellé paragraphe 1 :</label><br>
                                                    <textarea name="Parag1A" id="Parag1A" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['Parag1A']; ?></textarea><br><br>
                                                </div> 

                                                <div class="Margin">
                                                    <label for="LibSsTitr1">Libellé sous-titre 1 :</label><br>
                                                    <textarea name="LibSsTitr1" id="LibSsTitr1" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibSsTitr1']; ?></textarea><br><br>
                                                </div> 

                                                <div class="Margin">
                                                    <label for="Parag2A">Libellé paragraphe 2 :</label><br>
                                                    <textarea name="Parag2A" id="Parag2A" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['Parag2A']; ?></textarea><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="LibSsTitr2">Libellé sous-titre 2 :</label><br>
                                                    <textarea name="LibSsTitr2" id="LibSsTitr2" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibSsTitr2']; ?></textarea><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="Parag3A">Libellé paragraphe 3 :</label><br>
                                                    <textarea name="Parag3A" id="Parag3A" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['Parag3A']; ?></textarea><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="LibConclA">Libellé conlusion :</label><br>
                                                    <textarea name="LibConclA" id="LibConclA" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibConclA']; ?></textarea><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="Likes">Likes :</label>
                                                    <input type="number" id="Likes" name="Likes" min="0" placeholder="Nombre de like" value="<?php echo $donnees['Likes']; ?>" required><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="UrlPhotA">Remplir seulement si vous voulez changer l'image (10 Mo. MAX) :</label>
                                                    <input type="file" id="UrlPhotA" name="UrlPhotA" accept="image/*"><br><br>
                                                </div>

                                                <div class="Margin">
                                                    <label for="NumLang">Langue :</label>
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
                                                </div>

                                                <div class="Margin">
                                                    <label for="NumAngl">Angle :</label>
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
                                                </div>

                                                <div class="Margin">
                                                    <label for="NumThem">Thématique :</label>
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
                                                </div>

                                                <!-- Génération mot clés avec JavaScript -->
                                                <div id="MotCleJS">
                                                <?php 
                                                    for($i = 0; $i < $nbMotCle; $i++)
                                                    {
                                                ?>
                                                    <div class="MotCleContainer">
                                                        <div class="Margin">
                                                            <label for="MotCle">Mot clés :</label>
                                                            <select name="MotCle[]" id="MotCle" required>
                                                                <option value="" disabled selected>-- Choisir un mot clés --</option>
                                                                <?php 
                                                                
                                                                    $req = $bdd->query('SELECT * FROM motcle ORDER BY NumMoCle');

                                                                    while($donnees = $req->fetch()) {
                                                                ?>

                                                                        <option value="<?php echo $donnees['NumMoCle']; ?>" <?php echo $donnees['NumMoCle'] == $arrayMotCles[$i] ? "selected" : ""; ?>><?php echo $donnees['LibMoCle']; ?></option>
                                                                
                                                                <?php
                                                                    }

                                                                    $req->closeCursor();

                                                                ?>
                                                            </select>
                                                        </div>

                                                        <button type="button" class="removeMotCleJS" onclick="$(this).parents('.MotCleContainer').remove();">Supprimer <i class="fas fa-minus"></i></button>
                                                    </div>
                                                <?php 
                                                    }
                                                ?>
                                                </div>

                                                <button type="button" class="addMotCleJS">Ajouter un mot clés <i class="fas fa-plus"></i></button>

                                                <div class="validerInput">
                                                    <input type="submit">
                                                </div>
                                            </form>

                                            <div class="Margin validerInput">
                                                <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                                            </div>
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
                            </div>
                        </div>
                    </div>
    </body>

</html>
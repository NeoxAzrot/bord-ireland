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
                if((isset($_POST['LibAngl']) && !empty($_POST['LibAngl'])) AND
                (isset($_POST['NumLang']) && !empty($_POST['NumLang']))) {
                    $LibAngl = ctrlSaisies($_POST['LibAngl']);
                    $NumLang = ctrlSaisies($_POST['NumLang']);
                    $NumLang = strtoupper($NumLang);

                    $NumAngl_split = str_split($_GET['id'], 4);
                    $NumAngl_split_id = str_split($NumAngl_split[1], 2);

                    $req = $bdd->prepare('SELECT * FROM angle WHERE NumAngl LIKE :NumAngl AND NumLang = :NumLang');
                    $req->execute(array(
                        'NumAngl' => $NumAngl_split[0] . $NumAngl_split_id[0] . "%",
                        'NumLang' => $NumLang
                    ));
                    $donnees = $req->fetch();

                    if(empty($donnees)) {
                        // Met à jour l'angle
                        $req = $bdd->prepare('UPDATE angle SET LibAngl = :LibAngl, NumLang = :NumLang WHERE NumAngl = :ID');
                        $req->execute(array(
                            'LibAngl' => $LibAngl,
                            'NumLang' => $NumLang,
                            'ID' => $_GET['id']
                            ));
                            
                        $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";
                    } else {
                        $_SESSION['answer'] = "<span><b>" . $_GET['id'] . "</b> existe déjà en <b>" . $NumLang . "</b> !</span>";
                    }

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

            if(isset($_GET['id']) && !empty($_GET['id'])) {
                $req = $bdd->prepare('SELECT * FROM angle WHERE NumAngl = :id');
                $req->execute(array(
                    'id' => $_GET['id']
                ));

                $donnees = $req->fetch();

                $NumLangAngl = $donnees['NumLang'];

                // Affiche le formulaire et le pré remplie que si l'angle existe
                if(!empty($donnees)) {
                    ?>
                        <h1>Modifiez l'angle <span><?php echo $_GET['id']; ?></span>.</h1>

                        <?php include '../assets/php/menuAdmin.php'; ?>
                        <?php include '../assets/php/btnConnexionInAdminShow.php'; ?>
                        <?php include '../assets/php/menuInAdminShow.php'; ?>

                        <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                            <label for="NumAngl">ID :</label>
                            <input type="text" id="NumAngl" name="NumAngl" placeholder="Sur 8 car." size="8" minlength="8" value="<?php echo $donnees['NumAngl']; ?>" required disabled>

                            <label for="LibAngl">Libellé angle :</label>
                            <input type="text" id="LibAngl" name="LibAngl" placeholder="Sur 60 car." size="60" maxlength="60" autofocus="autofocus" value="<?php echo $donnees['LibAngl']; ?>" required>

                            <label for="NumLang">NumLang :</label>
                            <select name="NumLang" id="NumLang" required>
                                <option value="" disabled>-- Choisir un pays --</option>
                                <?php 
                                
                                    $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                                    while($donnees = $req->fetch()) {
                                ?>

                                        <option value="<?php echo $donnees['NumLang']; ?>" <?php echo $donnees['NumLang'] == $NumLangAngl ? "selected" : ""; ?>><?php echo $donnees['Lib1Lang']; ?></option>
                                
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
                    $_SESSION['answer'] = "<span>Cet angle est introuvable !</span>";

                    // Redirection avec un message personnalisé
                    header('Location: index.php');
                }
            } else {
                // Redirection avec un message personnalisé
                $_SESSION['answer'] = "<span>Cet angle est introuvable !</span>";
                header('Location: index.php');
            }

        ?>
    </body>

</html>
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
        
        <?php include '../assets/php/menuInAdminShow.php'; ?>
            <div class="thematiques">
                            <?php include '../assets/php/menuAdmin.php'; ?>
                <div class="Update">             
                            <?php
                            
                                // Affiche le formulaire seulement la première fois
                                if($_POST) {
                                    // Vérifie si tous les input ont été remplis et contrôle la saisie
                                    if((isset($_POST['FirstName']) && !empty($_POST['FirstName'])) AND
                                    (isset($_POST['LastName']) && !empty($_POST['LastName'])) AND
                                    (isset($_POST['EMail']) && !empty($_POST['EMail']))) {
                                        $FirstName = ctrlSaisies($_POST['FirstName']);
                                        $LastName = ctrlSaisies($_POST['LastName']);
                                        $EMail = ctrlSaisies($_POST['EMail']);

                                        // Met à jour l'utilisateur
                                        $req = $bdd->prepare('UPDATE user SET FirstName = :FirstName, LastName = :LastName, EMail = :EMail WHERE Login = :ID');
                                        $req->execute(array(
                                            'FirstName' => $FirstName,
                                            'LastName' => $LastName,
                                            'EMail' => $EMail,
                                            'ID' => $_GET['id']
                                            ));
                                    }

                                    // Redirection avec un message personnalisé
                                    $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";
                                    header('Location: index.php');
                                }

                                if(isset($_GET['id']) && !empty($_GET['id'])) {
                                    $req = $bdd->prepare('SELECT * FROM user WHERE Login = :id');
                                    $req->execute(array(
                                        'id' => $_GET['id']
                                    ));

                                    $donnees = $req->fetch();

                                    // Affiche le formulaire et le pré remplie que si l'utilisateur existe
                                    if(!empty($donnees)) {
                                        ?>
                                            <h1>Modifier l'utilisateur <span><?php echo $_GET['id']; ?></span>.</h1>
                                                <div class="UpdateContent">
                                                                        <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                                                                            <div class="Margin">
                                                                                <label for="Login">Identifiant :</label>
                                                                                <input type="text" id="Login" name="Login" placeholder="JohnDoe33" size="30" maxlength="30" value="<?php echo $donnees['Login']; ?>" required disabled><br>
                                                                            </div>
                                                                            <div class="Margin">
                                                                                <label for="Pass">Mot de passe :</label>
                                                                                <input type="password" id="Pass" name="Pass" placeholder="Entrer votre mot de passe" maxlength="255" minlength="6" value="******" required disabled><br>
                                                                            </div>
                                                                            <div class="Margin">
                                                                                <label for="FirstName">Prénom :</label>
                                                                                <input type="text" id="FirstName" name="FirstName" placeholder="John" size="30" maxlength="30" value="<?php echo $donnees['FirstName']; ?>" required><br>
                                                                            </div>
                                                                            <div class="Margin">
                                                                                <label for="LastName">Nom :</label>
                                                                                <input type="text" id="LastName" name="LastName" placeholder="Doe" size="30" maxlength="30" autofocus="autofocus" value="<?php echo $donnees['LastName']; ?>" required><br>
                                                                            </div>
                                                                            <div class="Margin">
                                                                                <label for="EMail">Email :</label>
                                                                                <input type="email" id="EMail" name="EMail" placeholder="johndoe@exemple.com" size="50" maxlength="50" value="<?php echo $donnees['EMail']; ?>" required><br>
                                                                            </div>
                                                                            <div class="validerInput">
                                                                                <input type="submit"><br>
                                                                            </div>
                                                                        </form>
                                                    <div class="Margin validerInput">
                                                                        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                                                                    <?php
                                                                } else {
                                                                    $_SESSION['answer'] = "<span>Cet utilisateur est introuvable !</span>";

                                                                    // Redirection avec un message personnalisé
                                                                    header('Location: index.php');
                                                                }
                                                            } else {
                                                                // Redirection avec un message personnalisé
                                                                $_SESSION['answer'] = "<span>Cet utilisateur est introuvable !</span>";
                                                                header('Location: index.php');
                                                            }

                                                        ?>
                                                    </div>
                                                </div>
                </div>
            </div>
    </body>

</html>
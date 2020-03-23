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
                if((isset($_POST['firstName']) && !empty($_POST['firstName'])) AND
                (isset($_POST['lastName']) && !empty($_POST['lastName'])) AND
                (isset($_POST['email']) && !empty($_POST['email']))) {
                    $firstName = ctrlSaisies($_POST['firstName']);
                    $lastName = ctrlSaisies($_POST['lastName']);
                    $email = ctrlSaisies($_POST['email']);

                    // Met à jour l'utilisateur
                    $req = $bdd->prepare('UPDATE user SET FirstName = :FirstName, LastName = :LastName, EMail = :EMail WHERE Login = :ID');
                    $req->execute(array(
                        'FirstName' => $firstName,
                        'LastName' => $lastName,
                        'EMail' => $email,
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
                        <h1>Modifiez l'utilisateur <span><?php echo $_GET['id']; ?></span>.</h1>

                        <?php include '../assets/php/menuAdmin.php'; ?>
                        <?php include '../assets/php/btnConnexionInAdminShow.php'; ?>
                        <?php include '../assets/php/menuInAdminShow.php'; ?>

                        <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                            <label for="login">Login :</label>
                            <input type="text" id="login" name="login" placeholder="Sur 30 car." size="30" maxlength="30" value="<?php echo $donnees['Login']; ?>" required disabled>

                            <label for="password">Password :</label>
                            <input type="password" id="password" name="password" placeholder="Sur 15 car." size="15" maxlength="15" minlength="6" value="<?php echo $donnees['Pass']; ?>" required disabled>

                            <label for="firstName">FirstName :</label>
                            <input type="text" id="firstName" name="firstName" placeholder="Sur 30 car." size="30" maxlength="30" autofocus="autofocus" value="<?php echo $donnees['FirstName']; ?>" required>

                            <label for="lastName">LastName :</label>
                            <input type="text" id="lastName" name="lastName" placeholder="Sur 30 car." size="30" maxlength="30" value="<?php echo $donnees['LastName']; ?>" required>

                            <label for="email">Email :</label>
                            <input type="email" id="email" name="email" placeholder="Sur 50 car." size="50" maxlength="50" value="<?php echo $donnees['EMail']; ?>" required>

                            <input type="submit">
                        </form>

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
    </body>

</html>
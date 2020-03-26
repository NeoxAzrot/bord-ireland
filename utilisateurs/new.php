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
                if((isset($_POST['FirstName']) && !empty($_POST['FirstName'])) AND
                (isset($_POST['LastName']) && !empty($_POST['LastName'])) AND
                (isset($_POST['EMail']) && !empty($_POST['EMail'])) AND
                (isset($_POST['Login']) && !empty($_POST['Login'])) AND
                (isset($_POST['Pass']) && !empty($_POST['Pass']))) {
                    $FirstName = ctrlSaisies($_POST['FirstName']);
                    $LastName = ctrlSaisies($_POST['LastName']);
                    $EMail = ctrlSaisies($_POST['EMail']);
                    $Login = ctrlSaisies($_POST['Login']);
                    $Pass = ctrlSaisies($_POST['Pass']);
                    $pass_hache = password_hash($Pass, PASSWORD_DEFAULT);

                    $req = $bdd->query('SELECT * FROM user WHERE Login = "' . $Login . '"');
                    $donnees = $req->fetch();
        
                    // Vérifie si l'utilisateur existe déjà
                    if(empty($donnees)) {
                        // Ajoute l'utilisateur dans la table
                        $req = $bdd->prepare('INSERT INTO user(Login, Pass, LastName, FirstName, EMail) VALUES(:Login, :Pass, :LastName, :FirstName, :EMail)');
                        $req->execute(array(
                            'Login' => $Login,
                            'Pass' => $pass_hache,
                            'LastName' => $LastName,
                            'FirstName' => $FirstName,
                            'EMail' => $EMail
                            ));

                        $_SESSION['answer'] = "<b>" . $Login . "</b> vient d'être ajouté à la table !";
                        
                        $req->closeCursor();
                    } else {
                        $_SESSION['answer'] = "<span><b>" . $Login . "</b> existe déjà dans la table !<span>";
                    }

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

        ?>
        
        
        <?php include '../assets/php/menuInAdminShow.php'; ?>
        <?php include '../assets/php/menuAdmin.php'; ?>
        
        <h1>Ajoutez un utilisateur.</h1>
        
        <form action="new.php" method="POST">
            <label for="FirstName">Prénom :</label>
            <input type="text" id="FirstName" name="FirstName" placeholder="Sur 30 car." size="30" maxlength="30" autofocus="autofocus" required>

            <label for="LastName">Nom :</label>
            <input type="text" id="LastName" name="LastName" placeholder="Sur 30 car." size="30" maxlength="30" required>

            <label for="EMail">Email :</label>
            <input type="email" id="EMail" name="EMail" placeholder="Sur 50 car." size="50" maxlength="50" required>

            <label for="Login">Identifiant :</label>
            <input type="text" id="Login" name="Login" placeholder="Sur 30 car." size="30" maxlength="30" required>

            <label for="Pass">Mot de passe :</label>
            <input type="password" id="Pass" name="Pass" placeholder="Sur 255 car." maxlength="255" minlength="6" required>

            <input type="submit">
        </form>

        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
    </body>

</html>
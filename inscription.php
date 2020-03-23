<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include 'assets/php/connect_PDO.php';
    include 'assets/php/ctrlSaisies.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bord'Irlande - BLOG</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>        

        <?php

            // Check si l'user est connecté
            if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user'] == true) {
                $user = true;
            } else {
                $user = false;
            }

            // Redirige si l'utilisateur est déjà connecté
            if($user) {
                header('Location: index.php');
            }

            // Affiche le formulaire d'inscription seulement la première fois
            if($_POST) {
                // Vérifie si tous les input ont été remplis et contrôle la saisie
                if((isset($_POST['firstName']) && !empty($_POST['firstName'])) AND
                (isset($_POST['lastName']) && !empty($_POST['lastName'])) AND
                (isset($_POST['email']) && !empty($_POST['email'])) AND
                (isset($_POST['login']) && !empty($_POST['login'])) AND
                (isset($_POST['password']) && !empty($_POST['password']))) {
                    $firstName = ctrlSaisies($_POST['firstName']);
                    $lastName = ctrlSaisies($_POST['lastName']);
                    $email = ctrlSaisies($_POST['email']);
                    $login = ctrlSaisies($_POST['login']);
                    $password = ctrlSaisies($_POST['password']);

                    $req = $bdd->prepare('SELECT * FROM user WHERE Login = ?');
                    $req->execute(array($login));
                    $donnees = $req->fetch();

                    // Vérifie si l'utilisateur n'existe pas déjà
                    if(empty($donnees)) {
                        $req = $bdd->prepare('INSERT INTO user(FirstName, LastName, EMail, Login, Pass) VALUES(:FirstName, :LastName, :EMail, :Login, :Pass)');
                        $req->execute(array(
                            'FirstName' => $firstName,
                            'LastName' => $lastName,
                            'EMail' => $email,
                            'Login' => $login,
                            'Pass' => $password
                            ));

                        $_SESSION['user'] = true;
                        $_SESSION['login'] = $login;
                        $_SESSION['errorLogin'] = false;

                        // Vérifie si c'est l'admin d'inscrit (si il s'est supprimé)
                        if($_SESSION['login'] == 'Admin') {
                            $_SESSION['admin'] = true;
                        }

                        // Redirige après l'inscription
                        header('Location: index.php');
                    } else {
                        $_SESSION['errorLogin'] = true;

                        $_SESSION['firstName'] = $firstName;
                        $_SESSION['lastName'] = $lastName;
                        $_SESSION['email'] = $email;
                        $_SESSION['login'] = $login;
                        $_SESSION['password'] = $password;

                        // Redirige avec un message d'erreur
                        header('Location: inscription.php');
                    }

                }

            }

        ?>

        <h1>Inscription</h1>

        <!-- Menus -->
        <?php include 'assets/php/btnConnexion.php'; ?>
        <?php include 'assets/php/menu.php'; ?>

        <!-- Formulaire d'inscription avec input près remplis si erreur -->
        <form action="" method="POST">
            <label for="firstName">Prénom :</label>
            <input type="text" id="firstName" name="firstName" placeholder="Sur 30 car." value="<?php echo isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] == true ? $_SESSION['firstName'] : "" ?>" size="30" maxlength="30" autofocus="autofocus" required>

            <label for="lastName">Nom :</label>
            <input type="text" id="lastName" name="lastName" placeholder="Sur 30 car." value="<?php echo isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] == true ? $_SESSION['lastName'] : "" ?>" size="30" maxlength="30" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Sur 50 car." value="<?php echo isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] == true ? $_SESSION['email'] : "" ?>" size="50" maxlength="50" required>

            <label for="login">Identifiant :</label>
            <!-- Message d'erreur de connexion -->
            <?php echo isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] == true ? "Cet identifiant existe déjà !" : "" ?>
            <input type="text" id="login" name="login" placeholder="Sur 30 car." value="<?php echo isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] == true ? $_SESSION['login'] : "" ?>" size="30" maxlength="30" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Sur 15 car." value="<?php echo isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] == true ? $_SESSION['password'] : "" ?>" size="15" maxlength="15" minlength="6" required>

            <input type="submit">
        </form>

        <!-- Lien pour se connecter -->
        <a href="connexion.php">Se connecter</a>

        <script src="assets/js/script.js"></script>
    </body>

</html>
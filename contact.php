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

            // Affiche le formulaire seulement la première fois
            if($_POST) {
                // Vérifie si tous les input ont été remplis et contrôle la saisie
                if((isset($_POST['name']) && !empty($_POST['name'])) AND
                (isset($_POST['email']) && !empty($_POST['email'])) AND
                (isset($_POST['subject']) && !empty($_POST['subject'])) AND
                (isset($_POST['message']) && !empty($_POST['message']))) {
                    $name = ctrlSaisies($_POST['name']);
                    $email = ctrlSaisies($_POST['email']);
                    $subject = ctrlSaisies($_POST['subject']);
                    $message = nl2br(ctrlSaisies($_POST['message']));

                    // Création de l'email
                    $email_from = 'contact@bordirlande.fr';
                    $email_subject = $subject;
                    $email_body = $message;

                    $email_body .= "<br/><br/><hr/><br/><u>Informations supplémentaires :</u> <br/><br/><b>Nom</b> : $name<br/><b>E-mail</b> : $email<br/><b>Sujet</b> : $subject";
                        
                    $req = $bdd->query('SELECT * FROM user WHERE Login = "Admin"');
                    $donnees = $req->fetch();

                    $to = $donnees['EMail'];
                    $headers = "From: $email_from \r\n";
                    $headers .= "Reply-To: $email \r\n";
                    $headers .= "MIME-Version: 1.0 \r\n";
                    $headers .= "Content-type: text/html; charset=utf-8 \r\n";

                    // Envoie de l'email
                    mail($to, $email_subject, $email_body, $headers);

                    // Redirection avec un message personnalisé
                    $validation = true;
                }
            }
    
        ?> 


        <!-- Menus -->
        <?php include 'assets/php/menu.php'; ?>

        <!-- Search bar -->
        <?php include 'assets/php/search.php'; ?>

        <div class="contact">
            <div class="btnContact">
                <?php include 'assets/php/btnConnexion.php'; ?>
            </div>
            
            <div class="contactContent">
                <h1>Contact</h1>

                <div class="contactContent1">
                    <?php 

                        if(isset($validation) && $validation == true) {
                            echo "Le message a bien été envoyé !";
                        }

                    ?>

                    <form action="" method="POST" >
                        <div class="Margin">
                            <label for="name">Prénom / Nom :</label>
                            <input type="text" name="name" id="name" placeholder="John Doe" required/><br>
                        </div>
                        <div class="Margin">
                            <label for="email">Adresse mail :</label>
                            <input type="email" name="email" id="email" placeholder="johndoe@exemple.com" required/><br>
                        </div>
                        <div class="Margin">
                            <label for="subject">Sujet :</label>
                            <input type="text" name="subject" id="subject" placeholder="Entrer votre sujet" required/><br>
                        </div>
                        <div class="Margin">
                            <label for="message" id="textarea-label">Message :</label><br>
                            <textarea name="message" id="message" placeholder="Entrer votre message" required></textarea><br>
                        </div>
                        <div class="sendButton">
                            <div>
                                <input type="reset" value="Effacer" />
                            </div>
                            <div>
                                <input type="submit" value="Envoyer" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="assets/js/script.js"></script>
    </body>

</html>
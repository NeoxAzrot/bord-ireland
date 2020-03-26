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
                if((isset($_POST['DtCreC']) && !empty($_POST['DtCreC'])) AND
                (isset($_POST['PseudoAuteur']) && !empty($_POST['PseudoAuteur'])) AND
                (isset($_POST['EmailAuteur']) && !empty($_POST['EmailAuteur'])) AND
                (isset($_POST['TitrCom']) && !empty($_POST['TitrCom'])) AND
                (isset($_POST['LibCom']) && !empty($_POST['LibCom'])) AND
                (isset($_POST['NumArt']) && !empty($_POST['NumArt']))) {
                    $DtCreC = ctrlSaisies($_POST['DtCreC']);
                    $DtCreC = str_replace("T", " ", $DtCreC);
                    $PseudoAuteur = ctrlSaisies($_POST['PseudoAuteur']);
                    $EmailAuteur = ctrlSaisies($_POST['EmailAuteur']);
                    $TitrCom = ctrlSaisies($_POST['TitrCom']);
                    $LibCom = ctrlSaisies($_POST['LibCom']);
                    $NumArt = ctrlSaisies($_POST['NumArt']);

                    // Ajout des secondes random car elles ne sont pas disponible dans l'input
                    $seconde = rand(0, 59);

                    if($seconde < 10) {
                        $seconde = "0" . $seconde;
                    }

                    $DtCreC = $DtCreC . ':' . $seconde;

                    // Vérifie si c'est le premier commentaire de la table
                    $req = $bdd->query('SELECT * FROM comment');
                    $donnees = $req->fetch();
        
                    if(empty($donnees)) {
                        // Ajoute le commentaire si c'est le premier de la table
                        $req = $bdd->prepare('INSERT INTO comment(NumCom, DtCreC, PseudoAuteur, EmailAuteur, TitrCom, LibCom, NumArt) VALUES(:NumCom, :DtCreC, :PseudoAuteur, :EmailAuteur, :TitrCom, :LibCom, :NumArt)');
                        $req->execute(array(
                            'NumCom' => "001",
                            'DtCreC' => $DtCreC,
                            'PseudoAuteur' => $PseudoAuteur,
                            'EmailAuteur' => $EmailAuteur,
                            'TitrCom' => $TitrCom,
                            'LibCom' => $LibCom,
                            'NumArt' => $NumArt
                            ));
                    } else {
                        // Récupère la clé primaire maximale du commentaire et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumCom) AS NumComMax FROM comment');
                        $donnees = $req->fetch();

                        $comm_max = $donnees['NumComMax'];
                        $comm_max = (int) $comm_max + 1;
                        
                        // Rajoute un 0 devant si on est entre 1 et 9
                        if($comm_max < 10) {
                            $comm_max = "0" . $comm_max;
                        }

                        // Rajoute un 0 devant si on est entre 1 et 99
                        if($comm_max < 100) {
                            $comm_max = "0" . $comm_max;
                        }

                        // Ajoute le commentaire dans la table
                        $req = $bdd->prepare('INSERT INTO comment(NumCom, DtCreC, PseudoAuteur, EmailAuteur, TitrCom, LibCom, NumArt) VALUES(:NumCom, :DtCreC, :PseudoAuteur, :EmailAuteur, :TitrCom, :LibCom, :NumArt)');
                        $req->execute(array(
                            'NumCom' => $comm_max,
                            'DtCreC' => $DtCreC,
                            'PseudoAuteur' => $PseudoAuteur,
                            'EmailAuteur' => $EmailAuteur,
                            'TitrCom' => $TitrCom,
                            'LibCom' => $LibCom,
                            'NumArt' => $NumArt
                            ));

                        $_SESSION['answer'] = "<b>" . $comm_max . "</b> vient d'être ajouté à la table !";
                    }
                    
                    $req->closeCursor();

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

        ?>
        
        
        <?php include '../assets/php/menuInAdminShow.php'; ?>
        <?php include '../assets/php/menuAdmin.php'; ?>
        
        <h1>Ajoutez un commentaire.</h1>
        
        <form action="new.php" method="POST">
            <label for="DtCreC">Date :</label>
            <input type="datetime-local" id="DtCreC" name="DtCreC" autofocus="autofocus" required>

            <label for="PseudoAuteur">Pseudo :</label>
            <input type="text" id="PseudoAuteur" name="PseudoAuteur" placeholder="Sur 20 car." size="20" maxlength="20" required>

            <label for="EmailAuteur">Email :</label>
            <input type="email" id="EmailAuteur" name="EmailAuteur" placeholder="Sur 60 car." size="60" maxlength="60" required>

            <label for="TitrCom">Titre :</label>
            <input type="text" id="TitrCom" name="TitrCom" placeholder="Sur 60 car." size="60" maxlength="60" required>

            <label for="LibCom">Libellé du commentaire :</label>
            <textarea name="LibCom" id="LibCom" cols="30" rows="10" placeholder="Ecrivez ici..." required></textarea>

            <label for="NumArt">Article :</label>
            <select name="NumArt" id="NumArt" required>
                <option value="" disabled selected>-- Choisir un article --</option>
                <?php 
                
                    $req = $bdd->query('SELECT * FROM article ORDER BY DtCreA DESC');

                    while($donnees = $req->fetch()) {
                ?>

                        <option value="<?php echo $donnees['NumArt']; ?>"><?php echo $donnees['LibTitrA']; ?></option>
                
                <?php
                    }

                    $req->closeCursor();

                ?>
            </select>

            <input type="submit">
        </form>

        <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
    </body>

</html>
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

                                    // Met à jour le commentaire
                                    $req = $bdd->prepare('UPDATE comment SET DtCreC = :DtCreC, PseudoAuteur = :PseudoAuteur, EmailAuteur = :EmailAuteur, TitrCom = :TitrCom, LibCom = :LibCom, NumArt = :NumArt WHERE NumCom = :ID');
                                    $req->execute(array(
                                        'DtCreC' => $DtCreC,
                                        'PseudoAuteur' => $PseudoAuteur,
                                        'EmailAuteur' => $EmailAuteur,
                                        'TitrCom' => $TitrCom,
                                        'LibCom' => $LibCom,
                                        'NumArt' => $NumArt,
                                        'ID' => $_GET['id']
                                        ));
                                }

                                // Redirection avec un message personnalisé
                                $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";
                                header('Location: index.php');
                            }

                            if(isset($_GET['id']) && !empty($_GET['id'])) {
                                $req = $bdd->prepare('SELECT * FROM comment WHERE NumCom = :id');
                                $req->execute(array(
                                    'id' => $_GET['id']
                                ));

                                $donnees = $req->fetch();

                                $NumComArt = $donnees['NumArt'];

                                // Pour enlever les secondes qui marche pas dans l'input
                                $date = substr($donnees['DtCreC'], 0, -3);
                                $date = str_replace(" ", "T", $date);

                                // Affiche le formulaire et le pré remplie que si le commentaire existe
                                if(!empty($donnees)) {
                                    ?>
                                        <h1>Modifier le commentaire <span><?php echo $_GET['id']; ?></span>.</h1>
                                            <div class="UpdateContent">
                                                <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                                                    <div class="Margin">
                                                        <label for="NumCom">ID :</label>
                                                        <input type="text" id="NumCom" name="NumCom" placeholder="Identifiant du commentaire" size="6" maxlength="6" value="<?php echo $donnees['NumCom']; ?>" required disabled><br>
                                                    </div>

                                                    <div class="Margin">
                                                        <label for="DtCreC">Date :</label>
                                                        <input type="datetime-local" id="DtCreC" name="DtCreC" autofocus="autofocus" value="<?php echo $date; ?>" required><br>
                                                    </div>

                                                    <div class="Margin">
                                                        <label for="PseudoAuteur">Pseudo :</label>
                                                        <input type="text" id="PseudoAuteur" name="PseudoAuteur" placeholder="Entrer votre pseudo" size="20" maxlength="20" value="<?php echo $donnees['PseudoAuteur']; ?>" required><br>
                                                    </div>

                                                    <div class="Margin">
                                                        <label for="EmailAuteur">Email :</label>
                                                        <input type="email" id="EmailAuteur" name="EmailAuteur" placeholder="Entrer votre email" size="60" maxlength="60" value="<?php echo $donnees['EmailAuteur']; ?>" required><br>
                                                    </div>

                                                    <div class="Margin">
                                                        <label for="TitrCom">Titre :</label>
                                                        <input type="text" id="TitrCom" name="TitrCom" placeholder="Entrer votre titre" size="60" maxlength="60" value="<?php echo $donnees['TitrCom']; ?>" required><br>
                                                    </div>

                                                    <div class="Margin">
                                                        <label for="LibCom">Libellé du commentaire :</label><br>
                                                        <textarea name="LibCom" id="LibCom" cols="30" rows="10" placeholder="Ecrivez ici..." required><?php echo $donnees['LibCom']; ?></textarea><br>
                                                    </div>

                                                    <div class="Margin">
                                                        <label for="NumArt">Article :</label>
                                                        <select name="NumArt" id="NumArt" required>
                                                            <option value="" disabled selected>-- Choisir un article --</option>
                                                            <?php 
                                                            
                                                                $req = $bdd->query('SELECT * FROM article ORDER BY DtCreA DESC');

                                                                while($donnees = $req->fetch()) {
                                                            ?>

                                                                    <option value="<?php echo $donnees['NumArt']; ?>" <?php echo $donnees['NumArt'] == $NumComArt ? "selected" : ""; ?>><?php echo $donnees['LibTitrA']; ?></option>
                                                            
                                                            <?php
                                                                }

                                                                $req->closeCursor();

                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="validerInput">
                                                        <input type="submit"><br>
                                                    </div>
                                                </form>
                                                
                                                <div class="Margin validerInput">
                                                    <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                                                </div>
                                            </div>
                                    <?php
                                } else {
                                    $_SESSION['answer'] = "<span>Ce commentaire est introuvable !</span>";

                                    // Redirection avec un message personnalisé
                                    header('Location: index.php');
                                }
                            } else {
                                // Redirection avec un message personnalisé
                                $_SESSION['answer'] = "<span>Ce commentaire est introuvable !</span>";
                                header('Location: index.php');
                            }

                        ?>
                
            </div>
        </div>
    </body>

</html>
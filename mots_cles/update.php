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
                if((isset($_POST['LibMoCle']) && !empty($_POST['LibMoCle']))) {
                    $LibMoCle = ctrlSaisies($_POST['LibMoCle']);

                    // Met à jour le mot clés
                    $req = $bdd->prepare('UPDATE motcle SET LibMoCle = :LibMoCle WHERE NumMoCle = :ID');
                    $req->execute(array(
                        'LibMoCle' => $LibMoCle,
                        'ID' => $_GET['id']
                        ));
                        
                    $_SESSION['answer'] = "La modification de <b>" . $_GET['id'] . "</b> a bien été pris en compte !";

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

            if(isset($_GET['id']) && !empty($_GET['id'])) {
                $req = $bdd->prepare('SELECT * FROM motcle WHERE NumMoCle = :id');
                $req->execute(array(
                    'id' => $_GET['id']
                ));

                $donnees = $req->fetch();

                $NumLangMoCle = $donnees['NumLang'];

                // Affiche le formulaire et le pré remplie que si le mot clés existe
                if(!empty($donnees)) {
                    ?>
                       
                        <?php include '../assets/php/menuInAdminShow.php'; ?>
                    <div class="thematiques">
                                        <?php include '../assets/php/menuAdmin.php'; ?>
                        <div class="Update">                
                                                <h1>Modifiez le mot clés <span><?php echo $_GET['id']; ?></span>.</h1>
                            <div class="UpdateContent"> 
                                                <form action="update.php?id=<?php echo $_GET['id']; ?>" method="POST">
                                                <div class="Margin"> 
                                                    <label for="NumMoCle">ID :</label>
                                                    <input type="text" id="NumMoCle" name="NumMoCle" placeholder="Sur 8 car." size="8" minlength="8" value="<?php echo $donnees['NumMoCle']; ?>" required disabled><br>
                                                </div> 
                                                <div class="Margin"> 
                                                    <label for="LibMoCle">Libellé mot clés :</label>
                                                    <input type="text" id="LibMoCle" name="LibMoCle" placeholder="Sur 30 car." size="30" maxlength="30" autofocus="autofocus" value="<?php echo $donnees['LibMoCle']; ?>" required><br>
                                                </div>
                                                <div class="Margin"> 
                                                    <label for="NumLang">NumLang :</label>
                                                    <select name="NumLang" id="NumLang" required disabled>
                                                        <option value="" disabled>-- Choisir un pays --</option>
                                                        <?php 
                                                        
                                                            $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                                                            while($donnees = $req->fetch()) {
                                                        ?>

                                                                <option value="<?php echo $donnees['NumLang']; ?>" <?php echo $donnees['NumLang'] == $NumLangMoCle ? "selected" : ""; ?>><?php echo $donnees['Lib1Lang']; ?></option>
                                                        
                                                        <?php
                                                            }

                                                            $req->closeCursor();

                                                        ?>
                                                    </select> <br>
                                                </div>
                                                <div class="Margin"> 
                                                    <input type="submit">
                                                </div>
                                                </form>
                                                <div class="Margin">
                                                    <a href="index.php" class="back"><i class="fas fa-arrow-left"></i> Revenir au tableau</a>
                                                </div>
                                            <?php
                                        } else {
                                            $_SESSION['answer'] = "<span>Ce mot clés est introuvable !</span>";

                                            // Redirection avec un message personnalisé
                                            header('Location: index.php');
                                        }
                                    } else {
                                        // Redirection avec un message personnalisé
                                        $_SESSION['answer'] = "<span>Ce mot clés est introuvable !</span>";
                                        header('Location: index.php');
                                    }

                                ?>
                            </div>
                        </div>
                    </div>    
    </body>

</html>
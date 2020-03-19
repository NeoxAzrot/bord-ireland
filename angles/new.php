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

                    $req = $bdd->query('SELECT * FROM angle WHERE NumLang LIKE "' . $NumLang . '%"');
                    $donnees = $req->fetch();
        
                    // Vérifie si la langue existe déjà. Exemple : FRAN
                    if(empty($donnees)) {
                        $req = $bdd->prepare('INSERT INTO langue(NumLang, Lib1Lang, Lib2Lang, NumPays) VALUES(:NumLang, :Lib1Lang, :Lib2Lang, :NumPays)');
                        $req->execute(array(
                            'NumLang' => $NumLang . "01",
                            'Lib1Lang' => $LibAngl,
                            'NumPays' => $pays
                            ));

                        $_SESSION['answer'] = "<b>" . $NumLang . "01" . "</b> vient d'être ajouté à la table !";
                    } else {
                        // Récupère la clé primaire maximale de la langue et lui ajoute 1
                        $req = $bdd->query('SELECT MAX(NumLang) AS NumLangMax FROM langue WHERE NumLang LIKE "' . $NumLang . '%"');
                        $donnees = $req->fetch();

                        $NumLang_split = str_split($donnees['NumLangMax'], 4);
                        $NumLang_next_id = (int) $NumLang_split[1] + 1;
                        
                        // Rajoute un 0 devant si on est entre 1 et 9 car sinon on aurait par exemple : FRAN2 et non FRAN02
                        if($NumLang_next_id < 10) {
                            $NumLang_next_id = "0" . $NumLang_next_id;
                        }

                        // Ajoute la langue
                        $req = $bdd->prepare('INSERT INTO langue(NumLang, Lib1Lang, Lib2Lang, NumPays) VALUES(:NumLang, :Lib1Lang, :Lib2Lang, :NumPays)');
                        $req->execute(array(
                            'NumLang' => $NumLang_split[0] . $NumLang_next_id,
                            'Lib1Lang' => $LibAngl,
                            'NumPays' => $NumLang
                            ));

                        $_SESSION['answer'] = "<b>" . $NumLang_split[0] . $NumLang_next_id  . "</b> vient d'être ajouté à la table !";

                        $req->closeCursor();
                    }

                }

                // Redirection avec un message personnalisé
                header('Location: index.php');
            }

        ?>
        
        <h1>Ajoutez un angle.</h1>

        <form action="new.php" method="POST">
            <label for="LibAngl">Libellé angle :</label>
            <input type="text" id="LibAngl" name="LibAngl" placeholder="Sur 60 car." size="60" maxlength="60" autofocus="autofocus" required>

            <label for="NumLang">NumLang :</label>
            <select name="NumLang" id="NumLang" required>
                <option value="" disabled selected>-- Choisir une langue --</option>
                <?php 
                
                    $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                    while($donnees = $req->fetch()) {
                ?>

                        <option value="<?php echo $donnees['NumLang']; ?>"><?php echo $donnees['Lib1Lang']; ?></option>
                
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
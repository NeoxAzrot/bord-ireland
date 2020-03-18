<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include '../assets/php/connect_PDO.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mots clés - blog</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>
        <h1>Tout les mots clés.</h1>

        <?php 

            // Affichage du message personnalisé lors de la redirection
            if(isset($_SESSION['answer']) && !empty($_SESSION['answer'])) {
                echo "<p class='answer'>" . $_SESSION['answer'] . "</p>";
                $_SESSION['answer'] = "";
            }

        ?>

        <table>
            <thead>
                <tr>
                    <th>NumLang</th>
                    <th>Lib1Lang</th>
                    <th>Lib2Lang</th>
                    <th>NumPays</th>
                </tr>
            </thead>
            <tbody>

            <?php

                $req = $bdd->query('SELECT * FROM langue ORDER BY NumLang');

                // Affichage de toutes les langues dans un tableau
                while ($donnees = $req->fetch())
                {

            ?>
                <tr>
                    <td><?php echo $donnees['NumLang'];?></td>
                    <td><?php echo $donnees['Lib1Lang'];?></td>
                    <td><?php echo $donnees['Lib2Lang'];?></td>
                    <td><?php echo $donnees['NumPays'];?></td>
                    <td><a href="update.php?id=<?php echo $donnees['NumLang'];?>" class="modified_link"><i class="fas fa-edit"></i> Modifier</a></td>
                    <td><a href="delete.php?id=<?php echo $donnees['NumLang'];?>" class="delete_link" data-id="<?php echo $donnees['NumLang']; ?>"><i class="fas fa-trash-alt"></i> Supprimer</a></td>
                </tr>

                <?php 

                    }

                    $req->closeCursor();

                ?>
            </tbody>
        </table>

        <a href="new.php" class="add"><i class="fas fa-plus"></i> Ajouter un nouveau mot clés</a>

        <script src="../assets/js/script.js"></script>
    </body>

</html>
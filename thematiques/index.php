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
        <title>Bord'Irlande - ADMIN</title>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,900&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/f69c2bce58.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>
        

        <?php include '../assets/php/menuInAdminShow.php'; ?>
        <?php include '../assets/php/menuAdmin.php'; ?>

        <h1>Toutes les thématiques.</h1>
        
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
                    <th>NumThem</th>
                    <th>LibThem</th>
                    <th>NumLang</th>
                </tr>
            </thead>
            <tbody>

            <?php

                $req = $bdd->query('SELECT * FROM thematique ORDER BY NumThem');

                // Affichage de toutes les thématiques dans un tableau
                while ($donnees = $req->fetch())
                {

            ?>
                <tr>
                    <td><?php echo $donnees['NumThem'];?></td>
                    <td><?php echo $donnees['LibThem'];?></td>
                    <td><a href="../langues/index.php"><?php echo $donnees['NumLang'];?></a></td>
                    <td><a href="update.php?id=<?php echo $donnees['NumThem'];?>" class="modified_link"><i class="fas fa-edit"></i> Modifier</a></td>
                    <td><a href="delete.php?id=<?php echo $donnees['NumThem'];?>" class="delete_link" data-id="<?php echo $donnees['NumThem']; ?>"><i class="fas fa-trash-alt"></i> Supprimer</a></td>
                </tr>

                <?php 

                    }

                    $req->closeCursor();

                ?>
            </tbody>
        </table>

        <a href="new.php" class="add"><i class="fas fa-plus"></i> Ajouter une nouvelle thématique</a>

        <script src="../assets/js/script.js"></script>
    </body>

</html>
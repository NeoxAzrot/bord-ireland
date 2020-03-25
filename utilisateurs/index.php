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
        <div class="thematiques">
            <?php include '../assets/php/menuAdmin.php'; ?>
            
            <h1>Tout les utilisateurs.</h1>
            
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
                        <th>Login</th>
                        <th>Pass</th>
                        <th>LastName</th>
                        <th>FirstName</th>
                        <th>EMail</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    $req = $bdd->query('SELECT * FROM user ORDER BY Login');

                    // Affichage de toutes les langues dans un tableau
                    while ($donnees = $req->fetch())
                    {

                ?>
                    <tr>
                        <td><?php echo $donnees['Login'];?></td>
                        <td><?php echo $donnees['Pass'];?></td>
                        <td><?php echo $donnees['LastName'];?></td>
                        <td><?php echo $donnees['FirstName'];?></td>
                        <td><?php echo $donnees['EMail'];?></td>
                        <td><a href="update.php?id=<?php echo $donnees['Login'];?>" class="modified_link"><i class="fas fa-edit"></i> Modifier</a></td>
                        <td><a href="delete.php?id=<?php echo $donnees['Login'];?>" class="delete_link" data-id="<?php echo $donnees['Login']; ?>"><i class="fas fa-trash-alt"></i> Supprimer</a></td>
                    </tr>

                    <?php 

                        }

                        $req->closeCursor();

                    ?>
                </tbody>
            </table>

            <a href="new.php" class="add"><i class="fas fa-plus"></i> Ajouter un nouvel utilisateur</a>

            <script src="../assets/js/script.js"></script>
        </div>
    </body>

</html>
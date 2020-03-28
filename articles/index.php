<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include '../assets/php/connect_PDO.php';
    include '../assets/php/dateChangeFormat.php';

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
        <div class="articleAdmin">
            <?php include '../assets/php/menuAdmin.php'; ?>
            
            <h1>Tout les articles.</h1>
            
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
                        <th>NumArt</th>
                        <th>DtCreA</th>
                        <th>LibTitrA</th>
                        <th>LibChapoA</th>
                        <th>LibAccrochA</th>
                        <th>Parag1A</th>
                        <th>LibSsTitr1</th>
                        <th>Parag2A</th>
                        <th>LibSsTitr2</th>
                        <th>Parag3A</th>
                        <th>LibConclA</th>
                        <th>UrlPhotA</th>
                        <th>Likes</th>
                        <th>NumAngl</th>
                        <th>NumThem</th>
                        <th>NumLang</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    $req = $bdd->query('SELECT * FROM article ORDER BY NumArt');

                    // Affichage de tout les articles dans un tableau
                    while ($donnees = $req->fetch())
                    {

                ?>
                    <tr>
                        <td><?php echo $donnees['NumArt'];?></td>
                        <td><?php echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y");?></td>
                        <td><?php echo $donnees['LibTitrA'];?></td>
                        <td><?php echo $donnees['LibChapoA'];?></td>
                        <td><?php echo $donnees['LibAccrochA'];?></td>
                        <td><?php echo $donnees['Parag1A'];?></td>
                        <td><?php echo $donnees['LibSsTitr1'];?></td>
                        <td><?php echo $donnees['Parag2A'];?></td>
                        <td><?php echo $donnees['LibSsTitr2'];?></td>
                        <td><?php echo $donnees['Parag3A'];?></td>
                        <td><?php echo $donnees['LibConclA'];?></td>
                        <td><img src="../assets/uploads/<?php echo $donnees['UrlPhotA'];?>" alt="Image de l'article"></td>
                        <td><?php echo $donnees['Likes'];?></td>
                        <td><a href="../angles/index.php"><?php echo $donnees['NumAngl'];?></a></td>
                        <td><a href="../thematiques/index.php"><?php echo $donnees['NumThem'];?></a></td>
                        <td><a href="../langues/index.php"><?php echo $donnees['NumLang'];?></a></td>
                        <td><a href="update.php?id=<?php echo $donnees['NumArt'];?>" class="modified_link"><i class="fas fa-edit"></i> Modifier</a></td>
                        <td><a href="delete.php?id=<?php echo $donnees['NumArt'];?>" class="delete_link" data-id="<?php echo $donnees['NumArt']; ?>"><i class="fas fa-trash-alt"></i> Supprimer</a></td>
                    </tr>

                    <?php 

                        }

                        $req->closeCursor();

                    ?>
                </tbody>
            </table>

            <a href="new.php" class="add"><i class="fas fa-plus"></i> Ajouter un nouvel article</a>

            <script src="../assets/js/script.js"></script>
        </div>
    </body>

</html>
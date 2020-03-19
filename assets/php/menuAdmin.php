<?php

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    // Check si l'admin est connecté
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true) {
        $admin = true;
    } else {
        $admin = false;
    }

    // Affichage en fonction de si admin connecté ou pas
    if(!$admin) {
        header('Location: index.php');
    }

?>

<ul>
    <li><a href="../articles/index.php">Articles</a></li>
    <li><a href="../commentaires/index.php">Commentaires</a></li>
    <li><a href="../utilisateurs/index.php">Utilisateurs</a></li>
    <li><a href="../angles/index.php">Angles</a></li>
    <li><a href="../mots_cles/index.php">Mots clés</a></li>
    <li><a href="../thematiques/index.php">Thématiques</a></li>
    <li><a href="../langues/index.php">Langues</a></li>
</ul>
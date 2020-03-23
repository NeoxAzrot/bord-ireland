<?php

    // Check si l'admin est connecté
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true) {
        $admin = true;
    } else {
        $admin = false;
    }

    // Redirige si admin pas connecté
    if(!$admin) {
        header('Location: index.php');
    }

?>

<!-- Menu pour toutes les pages administrateur -->
<ul>
    <li><a href="../articles/index.php">Articles</a></li>
    <li><a href="../commentaires/index.php">Commentaires</a></li>
    <li><a href="../utilisateurs/index.php">Utilisateurs</a></li>
    <li><a href="../angles/index.php">Angles</a></li>
    <li><a href="../mots_cles/index.php">Mots clés</a></li>
    <li><a href="../thematiques/index.php">Thématiques</a></li>
    <li><a href="../langues/index.php">Langues</a></li>
</ul>
<div class="pseudoAdminInAdminShow">
    <?php

        // Check si l'user est connecté
        if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user'] == true) {
            $user = true;
        } else {
            $user = false;
        }
        // Affichage en fonction de si user est connecté ou pas
        if($user) {
            echo '<div class="pseudoAdmin">';
            echo $_SESSION['login'];
            echo '</div>';
            echo '<a href="../deconnexion.php">Déconnexion</a>';
        } else {
            echo '<a href="../connexion.php">Connexion</a> / <a href="../inscription.php">Inscription</a>';
        }

    ?>
</div>
<?php 

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    $_SESSION['user'] = false;
    $_SESSION['admin'] = false;

    header('Location: index.php');

?>
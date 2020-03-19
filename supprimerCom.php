<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include 'assets/php/connect_PDO.php';

    // Supprime la langue en utilisant la clés primaire
    if(isset($_GET['numCom']) && !empty($_GET['numCom']) && isset($_GET['numArt']) && !empty($_GET['numArt'])) {
        $req = $bdd->prepare('DELETE FROM comment WHERE NumCom = :numCom');
        $req->execute(array(
            'numCom' => $_GET['numCom']
        ));

        $req->closeCursor();
    }

    // Redirection avec un message personnalisé
    header('Location: articles.php?numArt=' . $_GET['numArt']);

?>
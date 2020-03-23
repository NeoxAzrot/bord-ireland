<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include 'assets/php/connect_PDO.php';

    // Supprime le commentaire en utilisant la clés primaire
    if(isset($_GET['numCom']) && !empty($_GET['numCom']) && isset($_GET['numArt']) && !empty($_GET['numArt'])) {

        // Vérifie si c'est bien l'auteur qui demande de supprimer
        $req = $bdd->prepare('SELECT * FROM comment WHERE PseudoAuteur = :pseudo AND NumCom = :numCom');
        $req->execute(array(
            'pseudo' => $_SESSION['login'],
            'numCom' => $_GET['numCom']
        ));
        $donnees = $req->fetch();

        if(!empty($donnees)) {
            $req = $bdd->prepare('DELETE FROM comment WHERE NumCom = :numCom');
            $req->execute(array(
                'numCom' => $_GET['numCom']
            ));
    
            $req->closeCursor();
        }
    }

    // Redirection sur l'article en question
    header('Location: articles.php?numArt=' . $_GET['numArt']);

?>
<?php

    // Ouverture de la session et initialisation des erreurs et des includes
    session_start();

    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', 'on');
    error_reporting(E_ALL);

    include '../assets/php/connect_PDO.php';

    // Supprime la langue en utilisant la clés primaire
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $req = $bdd->prepare('DELETE FROM langue WHERE NumLang = :id');
        $req->execute(array(
            'id' => $_GET['id']
        ));

        $req->closeCursor();
    }

    // Redirection avec un message personnalisé
    $_SESSION['answer'] = "<span><b>" . $_GET['id'] . "</b> a bien été supprimé !</span>";
    header('Location: index.php');

?>
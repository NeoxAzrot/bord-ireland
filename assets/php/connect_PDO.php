<?php

    // Messages of errors = On
    ini_set('display_errors','on');
    ini_set('display_startup_errors','on');
    error_reporting(E_ALL);

    // 1. Chargement des variables de connexion
    /************************************************************************/
    // nom de votre serveur (ou 127.0.0.1)
    // ET nom BDD
    $hostBD = "localhost";
    // nom BD
    $nomBD = "BLOGART20";
    // nom utilisateur de connexion à la BDD
    $userBD = 'root';
    // mot de passe de connexion à la BDD
    $passBD = '';         // Pass MAC

    // 2. Ouverture de la connexion
    /************************************************************************/
    // Test de l'échec (ou pas) de la connexion
    // à partir d'une exception (try... catch...)
    try {
        $bdd = new PDO("mysql:dbname=$nomBD;host=$hostBD;charset=utf8", $userBD, $passBD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $error) {
        die('Failed to connect : ' . $error->getMessage());
    }

?>
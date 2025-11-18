<?php
include_once 'Connexion.php';
include_once 'Composants/mod_connexion/mod_connexion.php';
Connexion::initConnexion();
session_start();
$mod = new ModConnexion();
$contenuMenu = $mod->getAffichage();

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'client':
            include_once 'roles/client.php';
            $mod = new Client();
            $contenu = 'client';
        break;

        case 'vendeur':
            include_once 'roles/vendeur.php';
            $mod = new Vendeur();
            $contenu = 'vendeur';
            break;

        case 'gestionnaire':
            include_once 'roles/gestionnaire.php';
            $mod = new Gestionnaire();
            $contenu = 'gestionaire';
            break;
    }
}
else {
    $contenu = "Bienvenue dans le site d'achat";
}

include_once "template.php";
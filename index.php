<?php
include_once 'Connexion.php';
include_once 'Composants/mod_connexion/mod_connexion.php';
Connexion::initConnexion();
session_start();



if (isset($_SESSION['login'])) { // Si l'utilisateur est connecté
    include_once 'modules/mod_asso/mod_asso.php';
    $mod = new ModAsso();
    $contenu = 'Liste associations';

    $mod = new CompNavBar();
    $contenuMenu = $mod->affiche();
}
else {
    $mod = new ModConnexion();
    $contenuMenu = $mod->getAffichage();

    include_once 'modules/landingPage/mod_landingPage.php';
    $mod = new ModLandingPage();
    $contenu = 'landing page';
}

include_once "template.php";
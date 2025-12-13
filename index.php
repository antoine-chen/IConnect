<?php
include_once 'Connexion.php';
include_once 'Composants/mod_connexion/mod_connexion.php';
Connexion::initConnexion();
session_start();
$mod = new ModConnexion();
$contenuMenu = $mod->getAffichage();

if (isset($_SESSION['login'])) {
    include_once 'modules/mod_asso/mod_asso.php';
    $mod = new ModAsso();
    $contenu = $mod->getAffichage();

    include_once "Composants/comp_navbar/comp_navbar.php";
    $mod = new CompNavBar();
    $contenuMenu = $mod->affiche();
}

else {
    include_once 'modules/landingPage/mod_landingPage.php';
    $mod = new ModLandingPage();
    $contenu = 'landing page';
}

include_once "template.php";
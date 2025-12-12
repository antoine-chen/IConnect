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
    $contenu = 'Liste associations';
}

else {
    include_once 'modules/landingPage/mod_landingPage.php';
    $mod = new ModLandingPage();
    $contenu = 'landing page';
}

include_once "template.php";
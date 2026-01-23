<?php
include_once 'Connexion.php';
include_once 'Composants/mod_connexion/mod_connexion.php';
Connexion::initConnexion();
session_start();

$_SESSION['landing'] = 1;

$mod = new ModConnexion();
$contenuMenu = $mod->getAffichage();

if (isset($_SESSION['login'])) {
    include_once 'modules/mod_asso/mod_asso.php';
    $mod = new ModAsso();
    $contenu = $mod->getAffichage();
}
else {
    if ($_SESSION['landing'] == 1){
        include_once 'modules/landingPage/mod_landingPage.php';
        $mod = new ModLandingPage();
        $contenu = $mod->getAffichage();
    }
}
if ($_SESSION['landing'] == 1){
    include_once "Composants/comp_navbar/comp_navbar.php";
    $mod = new CompNavBar();
    $contenuMenu = $mod->affiche();
}

include_once "template.php";
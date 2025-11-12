<?php
include_once 'Connexion.php';


Connexion::initConnexion();

session_start();

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'client':
            //include_once 'modules/mod_client/mod_client.php';
            $mod = new ModClient();
        break;

        case 'vendeur':
            //include_once 'modules/mod_vendeur/mod_vendeur.php';
            $mod = new ModVendeur();
            break;

        case 'gestionaire':
            //include_once 'modules/mod_gestionaire/mod_gestionaire.php';
            $mod = new ModGestionaire();
            break;
    }
}else{
    //include_once 'modules/mod_connexion/mod_connexion.php';
    $mod = new ModConnexion();
}


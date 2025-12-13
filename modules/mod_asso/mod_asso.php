<?php

class ModAsso {
    private $controleur;
    private $action;

    public function __construct()
    {
        // Initialise le controleur

        $module = $_GET['module'] ? $_GET['module'] : "asso";
        switch ($module) {
            case 'panier':
                // new ModPanier
                break;
            case 'boutique':
                // New mod boutique
                break;
            case 'stock':
                // New mod stock
                break;
            case 'admin' :
                include_once 'modules/mod_admin/mod_admin.php';
                $mod = new ModAdmin();
            case "asso" :
                // Appelle le controleur de asso pour afficher la liste des assos
                break;
            default:
                echo "module inconnue";
                break;
    }
}
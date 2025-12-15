<?php
include_once 'cont_commande.php';
class ModCommande{
    public function __construct(){
        $modules = new ContCommande;
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'details':
        $this->modules->
                break;
            default:

        }
    }
}
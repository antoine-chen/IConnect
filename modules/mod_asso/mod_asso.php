<?php

class ModAsso
{
    private $module;

    public function __construct()
    {
        $action = isset($_GET['module']) ? $_GET['module'] : 'asso';
        switch ($action) {
            case 'panier':
                // $this->module = new ModPanier();
                break;
            case 'boutique':
                // $this->module = new ModBoutique();
                break;
            case 'stock':
                // $this->module = new ModStock();
                break;
            case 'admin':
                include_once 'modules/mod_admin/mod_admin.php';
                $this->module = new ModAdmin();
                break;
            case 'asso':
                include_once 'modules/mod_asso/cont_asso.php';
                $this->module = new ContAsso();
                break;
            default:
                $this->module = null;
                break;
        }
    }

    public function getAffichage()
    {
        if ($this->module != null) {
            return $this->module->getAffichage();
        } else {
            return $this->module = "module inconnu";
        }
    }
}
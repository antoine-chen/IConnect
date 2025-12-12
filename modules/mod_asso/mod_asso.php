<?php
class ModAsso {
    private $controleur;
    private $action;

    public function __construct()
    {
        // Initialise le controleur

        if(!isset($_SESSION['asso'])) { // Si l'utilisateur n'a pas choisi d'associations
            // Appelle le controleur de asso pour afficher la liste des assos
        }
        else { // Si l'utilisateur a pas choisi un asso
            $module = $_GET['module'];
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
                default:
                    // Appelle la fonction du controleur pour afficher la page d'accueil de l'asso (qui est différent
                    //selon les roles), : cette fonction va déterminer quel fonction de la vue appeller
            }

        }
    }
}
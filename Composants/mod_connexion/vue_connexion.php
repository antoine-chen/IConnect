<?php
include_once "vue_generique.php";

class VueConnexion extends VueGenerique {
    public function __construct() {
        parent::__construct();
    }
    public function menu() {
        echo '
        <nav>
            <ul>
                <li><a href="index.php?actionComposant=form_connexion">Se connecter</a></li>
                <li><a href="index.php?actionComposant=form_inscription">S inscrire</a></li>
            </ul>
        </nav>
    ';
    }


    public function form_inscription() {
        echo '
            
            <form method="post" action="index.php?actionComposant=inscription" class="container taille-connexion">
                <h2 class="text-center">Inscription</h2>
                <div class="form-floating mt-3 mb-2">
                    <input name="login" class="form-control" placeholder="Login">
                    <label>Login</label>
                </div>
                <div class="form-floating">
                    <input name="pwd" class="form-control" placeholder="Mot de passe">
                    <label>Mot de passe</label>
                </div>
                <div class="mb-3">
                    <a href="index.php?actionComposant=form_connexion"> Connectez-vous ici</a>
                </div>
                <input class="btn btn-primary" type="submit" value="inscrire">
                
            </form>
        ';
    }

    public function form_connexion() {
        echo '
            <form method="post" action="index.php?actionComposant=connexion" class="container taille-connexion">
                <h2 class="text-center">Connexion</h2>
                <div class="form-floating mt-3 mb-2">
                    <input name="login" class="form-control" placeholder="Login">
                    <label>Login</label>
                </div>
                <div class="form-floating">
                    <input name="pwd" class="form-control" placeholder="Mot de passe">
                    <label>Mot de passe</label>
                </div>
                <div class="mb-3">
                    <a href="index.php?actionComposant=form_inscription">Créer un compte</a>
                </div>
                <input class="btn btn-primary" type="submit" value="Se connecter">
            </form>      
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

}



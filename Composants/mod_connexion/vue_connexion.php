<?php
include_once "vue_generique.php";

class VueConnexion extends VueGenerique {
    public function __construct() {
        parent::__construct();
    }

    public function form_inscription() {
        echo '
            <div class="center-connexion bg-white">
                <form method="post" action="index.php?actionComposant=inscription" class="taille-connexion container-color rounded-4">
                    <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                    <h2 class="text-center">Inscription</h2>
                    <div class="form-floating mt-3 mb-2">
                        <input name="login" class="form-control" placeholder="Login" type="text" minlength="3" required>
                        <label>Login</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input name="pwd" class="form-control" placeholder="Mot de passe" type="text" minlength="12" required>
                        <label>Mot de passe</label>
                    </div>
                    
                    <div class="form-floating mt-3">
                        <input name="nom" class="form-control" placeholder="Nom" required>
                        <label>Nom</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input name="prenom" class="form-control" placeholder="Prenom" required>
                        <label>Prenom</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input name="email" class="form-control" placeholder="Email">
                        <label>Email</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input name="telephone" class="form-control" placeholder="Téléphone">
                        <label>Téléphone</label>
                    </div>
                    <div class="mb-3">
                        <a href="index.php?actionComposant=form_connexion"> Connectez-vous ici</a>
                    </div>
                    <input class="btn btn-primary" type="submit" value="inscrire">
                </form>
            </div>
        ';
    }

    public function form_connexion() {
        echo '
            <div class="center-connexion bg-white">
                <form method="post" action="index.php?actionComposant=connexion" class="taille-connexion container-color rounded-4">
                    <h2 class="text-center">Connexion</h2>
                    <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                    <div class="form-floating mt-3 mb-2">
                        <input name="login" class="form-control" placeholder="Login" type="text" minlength="3" required>
                        <label>Login</label>
                    </div>
                    <div class="form-floating">
                        <input name="pwd" class="form-control" placeholder="Mot de passe" type="text" minlength="12" required>
                        <label>Mot de passe</label>
                    </div>
                    <div class="mb-3">
                        <a href="index.php?actionComposant=form_inscription">Créer un compte</a>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Se connecter">
                </form>    
            </div>  
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

}



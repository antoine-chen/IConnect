<?php
class VueConnexion  {
    public function __construct() {
    }
    public function menu() {
        echo '
        <nav>
            <ul>
                <li><a href="index.php?action=form_connexion">Se connecter</a></li>
                <li><a href="index.php?action=form_inscription">S inscrire</a></li>
            </ul>
        </nav>
    ';
    }


    public function form_inscription() {
        echo '
            <h2>Inscription</h2>
            <form method="post" action="index.php?action=inscription">
                <label>Login :</label><br>
                <input name="login"><br><br>
                <label>Mot de passe :</label><br>
                <input name="pwd"><br><br>
                <input type="submit" value="inscrire">
            </form>
            <br>
            <a href="index.php?action=form_connexion"> Connectez-vous ici</a>
        ';
    }

    public function form_connexion() {
        echo '
            <h2>Connexion</h2>
            <form method="post" action="index.php?action=connexion">
                <label>Login :</label><br>
                <input name="login"><br><br>
                <label>Mot de passe :</label><br>
                <input name="pwd"><br><br>
                <input type="submit" value="Se connecter">
            </form>
            <br>
            <a href="index.php?action=form_inscription">Créer un compte</a>
        ';
    }

    public function message($msg) {
        echo "<p>$msg</p>";
    }

    public function lien_deconnexion() {
        echo '<p><a href="index.php?action=deconnexion">Se déconnecter</a></p>';
    }

}



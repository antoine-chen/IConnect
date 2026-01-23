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
        ';
        $this->confirmationProgressBar();
        echo '
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
                        <a href="index.php?actionComposant=rgpd">Créer un compte</a>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Se connecter">
                </form>    
            </div>  
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

    public function avertissementModal(){
        echo '
            <!-- ce bloc est une fenêtre modale, ajoute une animation  -->
            <div class="modal fade" id="rgpd">
                <!-- centre la modal verticalement dans l’écran -->
                <div class="modal-dialog modal-dialog-centered">
                    <!-- modal-content le rectangle blanc contient tout le contenu visible -->
                    <div class="modal-content p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Cookies</h4>
                            <a href="index.php" type="button" class="btn-close" aria-label="Close"></a>
                        </div>
                        <div>                            
                        <h1>Politique de confidentialité et cookies</h1>

    <h2>1. Données personnelles collectées</h2>
    <p>
        Lors de l’inscription sur le site, l’association collecte uniquement les données personnelles suivantes :
    </p>
    <ul>
        <li>Nom</li>
        <li>Prénom</li>
        <li>Adresse e-mail</li>
        <li>Numéro de téléphone</li>
    </ul>
    <p>
        Ces informations sont nécessaires afin d’identifier les adhérents de l’association et de leur permettre l’accès
        aux services proposés par la boutique associative.
    </p>

    <h2>2. Finalité de la collecte</h2>
    <p>
        Les données personnelles sont collectées exclusivement pour les finalités suivantes :
    </p>
    <ul>
        <li>Identification des adhérents</li>
        <li>Gestion des comptes utilisateurs</li>
        <li>Communication liée aux activités de l’association et à la boutique</li>
    </ul>
    <p>
        Aucune donnée n’est collectée sans inscription préalable.
    </p>

    <h2>3. Destinataires des données</h2>
    <p>
        Les données collectées sont destinées uniquement aux membres habilités de l’association.
        Elles ne sont ni vendues, ni échangées, ni transmises à des tiers, sauf obligation légale.
    </p>

    <h2>4. Durée de conservation</h2>
    <p>
        Les données sont conservées pendant toute la durée de l’adhésion à l’association.
        Elles peuvent être supprimées sur demande de l’adhérent ou à la fin de son adhésion.
    </p>

    <h2>5. Droits des adhérents</h2>
    <p>
        Conformément au Règlement Général sur la Protection des Données (RGPD), chaque adhérent dispose des droits suivants :
    </p>
    <ul>
        <li>Droit d’accès</li>
        <li>Droit de rectification</li>
        <li>Droit de suppression</li>
        <li>Droit d’opposition et de limitation du traitement</li>
    </ul>
    <p>
        Ces droits peuvent être exercés en contactant l’association à l’adresse suivante :
        <strong>[adresse e-mail de contact de l’association]</strong>
    </p>
    <h2>Retrait du consentement</h2>
<p>
    L’adhérent peut retirer son consentement au traitement de ses données personnelles à tout moment.
    Le retrait du consentement entraîne la suppression ou l’anonymisation du compte utilisateur,
    et la perte d’accès aux services proposés par l’association.
</p>

    <h2>6. Cookies</h2>
    <p>
        Le site utilise des cookies strictement nécessaires à son bon fonctionnement, notamment pour :
    </p>
    <ul>
        <li>La gestion de la session utilisateur</li>
        <li>L’accès sécurisé aux comptes adhérents</li>
    </ul>
    <p>
        Aucun cookie publicitaire n’est utilisé.
        Des cookies de mesure d’audience peuvent être utilisés de manière anonymisée.
    </p>
    <p>
        Lors de votre première visite, un bandeau vous informe de l’utilisation des cookies et vous permet
        de les accepter ou de les refuser.
    </p>

    <h2>7. Hébergement des données</h2>
    <p>
        Le site est hébergé en France. Les données personnelles sont stockées sur des serveurs situés
        en France ou au sein de l’Union européenne.
    </p>

</body>
</html>
                        <hr>
                      en clickant sur la case "Accepter" « J’accepte que mes données personnelles soient utilisées conformément à la politique de confidentialité »
                        <div class="d-flex justify-content-end gap-2">
                            <!-- ferme le modal -->
                            <a href="index.php" class="btn btn-secondary"> Refuser</a>
                            <a href="index.php?actionComposant=form_inscription" class=" btn btn-secondary"> Accepter</a>
                        </div>
                    </div>
                </div>
            </div>
        ';
        echo '<script>const modal = new bootstrap.Modal(document.getElementById("rgpd"));
        modal.show();</script>';
    }

}



<?php
include_once 'vue_generique.php';
class VueLandingPage extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }

    public function afficherlandingPage(){
        echo '
            <nav class="row m-3 align-items-center mx-5">
        <div class="col">
            <img src="../../modules/mod_asso/logos/logo.png" style="width: 50px;" alt="">
        </div>
        <div class="col-8 d-flex justify-content-center gap-3 mx-5">
            <a href="">Accueil</a>
            <a href="">Produits</a>
            <a href="">Fonctionnalités</a>
        </div>
        <div class="col">
            <a href="" class="btn btn-primary">Se connecter</a>
        </div>
    </nav>

    <div>
        <div class="d-flex justify-content-center align-items-center gap-5 m-5">
            <div class="mx-5">
                <div class="display-5 fw-bold">
                    <div>Gagnez du temps</div>
                    <div>Plateforme de gestion</div>
                    <div>de buvette associative</div>
                </div>
                <div class="fs-6 mt-4">
                    <div>Oubliez les cartes physique,</div>
                    <div>cette solution vous simplifies la vie.</div>
                </div>
                <div>
                <a href="" class="btn btn-success mt-2">S\'inscrire</a>
                </div>
            </div>
            <div>
                <img class="rounded img-fluid" style="height: 600px;" src="./img_landingPage/image.png"">
            </div>
        </div>

        <div class="m-5">
            <h2>Présentation</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium expedita quidem beatae dicta asperiores dignissimos quaerat vero aspernatur sit assumenda. Numquam veritatis minima esse deleniti magnam nemo expedita! Dolores, quam? Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero adipisci deleniti, repellat, exercitationem ipsum ipsa nemo molestias quam doloribus neque accusantium eveniet eius molestiae recusandae vitae? Rerum sunt quaerat commodi. </p>
        </div>

        <div class="m-5">
            <h2>Nos produits</h2>
            <div class="text-center d-flex justify-content-center gap-5">
                <div>
                    <img class="rounded img-fluid" style="height: 300px;" src="./img_landingPage/boisson.png" alt="">
                    <p>Lorem ipsum dolor</p>
                </div>
                <div>
                    <img class="rounded img-fluid" style="height: 300px;" src="./img_landingPage/snack.jpg" alt="">
                    <p>Lorem ipsum dolor</p>
                </div>
            </div>
        </div>

        <div class="m-5">
            <h2>Fonctionnalités</h2>
            <div class="d-flex justify-content-center align-items-center">
                <div class="w-25 mx-5">
                    <h3 class="text-center">Charger son compte</h3>
                    <p>Après la connextion, vous pourvez charger votre compte en mettant que le montant que vous voulez puis valider.</p>
                </div>
                <img class="rounded img-fluid" style="height: 300px; width: 300px;" src="./img_landingPage/rechargement.png" alt="">
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="w-25 mx-5">
                    <h3 class="text-center">Liste des produits</h3>
                    <p>Vous pouvez consulter la liste des produits de chaque association  en cliquand sur l’association</p>
                </div>
                <img class="rounded img-fluid" style="height: 300px; width: 300px;" src="./img_landingPage/listeProduits.png" alt="">
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="w-25 mx-5">
                    <h3 class="text-center">Panier</h3>
                    <p>Après avoir que vous avez fait votre panier il suffit de le valider le barman valide votre transition et vous donne ce que vous avez commander</p>
                </div>
                <img class="rounded img-fluid" style="height: 300px; width: 300px;" src="./img_landingPage/validerPanier.png" alt="">
            </div>
        </div>

    </div>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}
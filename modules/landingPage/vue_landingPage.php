<?php
include_once 'vue_generique.php';
class VueLandingPage extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }

    public function afficherlandingPage(){
        echo '
    <div>
        <div id="accueil" class="d-flex justify-content-center align-items-center gap-5 m-5">
            <div class="mx-5">
                <div class="display-5 fw-bold">
                    <div>Gagnez du temps</div>
                    <div>Plateforme de gestion</div>
                    <div>de buvette associative</div>
                </div>
                <div class="fs-6 mt-4">
                    <div>Oubliez les cartes physiques,</div>
                    <div>cette solution vous simplifie la vie.</div>
                </div>
                <div>
                <a href="index.php?actionComposant=form_inscription" class="btn btn-success mt-2">S\'inscrire</a>
                </div>
            </div>
            <div>
                <img class="rounded img-fluid" style="height: 600px;" src="modules/landingPage/img_landingPage/image.png" alt="">
            </div>
        </div>

        <div class="m-5">
            <h2 class="mb-4"><span class="badge text-bg-primary">Présentation</span></h2>
            <p>Ce projet consiste à développer une application web destinée à moderniser la gestion des buvettes associatives. L’objectif est de supprimer l’utilisation d’argent liquide en mettant en place un système de comptes numériques rechargeables pour les adhérents. Les utilisateurs peuvent acheter des consommations directement au comptoir, tandis que les barmen enregistrent les ventes via l’application. Les gestionnaires disposent d’outils pour suivre les stocks, réaliser des inventaires et analyser les ventes. L’application est conçue pour être utilisable sur mobile et pour gérer plusieurs associations de manière indépendante.</p>
        </div>

        <div id="produits" class="m-5">
            <h2><span class="badge text-bg-secondary">Fonctionnalités</span></h2>
            <div class="text-center d-flex justify-content-center gap-5">
                <div>
                    <img class="rounded img-fluid" style="height: 300px;" src="modules/landingPage/img_landingPage/boisson.png" alt="">
                    <p>Des boissons disponibles</p>
                </div>
                <div>
                    <img class="rounded img-fluid" style="height: 300px;" src="modules/landingPage/img_landingPage/snack.jpg" alt="">
                    <p>Des boissons disponibles</p>
                </div>
            </div>
        </div>

        <div id="fonctionnalités" class="m-5">
            <h2><span class="badge text-bg-success">Fonctionnalités</span></h2>
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="w-25 mx-5">
                    <h3 class="text-center">Charger son compte</h3>
                    <p>Après la connexion, vous pouvez charger votre compte en mettant que le montant que vous voulez puis valider.</p>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="w-25 mx-5">
                    <h3 class="text-center">Liste des produits</h3>
                    <p>Vous pouvez consulter la liste des produits de chaque association  en cliquant sur l’association</p>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="w-25 mx-5">
                    <h3 class="text-center">Panier</h3>
                    <p>Après avoir que vous avez fait votre panier il suffit de le valider pour que le barman valide votre commande et vous donne ce que vous avez commandé</p>
                </div>
            </div>
        </div>

    </div>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}
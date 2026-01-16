<?php
include_once "vue_generique.php";

class VueAsso extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }

    public function afficher() {
        return $this->getAffichage();
    }

    public function afficherListeAsso($associations){
        echo '
        <div class="d-flex justify-content-center align-items-center">
            <div class="d-flex flex-column gap-4">

        ';
        foreach ($associations as $elementAsso) {
            echo '
                <div class="box-asso">
                    <a href="index.php?module=asso&action=choisiAsso&id='.$elementAsso['id'].'">
                      <img src="'. $elementAsso['image'] .'" class="img-association" alt="">
                      <h6>'. htmlspecialchars($elementAsso['nom']). '</h6>
                   </a>
                </div>
            '; 
        }
        echo '
            </div>
        </div>    
        ';
    }

    public function choixRole($roles, $idAsso) {
        echo '
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="d-flex flex-column gap-3">
            <h2 class="text-center">Choisir de se connecter en :</h2>
    ';

        foreach ($roles as $role) {
            echo '
        <div class="text-center">
            <a href="index.php?module=asso&action=choisiAsso&role='.$role.'&id='.$idAsso.'" class="btn btn-primary">
                '.htmlspecialchars($role).'
            </a>
        </div>
        ';
        }

        echo '
        </div>
    </div>
    ';
    }




}
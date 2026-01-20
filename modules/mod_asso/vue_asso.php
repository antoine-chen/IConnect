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

    public function afficherFormAssociation($messageErreur){
        echo '
            <h2 class="text-center">Ajouter une association</h2>
            <form action="index.php?module=asso&action=ajouterAssociation" method="post" enctype="multipart/form-data" class="container taille-formulaire">
                <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                <p class="text-danger">' . $messageErreur . '</p>
                <div class="form-floating">
                    <input name="nom" class="form-control" placeholder="Nom de l\'association" required>
                    <label>Nom de l\'association :</label><br>
                </div>
                <div class="mb-3">
                    <label for="imageAso" class="form-label">Choisissez une image :</label>
                    <input type="file" name="imageAso" id="imageAso" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        
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
            <a href="index.php?module=asso&action=choisiAsso&role='.$role['role'].'&id='.$idAsso.'" class="btn btn-primary">
                '.htmlspecialchars($role['role']).'
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
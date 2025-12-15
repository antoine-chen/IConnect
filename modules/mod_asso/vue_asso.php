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
        echo '<section class="d-flex align-items-center flex-column gap-4">';
        foreach ($associations as $elementAsso) {
            echo '
                <div>
                    <a href="index.php?module=asso&action=choisiAsso&id='.$elementAsso['id'].'">
                      <img src="'. $elementAsso['image'] .'" style="width: 600px; height: 300px;" alt="">
                      <h6>'. htmlspecialchars($elementAsso['nom']). '</h6>
                   </a>
                </div>
            '; 
        }
        echo '</section>';
    }

}
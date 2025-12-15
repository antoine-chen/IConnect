<?php
include_once "vue_generique.php";

class VueAsso extends VueGenerique {
    public function __construct()
    {
        parent::__construct();
    }

    public function afficher() {
        return $this->getAffichage();
    }

    public function afficherListeAsso($associations)
    {
        foreach ($associations as $elementAsso) {
            ?>
            <div>
                <a href="index.php?module=asso&action=choisiAsso&id=<?php echo htmlspecialchars($elementAsso['id']); ?>">
                    <img src="<?php echo htmlspecialchars($elementAsso['image']); ?>" width="50">
                </a>
                <p><?php echo htmlspecialchars($elementAsso['nom']); ?></p>
            </div>
            <?php
        }
    }

}
<?php

class VueGenerique {

    public function __construct() {
        ob_start();
    }

    public function getAffichage()
    {
        return ob_get_clean();
    }
}

?>
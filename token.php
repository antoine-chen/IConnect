<?php
include_once 'abstractToken.php';
class Token extends AbstractToken {

    public static function genererToken() {
        $_SESSION['tokenCSRF'] = bin2hex(random_bytes(24));
        return $_SESSION['tokenCSRF'];
    }

    public static function getToken() {
        if(isset($_SESSION['tokenCSRF'])) {
            return $_SESSION['tokenCSRF'];
        }
        return null;
    }

    public static function verifierToken($tokenParam): bool
    {
        if(empty($_SESSION['tokenCSRF']) || $_SESSION['tokenCSRF'] != $tokenParam) {
            return false;
        }
        else {
            unset($_SESSION['tokenCSRF']);
            return true;
        }
    }
}
?>
<?php
abstract class AbstractToken {
    public abstract static function genererToken();
    public abstract static function getToken();
    public abstract static function verifierToken($tokenParam);
}
?>
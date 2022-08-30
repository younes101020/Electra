<?php
    // Toute les fonctions auront attrait au chaine de caractères seront dans cette classe
    class Str{

        // Cette fonction vas générer une chaîne de caractères qui fais une certaine taille (notre token)
        static function random($length) {
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        
            // La chaîne alphabet sera répété plusieurs (64 fois pour avoir la possibilite d'avoir plusieurs fois le meme caracteres) 
            // fois et la melanger avec la méthode shuffle et enfin nous allons retourner que les 64 ($length) premiers caractères
            // grâce à substr
            return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
        }

    }
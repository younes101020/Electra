<?php
    // Ce fichier permettra de gérer les inclusions càd qu'au lieu de faire des require à tout vas dans mes fichier
    // je n'aurais qu'à inclure ce fichier et il detectera les class utiliser dans mon fichier pour me les retourner
    // On appelle ça un auto loader

    spl_autoload_register('app_autoload');

    function app_autoload($model) {
        require "../models/$model.php";
    }
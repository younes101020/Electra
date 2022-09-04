<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();
    $show = App::getShow();

    // Récupération de la showlist de l'utilisateur
    if($show->getList() !== 0) {
        $show->getMovieList();
    } else {
        echo "Pas de liste trouvé, sert toi dans l'accueil.";
    }

    $title = "Ma showlist - Electra";
    include '../inc/header.php';
    include '../views/showlist.php';

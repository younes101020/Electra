<?php 

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

    // Récupération des films
    $show_instance = App::getShow();
    $shows = $show_instance->showRetrieve();

    $showid = 1;

    $style = NULL;
    $title = "Film - Electra";
    include '../inc/header.php';
    include '../views/accueil.php';
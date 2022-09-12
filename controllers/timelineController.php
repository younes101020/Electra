<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();
    $show = App::getShow();


    $publicshowlists = $show->getPublicShowlist();

    $title = "Timeline - Electra";
    include_once '../inc/header.php';
    include_once '../views/timeline.php';
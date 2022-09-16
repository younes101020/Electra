<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();
    $show = App::getShow();
    $auth = App::getAuth();


    $publicshowlists = $show->getPublicShowlist();
    $commentsarr = $show->getComments();

    $title = "Timeline - Electra";
    include_once '../inc/header.php';
    include_once '../views/timeline.php';
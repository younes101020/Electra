<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();
    $show = App::getShow();
    $auth = App::getAuth();


    $publicshowlists = $show->getPublicShowlist();
    $commentsarr = $show->getComments();
    $currentUsername = $auth->user();

    $style = 'style="overflow-y: hidden;"';
    $title = "Timeline - Electra";
    include_once '../inc/header.php';
    include_once '../views/timeline.php';
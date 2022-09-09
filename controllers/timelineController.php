<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

    $title = "Timeline - Electra";
    include_once '../inc/header.php';
    include_once '../views/timeline.php';
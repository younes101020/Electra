<?php 

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

    $title = "Administration - Electra";
    include_once '../inc/header.php';
    include_once '../inc/header_account.php';
    include_once '../views/administration.php';
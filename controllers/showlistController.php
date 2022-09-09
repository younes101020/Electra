<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

    if(isset($_POST['listname'])) {
        $show = App::getShow();
        $show->listname = $_POST['listname'];
        $show->setListName();
    } 

    // Récupération de la showlist de l'utilisateur
    function callShowlist() {
        $show = App::getShow();
        if($show->getList() !== 0) {
            $showlist = $show->getMovieList();
            return $showlist;
        } else {
            $show->addList();
            $show->getList();
            $showlist = $show->getMovieList();
            return $showlist;
        }
    }
    // Récupération du nom de la showlist de l'utilisateur
    function calllistName() {
        $show = App::getShow();
        if($show->getList() !== 0) {
            $show->getListName();
            $listname = $show->listname;
            return $listname;
        } else {
            $show->addList();
            $show->getListName();
            return $show->listname;
        }
        
        
    }
    

    $title = "Ma showlist - Electra";
    include_once '../inc/header.php';
    include_once '../views/showlist.php';

<?php

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

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
    include '../inc/header.php';
    include '../views/showlist.php';

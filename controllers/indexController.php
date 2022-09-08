<?php
    // Vérification du nom d'utilisateur
    // Récupération de la row username en PHP afin de fournir la donnée à l'Ajax et enfin pouvoir faire nos vérifications
    // D'utilisateur déjà existant en Javascript 

    // Je n'ai pas trouver de moyen de faire fonctionner l'auto loader ici
    // L'inclusion se fait donc manuellement sur ce fichier
    require_once '../inc/bootstrap.php';


    $auth = App::getAuth();
    $show = App::getShow();

    $showtransaction = new Transaction;
    

    if(isset($_GET['pseudonyme'])) {

        $auth->username = $_GET['pseudonyme'];
        echo $auth->getUserByUsername();

    } else if(isset($_GET['email'])) {

        $auth->email = $_GET['email'];
        echo $auth->getUserByMail();

    } else if(isset($_GET['search'])) {

        $show->showname = $_GET['search'];
        echo $show->getShowByName();

    } else if(isset($_GET['addingshow'])) {

        $show->getList();
                if($show->listid > 0) {
                    $show->addingshow = $_GET['addingshow'];
                    $show->getidShow();
                } else {                
                    $show->addingshow = $_GET['addingshow'];
                    $show->addList();
                    $show->listid = $showtransaction->lastInsertId();
                    $show->getidShow();
                }
        
    } else if(isset($_GET['deletingshow'])) {
        $show->deletingshow = $_GET['deletingshow'];
        $show->getList();
        $show->getlistcontentId();
        $show->removeshowList();
    } else if(isset($_GET['checkedshow'])) {

        $show->checkedshow = $_GET['checkedshow'];
        $show->getList();
        $showlist = $show->checkmovieinList();
        echo $showlist;

    }
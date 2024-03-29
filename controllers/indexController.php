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

    } else if(isset($_GET['listname'])) {

        $show->listname = $_GET['listname'];
        echo $show->getlistByListName();

    } else if(isset($_GET['statuslist'])) {

        $show->validated = $_GET['statuslist'];
        $show->setListStatus();

    } else if(isset($_GET['getstatuslist'])) {

        $show->getList();

        $details = $show->getListDetails();

        $validated = $details->validated;
        
        echo json_encode($validated);

    } else if(isset($_GET['message']) && isset($_GET['sentlistnameforcomment'])) {

        $show->listname = $_GET['sentlistnameforcomment'];
        $show->commentaire = $_GET['message'];

        $show->getlistidByListName();

        $show->setComment();
    } else if(isset($_GET['deletingcom'])) {

        $show->content = $_GET['deletingcom'];
        $show->deleteComments();

    } else if(isset($_GET['rating']) && isset($_GET['showname'])) {

        $show->note = $_GET['rating'];
        $show->showname = $_GET['showname'];

        $show->getShowIdByName();
        $show->checkIfUserRated();

        if($show->notationid == 0) {
            $show->ratingShow();
            echo "Vous n'avez pas noté ce film";
        } else {
            $show->updateUserRating();
            echo "Vous avez déjà noté ce film";
        }
        
        
    }
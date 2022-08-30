<?php
    // Vérification du nom d'utilisateur
    // Récupération de la row username en PHP afin de fournir la donnée à l'Ajax et enfin pouvoir faire nos vérifications
    // D'utilisateur déjà existant en Javascript 

    // Je n'ai pas trouver de moyen de faire fonctionner l'auto loader ici
    // L'inclusion se fait donc manuellement sur ce fichier
    require_once '../inc/bootstrap.php';


    $auth = App::getAuth();
    $show = App::getShow();
    

    if(isset($_GET['pseudonyme'])) {
        $auth->username = $_GET['pseudonyme'];
        echo $auth->getUserByUsername();
    } else if(isset($_GET['email'])) {
        $auth->email = $_GET['email'];
        echo $auth->getUserByMail();
    } /*else if(isset($_GET['search'])) {
        $show->showname = $_GET['search'];
        $searchResult = $db->query('SELECT name, buy, image, synopsis FROM elec_shows WHERE TRIM(name) = ?', [$_GET['search']])->fetch();
        echo json_encode($searchResult);
    }*/
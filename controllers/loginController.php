<?php

    require '../inc/bootstrap.php';
    $auth = App::getAuth();
    $auth->connectFromCookie();
    // Si l'utilisateur est déjà connecté alors le rediriger vers son compte
    if($auth->user()) {
        App::redirect('showController.php');
    }

    if(isset($_POST['submit'])) {
        $auth->username = $_POST['pseudonyme'];
        $auth->password = $_POST['password'];
        $auth->remember = $_POST['remember'];
        $user = $auth->login(isset($_POST['remember']));
        $session = Session::getInstance();
        // Si l'utilisateur est connecté
        if($user) {
            $session->setFlash('success', 'Vous êtes maintenant connecté');
            App::redirect('showController.php');
            exit();
        } else {
            $session->setFlash('error', 'Pseudonyme ou mot de passe incorrect');
            var_dump($user);
        }
    }

    $style = 'style="overflow-y: hidden;"';
    $title = "Connexion - Electra";
    require_once '../inc/header.php';
    require_once '../views/login.php';

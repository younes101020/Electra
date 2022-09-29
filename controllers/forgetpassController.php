<?php
    require '../inc/bootstrap.php';
    if(!empty($_POST['email'])) {
        $auth = App::getAuth();
        $session = Session::getInstance();
        $auth->email = $_POST['email'];
        if($auth->resetPassword()){
            $session->setFlash('success', 'Les instructions du rappel de mot de passe vous ont été envoyées par emails');
            App::redirect('loginController.php');
        } else {
            $session->setFlash('error', 'Aucun compte ne correspond à cette adresse');
        }
    }

    $title = "Electra - Mot de passe oublié";
    require_once '../inc/header.php';
    require_once '../views/forget.php';
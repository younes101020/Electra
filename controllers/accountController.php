<?php 

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

    // Si le mot de passe peut être modifier (vérif fais cote JS) récuperer l'id de l'utilisateur de la db
    // Egalement hasher son nouveau mot de passe pour pouvoir l'envoyer dans sa row sql
    //Initialiser une connexion à la db
    // Et enfin mettre à jour son champs sql password avec son nouveau mot de passe
    $auth = App::getAuth();
    if(!empty($_POST['newPassword'])){
        $auth->id = $auth->user()->id;
        $auth->password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
        $auth->updatePassword();
        Session::getInstance()->setFlash('success', "Votre mot de passe a bien été mis à jour");
    } else if(!empty($_POST['pseudonyme'])) {
        $auth->username = $_POST['pseudonyme'];
        $auth->updateUsername();
        Session::getInstance()->setFlash('success', "Votre pseudonyme a bien été mis à jour");
    }


    $style = NULL;
    $title = "Mon compte - Electra";
    include_once '../inc/header.php';
    include_once '../inc/header_account.php';
    include_once '../views/account.php';
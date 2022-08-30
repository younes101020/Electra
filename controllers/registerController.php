<?php
    require_once '../inc/bootstrap.php';
    // Si les regex et verifications de donnée utilisateurs déjà existant fait en javascript s'avére retourner aucune
    // erreur, alors executer la requete d'insertion à la table users. Dans le cas contraire le javascript appliquera
    // la méthode preventDefault qui empechera la condition ci-dessous de retourner true
    // Un token aléatoire sera attribuer à chaque utilisateur tout justement enregistrer afin de permettre partiellement la confirmation
    // d'inscription par email. Chaque nouvelle utilisateur recevra un mail dans lequel sera indiquer un lien qui les redirigera vers
    // la page confirm.php avec comme parametres query: leur ID et token

    if(isset($_POST['submit'])) {
        $auth = App::getAuth();
        $db_instance = new Transaction;
        $auth->username = $_POST['pseudonyme'];
        $auth->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $auth->email = $_POST['email'];
        $auth->token = $auth->random();
        $auth->register();
        $user_id = $db_instance->lastInsertId();
        mail($_POST['email'], 'Electra - Confirmation de votre compte', "Afin de valider votre compte Electra merci de cliquer sur ce lien\n\nhttp://localhost/controllers/confirmController.php?id=" . $user_id . "&token=" . $auth->token . "", "From: youneslow60@gmail.com");
        Session::getInstance()->setFlash('success', 'Un email de confirmation vous a été envoyé pour valider votre compte');
        App::redirect('loginController.php');
        exit();
    }

    $title = "Inscription - Electra";
    include_once '../inc/header.php';
    include_once '../views/register.php';

?>
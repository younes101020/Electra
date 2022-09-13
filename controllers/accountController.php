<?php 

    require '../inc/bootstrap.php';
    App::getAuth()->restrict();

    // Si le mot de passe peut être modifier (vérif fais cote JS) récuperer l'id de l'utilisateur de la db
    // Egalement hasher son nouveau mot de passe pour pouvoir l'envoyer dans sa row sql
    //Initialiser une connexion à la db
    // Et enfin mettre à jour son champs sql password avec son nouveau mot de passe
    if(isset($_POST['submit'])){
        $auth = App::getAuth();
        $auth->id = $auth->user();
        $auth->password = $auth->hashPassword($_POST['password']);
        $auth->updatePassword();
        Session::getInstance()->setFlash('success', "Votre mot de passe a bien été mis à jour");
    }


    $title = "Mon compte - Electra";
    include_once '../inc/header.php';
    include_once '../inc/header_account.php';
    include_once '../views/account.php';
    if(Session::getInstance()->hasFlashes()) {
        foreach(Session::getInstance()->getFlashes() as $key => $message) {
            if($key == 'error') {
                echo "<div id='notif'>
                        <p class='errormsg'> <?= $message; ?> </p>
                     </div>";
            } else {
                echo "<div id='notif'>;
                    <p class='successmsg'> <?= $message; ?> </p>
                </div>";
            }
        }
    }
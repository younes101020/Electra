<?php
    require '../inc/bootstrap.php';
    if(isset($_GET['id']) && isset($_GET['token'])) {
        $auth = App::getAuth();
        $auth->id = $_GET['id'];
        $auth->reset_token = $_GET['token'];
        $auth->checkResetToken($_POST['password']);
    } else {
        App::redirect('loginController.php');
    }
<body class="forced_no_overflow">
    <?php if(App::getAuth()->user()): ?>
        <li class="logout"><a href="logoutController.php">Déconnexion <i class="fa-solid fa-arrow-up-left-from-circle"></i></a></li>
    <?php endif; ?>
    
    <!-- Afficher chaque message flash (le status de l'utilisateur) si il y en a -->
    <?php if(Session::getInstance()->hasFlashes()): ?>
            <?php foreach(Session::getInstance()->getFlashes() as $key => $message): ?>
                <?php if($key == 'error'): ?>
                    <div id="notif">
                        <p class="errormsg"> <?= $message; ?> </p>
                    </div>
                <?php else: ?>
                    <div id="notif">
                        <p class="successmsg"> <?= $message; ?> </p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    <div class="ocontainer">
        <div class="bg-form">
            <img class="login-logo" src="../img/logo_signe.svg" alt="Logo d'Electra">
                <form action="accountController.php" method="POST">
                    <div id="btinput">
                        <input id="tinput" type="password" name="password" placeholder="votre nouveau mot de passe">
                        <i class="fa-solid fa-arrows-to-eye eye" id="togglePassword"></i>
                    </div>
                    <div class="check">
                        <input class="btn-sub register-btn" type="submit" id="submitt" name="submit" value="modifier">
                    </div>
                </form>
        </div>
    </div>
    <script src="../js/account.js"></script>
</body>
</html>
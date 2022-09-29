
<body>
<?php if(Session::getInstance()->hasFlashes()): ?>
            <?php foreach(Session::getInstance()->getFlashes() as $key => $message): ?>
                <?php if($key == 'error'): ?>
                    <div id="phpnotif">
                        <p class="errormsg"> <?= $message; ?> </p>
                    </div>
                <?php else: ?>
                    <div id="phpnotif">
                        <p class="successmsg"> <?= $message; ?> </p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
<?php endif; ?>
<main>
<div class="ocontainer">
            <div class="bg-form">
                <a href=".."><img class="login-logo" src="../img/logo_signe.svg" alt="Logo d'Electra"></a>
                <form action="loginController.php" method="POST">
                    <div id="bfinput">
                        <input id="finput" type="text" name="pseudonyme" placeholder="votre pseudonyme">
                    </div>
                    <div id="btinput">
                        <input id="tinput" type="password" name="password" placeholder="votre mot de passe">
                    </div>
                    <div class="remember">
                            <label class="checkbox">
                                <span>Se souvenir de moi</span><input type="checkbox" name="remember">
                            </label>
                    </div>
                    <div class="instruction">
                        <p class="question">pas de compte?</p>
                        <a href="../controllers/registerController.php" class="btn-sub btn-return-log">inscris-toi</a>
                    </div>
                    <div class="forgotpwd">
                        <a href="forgetpassController.php" class="forgottxt">mot de passe oublié?</a>
                    </div>
                    <div class="check">
                        <input class="btn-sub register-btn" type="submit" id="submitt" name="submit" value="connexion">
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
    <script src="../js/login.js"></script>
</body>
</html>
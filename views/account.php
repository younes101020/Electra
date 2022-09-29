<body class="forced_no_overflow">
    
    
        <div class="notif" id="notif"></div>
        <div id="phpnotif"></div>
    <div class="ocontainer" id="onlineocontainer">
        <div class="bg-form">
            <img class="login-logo" src="../img/logo_signe.svg" alt="Logo d'Electra">
                <form action="../controllers/accountController.php" method="POST">
                    <div id="bfinput">
                        <input id="finput" type="text" name="pseudonyme" placeholder="votre nouveau pseudonyme">
                    </div>
                    <div id="btinput">
                        <input id="tinput" type="password" name="newPassword" placeholder="votre nouveau mot de passe">
                        <i class="fa-solid fa-arrows-to-eye eye" id="togglePassword"></i>
                    </div>
                    <div class="check">
                        <input class="btn-sub register-btn" type="submit" id="submitt" name="submit" value="modifier">
                    </div>
                </form>
        </div>
    </div>
    
    <?php include_once '../inc/footer.php'; ?>

</body>
</html>
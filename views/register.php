
        <main>
        <div id="notif"></div>
        
        <div class="ocontainer">
            <div class="bg-form">
                <a href=".."><img class="login-logo" src="../img/logo_signe.svg" alt="Logo d'Electra"></a>
                <form action="../controllers/registerController.php" method="POST" id="myform">
                    <div id="bfinput">
                        <input id="finput" type="text" name="pseudonyme" placeholder="votre pseudonyme">
                    </div>
                    <div id="bsinput">
                        <input id="sinput" type="email" name="email" placeholder="votre adresse mail">
                    </div>
                    <div id="btinput">
                        <input id="tinput" type="password" name="password" placeholder="votre mot de passe">
                    </div>
                    <div class="instruction">
                        <p class="question">déjà inscrit ?</p>
                        <a href="../controllers/loginController.php" class="btn-sub btn-return-log">connexion</a>
                    </div>
                    <div class="check">
                        <input class="btn-sub register-btn" id="submit-action" type="submit" name="submit" value="s'inscrire">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../js/register.js"></script>
</body>
</html>
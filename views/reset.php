<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electra - Réinitialisation du mot de passe</title>
</head>
<body>
    <div class="ocontainer">
            <div class="bg-form">
                <img class="login-logo" src="./img/logo_signe.svg" alt="Logo d'Electra">
                    <form action="resetController.php" method="POST">
                        <div id="btinput">
                            <input id="tinput" type="password" name="password" placeholder="votre nouveau mot de passe">
                            <i class="fa-solid fa-arrows-to-eye eye" id="togglePassword"></i>
                        </div>
                        <div class="check">
                            <input class="btn-sub register-btn" type="submit" id="submitt" name="submit" value="réinitialiser">
                        </div>
                    </form>
            </div>
    </div>
</body>
</html>
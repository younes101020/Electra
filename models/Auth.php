<?php
// Modèle
class auth extends Database
{
    public int $id = 0;
    public string $username = '';
    public string $password = '';
    public string $email = '';
    public string $token = '';
    public int $id_roles = 1;
    public string $remember_token = '';
    public string $reset_token = '';
    protected $db;

    private $options = ['restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"];

    private $session;

    public function __construct($session, $options = [])
    {
        $this->db = parent::getInstance();
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }

    /**
     * Fonction permettant d'ajouter un utilisateur dans la base de données.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $token
     * @param int $role
     * @return bool
     */
    public function addUser()
    {
        /**
         * Toutes les méthodes ont besoin d'une visibilité.
         * private = privée, ne peut être utilisée que dans la classe
         * protected = protégée, ne peut être utilisée que dans la classe et ses enfants
         * public = publique, peut être appelée de partout
         * 
         * Il faut la mettre en public pour pouvoir l'appeler depuis le contrôlleur et pouvoir
         * ajouter l'utilisateur.
         */
        /**
         * On stocke la requête SQL dans une variable.
         * DB_PREFIX est une constant créée dans le fichier config.php
         * permet de ne pas répéter le préfixe et de rendre plus lisible la requête
         * 
         * :username et :password sont des marqueurs nominatifs.
         * Ils servent à marquer l'endroit où des données sont manquantes
         * C'est dans le bindValue que nous remplacerons les marqueurs nominatifs par des valeurs
         * 
         * S'il y a marqueur nominatif, il y a forcément un prepare, puis bindValue, puis execute
         * 
         * NOW() est une fonction SQL qui permet ici d'insérer la date et l'heure de la création du compte
         */
        $sqlQuery = 'INSERT INTO `' . DB_PREFIX . 'users`(`username`, `password`, `createdAt`) 
        VALUES (:username, :password, NOW())';
        /**
         * $this->db c'est la connexion à la base de données, c'est l'instance de la base
         * Prepare va préparer la requête SANS l'exécuter, tant qu'execute n'a pas été appelé,
         * Elle ne se lancera pas. Permet de préparer l'arrivée d'une requête dans la base même si invomplète
         * au moment de la création de la méthode
         */
        $queryExecute = $this->db->prepare($sqlQuery);
        /**
         * Remplacer les marqueurs nominatifs par les valeurs données tout en les formatant
         */
        $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
        $queryExecute->bindValue(':password', $this->password, PDO::PARAM_STR);
        return $queryExecute->execute();
    }

    static function random() {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    
        // La chaîne alphabet sera répété plusieurs (64 fois pour avoir la possibilite d'avoir plusieurs fois le meme caracteres) 
        // fois et la melanger avec la méthode shuffle et enfin nous allons retourner que les 64 ($length) premiers caractères
        // grâce à substr
        return substr(str_shuffle(str_repeat($alphabet, 60)), 0, 60);
    }

    public function hashPassword(){
        return password_hash($this->password, PASSWORD_BCRYPT);
     }

    public function countNumberOfUserByUsername()
    {
        $sqlQuery = 'SELECT COUNT(*) AS number FROM `' . DB_PREFIX . 'users` WHERE `username` = :username';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);
        return $queryResult->number;
    }

    public function register() {
        $this->token = $this->random();
        $sqlQuery = 'INSERT INTO `' . DB_PREFIX . 'users`(`username`, `password`, `email`, `confirmation_token`, `id_roles`) 
        VALUES (:username, :password, :email, :confirmation_token, :id_roles)';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
        $queryExecute->bindValue(':password', $this->password, PDO::PARAM_STR);
        $queryExecute->bindValue(':email', $this->email, PDO::PARAM_STR);
        $queryExecute->bindValue(':confirmation_token', $this->token, PDO::PARAM_STR);
        $queryExecute->bindValue(':id_roles', $this->id_roles, PDO::PARAM_INT);
        return $queryExecute->execute();
    }

    public function getHashByUsername()
    {
        $sqlQuery = 'SELECT `password` FROM `' . DB_PREFIX . 'users` 
        WHERE `username` = :username';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);
        $this->password = $queryResult->password;
        return true;
    }

    public function getUserByUsername()
    {
        $sqlQuery = 'SELECT id FROM `' . DB_PREFIX . 'users` WHERE `username` = :username';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch();
        return json_encode($queryResult);
    }

    public function getUserByMail()
    {
        $sqlQuery = 'SELECT id FROM `' . DB_PREFIX . 'users` WHERE `email` = :email';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':email', $this->email, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch();
        return json_encode($queryResult);
    }

    public function confirm(){

        $idallQuery = 'SELECT * FROM '. DB_PREFIX .'users WHERE id = :id';
        $idallExecute = $this->db->prepare($idallQuery);
        $idallExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
        $idallExecute->execute();
        $user = $idallExecute->fetch(PDO::FETCH_OBJ);

        // Si le token a bien été récuperer et qu'il correspond au token de l'URL (paramétre)
        // Alors nous allons lui initialiser sa session (dans tous les cas une session sera initialiser)
        // mais je vais également lui vider son champ confirmation_token
        // de la db afin qu'il ne puissent plus accéder à cette page et enfin lui remplir son champs confirmed_at avec la date du jour

        if($user && $user->confirmation_token == $this->token) { 
            $sqlQuery = 'UPDATE '. DB_PREFIX .'users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = :id';
            $queryExecute = $this->db->prepare($sqlQuery);
            $queryExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
            $queryExecute->execute();
            $this->session->write('auth', $user);
            return true;
        }
        return false;
    }

    // Cette fonction permet de modifier le nom d'utilisateur
    public function updateUsername() {
            $sqlQuery = 'UPDATE '. DB_PREFIX .'users SET username = :username WHERE id = :id';
            $queryExecute = $this->db->prepare($sqlQuery);
            $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
            $queryExecute->bindValue(':id', $this->session->read('auth')->id, PDO::PARAM_INT);
            $queryExecute->execute();
    }

    // Cette fonction nous servira de "verrou" pour les pages nécéssitant dêtre connecté à electra
    public function restrict(){
        if(!$this->session->read('auth')) {
            $this->session->setFlash('error', $this->options['restriction_msg']);
            App::redirect('loginController.php');
            exit();
        }
    }

        // Cette fonction vérifie si l'utilisateur est connecté
        // Si oui renvoi ses infos
        public function user(){
            if(!$this->session->read('auth')) {
                return false;
            } else {
                return $this->session->read('auth');
            }
        }

        // Cette fonction permettra de créer une session (connecter un utilisateur) en mettant toute ses info
        // Daans la superglobal session
        // Elle prendra en parametre l'utilisateur à connecté
        public function connect($user){
            $this->session->write('auth', $user);
        }


    // à factoriser
    
        public function connectFromCookie(){
                // Vérifier si le cookie de reco automatique a bien été initialiser
                // Si oui alors récupérer toute la row sql de l'utilisateur qui l'aura initialiser
                // Vérifier également si l'utilisateur n'a pas de connexion initialiser grace à SESSION
                if(isset($_COOKIE['remember']) && !$this->user()) {
                    $remember_token = $_COOKIE['remember'];
                    $parts = explode('==', $remember_token);
                    $this->id = $parts[0];
                    $sqlQuery = 'SELECT * FROM '. DB_PREFIX .'users WHERE id = :id';
                    $queryExecute = $this->db->prepare($sqlQuery);
                    $queryExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
                    $queryExecute->execute();
                    $user = $queryExecute->fetch(PDO::FETCH_OBJ);
                    if($user) {
                        // Vérifier si la valeur du cookie contient bien l'id et la valeur sql du champs remember_token de l'utilisateur
                        $expected = $this->id . '==' . $user->remember_token . sha1($this->id . 'younessss');
                        // Si la condition en dessous s'avére vrais cela voudras 
                        // qu'il peut encore garder sa connexion automatique (7 jours d'exp du cookie non dépasser)
                        if($expected == $remember_token) {
                            $this->connect($user);
                            setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                        } else {
                            setcookie('remember', NULL, -1);
                        }
                    }else {
                        setcookie('remember', NULL, -1);
                    }
                }
            }

        public function login($remember = false){
                    // Renvoyer toute la row sql si le pseudonyme est dans la db; vérifier également que son champs de db confirmed_at
                    // a bien été rempli ce qui voudrais dire qu'il a confirmer son inscription avec le token
                    $sqlQuerys = 'SELECT * FROM '. DB_PREFIX .'users WHERE username = :username AND confirmed_at IS NOT NULL';
                    $queryExecute = $this->db->prepare($sqlQuerys);
                    $queryExecute->bindValue(':username', $this->username, PDO::PARAM_STR);
                    $queryExecute->execute();
                    $user = $queryExecute->fetch(PDO::FETCH_OBJ);
                    // Vérifier si le mot de passe taper correspond au mot de passe de l'utilisateur stocker en db
                    if(password_verify($this->password, $user->password)) {
                        $this->connect($user);
                        // Si l'utilisateur coche la checkbox "se souvenir de moi"
                        if($remember !== false) {
                            $this->id = $user->id;
                            $this->remember();
                        } return $user;
                    } else {
                        return false;
                    }
        }
        // se souvenir de la session de  l'utilisateur (insertion du cookie et de sa durée)
        public function remember(){
            $this->remember_token = Str::random(250);
            $sqlQuery = 'UPDATE '. DB_PREFIX .'users SET remember_token = :remember_token WHERE id = :id';
            $queryExecute = $this->db->prepare($sqlQuery);
            $queryExecute->bindValue(':remember_token', $this->remember_token, PDO::PARAM_STR);
            $queryExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
            $queryExecute->execute();
            // Faire en sorte de rendre la clé du cookie difficile à deviner et donc éviter qu'un utilisateur les regenére automatiquement
            // Ce cookie tiendra 7 jours
            setcookie('remember', $this->id . '==' . $this->remember_token . sha1($this->id . 'younessss'), time() + 60 * 60 * 24 * 7);
        }
        // Cette fonction supprimera la clé auth ce qui voudras dire que toute les info sql de l'utilisateur ne seront plus stocker
        // Il sera donc deconnecté
        public function logout() {
            setcookie('remember', NULL, -1);
            $this->session->delete('auth');
        }

        public function resetPassword() {
                // Si l'adresse mail entré par l'utilisateur correspond à un champ mail de la db alors retourner la row de ce dernier
                // dans la variable user
                $sqlQuery = 'SELECT * FROM '. DB_PREFIX .'users WHERE email = :email AND confirmed_at IS NOT NULL';
                $queryExecute = $this->db->prepare($sqlQuery);
                $queryExecute->bindValue(':email', $this->email, PDO::PARAM_STR);
                $queryExecute->execute();
                $user = $queryExecute->fetch(PDO::FETCH_OBJ);
                // Si l'utilisateur entre une adresse mail enregistré sur Electra alors remplir la conditon ci-dessous
                // Celle ci remplira le champ reset_token générer par notre fonction, et le champ reset_at par la date du jour
                // de la row sql de l'utilisateur
                var_dump($user);
                if($user){
                    $this->id = $user->id;
                    $this->realresetPassword();
                    return $user;
                }
                return false;
        }

        public function realresetPassword() {
            $this->reset_token = Str::random(60);
            $sqlReset = 'UPDATE '. DB_PREFIX .'users SET reset_token = :reset_token, reset_at = NOW() WHERE id = :id';
            $resetExecute = $this->db->prepare($sqlReset);
            $resetExecute->bindValue(':reset_token', $this->reset_token, PDO::PARAM_STR);
            $resetExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
            $resetExecute->execute();
            mail($this->email, 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe Electra merci de cliquer sur ce lien\n\nhttp://localhost/reset.php?id={$this->id}&token={$this->reset_token}", 'From: youneslow60@gmail.com');
        }

        public function checkResetToken($pass){
            // Récupérer toute la row quand l'id et le reset_token correspondent à ceux de l'URL
            // La deuxième partie de la requête sert à eviter que l'utilisateur spam la réinitialisation de compte
            $sqlQuerys = 'SELECT * FROM '. DB_PREFIX .'users WHERE id = :id AND reset_token IS NOT NULL AND reset_token = :reset_token AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)';
            $queryExecute = $this->db->prepare($sqlQuerys);
            $queryExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
            $queryExecute->bindValue(':reset_token', $this->reset_token, PDO::PARAM_STR);
            $queryExecute->execute();
            $user = $queryExecute->fetch();
            // Si le reset token est valide
            if($user){
                $this->password = $this->hashPassword($pass);

                $sqlReset = 'UPDATE '. DB_PREFIX .'users SET password = :password, reset_at = NULL, reset_token = NULL WHERE id = :id';
                $resetExecute = $this->db->prepare($sqlReset);
                $resetExecute->bindValue(':password', $this->password, PDO::PARAM_STR);
                $resetExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
                $resetExecute->execute();

                $this->connect($user);
                Session::getInstance()->setFlash('success', "Votre mot de passe a bien été modifié");
                App::redirect('account.php');
            } else {
                Session::getInstance()->setFlash('error', "Ce token n'est pas valide");
                App::redirect('login.php');
            }
        }

        public function updatePassword() {
            // Cette fonction me sert à mettre à jour le mot de passe dans la base de donnée
            $sqlReset = 'UPDATE '. DB_PREFIX .'users SET password = :password WHERE id = :id';
            $resetExecute = $this->db->prepare($sqlReset);
            $resetExecute->bindValue(':password', $this->password, PDO::PARAM_STR);
            $resetExecute->bindValue(':id', $this->id, PDO::PARAM_INT);
            $resetExecute->execute();
        }


}

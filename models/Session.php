<?php
    
    class Session{

        // On retrouvera ici le même cas de figure qu'avec l'initialisation d'une connexion à la db avec la class App
        // càd qu'on ne voudra pas initialiser une nouvelle session_start si il y en a deja une d'actif
        // On vas donc reutiliser la méthode self pour enregistrer notre etat et le comparer pour voir si on a deja une session d'actif

        static $instance;

        static function getInstance(){
            if(!self::$instance) {
                self::$instance = new Session();
            }
            return self::$instance;
        }


        public function __construct(){
            session_start();

        }
// Les deux prochaines fonctions vont nous permettre de gérer les messages d'erreur ou de succès,
// lors de l'appel de la premiere fonctions ont devras mettre en parametre
// La clés du message (erreur ou succès) et le message
        public function setFlash($key, $message){
            $_SESSION['flash'][$key] = $message;
        }
// Cette fonction vas nous permettre la vérification des messages d'erreur (s'il y en a ou pas)
        public function hasFlashes(){
            return isset($_SESSION['flash']);
        }
// Pareil que la fonctions du dessus mis à part qu'elle ne vas pas savoir si il y a des msg de succès ou pas
        public function hasFlasheserr(){
            return isset($_SESSION['flash']['error']);
        }
// Cette fonction nous renverra tous les messages (d'erreur ou de succès)
// Et les supprimera de notre tableau associatif flash directement après
// Car on aura besoin d'avertir l'utilisateur qu'une seule fois
        public function getFlashes(){
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
// Lorsque on appel cette fonction il faudra lui donner deux paramétre la clés et la valeur
// son but est simple: pouvoir insérer des choses dans notre superglobal session
        public function write($key, $value){
            $_SESSION[$key] = $value;
        }
// Lorsque on appel cette fonction il faudra lui donner un paramétre une clé du tableau session
// son but est également simple: pouvoir savoir si une clés du tableau superglobal contient bien quelque chose
        public function read($key){
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }
// Lorsque on appel cette fonction il faudra lui donner un paramétre une clé du tableau session
// son but est simple pouvoir supprimer une clés de notre superglobal session
        public function delete($key) {
            unset($_SESSION[$key]);
        }
    }
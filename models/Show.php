<?php

class Show extends Database{
    // Cette class servira à l'instanciation des différentes méthodes qui auront attrait à la gestion des films

    public string $showname = '';
    public string $listname = 'Ma liste';
    public string $addingshow = '';
    public int $blocked = 0;
    public int $validated = 0;
    public string $commentaire	= '';
    public int $showid = 0;
    public int $listid = 0;
    public int $note = 0;
    protected $db;

    // 0 == false , 1 == true

    private $session;

    public function __construct($session) {
        $this->db = parent::getInstance();
        $this->session = $session;
    }
    // Cette fonction renvoi un tableau de tous les films stocker en db dans l'ordre suivant: du film le plus récent au plus anciens.
    public function showRetrieve(){
        $sqlQuerys = 'SELECT name, id_genres, image, synopsis, buy FROM '. DB_PREFIX .'movies';
        $queryExecute = $this->db->prepare($sqlQuerys);
        $queryExecute->execute();
        $shows = $queryExecute->fetchAll(PDO::FETCH_OBJ);

        return $shows;
    }
    // Cette fonction renvoi un film qui contient un nom spécifique
    public function getShowByName() {
        $sqlQuery = 'SELECT name, buy, image, synopsis FROM ' . DB_PREFIX .'movies WHERE TRIM(name) = :name';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':name', $this->showname, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch();
        return json_encode($queryResult);
    }
    // Cette fonction permet de vérifier si la liste de l'utilisateur existe
    public function getList() {
        $sqlQuery = 'SELECT id FROM ' . DB_PREFIX .'movielists WHERE id_users = :id_users';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        if(is_numeric($queryResult->id) || $queryResult->id > 0) {
            $this->listid = $queryResult->id;
        } else {
            return 0;
        }
        
    }
    // Cette fonction permet de récupérer le nom de la liste de l'utilisateur
    public function getListName() {
        $sqlQuery = 'SELECT name FROM ' . DB_PREFIX .'movielists WHERE id_users = :id_users';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        $this->listname = $queryResult->name;
    }
    // Cette fonction permet d'initialiser une liste pour ca showlist
    public function addList() {
        $sqlQuery = 'INSERT INTO `' . DB_PREFIX . 'movielists`(`name`, `note`, `commentaire`, `blocked`, `validated`, `id_users`)
        VALUES (:name, :note, :commentaire, :blocked, :validated, :id_users)';


        $queryExecute = $this->db->prepare($sqlQuery);

        $queryExecute->bindValue(':name', $this->listname, PDO::PARAM_STR);
        $queryExecute->bindValue(':note', $this->note, PDO::PARAM_INT);
        $queryExecute->bindValue(':commentaire', $this->commentaire, PDO::PARAM_STR);
        $queryExecute->bindValue(':blocked', $this->blocked, PDO::PARAM_INT);
        $queryExecute->bindValue(':validated', $this->validated, PDO::PARAM_INT);
        $queryExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);

        return $queryExecute->execute();
    }
    // Cette fonction permet d'ajouter un film à la base de donnée
    public function getidShow() {
        $sqlQuery = 'SELECT id FROM ' . DB_PREFIX .'movies WHERE TRIM(name) = :name';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':name', $this->addingshow, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        $this->showid = $queryResult->id;

        $sqlQuerys = 'INSERT INTO `' . DB_PREFIX . 'movieslistscontent`(`id_movielists`, `id_movies`)
        VALUES (:id_movielists, :id_movies)';
        $queryExecutes = $this->db->prepare($sqlQuerys);
        $queryExecutes->bindValue(':id_movielists', $this->listid, PDO::PARAM_INT);
        $queryExecutes->bindValue(':id_movies', $this->showid, PDO::PARAM_INT);
        
        return $queryExecutes->execute();
    }
    // Cette fonction permet de récupérer les films ajouter à la liste de l'utilisateur
    public function getMovieList() {
        $sqlQuery = 'SELECT s.name, s.validated, mov.name, mov.image, mov.synopsis, mov.buy
                    FROM ' . DB_PREFIX . 'movielists AS s
                    INNER JOIN ' . DB_PREFIX . 'movieslistscontent AS mlc ON mlc.id_movielists = :listid
                    INNER JOIN ' . DB_PREFIX . 'movies AS mov ON mlc.id_movies = mov.id
                    WHERE s.id = :listid';

        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':listid', $this->listid, PDO::PARAM_STR);
        $queryExecute->execute();
        $usershowlist = $queryExecute->fetchAll(PDO::FETCH_OBJ);
        return $usershowlist;
    }
}
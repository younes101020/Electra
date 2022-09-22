<?php

class Show extends Database{
    // Cette class servira à l'instanciation des différentes méthodes qui auront attrait à la gestion des films

    public string $showname = '';
    public string $listname = 'Ma liste';
    public string $addingshow = '';
    public string $deletingshow = '';
    public string $checkedshow = '';
    public string $content = '';
    public int $blocked = 0;
    public int $validated = 0;
    public string $commentaire	= '';
    public int $showid = 0;
    public int $listid = 0;
    public int $listcontentid = 0;
    public int $note = 0;
    public int $notationid = 0;
    protected $db;

    // 0 == false , 1 == true

    private $session;

    public function __construct($session) {
        $this->db = parent::getInstance();
        $this->session = $session;
    }
    // Cette fonction renvoi un tableau de tous les films stocker en db dans l'ordre suivant: du film le plus récent au plus anciens.
    public function showRetrieve(){
        $sqlQuerys = 'SELECT name, id_genres, image, synopsis, buy, id FROM '. DB_PREFIX .'movies';
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
    //Cette fonction permet de vérifier si le nom d'une liste existe déjà
    public function getlistByListName()
    {
        $sqlQuery = 'SELECT id FROM `' . DB_PREFIX . 'movielists` WHERE `name` = :listname';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':listname', $this->listname, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        return json_encode($queryResult);
    }
    //Cette fonction permet de récupérer l'id d'une list de film
    public function getlistidByListName()
    {
        $sqlQuery = 'SELECT id FROM `' . DB_PREFIX . 'movielists` WHERE `name` = :listname';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':listname', $this->listname, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        $this->listid = $queryResult->id;
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
    // Cette fonction permet de modifier le nom de la liste de l'utilisateur
    public function setListName() {
        $sqlReset = 'UPDATE '. DB_PREFIX .'movielists SET name = :listname WHERE id_users = :id_users';
        $resetExecute = $this->db->prepare($sqlReset);
        $resetExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $resetExecute->bindValue(':listname', $this->listname, PDO::PARAM_STR);
        $resetExecute->execute();
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
    // Cette fonction permet de récupérer l'id de la contentlist qui correspond à un film spécifique
    public function getlistcontentId() {
        $sqlQuery = 'SELECT mlc.id
                    FROM ' . DB_PREFIX . 'movielists
                    INNER JOIN ' . DB_PREFIX . 'movieslistscontent AS mlc ON mlc.id_movielists = :listid
                    INNER JOIN ' . DB_PREFIX . 'movies AS mov ON mlc.id_movies = mov.id
                    WHERE mov.name = :deletingshow';
            
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':deletingshow', $this->deletingshow, PDO::PARAM_STR);
        $queryExecute->bindValue(':listid', $this->listid, PDO::PARAM_INT);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        $this->listcontentid = $queryResult->id;

    }
    // Cette fonction permet de supprimer la row stocker dans la base de donnée qui fais référence à un film spécifique
    public function removeshowList() {
        $sqlQuerys = 'DELETE FROM ' . DB_PREFIX . 'movieslistscontent WHERE id = :listcontentid';
        $queryExecutes = $this->db->prepare($sqlQuerys);
        $queryExecutes->bindValue(':listcontentid', $this->listcontentid, PDO::PARAM_INT);

        $queryExecutes->execute();
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
        $sqlQuery = 'SELECT mov.name, mov.image, mov.synopsis, mov.buy
                    FROM ' . DB_PREFIX . 'movielists AS s
                    INNER JOIN ' . DB_PREFIX . 'movieslistscontent AS mlc ON mlc.id_movielists = :listid
                    INNER JOIN ' . DB_PREFIX . 'movies AS mov ON mlc.id_movies = mov.id
                    WHERE s.id = :listid';

        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':listid', $this->listid, PDO::PARAM_INT);
        $queryExecute->execute();
        $usershowlist = $queryExecute->fetchAll(PDO::FETCH_OBJ);
        return $usershowlist;
    }
    // Cette fonction permet de vérifier si un film est déjà dans la movielist de l'utilisateur
    public function checkmovieinList() {
        $sqlQuery = 'SELECT mov.name
                    FROM rp4z3_movielists AS s
                    INNER JOIN rp4z3_movieslistscontent AS mlc ON mlc.id_movielists = :listid
                    INNER JOIN rp4z3_movies AS mov ON mlc.id_movies = mov.id
                    WHERE mov.name = :checkedshow';
        
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':listid', $this->listid, PDO::PARAM_INT);
        $queryExecute->bindValue(':checkedshow', $this->checkedshow, PDO::PARAM_STR);
        $queryExecute->execute();
        $usershowlist = $queryExecute->fetch(PDO::FETCH_OBJ);

        if($usershowlist !== false) {
            return "Le film est déjà dans la movielist !";
        } else {
            return "Le film n'est pas dans la movielist !";
        }
    }
    // Cette fonction permet de vérifier l'état des listes
    public function getListDetails() {
        $sqlQuery = 'SELECT s.name, s.note, s.commentaire, s.blocked, s.validated, s.id_users
                    FROM ' . DB_PREFIX . 'movielists AS s
                    INNER JOIN ' . DB_PREFIX . 'movieslistscontent AS mlc ON mlc.id_movielists = :listid
                    INNER JOIN ' . DB_PREFIX . 'movies AS mov ON mlc.id_movies = mov.id
                    WHERE s.id = :listid 
                    LIMIT 1';

        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':listid', $this->listid, PDO::PARAM_INT);
        $queryExecute->execute();
        $usershowlist = $queryExecute->fetch(PDO::FETCH_OBJ);
        return $usershowlist;
    }
    // Cette fonction permet de mettre à jour
    public function setListStatus() {
        $sqlReset = 'UPDATE ' . DB_PREFIX . 'movielists SET ' . DB_PREFIX . 'movielists.validated = :validated WHERE ' . DB_PREFIX . 'movielists.id_users = :id_users';
        $resetExecute = $this->db->prepare($sqlReset);
        $resetExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $resetExecute->bindValue(':validated', $this->validated, PDO::PARAM_INT);
        $resetExecute->execute();
        
    }
    // Cette fonction renvoi la liste des showlist public
    public function getPublicShowlist() {
        $sqlQuery = 'SELECT mov.name AS mname, mov.image, mov.buy, s.name AS lname, u.username, s.id AS mlid
            FROM ' . DB_PREFIX . 'movielists AS s
            INNER JOIN ' . DB_PREFIX . 'movieslistscontent AS mlc ON mlc.id_movielists = s.id
            INNER JOIN ' . DB_PREFIX . 'users AS u ON u.id = s.id_users
            INNER JOIN ' . DB_PREFIX . 'movies AS mov ON mlc.id_movies = mov.id
            WHERE s.validated = 1';

            $queryExecute = $this->db->prepare($sqlQuery);
            $queryExecute->execute();
            $publicshowlists = $queryExecute->fetchAll(PDO::FETCH_OBJ);
            return $publicshowlists;
    }
    // Cette fonction ajoute un commentaire dans la db
    public function setComment() {
        $sqlQuery = 'INSERT INTO `' . DB_PREFIX . 'comments`(`content`, `blocked`, `validated`, `id_users`, `id_movielists`)
        VALUES (:content, :blocked, :validated, :id_users, :id_movielists)';

        $queryExecute = $this->db->prepare($sqlQuery);

        $queryExecute->bindValue(':content', $this->commentaire, PDO::PARAM_STR);
        $queryExecute->bindValue(':blocked', $this->blocked, PDO::PARAM_INT);
        $queryExecute->bindValue(':validated', $this->validated, PDO::PARAM_INT);
        $queryExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $queryExecute->bindValue(':id_movielists', $this->listid, PDO::PARAM_INT);

        return $queryExecute->execute();
    }
    // Cette fonction permet de récupérer les commentaires
    public function getComments() {
        $sqlQuery = 'SELECT u.username AS pseudonyme, content, blocked, validated, id_users, id_movielists AS mlid 
                    FROM ' . DB_PREFIX .'comments AS com
                    INNER JOIN ' . DB_PREFIX .'users AS u ON u.id = com.id_users;';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetchAll(PDO::FETCH_OBJ);

        return $queryResult;
    }
    // Cette fonction permet de supprimer un commentaire
    public function deleteComments() {
        $sqlQuerys = 'DELETE FROM ' . DB_PREFIX . 'comments WHERE content = :content AND id_users = :id_users';
        $queryExecutes = $this->db->prepare($sqlQuerys);
        $queryExecutes->bindValue(':content', $this->content, PDO::PARAM_STR);
        $queryExecutes->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);

        $queryExecutes->execute();
    }
    // Cette fonction permet de récuperer une id de film à partir d'un nom de film
    public function getShowIdByName() {
        $sqlQuery = 'SELECT id FROM ' . DB_PREFIX .'movies WHERE TRIM(name) = :name';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':name', $this->showname, PDO::PARAM_STR);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        $this->showid = $queryResult->id;
    }
    // Cette fonction permet de vérifier si l'utilisateur a déjà noter ce film
    public function checkIfUserRated() {
        $sqlQuery = 'SELECT id FROM ' . DB_PREFIX .'notations WHERE id_movies = :id_movies AND id_users = :id_users';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->bindValue(':id_movies', $this->showid, PDO::PARAM_INT);
        $queryExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetch(PDO::FETCH_OBJ);

        if(!isset($queryResult->id)) {
            $this->notationid = 0;
        } else {
            $this->notationid = $queryResult->id;
        }
    }
    //  Cette fonction permet de noter un film
    public function ratingShow() {
        $sqlQuery = 'INSERT INTO `' . DB_PREFIX . 'notations`(`notation`, `id_movies`, `id_users`)
        VALUES (:notation, :id_movies, :id_users)';

        $queryExecute = $this->db->prepare($sqlQuery);

        $queryExecute->bindValue(':notation', $this->note, PDO::PARAM_INT);
        $queryExecute->bindValue(':id_movies', $this->showid, PDO::PARAM_INT);
        $queryExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);

        return $queryExecute->execute();
    }
    // Cette fonction permet de mettre à jour la note de l'utilisateur sur un film
    public function updateUserRating() {
        $sqlReset = 'UPDATE '. DB_PREFIX .'notations SET notation = :notation WHERE id_movies = :id_movies AND id_users = :id_users';
        $resetExecute = $this->db->prepare($sqlReset);
        $resetExecute->bindValue(':notation', $this->note, PDO::PARAM_INT);
        $resetExecute->bindValue(':id_movies', $this->showid, PDO::PARAM_INT);
        $resetExecute->bindValue(':id_users', $this->session->read('auth')->id, PDO::PARAM_INT);
        $resetExecute->execute();
    }
    // Cette fonction permet de récupérer toutes les moyennes de films
    public function getAverage() {
        $sqlQuery = 'SELECT mov.name, floor(Avg(note.notation)) AS average
            From ' . DB_PREFIX .'notations AS note 
            INNER JOIN ' . DB_PREFIX .'movies AS mov On mov.id = note.id_movies
            GROUP BY note.id_movies;';
        $queryExecute = $this->db->prepare($sqlQuery);
        $queryExecute->execute();
        $queryResult = $queryExecute->fetchAll(PDO::FETCH_OBJ);

        return $queryResult;
    }
}
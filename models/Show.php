<?php

class Show extends Database{
    // Cette class servira à l'instanciation des différentes méthodes qui auront attrait à la gestion des films

    public string $showname = '';
    protected $db;

    public function __construct() {
        $this->db = parent::getInstance();
    }
    // Cette fonction renvoi un tableau de tous les films stocker en db dans l'ordre suivant: du film le plus récent au plus anciens.
    public function showRetrieve(){
        $sqlQuerys = 'SELECT name, id_genres, image, synopsis, buy FROM '. DB_PREFIX .'movies';
        $queryExecute = $this->db->prepare($sqlQuerys);
        $queryExecute->execute();
        $shows = $queryExecute->fetchAll(PDO::FETCH_OBJ);

        return $shows;
    }
}
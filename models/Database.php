<?php
include_once '../config.php';
class Database
{

    protected $prefix = 'bw32c_';
    public static $_instance = NULL;
    
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            try {
                self::$_instance = new PDO('mysql:host=localhost;dbname=electra;charset=utf8', 'root', 'Azerty02');
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                mail('youneslow60@gmail.com', 'ERROR : Erreur base de donnÃ©es', $e->getMessage());
                header('Location:../views/errors/no-database-connection.php');
                exit;
            }
        }
        return self::$_instance;
    }
}
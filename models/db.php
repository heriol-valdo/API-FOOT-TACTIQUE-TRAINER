<?php 
class Database{

    public  $database;

    public function __construct() {
        try {
            $this->database = new PDO  ('mysql:host=localhost;dbname=ecf_api;charset=utf8','root','');
        } catch (Exception $e) {
            die ('Erreur :'. $e->getMessage());
            
        }

    }
    
}

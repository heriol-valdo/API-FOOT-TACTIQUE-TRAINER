<?php 
require_once 'db.php';

// addJoueur() : Fonction pour l'ajout d'un joueur 
// getJoueur() : Fonction pour lister les joueurs 
// boolEmail() : Fonction pour vérifier si un email existe déjà 
// boolTel() : Fonction pour vérifier si un numéro de téléphone existe déjà 

class Joueur extends Database{
    public $id;
    public $firstname;

    public $lastname;

    public $email;

    public $age;
    public $adresse;
    public $telephone;

    public function addJoueur() {

        $query = 'INSERT INTO `player` (`firstname`,`lastname`,`email`,`age`,`adresse`,`telephone`) VALUES(?,?,?,?,?,?)';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1,  $this->firstname ,PDO::PARAM_STR);
        $queryexec->bindValue(2,  $this->lastname ,PDO::PARAM_STR);
        $queryexec->bindValue(3,  $this->email ,PDO::PARAM_STR);
        $queryexec->bindValue(4,  $this->age ,PDO::PARAM_STR);
        $queryexec->bindValue(5,  $this->adresse ,PDO::PARAM_STR);
        $queryexec->bindValue(6,  $this->telephone ,PDO::PARAM_STR);
        $queryexec->execute();  
    }

    public function getJoueur() {
        $query = 'SELECT * FROM `player` ';
        $queryexec = $this->database->prepare($query);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        return $res;
    }

    public function  boolEmail() {
        $query = 'SELECT * FROM `player` WHERE `email` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->email ,PDO::PARAM_STR);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        if(empty($res)){
            return true;
        }else{
            return false;
        }
    }
    public function  boolTel() {
        $query = 'SELECT * FROM `player` WHERE `telephone` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->telephone ,PDO::PARAM_STR);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        if(empty($res)){
            return true;
        }else{
            return false;
        }
    }
   


}
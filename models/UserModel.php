<?php 
require_once 'db.php';

// addUser() : Fonction pour l'ajout d'un utilisateur 
// getUser() : Fonction pour lister les utilisateurs 
// boolEmail() : Fonction pour vérifier si un email existe déjà 
// loginUser() : Fonction pour vérifier si un utilisateur existe 


class User extends Database{
    public $id;
    public $firstname;

    public $lastname;

    public $email;

    public $password;


    public function addUser() {

        $passwordhash = password_hash($this->password,PASSWORD_DEFAULT);
        $query = 'INSERT INTO `users` (`firstname`,`lastname`,`email`,`password`) VALUES(?,?,?,?)';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->firstname ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->lastname ,PDO::PARAM_STR);
        $queryexec->bindValue(3, $this->email ,PDO::PARAM_STR);
        $queryexec->bindValue(4, $passwordhash ,PDO::PARAM_STR);
        $queryexec->execute();
    }

    public function getUser() {
        $query = 'SELECT * FROM `users` WHERE `id` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->id ,PDO::PARAM_INT);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        return $res;
    }

    public function  boolEmail() {
        $query = 'SELECT * FROM `users` WHERE `email` = ?';
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

    public function loginUser() {
        $query = 'SELECT * FROM `users` WHERE `email` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->email, PDO::PARAM_STR);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        return $res;
    }

}
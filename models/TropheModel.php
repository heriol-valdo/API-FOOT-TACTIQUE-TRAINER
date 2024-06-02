<?php 
require_once 'db.php';

// addTrophe() : Fonction pour l'ajout d'un trophée par rapport à un joueur 
// getTrophe() : Fonction pour lister les trophées d'un joueur précis
// boolDate() : Fonction pour vérifier si un trophée existe déjà pour une date précise par rapport à un joueur 
// deleteTrophe() : Fonction pour supprimer un trophée précis par rapport à un joueur

class Trophe extends Database{
    public $id;
    public $date;

    public $nom;

    public $motif;

    public $idjoueur;


    public function addTrophe() {

        $query = 'INSERT INTO `trophe` (`date`,`nom`,`motif`,`idjoueur`) VALUES(?,?,?,?)';
        $queryexec =  $this->database->prepare($query);
        $queryexec->bindValue(1, $this->date ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->nom,PDO::PARAM_STR);
        $queryexec->bindValue(3, $this->motif,PDO::PARAM_STR);
        $queryexec->bindValue(4,  $this->idjoueur ,PDO::PARAM_STR);
        $queryexec->execute(); 
    }

    public function getTrophe() {
        $query = 'SELECT * FROM `trophe`  WHERE `idjoueur` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->idjoueur ,PDO::PARAM_INT);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        return $res;
    }

    public function deleteTrophe() {
        $query = 'DELETE FROM `trophe` WHERE `idjoueur` = ? AND `date` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->idjoueur  ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->date  ,PDO::PARAM_STR);
        $queryexec->execute();
    }

    public function boolDate() {
        $query = 'SELECT * FROM `trophe` WHERE `date` = ? AND `idjoueur` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->date, PDO::PARAM_STR); 
        $queryexec->bindValue(2, $this->idjoueur, PDO::PARAM_STR);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
    
        return empty($res);
    }


}
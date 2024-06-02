<?php 
require_once 'db.php';

// addStatistique() : Fonction pour l'ajout d'une statistique par rapport à un joueur 
// getStatistique() : Fonction pour lister les statistiques d'un joueur précis
// boolDate() : Fonction pour vérifier si une statistique existe déjà pour une date précise par rapport à un joueur 
// deleteStatistique() : Fonction pour supprimer une statistique précise par rapport à un joueur

class Statistique extends Database{
    public $id;
    public $date;

    public $lieu;

    public $but;

    public $jaune;

    public $rouge;

    public $idjoueur;


    public function addStatistique() {
        $query = 'INSERT INTO `statistique` (`date`,`lieu`,`but`,`jaune`,`rouge`,`idjoueur`) VALUES(?,?,?,?,?,?)';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1,$this->date ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->lieu ,PDO::PARAM_STR);
        $queryexec->bindValue(3, $this->but ,PDO::PARAM_STR);
        $queryexec->bindValue(4, $this->jaune ,PDO::PARAM_STR);
        $queryexec->bindValue(5, $this->rouge ,PDO::PARAM_STR);
        $queryexec->bindValue(6, $this->idjoueur ,PDO::PARAM_STR);
        $queryexec->execute();
    }

    public function getStatistique() {
        $query = 'SELECT * FROM `statistique`  WHERE `idjoueur` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->idjoueur ,PDO::PARAM_INT);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        return $res;
    }
    public function deleteStatistique() {
        $query = 'DELETE FROM `statistique` WHERE `idjoueur` = ? AND `date` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->idjoueur  ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->date  ,PDO::PARAM_STR);
        $queryexec->execute();
    }

    public function boolDate() {
        $query = 'SELECT * FROM `statistique` WHERE `date` = ? AND `idjoueur` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->date, PDO::PARAM_STR); 
        $queryexec->bindValue(2, $this->idjoueur, PDO::PARAM_STR);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
    
        return empty($res);
    }


}
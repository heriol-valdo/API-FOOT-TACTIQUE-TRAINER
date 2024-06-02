<?php 
require_once 'db.php';

// addSelection() : Fonction pour l'ajout d'une sélection  par rapport à un joueur 
// getSelection() : Fonction pour lister les sélections d'un joueur précis
// boolDate() : Fonction pour vérifier si une sélection existe déjà pour une date précise par rapport à un joueur 
// deleteSelection() : Fonction pour supprimer une sélection précise par rapport à un joueur


class Selection extends Database{
    public $id;
    public $date;

    public $nom;

    public $idjoueur;


    public function addSelection() {

        $query = 'INSERT INTO `selection` (`date`,`nom`,`idjoueur`) VALUES(?,?,?)';
        $queryexec =  $this->database->prepare($query);
        $queryexec->bindValue(1, $this->date ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->nom,PDO::PARAM_STR);
        $queryexec->bindValue(3,  $this->idjoueur ,PDO::PARAM_STR);
        $queryexec->execute(); 
    }

    public function getSelection() {
        $query = 'SELECT * FROM `selection`  WHERE `idjoueur` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->idjoueur ,PDO::PARAM_INT);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
        return $res;
    }

    
    public function deleteSelection() {
        $query = 'DELETE FROM `selection` WHERE `idjoueur` = ? AND `date` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->idjoueur  ,PDO::PARAM_STR);
        $queryexec->bindValue(2, $this->date  ,PDO::PARAM_STR);
        $queryexec->execute();
    }

    public function boolDate() {
        $query = 'SELECT * FROM `selection` WHERE `date` = ? AND `idjoueur` = ?';
        $queryexec = $this->database->prepare($query);
        $queryexec->bindValue(1, $this->date, PDO::PARAM_STR); 
        $queryexec->bindValue(2, $this->idjoueur, PDO::PARAM_STR);
        $queryexec->execute();
        $res = $queryexec->fetchAll();
    
        return empty($res);
    }
    


}
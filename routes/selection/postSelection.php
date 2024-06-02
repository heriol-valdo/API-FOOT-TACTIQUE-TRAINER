<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/SelectionModel.php';

$app->post('/addSel', function (Request $request, Response $response) {
    // Initialisation du tableau des erreurs
    $err = array();
    
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();

    // Vérification si la date est vide
    if(empty($data['date'])){
        $err['date'] = 'date vide';
    }

    // Vérification si le nom est vide
    if(empty($data['nom'])){
        $err['nom'] = 'nom vide';
    }
    
    // Vérification si l'ID du joueur est vide
    if(empty($data['id'])){
        $err['id'] = 'idjoueur vide';
    }
   
    // Vérification s'il n'y a pas d'erreur
    if(empty($err)){
        // Création d'une nouvelle instance de la classe Selection
        $sel = new Selection();
        
        // Affectation des valeurs aux propriétés de l'objet Selection
        $sel->date = $data['date'];
        $sel->nom = $data['nom'];
        $sel->idjoueur = $data['id'];
        
        // Vérification si une sélection existe déjà pour cette date
        $exitsel = $sel->boolDate();
        if($exitsel){
            // Ajout de la sélection dans la base de données
            $sel->addSelection();
            // Répond avec un message JSON indiquant que l'ajout est réussi
            $response->getBody()->write(json_encode(['valid' => 'ok']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        }else{
            // Répond avec un message JSON indiquant qu'une sélection existe déjà pour cette date
            $response->getBody()->write(json_encode(['erreur' => "une selection a déjà été renseigné pour cette date"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
       
    }else{
        // Répond avec un message JSON indiquant qu'il manque des informations dans le formulaire
        $response->getBody()->write(json_encode(['erreur' => "il manque des informations à votre formulaire"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

})->add($authMiddleware);


$app->post('/deleteSel', function (Request $request, Response $response) {
    // Initialisation du tableau des erreurs
    $err = array();
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();
 
    // Vérification si l'ID du joueur est vide
    if(empty($data['id'])){
        $err['id'] = 'idjoueur vide';
    }
    // Vérification si la date est vide
    if(empty($data['date'])){
        $err['date'] = 'date vide';
    }
    // Vérification s'il n'y a pas d'erreur
    if(empty($err)){
        // Création d'une nouvelle instance de la classe Selection
        $sel = new Selection();
        // Affectation des valeurs aux propriétés de l'objet Selection
        $sel->idjoueur = $data['id'];
        $sel->date = $data['date'];
        // Suppression de la sélection dans la base de données
        $sel->deleteSelection();
        // Répond avec un message JSON indiquant que la suppression est réussie
        $response->getBody()->write(json_encode(['valid' => 'ok']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }else{
        // Répond avec un message JSON indiquant qu'il manque des informations dans la requête
        $response->getBody()->write(json_encode(['erreur' => "il manque des informations à votre requête"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
})->add($authMiddleware);

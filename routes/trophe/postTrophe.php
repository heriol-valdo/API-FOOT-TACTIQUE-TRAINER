<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/TropheModel.php';

$app->post('/addTrof', function (Request $request, Response $response) {
    // Initialisation du tableau d'erreurs
    $err = array();
    
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();

    // Vérification de la présence des champs obligatoires dans les données
    if(empty($data['date'])){
        $err['date'] = 'date vide';
    }
    if(empty($data['nom'])){
        $err['nom'] = 'nom vide';
    }
    if(empty($data['motif'])){
        $err['motif'] = 'motif vide';
    }
    if(empty($data['id'])){
        $err['id'] = 'idjoueur vide';
    }
   
    // Vérification s'il y a des erreurs dans les données
    if(empty($err)){
        // Création d'une nouvelle instance de la classe Trophe
        $trophe = new Trophe();
        
        // Affectation des valeurs des champs de la nouvelle instance
        $trophe->date = $data['date'];
        $trophe->nom = $data['nom'];
        $trophe->motif = $data['motif'];
        $trophe->idjoueur = $data['id'];
        
        // Vérification si un trophée existe déjà pour cette date
        $exittrophe = $trophe->boolDate();
        if($exittrophe){
            // Ajout du trophée à la base de données
            $trophe->addTrophe();

            // Réponse avec succès
            $response->getBody()->write(json_encode(['valid' => 'ok']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }else{
            // Réponse avec erreur si un trophée existe déjà pour cette date
            $response->getBody()->write(json_encode(['erreur' => "Un trophée a déjà été renseigné pour cette date"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }else{
        // Réponse avec erreur si des informations obligatoires sont manquantes
        $response->getBody()->write(json_encode(['erreur' => "Il manque des informations dans votre formulaire"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
})->add($authMiddleware);



$app->post('/deleteTrof', function (Request $request, Response $response) {
    // Initialisation du tableau d'erreurs
    $err = array();
    
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();

    // Vérification de la présence des champs obligatoires dans les données
    if(empty($data['id'])){
        $err['id'] = 'idjoueur vide';
    }
    if(empty($data['date'])){
        $err['date'] = 'date vide';
    }
    
    // Vérification s'il y a des erreurs dans les données
    if(empty($err)){
        // Création d'une nouvelle instance de la classe Trophe
        $trophe = new Trophe();
        
        // Affectation des valeurs des champs de la nouvelle instance
        $trophe->date = $data['date'];
        $trophe->idjoueur = $data['id'];
        
        // Suppression du trophée de la base de données
        $trophe->deleteTrophe();

        // Réponse avec succès
        $response->getBody()->write(json_encode(['valid' => 'ok']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }else{
        // Réponse avec erreur si des informations obligatoires sont manquantes
        $response->getBody()->write(json_encode(['erreur' => "Il manque des informations dans votre requête"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
})->add($authMiddleware);

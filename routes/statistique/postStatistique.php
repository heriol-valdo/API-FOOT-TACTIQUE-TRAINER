<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/StatistiqueModel.php';

$app->post('/addStat', function (Request $request, Response $response) {
    // Initialisation du tableau d'erreurs
    $err = array();
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();

    // Vérification de la présence des données requises
    if(empty($data['date'])){
        $err['date'] = 'date vide';
    }
    if(empty($data['lieu'])){
        $err['lieu'] = 'lieu vide';
    }
    if(empty($data['id'])){
        $err['id'] = 'idjoueur vide';
    }
   
    // Vérification s'il y a des erreurs
    if(empty($err)){
        // Création d'une nouvelle instance de la classe Statistique
        $stat = new Statistique();
        // Affectation des données aux propriétés de l'objet Statistique
        $stat->date = $data['date'];
        $stat->lieu = $data['lieu'];
        $stat->but = $data['but'];
        $stat->jaune = $data['jaune'];
        $stat->rouge = $data['rouge'];
        $stat->idjoueur = $data['id'];
        
        // Vérification si une statistique existe déjà pour cette date
        $exitstat = $stat->boolDate();
        if($exitstat){
            // Ajout de la statistique dans la base de données
            $stat->addStatistique();
            // Répond avec un message JSON indiquant que l'ajout est réussi
            $response->getBody()->write(json_encode(['valid' => 'ok']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }else{
            // Répond avec un message JSON indiquant qu'une statistique existe déjà pour cette date
            $response->getBody()->write(json_encode(['erreur' => "une statistique a déjà été renseignée pour cette date"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }else{
        // Répond avec un message JSON indiquant qu'il manque des informations dans le formulaire
        $response->getBody()->write(json_encode(['erreur' => "il manque des informations à votre formulaire"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
})->add($authMiddleware);



$app->post('/deleteStat', function (Request $request, Response $response) {
    // Initialisation du tableau d'erreurs
    $err = array();
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();
 
    // Vérification de la présence des données requises
    if(empty($data['id'])){
        $err['id'] = 'idjoueur vide';
    }
    if(empty($data['date'])){
        $err['date'] = 'date vide';
    }

    // Vérification s'il y a des erreurs
    if(empty($err)){
        // Création d'une nouvelle instance de la classe Statistique
        $stat = new Statistique();
        // Affectation des données aux propriétés de l'objet Statistique
        $stat->date = $data['date'];
        $stat->idjoueur = $data['id'];
        
        // Suppression de la statistique dans la base de données
        $stat->deleteStatistique();

        // Répond avec un message JSON indiquant que la suppression est réussie
        $response->getBody()->write(json_encode(['valid' => 'ok']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }else{
        // Répond avec un message JSON indiquant qu'il manque des informations dans la requête
        $response->getBody()->write(json_encode(['erreur' => "il manque des informations à votre requête"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
})->add($authMiddleware);

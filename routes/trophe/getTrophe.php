<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/TropheModel.php';


$app->post('/listTrof', function (Request $request, Response $response) {
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();
    
    // Création d'une nouvelle instance de la classe Trophe
    $trophe = new Trophe();
    
    // Affectation de l'identifiant du joueur
    $trophe->idjoueur = $data['id'];
    
    // Récupération des trophées du joueur depuis la base de données
    $res = $trophe->getTrophe();
    
    // Vérification de l'existence de trophées pour ce joueur
    if(empty($res)){
        // Si aucun trophée n'est trouvé, renvoie un message d'erreur
        $response->getBody()->write(json_encode(['erreur' => 'liste des trophées vide pour ce joueur']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }else{
        // Si des trophées sont trouvés, renvoie les données des trophées au format JSON
        $response->getBody()->write(json_encode(['trophées valid' => 'ok', 'data' => $res]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}); 

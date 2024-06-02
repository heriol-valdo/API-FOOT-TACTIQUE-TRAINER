<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/UserModel.php';

$app->get('/profil', function (Request $request, Response $response) {
    // Récupération de l'ID de l'utilisateur depuis les attributs de la requête
    $id = $request->getAttribute('id');
    
    // Création d'une nouvelle instance de la classe User
    $user = new User();
    
    // Attribution de l'ID à l'utilisateur
    $user->id = $id;
    
    // Récupération des données du profil de l'utilisateur
    $res = $user->getUser();
    
    // Écriture de la réponse JSON contenant les données du profil de l'utilisateur
    $response->getBody()->write(json_encode(['profil valid' => 'ok', 'data' => $res]));
    
    // Envoi de la réponse avec le code de statut 201 (Créé)
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
})->add($authMiddleware);

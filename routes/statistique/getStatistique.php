<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/StatistiqueModel.php';

$app->post('/listStat', function (Request $request, Response $response) {
    // Récupération des données du corps de la requête
    $data = $request->getParsedBody();

    // Création d'une nouvelle instance de la classe Statistique
    $stat = new Statistique();
    // Affectation de l'ID du joueur aux propriétés de l'objet Statistique
    $stat->idjoueur = $data['id'];
    // Récupération des statistiques du joueur depuis la base de données
    $res = $stat->getStatistique();

    // Vérification si les statistiques sont vides
    if(empty($res)){
        // Répond avec un message JSON indiquant que la liste des statistiques est vide pour ce joueur
        $response->getBody()->write(json_encode(['erreur' => 'liste des statistiques vide pour ce joueur']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }else{
        // Répond avec un message JSON contenant les statistiques du joueur
        $response->getBody()->write(json_encode(['Statistique valid'.$data['id'] => 'ok', 'data' => $res]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}); 

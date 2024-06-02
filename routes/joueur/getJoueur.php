
<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/JoueurModel.php';


// route pour lister  les joueurs 
$app->get('/listplayeur', function (Request $request, Response $response) {
    // Crée une nouvelle instance de la classe Joueur
    $joueur = new Joueur();
    
    // Récupère les données des joueurs à partir de la base de données
    $res = $joueur->getJoueur();
    
    // Écrit les données récupérées dans le corps de la réponse JSON
    $response->getBody()->write(json_encode(['player valid' => 'ok', 'data' => $res]));
    
    // Retourne la réponse HTTP avec un code de statut 201 (Created)
    // et un en-tête indiquant que le contenu est de type JSON
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

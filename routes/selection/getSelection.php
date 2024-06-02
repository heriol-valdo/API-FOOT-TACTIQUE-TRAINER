
<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/SelectionModel.php';

$app->post('/listSel', function (Request $request, Response $response) {
    // Récupère les données du corps de la requête
    $data = $request->getParsedBody();
    
    // Crée une nouvelle instance de la classe Selection
    $sel = new Selection();
    
    // Affecte l'ID du joueur aux propriétés de l'objet Selection
    $sel->idjoueur = $data['id'];
    
    // Récupère les sélections du joueur à partir de la base de données
    $res = $sel->getSelection();

    // Vérifie si aucune sélection n'a été trouvée pour ce joueur
    if(empty($res)){
        // Répond avec un message JSON indiquant qu'aucune sélection n'a été trouvée pour ce joueur
        $response->getBody()->write(json_encode(['erreur' => 'liste des selections vide pour ce joueur']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

    }else{
        // Répond avec un message JSON contenant les sélections du joueur
        $response->getBody()->write(json_encode(['selections valid'.$data['id'] => 'ok', 'data' => $res]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
   
});



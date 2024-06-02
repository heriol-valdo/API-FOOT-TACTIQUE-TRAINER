<?php
//Récupérer les dépendances
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


//Récupération de l'autoload
require_once __DIR__ .'/vendor/autoload.php';
//instance d'app slim
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$key = 'ïOÖbÈ3~_Äijb¥d-ýÇ£Hf¿@xyLcP÷@';



$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Foot Tactique Trainer");
    return $response;
});

// On vérifie si l'utilisateur est connecté
$authMiddleware = function($request,$handler)use ($key){
    $authMiddleware = $request->getHeader('Authorization');
    if(!empty($authMiddleware)){
        $token = $authMiddleware[0];
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        $request = $request->withAttribute('id',$decoded->id);
          return $response = $handler->handle($request);
        }else{
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode(['erreur' => 'token vide ou invalide']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
};



// On liste toute les routes de notre api 
require_once __DIR__ . '/routes/joueur/postJoueur.php';
require_once __DIR__ . '/routes/joueur/getJoueur.php';

require_once __DIR__ . '/routes/selection/postSelection.php';
require_once __DIR__ . '/routes/selection/getSelection.php';

require_once __DIR__ . '/routes/statistique/postStatistique.php';
require_once __DIR__ . '/routes/statistique/getStatistique.php';

require_once __DIR__ . '/routes/trophe/postTrophe.php';
require_once __DIR__ . '/routes/trophe/getTrophe.php';

require_once __DIR__ . '/routes/user/postUser.php';
require_once __DIR__ . '/routes/user/getUser.php';




$app->run();

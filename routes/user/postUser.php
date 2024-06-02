<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/UserModel.php';


$app->post('/addUser', function (Request $request, Response $response) {
     // Initialisation du tableau d'erreurs
    $err = array();

     // Récupération des données du corps de la requête
    $data = $request->getParsedBody();

    // Vérification des champs vides
    if(empty($data['lastname'])){
        $err['lastname'] = 'nom de famille vide';
    }
    if(empty($data['firstname'])){
        $err['firstname'] = 'prénom vide';
    }
    if(empty($data['email'])){
        $err['email'] = 'adresse email vide';
    }
    if(empty($data['password'])){
        $err['password'] = 'mot de passe vide';
    }

    // S'il n'y a pas d'erreurs
    if(empty($err)){
        // Création d'une nouvelle instance de la classe User
        $user = new User();
        // Attribution des valeurs des champs
        $user->lastname = $data['lastname'];
        $user->firstname = $data['firstname'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        // Vérification si l'email existe déjà
        $exituser = $user->boolEmail();
        if($exituser){
            // Ajout de l'utilisateur si l'email n'existe pas déjà
            $user->addUser();
            // Réponse avec succès
            $response->getBody()->write(json_encode(['valid' => 'ok']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        }else{
            // Réponse avec erreur si l'email existe déjà
            $response->getBody()->write(json_encode(['erreur' =>"Un compte avec cette adresse e-mail existe déjà"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }else{
        // Réponse avec les erreurs de champs vides
        $response->getBody()->write(json_encode(['erreur' =>"Il manque des informations dans votre requête"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});


$app->post('/login', function (Request $request, Response $response) use ($key) {
    // Récupération des données du formulaire de connexion
    $data = $request->getParsedBody();

    // Création d'une nouvelle instance de la classe User
    $user = new User();
    // Attribution de l'email pour la vérification de l'utilisateur
    $user->email = $data['email'];
    // Recherche de l'utilisateur dans la base de données
    $res = $user->loginUser();
   
    // Vérifie si un utilisateur avec cet email a été trouvé
    if (!empty($res)) {
        // Vérifie si le mot de passe correspond au hash stocké dans la base de données
        if (password_verify($data['password'], $res[0]['password'])) {
            // Création du payload JWT avec l'identifiant de l'utilisateur et son rôle
            $payload = [
                'iat' => time(),
                'exp' => time() + 18000, // Expiration du token après 5 heures (18000 secondes)
                'id' => $res[0]['id'],
                'role' => $res[0]['role']
            ];
            // Encodage du payload en JWT avec la clé secrète
            $jwt = JWT::encode($payload, $key, 'HS256');
            // Réponse avec un message de succès et le token JWT
            $response->getBody()->write(json_encode(['valid' => 'Vous êtes connecté', 'token' => $jwt]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } else {
            // Réponse avec un message d'erreur si le mot de passe est incorrect
            $response->getBody()->write(json_encode(['erreur' => 'Mauvais mot de passe ou mauvais mail']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    } else {
        // Réponse avec un message d'erreur si aucun utilisateur n'a été trouvé avec cet email
        $response->getBody()->write(json_encode(['erreur' => 'Utilisateur non trouvé']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
});

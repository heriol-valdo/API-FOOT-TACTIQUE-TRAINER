
<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../../models/JoueurModel.php';

$app->post('/addPlayer', function (Request $request, Response $response) {
    // Initialise un tableau pour stocker les erreurs éventuelles
    $err = array();
    
    // Récupère les données du corps de la requête
    $data = $request->getParsedBody();

    // Vérifie si le prénom est vide
    if(empty($data['prenom'])){
        $err['prenom'] = 'prenom de famille vide';
    }
    // Vérifie si le nom est vide
    if(empty($data['nom'])){
        $err['nom'] = 'nom vide';
    }
    // Vérifie si l'email est vide
    if(empty($data['email'])){
        $err['email'] = 'email email vide';
    }
    // Vérifie si l'âge est vide
    if(empty($data['age'])){
        $err['age'] = 'age vide';
    }
    // Vérifie si l'adresse est vide
    if(empty($data['adresse'])){
        $err['adresse'] = 'adresse vide';
    }
    // Vérifie si le numéro de téléphone est vide
    if(empty($data['telephone'])){
        $err['telephone'] = 'telephone vide';
    }

    // Si aucun champ n'est vide
    if(empty($err)){
        // Crée une nouvelle instance de la classe Joueur
        $joueur = new Joueur();
        // Affecte les données du formulaire à l'objet Joueur
        $joueur->firstname = $data['nom'];
        $joueur->lastname = $data['prenom'];
        $joueur->email = $data['email'];
        $joueur->age = $data['age'];
        $joueur->adresse = $data['adresse'];
        $joueur->telephone = $data['telephone'];
        
        // Vérifie si l'email existe déjà dans la base de données
        $exitjoueur =  $joueur->boolEmail();
        // Vérifie si le numéro de téléphone existe déjà dans la base de données
        $exitjoueurtel =  $joueur->boolTel();

        if($exitjoueur){
            if($exitjoueurtel){
                // Ajoute le joueur à la base de données
                $joueur->addJoueur();
                // Répond avec un message JSON indiquant le succès
                $response->getBody()->write(json_encode(['valid' => 'ok']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
            }else{
                // Répond avec un message JSON indiquant que le numéro de téléphone existe déjà
                $response->getBody()->write(json_encode(['erreur' =>"Ce numéro est déjà enregistré"]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        }else{
            // Répond avec un message JSON indiquant que l'email existe déjà
            $response->getBody()->write(json_encode(['erreur' =>"Un compte avec cette adresse e-mail existe déjà"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }else{
        // Répond avec un message JSON indiquant qu'il manque des informations dans le formulaire
        $response->getBody()->write(json_encode(['erreur' =>"il manque des informations à votre formulaire"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
})->add($authMiddleware);

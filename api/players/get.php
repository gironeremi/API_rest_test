<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Players.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les joueurs
    $player = new Players($db);

    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->id)){
        $player->id = $data->id;

        // On récupère le produit
        $player->get();

        // On vérifie si le produit existe
        if($player->name != null){

            $result = [
                "id" => $player->id,
                "name" => $player->name,
                "age" => $player->age,
                "city" => $player->city
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($result);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "Le produit n'existe pas."));
        }
        
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
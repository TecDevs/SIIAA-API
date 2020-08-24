<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/api/eventos/get-events', function(Request $request, Response $response){
    $sql = "SELECT * FROM eventos";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->query($sql);

        if($result->rowCount() > 0){
            $eventos = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($eventos);
        } else {
            echo json_encode("No hay eventos actualmente");
        }
        $result = null;
        $db = null;
    }catch(PDOException $ex) {
        echo '{"error": '.$ex->getMessage().'}';
    }
});
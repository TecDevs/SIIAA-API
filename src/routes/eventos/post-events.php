<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->post('/api/eventos/post-events', function(Request $request, Response $response){
    
    $nombreEvento = $request->getParam('nombreEvento');
    $fecha_evento = $request->getParam('fecha_evento');


    $sql = "INSERT INTO eventos (evento, fecha_de_evento) VALUES
            (:nombreEvento, :fecha_evento)";

    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);

        $result->bindParam(':nombreEvento', $nombreEvento);
        $result->bindParam(':fecha_evento', $fecha_evento);

        $result->execute();
        echo json_encode("Evento guardado exitosamente");
        
        $result = null;
        $db = null;
    }catch(PDOException $ex) {
        echo '{"error": '.$ex->getMessage().'}';
    }
});
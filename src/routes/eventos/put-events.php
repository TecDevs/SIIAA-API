<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->put('/api/eventos/put-events/{id}', function(Request $request, Response $response){
    
    $id_eventos = $request->getAttribute('id');
    $nombreEvento = $request->getParam('nombreEvento');
    $fecha_evento = $request->getParam('fecha_evento');


    $sql = "UPDATE eventos SET
            evento           = :nombreEvento,
            fecha_de_evento  = :fecha_evento
            WHERE id_eventos = $id_eventos";

    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);

        $result->bindParam(':nombreEvento', $nombreEvento);
        $result->bindParam(':fecha_evento', $fecha_evento);

        $result->execute();
        echo json_encode("Se a modificado el evento exitosamente");
        
        $result = null;
        $db = null;
    }catch(PDOException $ex) {
        echo '{"error": '.$ex->getMessage().'}';
    }
});
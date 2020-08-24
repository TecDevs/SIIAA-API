<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->put('/api/avisos/put-avisos/{id}', function(Request $request, Response $response){
    
    $id_avisos            = $request->getAttribute('id');
    $nombreAviso          = $request->getParam('nombreAviso');
    $fecha_de_publicacion = $request->getParam('fecha_de_publicacion');
    $fecha_de_caducidad   = $request->getParam('fecha_de_caducidad');

    $sql = "UPDATE avisos SET
            aviso                = :nombreAviso,
            fecha_de_publicacion = :fecha_de_publicacion,
            fecha_de_caducidad   = :fecha_de_caducidad
            WHERE id_avisos = $id_avisos";

    try { 
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);

        $result->bindParam(':nombreAviso', $nombreAviso);
        $result->bindParam(':fecha_de_publicacion', $fecha_de_publicacion);
        $result->bindParam(':fecha_de_caducidad', $fecha_de_caducidad);

        $result->execute();
        echo json_encode("Se a modificado el aviso exitosamente");
        
        $result = null;
        $db = null;
    }catch(PDOException $ex) {
        echo '{"error": '.$ex->getMessage().'}';
    }
});
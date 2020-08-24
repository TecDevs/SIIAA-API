<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->post('/api/avisos/post_avisos', function(Request $request, Response $response){
    
    $nombreAviso          = $request->getParam('nombreAviso');
    $fecha_de_publicacion = $request->getParam('fecha_de_publicacion');
    $fecha_de_caducidad   = $request->getParam('fecha_de_caducidad');

    $sql = "INSERT INTO avisos (aviso, fecha_de_publicacion, fecha_de_caducidad) VALUES
            (:nombreAviso, :fecha_de_publicacion, :fecha_de_caducidad)";

    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);

        $result->bindParam(':nombreAviso', $nombreAviso);
        $result->bindParam(':fecha_de_publicacion', $fecha_de_publicacion);
        $result->bindParam(':fecha_de_caducidad', $fecha_de_caducidad);

        $result->execute();
        echo json_encode("Aviso guardado exitosamente");
        
        $result = null;
        $db = null;
    }catch(PDOException $ex) {
        echo '{"error": '.$ex->getMessage().'}';
    }
});
<?php

use Slim\Http\Request;
use Slim\Http\Response;


//API for get all events with method get
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

//API for insert events with method post
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

//API for update events with method put
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

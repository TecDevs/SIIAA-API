<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/api/eventos/get-events', function (Request $request, Response $response) {
    $sql = "SELECT * FROM eventos";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->query($sql);

        if ($result->rowCount() > 0) {
            $eventos = $result->fetchAll(PDO::FETCH_OBJ);
            return $response->withStatus(200)->withJson($eventos);
        } else {
            return $response->withStatus(200)->withJson("No hay eventos actualmente");
        }
        $result = null;
        $db = null;
    } catch (PDOException $ex) {
        return $response->withStatus(200)->withJson('{"error": ' . $ex->getMessage() . '}');
    }
});

$app->post('/api/eventos/post-events', function (Request $request, Response $response) {

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
        return $response->withStatus(200)->withJson("Evento guardado exitosamente");

        $result = null;
        $db = null;
    } catch (PDOException $ex) {
        return $response->withStatus(200)->withJson('{"error": ' . $ex->getMessage() . '}');
    }
});

$app->put('/api/eventos/put-events/{id}', function (Request $request, Response $response) {

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
        return $response->withStatus(200)->withJson("Se a modificado el evento exitosamente");

        $result = null;
        $db = null;
    } catch (PDOException $ex) {
        return $response->withStatus(200)->withJson('{"error": ' . $ex->getMessage() . '}');
    }
});

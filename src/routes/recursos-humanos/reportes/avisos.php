<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/api/avisos/get-avisos', function (Request $request, Response $response) {
    $sql = "SELECT * FROM avisos";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->query($sql);

        if ($result->rowCount() > 0) {
            $avisos = $result->fetchAll(PDO::FETCH_OBJ);
            return $response->withStatus(200)->withJson($avisos);
        } else {
            return $response->withStatus(200)->withJson("No hay avisos actualmente");
        }
        $result = null;
        $db = null;
    } catch (PDOException $ex) {
        return $response->withStatus(200)->withJson('{"error": ' . $ex->getMessage() . '}');
    }
});

//API for insert notice with method post
$app->post('/api/avisos/post_avisos', function (Request $request, Response $response) {

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
        return $response->withStatus(200)->withJson("Aviso guardado exitosamente");

        $result = null;
        $db = null;
    } catch (PDOException $ex) {
        return $response->withStatus(200)->withJson('{"error": ' . $ex->getMessage() . '}');
    }
});

//API for update notice with method put
$app->put('/api/avisos/put-avisos/{id}', function (Request $request, Response $response) {

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
        return $response->withStatus(200)->withJson("Se a modificado el aviso exitosamente");

        $result = null;
        $db = null;
    } catch (PDOException $ex) {
        return $response->withStatus(200)->withJson('{"error": ' . $ex->getMessage() . '}');
    }
});

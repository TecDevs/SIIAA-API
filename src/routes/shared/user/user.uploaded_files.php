<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('api/user/uploaded-files', function (Request $request, Response $response) {

    $idUsuario = $request->getParam('idUsuario');

    $sql = "SELECT DISTINCT id_archivos, ruta
            FROM archivos_usuarios
            WHERE id_usuarios = :idUsuario";

    try {
        $db = new Database();
        $db = $db->connectDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        if ($stmt->rowCount() >= 1) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $response->withStatus(200)->withJson($result);
        } else {
            return $response->withStatus(200)->withJson('No hay archivos');
        }
    } catch (PDOException $e) {
        return $response->withStatus(200)->withJson($e->getMessage());
    }
});

<?php

use Slim\Http\Response;
use Slim\Http\Request;

//CORS headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "OPTIONS") {
    die();
}

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

            echo json_encode($result);
        } else {
            echo json_encode('No hay archivos');
        }
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }
});

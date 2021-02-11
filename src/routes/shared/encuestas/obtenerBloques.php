<?php

use Slim\Http\Response;
use Slim\Http\Request;

$res = array();
$app->post('/api/encuestas/obtener-bloques', function (Request $request, Response $response) {
    $id_usuarios    = $request->getParam('id_usuarios');
    $id_usuarios    = htmlspecialchars(filter_var($id_usuarios, FILTER_SANITIZE_STRING));

    $sql = 'SELECT bloque FROM progreso_encuestas WHERE id_usuarios = :id_usuarios';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':id_usuarios', $id_usuarios);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->withJson($resultado);
    } catch (PDOException $th) {
        return $response->withStatus(200)->withJson('{"error":' . $th->getMessage() . '}');
    }
});

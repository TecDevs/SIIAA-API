<?php

use Slim\Http\Response;
use Slim\Http\Request;

$res = array();

$app->post('/api/encuestas/guardar-resultados', function (Request $request, Response $response) {
    $bloque         = $request->getParam('bloque');
    $id_area        = $request->getParam('id_areas');
    $valorRespuesta = $request->getParam('valor-respuesta');
    $pregunta       = $request->getParam('pregunta');
    $bloque          = htmlspecialchars(filter_var($bloque, FILTER_SANITIZE_STRING));
    $pregunta        = htmlspecialchars(filter_var($pregunta, FILTER_SANITIZE_STRING));

    $sql = 'SELECT id_bloques FROM bloques WHERE bloque = :bloque';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':bloque', $bloque);
        $result->execute();
        if (($id_bloques = $result->fetchColumn()) != null) {
            try {
                $sqlRes = 'INSERT INTO 
                respuestas (id_bloques, id_areas, valor_respuesta, pregunta)
                VALUES (:id_bloques, :id_areas, :valor_respuesta, :pregunta)';
                $stmt = $db->prepare($sqlRes);
                $stmt->bindParam(':id_bloques', $id_bloques);
                $stmt->bindParam(':id_areas', $id_area);
                $stmt->bindParam(':valor_respuesta', $valorRespuesta);
                $stmt->bindParam(':pregunta', $pregunta);
                $stmt->execute();
                $res = [
                    'exito' => 'registro exitoso'
                ];
            } catch (PDOException $th) {
                echo '{"error":' . $th->getMessage() . '}';
            }
        } else {
            $res = [
                'error' => 'No se encotro el area'
            ];
        }
    } catch (PDOException $th) {
        return $response->withStatus(200)->withJson('{"error":' . $th->getMessage() . '}');
    }
    return $response->withStatus(200)->withJson($res);
});

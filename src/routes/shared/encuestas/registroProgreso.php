<?php

use Slim\Http\Response;
use Slim\Http\Request;

$res = array();
$app->post('/api/encuestas/registro-progreso', function (Request $request, Response $response) {
    $id_usuarios    = $request->getParam('id_usuarios');
    $bloque         = $request->getParam('bloque');
    $bloque         = htmlspecialchars(filter_var($bloque, FILTER_SANITIZE_STRING));

    $sql = 'SELECT bloque FROM progreso_encuestas WHERE id_usuarios = :id_usuarios AND bloque = :bloque';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':bloque', $bloque);
        $result->bindParam(':id_usuarios', $id_usuarios);
        $result->execute();
        if (($id_bloques = $result->fetchColumn()) == null) {
            try {
                $sqlRes = 'INSERT INTO 
                progreso_encuestas (id_usuarios, bloque)
                VALUES (:id_usuarios, :bloque)';
                $stmt = $db->prepare($sqlRes);
                $stmt->bindParam(':id_usuarios', $id_usuarios);
                $stmt->bindParam(':bloque', $bloque);
                $res = [
                    'status' => 'false'
                ];
            } catch (PDOException $th) {
                echo '{"error":' . $th->getMessage() . '}';
            }
        } else {
            $res = [
                'status' => 'true'
            ];
        }
    } catch (PDOException $th) {
        return $response->withStatus(200)->withJson('{"error":' . $th->getMessage() . '}');
    }
    return $response->withStatus(200)->withJson($res);
});

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

$app->post('api/user/upload-file', function (Request $request, Response $response) {

    $destino = '/home/mantehostingacm/public_html/SIIAA-uploads';

    $idUsuario = $request->getParam('idUsuario');
    $documento = $request->getParam('fileType');
    $file = $request->getUploadedFiles();

    switch ($documento) {
        case 1:
            $archivo = 'acta_nacimiento';
            break;
        case 2:
            $archivo = 'rfc';
            break;
        case 3:
            $archivo = 'curp';
            break;
        case 4:
            $archivo = 'ine';
            break;
        case 5:
            $archivo = 'comprobante_domicilio';
            break;
        case 6:
            $archivo = 'curriculum';
            break;
        case 7:
            $archivo = 'kardex';
            break;
        case 8:
            $archivo = 'titulo';
            break;
        case 9:
            $archivo = 'cedula';
            break;
        case 11:
            $archivo = 'maestria';
            break;
    }

    $destino = $destino . '/' . $idUsuario;

    if (!file_exists($destino)) {
        mkdir($destino, 0777, true);
    }

    $destino = $destino . '/' . $archivo . '.pdf';

    if (move_uploaded_file($file['file']['tmp_name'], $destino)) {

        $sql = "DELETE FROM archivos_usuarios
                WHERE id_usuarios = :idUsuario
                AND   id_archivos = :documento";

        try {
            $db = new Database();
            $db = $db->connectDB();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':documento', $documento);
            $stmt->execute();

            $sql = "INSERT INTO archivos_usuarios 
                VALUES(:idUsuario, :documento, :destino)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':destino', $destino);
            $stmt->execute();

            if ($stmt->rowCount() >= 1) {
                echo json_encode('Subida exitosa');
            } else {
                unlink($destino);
                return $response->withStatus(200)->withJson('Ocurrio un error al subir el archivo');
            }
        } catch (PDOException $e) {
            return $response->withStatus(200)->withJson($e->getMessage());
        }
    } else {
        return $response->withStatus(200)->withJson('Ocurrio un problema al subir el archivo');
    }
});

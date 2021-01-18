<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('/api/rh/user/new', function (Request $request, Response $response) {
    $area                = $request->getParam('area');
    $nombres                = $request->getParam('nombres');
    $a_paterno              = $request->getParam('a_paterno');
    $a_materno              = $request->getParam('a_materno');
    $fecha_de_nacimiento    = $request->getParam('fecha_de_nacimiento');
    $celular                = $request->getParam('celular');
    $cp                     = $request->getParam('cp');
    $ciudad                 = $request->getParam('ciudad');
    $estado                 = $request->getParam('estado');
    $municipio              = $request->getParam('municipio');
    $colonia                = $request->getParam('colonia');
    $calle                  = $request->getParam('calle');
    $numInt                 = $request->getParam('numInt');
    $numExt                 = $request->getParam('numExt');
    $correo                 = $request->getParam('correo');
    $contrasena             = $request->getParam('contrasena');

    $nombres             = htmlspecialchars(filter_var($nombres, FILTER_SANITIZE_STRING));
    $a_paterno           = htmlspecialchars(filter_var($a_paterno, FILTER_SANITIZE_STRING));
    $a_materno           = htmlspecialchars(filter_var($a_materno, FILTER_SANITIZE_STRING));
    $fecha_de_nacimiento = htmlspecialchars(filter_var($fecha_de_nacimiento, FILTER_SANITIZE_STRING));
    $celular             = htmlspecialchars(filter_var($celular, FILTER_SANITIZE_STRING));
    $cp                  = htmlspecialchars(filter_var($cp, FILTER_SANITIZE_STRING));
    $ciudad              = htmlspecialchars(filter_var($ciudad, FILTER_SANITIZE_STRING));
    $estado              = htmlspecialchars(filter_var($estado, FILTER_SANITIZE_STRING));
    $municipio           = htmlspecialchars(filter_var($municipio, FILTER_SANITIZE_STRING));
    $colonia             = htmlspecialchars(filter_var($colonia, FILTER_SANITIZE_STRING));
    $calle               = htmlspecialchars(filter_var($calle, FILTER_SANITIZE_STRING));
    $numInt              = htmlspecialchars(filter_var($numInt, FILTER_SANITIZE_NUMBER_INT));
    $numExt              = htmlspecialchars(filter_var($numExt, FILTER_SANITIZE_NUMBER_INT));
    $correo              = htmlspecialchars(filter_var($correo, FILTER_SANITIZE_STRING));
    $contrasena          = htmlspecialchars(filter_var($contrasena, FILTER_SANITIZE_STRING));

    $sqlNewUser = 'INSERT INTO 
                usuarios ( 
                    id_areas,
                    nombres,
                    apellido_paterno,
                    apellido_materno,
                    fecha_de_nacimiento,
                    ciudad,
                    municipio,
                    estado,
                    codigo_postal,
                    num_ext,
                    num_int,
                    colonia,
                    calle,
                    numero_celular,
                    correo_electronico,
                    contrasena )
            VALUES (
                    :id_areas,
                    :nombres,
                    :apellido_paterno,
                    :apellido_materno,
                    :fecha_de_nacimiento,
                    :ciudad,
                    :municipio,
                    :estado,
                    :codigo_postal,
                    :num_ext,
                    :num_int,
                    :colonia,
                    :calle,
                    :numero_celular,
                    :correo_electronico,
                    :contraseña )';

    $sqlArea = "SELECT id_areas, nombre_area FROM areas WHERE nombre_area = :area";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $stmtArea = $db->prepare($sqlArea);
        $stmtArea->bindParam(':area', $area);
        $stmtArea->execute();
        if (($idAreas = $stmtArea->fetchColumn()) != null) {
            $db = new Database();
            $db = $db->connectDB();
            $result = $db->prepare($sqlNewUser);
            $result->bindParam(':id_areas', $idAreas);
            $result->bindParam(':nombres', $nombres);
            $result->bindParam(':apellido_paterno', $a_paterno);
            $result->bindParam(':apellido_materno', $a_materno);
            $result->bindParam(':fecha_de_nacimiento', $fecha_de_nacimiento);
            $result->bindParam(':ciudad', $ciudad);
            $result->bindParam(':municipio', $municipio);
            $result->bindParam(':estado', $estado);
            $result->bindParam(':codigo_postal', $cp);
            $result->bindParam(':num_ext', $numExt);
            $result->bindParam(':num_int', $numInt);
            $result->bindParam(':colonia', $colonia);
            $result->bindParam(':calle', $calle);
            $result->bindParam(':correo_electronico', $correo);
            $result->bindParam(':contraseña', $contrasena);
            $result->execute();
            return $response->withStatus(200)->withJson('El usuario se registro correctamente');
        } else {
            return $response->withStatus(200)->withJson('El area no se encontro');
        }
    } catch (PDOException $th) {
        return $response->withStatus(200)->withJson('{"error": ' . $th->getMessage() . '}');
    }
});

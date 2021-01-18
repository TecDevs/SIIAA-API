<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->put('/api/login/token-register', function (Request $request, Response $response) {
    $nombres    = $request->getParam('nombres');
    $apePat     = $request->getParam('apePat');
    $apeMat     = $request->getParam('apeMat');
    $fechaNac   = $request->getParam('fechaNac');
    $celular    = $request->getParam('celular');
    $cp         = $request->getParam('cp');
    $ciudad     = $request->getParam('ciudad');
    $estado     = $request->getParam('estado');
    $municipio  = $request->getParam('municipio');
    $colonia    = $request->getParam('colonia');
    $calle      = $request->getParam('calle');
    $numInt     = $request->getParam('numInt');
    $numExt     = $request->getParam('numExt');
    $correo     = $request->getParam('email');
    $contrasena = $request->getParam('pass');
    $token      = $request->getParam('token');

    $nombres    = htmlspecialchars(filter_var($nombres, FILTER_SANITIZE_STRING));
    $apePat     = htmlspecialchars(filter_var($apePat, FILTER_SANITIZE_STRING));
    $apeMat     = htmlspecialchars(filter_var($apeMat, FILTER_SANITIZE_STRING));
    $fechaNac   = htmlspecialchars(filter_var($fechaNac, FILTER_SANITIZE_STRING));
    $celular    = htmlspecialchars(filter_var($celular, FILTER_SANITIZE_STRING));
    $cp         = htmlspecialchars(filter_var($cp, FILTER_SANITIZE_STRING));
    $ciudad     = htmlspecialchars(filter_var($ciudad, FILTER_SANITIZE_STRING));
    $estado     = htmlspecialchars(filter_var($estado, FILTER_SANITIZE_STRING));
    $municipio  = htmlspecialchars(filter_var($municipio, FILTER_SANITIZE_STRING));
    $colonia    = htmlspecialchars(filter_var($colonia, FILTER_SANITIZE_STRING));
    $calle      = htmlspecialchars(filter_var($calle, FILTER_SANITIZE_STRING));
    $numInt     = htmlspecialchars(filter_var($numInt, FILTER_SANITIZE_STRING));
    $numExt     = htmlspecialchars(filter_var($numExt, FILTER_SANITIZE_STRING));
    $correo     = htmlspecialchars(filter_var($correo, FILTER_SANITIZE_EMAIL));
    $contrasena = htmlspecialchars(filter_var($contrasena, FILTER_SANITIZE_STRING));
    $token      = htmlspecialchars(filter_var($token, FILTER_SANITIZE_STRING));

    $sql = "UPDATE usuarios 
            SET nombres = :nombres, 
                apellido_paterno = :apePat, 
                apellido_materno = :apeMat, 
                fecha_de_nacimiento = :fechaNac, 
                ciudad = :ciudad,
                municipio = :municipio, 
                estado = :estado, 
                codigo_postal = :cp, 
                num_ext = :numExt, 
                num_int = :numInt, 
                colonia = :colonia,
                calle = :calle, 
                numero_celular = :celular, 
                correo_electronico = :correo,
                contrasena = :contrasena, 
                token = '' 
            WHERE token = :token";
    
    try {
        $db = new Database();
        $db = $db->connectDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apePat', $apePat);
        $stmt->bindParam(':apeMat', $apeMat);
        $stmt->bindParam(':fechaNac', $fechaNac);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':municipio', $municipio);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':numExt', $numExt);
        $stmt->bindParam(':numInt', $numInt);
        $stmt->bindParam(':colonia', $colonia);
        $stmt->bindParam(':calle', $calle);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() >= 1) {
            return $response->withStatus(200)->withJson('Registro exitoso');
        } else {
            return $response->withStatus(200)->withJson('No se encontro el token');
        }
    } catch(PDOException $e) {
        return $response->withStatus(200)->withJson($e->getMessage());
    }
});

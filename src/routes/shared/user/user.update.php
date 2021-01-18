<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('/api/shared/user/update', function (Request $request, Response $response) {
    $nombres       = $request->getParam('nombres');
    $apePat        = $request->getParam('apePat');
    $apeMat        = $request->getParam('apeMat');
    $fechNac       = $request->getParam('fechNac');
    $celular       = $request->getParam('celular');
    $cp            = $request->getParam('cp');
    $ciudad        = $request->getParam('ciudad');
    $estado        = $request->getParam('estado');
    $municipio     = $request->getParam('municipio');
    $colonia       = $request->getParam('colonia');
    $calle         = $request->getParam('calle');
    $numInt        = $request->getParam('numInt');
    $numExt        = $request->getParam('numExt');
    $correo        = $request->getParam('correo');
    $correo_old    = $request->getParam('correo_old');
    $contrasena    = $request->getParam('contrasena');
    $token         = $request->getParam('token');
    $id_usuarios   = $request->getParam('id_usuarios');

    $nombres    = htmlspecialchars(filter_var($nombres, FILTER_SANITIZE_STRING));
    $apePat     = htmlspecialchars(filter_var($apePat, FILTER_SANITIZE_STRING));
    $apeMat     = htmlspecialchars(filter_var($apeMat, FILTER_SANITIZE_STRING));
    $fechNac    = htmlspecialchars(filter_var($fechNac, FILTER_SANITIZE_STRING));
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
    $correo_old = htmlspecialchars(filter_var($correo_old, FILTER_SANITIZE_EMAIL));
    $contrasena = htmlspecialchars(filter_var($contrasena, FILTER_SANITIZE_STRING));
    $token      = htmlspecialchars(filter_var($token, FILTER_SANITIZE_STRING));
    $id_usuarios= htmlspecialchars(filter_var($id_usuarios, FILTER_SANITIZE_NUMBER_INT));

    $sql = 'UPDATE usuarios
            SET nombres             = :nombres,
                apellido_paterno    = :apePat,
                apellido_materno    = :apeMat,
                fecha_de_nacimiento = :fechNac,
                ciudad              = :ciudad,
                municipio           = :municipio,
                estado              = :estado,
                codigo_postal       = :codigo_postal,
                num_ext             = :num_ext,
                num_int             = :num_int,
                colonia             = :colonia,
                calle               = :calle,
                numero_celular      = :numero_celular,
                correo_electronico  = :correo_electronico,
                contrasena          = :contrasena
            WHERE correo_electronico = :correo_old
            ';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':nombres', $nombres);
        $result->bindParam(':apePat', $apePat);
        $result->bindParam(':apeMat', $apeMat);
        $result->bindParam(':fechNac', $fechNac);
        $result->bindParam(':ciudad',$ciudad);
        $result->bindParam(':municipio', $municipio);
        $result->bindParam(':estado', $estado);
        $result->bindParam(':codigo_postal', $cp);
        $result->bindParam(':num_ext', $numExt);
        $result->bindParam(':num_int', $numInt);
        $result->bindParam(':colonia', $colonia);
        $result->bindParam(':calle', $calle);
        $result->bindParam(':numero_celular', $celular);
        $result->bindParam(':correo_electronico', $correo);
        $result->bindParam(':contrasena', $contrasena);
        $result->bindParam(':correo_old', $correo_old);
        $result->execute();
        if ($result->rowCount() > 0){
            $response = [
                'success' => 'SUCCESS_UPDATE',
            ];
        }else{
            $response = [
                'error' => 'ERROR_UPDATE_INFO',
            ];
        }
        echo json_encode($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error": ' . $e->getMessage() . '}';
    }
});
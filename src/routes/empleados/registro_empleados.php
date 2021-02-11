<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('/api/empleados/new', function (Request $request, Response $response) {
    // infomación tabla empleados
    $id_cargos  = $request->getParam('id_cargos');
    $correo     = $request->getParam('correo');
    $contrasena = $request->getParam('contrasena');
    // información personal
    $nombre              = $request->getParam('nombre');
    $ape_pat            = $request->getParam('ape_pat');
    $ape_mat            = $request->getParam('ape_mat');
    $sexo               = $request->getParam('sexo');
    $fecha_nacimiento   = $request->getParam('fecha_nacimiento');
    $lugar_nacimiento   = $request->getParam('lugar_nacimiento');
    $tel_fijo           = $request->getParam('tel_fijo');
    $tel_cel            = $request->getParam('tel_cel');
    $codigo_postal      = $request->getParam('codigo_postal');
    $ciudad             = $request->getParam('ciudad');
    $estado             = $request->getParam('estado');
    $municipio          = $request->getParam('municipio');
    $colonia            = $request->getParam('colonia');
    $calle              = $request->getParam('calle');
    $num_ext            = $request->getParam('num_ext');
    $num_int            = $request->getParam('num_int');
    $token              = $request->getParam('token');

    $sql = "CALL SP_registro_empleados (
        :nombre,
        :ape_pat,
        :ape_mat,
        :sexo,
        :fecha_nacimiento,
        :lugar_nacimiento,
        :tel_fijo,
        :tel_cel,
        :codigo_postal,
        :ciudad,
        :estado,
        :municipio,
        :colonia,
        :calle,
        :num_ext,
        :num_int,
        :id_cargos,
        :correo,
        :contrasena,
        :token,
        @result
    )";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_cargos', $id_cargos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ape_pat', $ape_pat);
        $stmt->bindParam(':ape_mat', $ape_mat);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':lugar_nacimiento', $lugar_nacimiento);
        $stmt->bindParam(':tel_fijo', $tel_fijo);
        $stmt->bindParam(':tel_cel', $tel_cel);
        $stmt->bindParam(':codigo_postal', $codigo_postal);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':municipio', $municipio);
        $stmt->bindParam(':colonia', $colonia);
        $stmt->bindParam(':calle', $calle);
        $stmt->bindParam(':num_ext', $num_ext);
        $stmt->bindParam(':num_int', $num_int);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $message = $db->query('SELECT @result AS msg')->fetch(PDO::FETCH_ASSOC);
        return $response->withStatus(200)->withJson([
            'error' => false,
            'message' => $message['msg']
        ]);
    } catch (PDOException $th) {
        return $response->withStatus(200)->withJson('{"error": ' . $th->getMessage() . '}');
    }
});

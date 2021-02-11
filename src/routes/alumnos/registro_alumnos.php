<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('/api/alumnos/new', function (Request $request, Response $response) {
    // infomación tabla alumnos
    $id_carreras    = $request->getParam('id_carreras');
    $matricula      = $request->getParam('matricula');
    $nss            = $request->getParam('nss');
    $tipo_sangre    = $request->getParam('tipo_sangre');
    $tutor          = $request->getParam('tutor');
    $correo         = $request->getParam('correo');
    $contrasena     = $request->getParam('contrasena');
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

    $sql = "CALL SP_registro_alumno (
        :id_carreras,
        :matricula,
        :nss,
        :tipo_sangre,
        :tutor,
        :correo,
        :contrasena,
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
        @result
    )";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_carreras', $id_carreras);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':nss', $nss);
        $stmt->bindParam(':tipo_sangre', $tipo_sangre);
        $stmt->bindParam(':tutor', $tutor);
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
        $stmt->execute();
        $message = $db->query('SELECT @result AS msg')->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $response->withStatus(200)->withJson([
                'error' => false,
                'message' => $message['msg']
            ]);
        } else {
            return $response->withStatus(200)->withJson([
                'error' => true,
                'message' => $message['msg']
            ]);
        }
    } catch (PDOException $th) {
        return $response->withStatus(200)->withJson('{"error": ' . $th->getMessage() . '}');
    }
});

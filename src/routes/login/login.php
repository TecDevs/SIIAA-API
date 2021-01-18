<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('/api/login', function (Request $request, Response $response) {
    $correo     = $request->getParam('email');
    $contrasena = $request->getParam('pass');

    $correo     = htmlspecialchars(filter_var($correo, FILTER_SANITIZE_EMAIL));
    $contrasena = htmlspecialchars(filter_var($contrasena, FILTER_SANITIZE_STRING));

    $sql = "SELECT *
            FROM empleados
            JOIN cargos ON
                empleados.id_cargos = cargos.id_cargos
            JOIN informacion_personal ON
                empleados.id_informacion_personal = informacion_personal.id_informacion_personal
            WHERE correo = :correo";

    try {
        $db = new Database();
        $db = $db->connectDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            $sql = "SELECT *
                    FROM alumnos
                    JOIN carreras ON
                        alumnos.id_carreras = carreras.id_carreras
                    JOIN informacion_personal ON
                        alumnos.id_informacion_personal = informacion_personal.id_informacion_personal
                    WHERE correo = :correo";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['contrasena'] === $contrasena) {
                array_map(function ($value) {
                    return utf8_encode($value);
                }, $result);
                return $response->withJson($result)->withStatus(200);
            } else {
                return $response->withJson('Contraseña incorrecta')->withStatus(200);
            }
        } else {
            return $response->withJson('Usuario no encontrado')->withStatus(200);
        }
    } catch (PDOException $e) {
        return $response->withJson($e->getMessage())->withStatus(200);
    }
});

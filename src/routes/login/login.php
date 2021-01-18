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

$app->post('api/login', function (Request $request, Response $response) {
    $correo     =$request->getParam('email');
    $contrasena =$request->getParam('pass');
    
    $correo     = htmlspecialchars(filter_var($correo, FILTER_SANITIZE_EMAIL));
    $contrasena = htmlspecialchars(filter_var($contrasena, FILTER_SANITIZE_STRING));

    $sql = "SELECT 
                id_usuarios, 
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
                contrasena
            FROM usuarios 
            WHERE correo_electronico=:correo";

    try {
        $db = new Database();
        $db = $db->connectDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['contrasena'] === $contrasena) {
                array_map(function ($value){
                    return utf8_encode($value);
                }, $result);
                echo json_encode($result);
            } else {
                echo json_encode('Contrasena incorrecta');
            }
        } else {
            echo json_encode('No existe');
        }
    } catch(PDOException $e) {
        echo json_encode($e->getMessage());
    }

});

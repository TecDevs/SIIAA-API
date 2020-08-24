<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/api/avisos/get-avisos', function(Request $request, Response $response){
    $sql = "SELECT * FROM avisos";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->query($sql);

        if($result->rowCount() > 0){
            $avisos = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($avisos);
        } else {
            echo json_encode("No hay avisos actualmente");
        }
        $result = null;
        $db = null;
    }catch(PDOException $ex) {
        echo '{"error": '.$ex->getMessage().'}';
    }
});
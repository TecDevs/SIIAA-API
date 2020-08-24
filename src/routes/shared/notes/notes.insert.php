<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
//CORS headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}
//show profile picture
$app->post('/api/shared/user/notes/insert', function (Request $request, Response $response) {
    /*info*/
    
    $title = $request->getParam('title');
    $description = $request->getParam('description');
    $date = $request->getParam('date');
    $idUser = $request->getParam('idUser');

    $title         = htmlspecialchars(filter_var($title, FILTER_SANITIZE_STRING));
    $description   = htmlspecialchars(filter_var($description, FILTER_SANITIZE_STRING));
    $date          = htmlspecialchars(filter_var($date, FILTER_SANITIZE_STRING));
    $idUser        = htmlspecialchars(filter_var($idUser, FILTER_SANITIZE_NUMBER_INT));
    

    $sql = 'INSERT INTO notas (id_usuarios, titulo, descripcion, fecha) 
            VALUES (:idUser, :title, :descriptionn, :datee)';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':idUser', $idUser);
        $result->bindParam(':title', $title);
        $result->bindParam(':descriptionn', $description);
        $result->bindParam(':datee', $date);
        $result->execute();

        if ($result->rowCount() == 0){
            $response = [
                'message' => 'ERROR_REGISTERED_NOTE'
            ];
        }else{
            $response = [
                'message' => 'NOTE_REGISTERED_OK'
            ];
        }
        
        echo json_encode($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error": ' . $e->getMessage() . '}';
    }
});

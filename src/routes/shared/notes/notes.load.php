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
$app->post('/api/shared/user/notes/load', function (Request $request, Response $response) {
    /*info*/
    $idUser = $request->getParam('idUser');
    $idUser= htmlspecialchars(filter_var($idUser, FILTER_SANITIZE_NUMBER_INT));

    $sql = 'SELECT id_notas, id_usuarios, titulo, descripcion, fecha FROM notas WHERE id_usuarios=:idUser';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':idUser', $idUser);
        $result->execute();

        if ($result->rowCount() == 0){
            $response = [
                'message' => 'NO_NOTES'
            ];
        }else{
            $response = [
                'total_notes' => $result->rowCount(),
                'notes' => $result->fetchAll(PDO::FETCH_OBJ)
            ];
        }
        
        echo json_encode($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error": ' . $e->getMessage() . '}';
    }
});

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
$app->post('/api/shared/user/notes/delete', function (Request $request, Response $response) {
    /*info*/
    $idNote = $request->getParam('idNote');
    $idNote= htmlspecialchars(filter_var($idNote, FILTER_SANITIZE_NUMBER_INT));

    $sql = 'DELETE FROM notas WHERE id_notas=:idNote';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':idNote', $idNote);
        $result->execute();

        if ($result->rowCount() == 0){
            $response = [
                'message' => 'FAIL_DELETED'
            ];
        }else{
            $response = [
                'id_note' => $idNote,
                'message' => 'NOTE_DELETED'
            ];
        }
        
        echo json_encode($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error": ' . $e->getMessage() . '}';
    }
});

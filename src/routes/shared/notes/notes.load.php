<?php

use Slim\Http\Response;
use Slim\Http\Request;

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

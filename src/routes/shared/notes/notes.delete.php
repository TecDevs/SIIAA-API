<?php

use Slim\Http\Response;
use Slim\Http\Request;

//show profile picture
$app->post('/api/shared/user/notes/delete', function (Request $request, Response $httpResponse) {
    /*info*/
    $idNote = $request->getParam('idNote');
    $idNote = htmlspecialchars(filter_var($idNote, FILTER_SANITIZE_NUMBER_INT));

    $sql = 'DELETE FROM notas WHERE id_notas=:idNote';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':idNote', $idNote);
        $result->execute();

        if ($result->rowCount() == 0) {
            $response = [
                'message' => 'FAIL_DELETED'
            ];
        } else {
            $response = [
                'id_note' => $idNote,
                'message' => 'NOTE_DELETED'
            ];
        }

        return $httpResponse->withStatus(200)->withJson($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        return $httpResponse->withStatus(200)->withJson('{"error": ' . $e->getMessage() . '}');
    }
});

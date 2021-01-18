<?php

use Slim\Http\Response;
use Slim\Http\Request;

//show profile picture
$app->post('/api/shared/user/notes/update', function (Request $request, Response $httpResponse) {
    /*info*/

    $title = $request->getParam('title');
    $description = $request->getParam('description');
    $idNote = $request->getParam('idNote');
    $idUser = $request->getParam('idUser');

    $title         = htmlspecialchars(filter_var($title, FILTER_SANITIZE_STRING));
    $description   = htmlspecialchars(filter_var($description, FILTER_SANITIZE_STRING));
    $idNote          = htmlspecialchars(filter_var($idNote, FILTER_SANITIZE_STRING));
    $idUser        = htmlspecialchars(filter_var($idUser, FILTER_SANITIZE_NUMBER_INT));


    $sql = 'UPDATE notas SET titulo=:title, descripcion=:descriptionn 
            WHERE id_usuarios=:idUser  and id_notas=:idNote';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':idUser', $idUser);
        $result->bindParam(':title', $title);
        $result->bindParam(':descriptionn', $description);
        $result->bindParam(':idNote', $idNote);
        $result->execute();

        if ($result->rowCount() == 0) {
            $response = [
                'message' => 'ERROR_UPDATING_NOTE'
            ];
        } else {
            $response = [
                'message' => 'NOTE_UPDATED_OK'
            ];
        }

        return $httpResponse->withStatus(200)->withJson($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        return $httpResponse->withStatus(200)->withJson('{"error": ' . $e->getMessage() . '}');
    }
});

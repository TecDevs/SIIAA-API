<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$res = array();
$app->post('/api/encuestas/obtener-bloques', function (Request $request, Response $response){
    $id_usuarios    = $request->getParam('id_usuarios');
    $id_usuarios    = htmlspecialchars(filter_var($id_usuarios , FILTER_SANITIZE_STRING));

    $sql = 'SELECT bloque FROM progreso_encuestas WHERE id_usuarios = :id_usuarios';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':id_usuarios', $id_usuarios);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($resultado);

    } catch (PDOException $th) {
        echo '{"error":'.$th->getMessage().'}';
    }

});
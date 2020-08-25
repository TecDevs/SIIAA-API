<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//CORS headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$app->get('api/rh/personal', function( Request $reques, Response $response){
    $sql = 'SELECT nombres, apellido_paterno, apellido_materno, fecha_de_nacimiento, colonia, calle 
        FROM usuarios';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->query($sql);
        if ( $result->RowCount() > 0 ){
            $personal = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($personal);
        }else{
            echo json_encode('No existen usuarios en la bd');
        }
    } catch (PDOException $th) {
        echo '{"error": '.$th->getMessage().'}';
    }
});
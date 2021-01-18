<?php
use Slim\Http\Response;
use Slim\Http\Request;

$app->get('/api/rh/personal', function( Request $reques, Response $response){
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
<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/database.php';

/**Librerias del PHPMailer */
require '../src/lib/mailLibrary/PHPMailer.php';
require '../src/lib/mailLibrary/SMTP.php';
require '../src/lib/mailLibrary/Exception.php';
require '../src/lib/mailLibrary/OAuth.php';

//CORS headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

#region Login
require '../src/routes/login/login.php';
require '../src/routes/login/login.recover.php';
require '../src/routes/login/login.token_register.php';
#endregion

#region Shared
require '../src/routes/shared/user/user.update.php';
require '../src/routes/shared/user/user.picture.php';
require '../src/routes/shared/user/user.upload_file.php';
require '../src/routes/shared/user/user.uploaded_files.php';

require '../src/routes/shared/notes/notes.load.php';
require '../src/routes/shared/notes/notes.delete.php';
require '../src/routes/shared/notes/notes.insert.php';
require '../src/routes/shared/notes/notes.update.php';
#endregion

#region Recursos humanos
require '../src/routes/recursos-humanos/generar-token.php';
require '../src/routes/recursos-humanos/personal.php';
require '../src/routes/recursos-humanos/registro-empleado.php';
#endregion

#region Encuestas
require '../src/routes/shared/encuestas/registro-de-respuestas.php';
require '../src/routes/shared/encuestas/obtenerBloques.php';
require '../src/routes/shared/encuestas/registroProgreso.php';
#endregion

#region eventos
require '../src/routes/recursos-humanos/reportes/eventos.php';
#endregion

#region avisos
require '../src/routes/recursos-humanos/reportes/avisos.php';
#endregion

$app->run();
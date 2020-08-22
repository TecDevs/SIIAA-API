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

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

#region Routes --- Aquí se harán los require de todas las rutas de la API
// Se pone la referencia al archivo local de php
// Ejemplo: require '../src/routes/clientes.php';

#endregion
require '../src/routes/recursos-humanos/generar-token.php';
require '../src/routes/shared/encuestas/registro-de-respuestas.php';

$app->run();
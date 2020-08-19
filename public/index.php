<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/database.php';

$app = new \Slim\App;

#region Routes --- Aquí se harán los require de todas las rutas de la API
// Se pone la referencia al archivo local de php
// Ejemplo: require '../src/routes/clientes.php';

#endregion


$app->run();
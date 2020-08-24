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

    #region Login
        require '../src/routes/login/login.recover.php';
    #endregion

    #region Shared
        require '../src/routes/shared/user/user.update.php';
        require '../src/routes/shared/user/user.picture.php';

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
    #endregion

$app->run();
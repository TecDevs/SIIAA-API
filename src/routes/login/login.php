<?php

use Slim\Http\Response;
use Slim\Http\Request;

$app->post('/api/login/recover', function (Request $request, Response $httpResponse) {
    $correo = $request->getParam('email');
    $correo = htmlspecialchars(filter_var($correo, FILTER_SANITIZE_EMAIL));
    $sqlCorreo = "SELECT contrasena FROM alumnos WHERE correo = :correo";

    try {
        $db = new Database();
        $db = $db->connectDB();
        $stmtCorreo = $db->prepare($sqlCorreo);
        $stmtCorreo->bindParam(':correo', $correo);
        $stmtCorreo->execute();
        if (($stmtCorreo->rowCount()) > 0) {
            $contrasena = $stmtCorreo->fetchColumn();

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            // Configuraci贸n del servidor SMTP
            $mail->SMTPDebug = 0;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'mail.mante.hosting.acm.org';
            $mail->Username = "siia.sup.tm@gmail.com"; //correo de soporte
            $mail->Password = "aT17.zSxHL"; //contrase帽a de soporte
            $mail->Port = 465;

            $mail->setFrom('siia.sup.tm@gmail.com', 'Soporte Tec Mante');
            $mail->addAddress($correo);
            $mail->Subject = 'Olvidaste tu clave de acceso?';
            $mail->Body = '
                    <table style="background-color: #dfe6e9; height: 109px; margin-left: auto; margin-right: auto; width: 484px;">
                    <tbody>
                    <tr style="text-align: center; height: 89px;">
                    <th style="background-color: #74b9ff; height: 89px;">
                    <h2 style="text-align: left;"><strong><img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Logo-TecNM-2017.png" alt="logo" width="80" height="49" /></strong></h2>
                    </th>
                    <th style="background-color: #74b9ff; height: 89px;">
                    <h2 style="text-align: left;"><span style="color: #ffffff;"><strong>Recuerda Bien.</strong></span></h2>
                    </th>
                    </tr>
                    <tr style="height: 128px;">
                    <td style="width: 86.8333px; height: 128px;">&nbsp;</td>
                    <td style="width: 857.167px; height: 128px;">
                    <p>Recientemente solicitaste el recordatorio de tu contrase&ntilde;a.</p>
                    <p>Recuerdala bien para tu siguiente inicio de sesi&oacute;n.</p>
                    <p>Tu contrase&ntilde;a es:</p>
                    </td>
                    </tr>
                    <tr style="height: 100.25px;">
                    <td style="width: 86.8333px; height: 100.25px;">&nbsp;</td>
                    <td style="width: 857.167px; height: 100.25px;">
                    <h4>' . $contrasena . '</h4>
                    </td>
                    </tr>
                    <tr style="height: 150px;">
                    <td style="background-color: #fdcb6e; text-align: left; vertical-align: middle; height: 161px;">&nbsp;</td>
                    <td style="background-color: #fdcb6e; text-align: left; vertical-align: bottom; height: 150px;">
                    <blockquote>
                    <p>TELS (831) 23 3 66 66 Y (831) 23 3 66 70</p>
                    <p>e-mail: direccion@itsmante.edu.mx</p>
                    <p>www.itsmante.edu.mx</p>
                    </blockquote>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <p>&nbsp;</p>
                ';
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true);

            if (!$mail->send()) {
                $response = [
                    'error' => "Error al enviar el E-Mail: " . $mail->ErrorInfo,
                ];
            } else {
                $response = [
                    'success' => "Correo de recuperacion enviado"
                ];
            }
        } else {
            $correo2 = $request->getParam('email');
            $correo2 = htmlspecialchars(filter_var($correo2, FILTER_SANITIZE_EMAIL));
            $sqlCorreo2 = "SELECT contrasena FROM empleados WHERE correo = :correo";

    try {
        $db = new Database();
        $db = $db->connectDB();
        $stmtCorreo2 = $db->prepare($sqlCorreo2);
        $stmtCorreo2->bindParam(':correo', $correo2);
        $stmtCorreo2->execute();
        if (($stmtCorreo2->rowCount()) > 0) {
            $contrasena2 = $stmtCorreo2->fetchColumn();

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            // Configuraci贸n del servidor SMTP
            $mail->SMTPDebug = 0;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'mail.mante.hosting.acm.org';
            $mail->Username = "siia.sup.tm@gmail.com"; //correo de soporte
            $mail->Password = "aT17.zSxHL"; //contrase帽a de soporte
            $mail->Port = 465;

            $mail->setFrom('siia.sup.tm@gmail.com', 'Soporte Tec Mante');
            $mail->addAddress($correo2);
            $mail->Subject = 'Olvidaste tu clave de acceso?';
            $mail->Body = '
                    <table style="background-color: #dfe6e9; height: 109px; margin-left: auto; margin-right: auto; width: 484px;">
                    <tbody>
                    <tr style="text-align: center; height: 89px;">
                    <th style="background-color: #74b9ff; height: 89px;">
                    <h2 style="text-align: left;"><strong><img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Logo-TecNM-2017.png" alt="logo" width="80" height="49" /></strong></h2>
                    </th>
                    <th style="background-color: #74b9ff; height: 89px;">
                    <h2 style="text-align: left;"><span style="color: #ffffff;"><strong>Recuerda Bien.</strong></span></h2>
                    </th>
                    </tr>
                    <tr style="height: 128px;">
                    <td style="width: 86.8333px; height: 128px;">&nbsp;</td>
                    <td style="width: 857.167px; height: 128px;">
                    <p>Recientemente solicitaste el recordatorio de tu contrase&ntilde;a.</p>
                    <p>Recuerdala bien para tu siguiente inicio de sesi&oacute;n.</p>
                    <p>Tu contrase&ntilde;a es:</p>
                    </td>
                    </tr>
                    <tr style="height: 100.25px;">
                    <td style="width: 86.8333px; height: 100.25px;">&nbsp;</td>
                    <td style="width: 857.167px; height: 100.25px;">
                    <h4>' . $contrasena2 . '</h4>
                    </td>
                    </tr>
                    <tr style="height: 150px;">
                    <td style="background-color: #fdcb6e; text-align: left; vertical-align: middle; height: 161px;">&nbsp;</td>
                    <td style="background-color: #fdcb6e; text-align: left; vertical-align: bottom; height: 150px;">
                    <blockquote>
                    <p>TELS (831) 23 3 66 66 Y (831) 23 3 66 70</p>
                    <p>e-mail: direccion@itsmante.edu.mx</p>
                    <p>www.itsmante.edu.mx</p>
                    </blockquote>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <p>&nbsp;</p>
                ';
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true);

            if (!$mail->send()) {
                $response = [
                    'error' => "Error al enviar el E-Mail: " . $mail->ErrorInfo,
                ];
            } else {
                $response = [
                    'success' => "Correo de recuperacion enviado"
                ];
            }
        } else {
            $error = 'No se encontro el correo';
            $response = [
                'error' => $error,
            ];
        }
    } catch (Exception $exception) {
        $response = [
            'error' => $exception,
        ];
    }
        }
    } catch (Exception $exception) {
        $response = [
            'error' => $exception,
        ];
    }
    return $httpResponse->withStatus(200)->withJson($response);
});

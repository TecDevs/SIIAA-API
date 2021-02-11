<?php

use Slim\Http\Response;
use Slim\Http\Request;


$app->post('/api/rh/token', function (Request $request, Response $httpResponse) {
    $Email = $request->getParam('mail');
    $Email = htmlspecialchars(filter_var($Email, FILTER_SANITIZE_EMAIL));
    $area = $request->getParam('area');
    $token = bin2hex(random_bytes((10 - (10 % 2)) / 2));
    $sqlArea = "SELECT id_areas, nombre_area FROM areas WHERE nombre_area = :area";
    try {
        $db = new Database();
        $db = $db->connectDB();
        $stmtArea = $db->prepare($sqlArea);
        $stmtArea->bindParam(':area', $area);
        $stmtArea->execute();
        if (($idAreas = $stmtArea->fetchColumn()) != null) {
            try {
                $sql = 'INSERT INTO usuarios (id_areas, correo_electronico, token) VALUES (:idAreas, :mail, :token)';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':idAreas', $idAreas);
                $stmt->bindParam(':mail', $Email);
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                $response = [
                    'exito' => 'El token se envio al correo',
                    'token' => $token,
                ];
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                // Configuración del servidor SMTP
                $mail->SMTPDebug = 0;
                $mail->SMTPSecure = 'ssl';
                $mail->Host = 'mail.mante.hosting.acm.org';
                $mail->Username = "siia.sup.tm@gmail.com"; //correo de soporte
                $mail->Password = "aT17.zSxHL"; //contraseña de soporte
                $mail->Port = 465;

                // Datos del correo
                $mail->setFrom('siia.sup.tm@gmail.com', 'Soporte Tec Mante');
                $mail->addAddress($Email);
                $mail->Subject = 'Token generado';
                $mail->Body = '
        <table style="background-color: #dfe6e9; height: 109px; margin-left: auto; margin-right: auto; width: 484px;">
                        <tbody>
                        <tr style="text-align: center; height: 89px;">
                        <th style="background-color: #74b9ff; height: 89px;">
                        <h2 style="text-align: left;"><strong><img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Logo-TecNM-2017.png" alt="logo" width="80" height="49" /></strong></h2>
                        </th>
                        <th style="background-color: #74b9ff; height: 89px;">
                        <h2 style="text-align: left;"><span style="color: #ffffff;"><strong>Token para registrarse en SIIAA.</strong></span></h2>
                        </th>
                        </tr>
                        <tr style="height: 128px;">
                        <td style="width: 86.8333px; height: 128px;">&nbsp;</td>
                        <td style="width: 857.167px; height: 128px;">
                        <p>Recientemente se genero un token para que puedas registrarte.</p>
                        <p>Tu token te servira para poder registrarte en el SIIAA con el area de: ' . $area . '</p>
                        <p>Tu token es:</p>
                        </td>
                        </tr>
                        <tr style="height: 100.25px;">
                        <td style="width: 86.8333px; height: 100.25px;">&nbsp;</td>
                        <td style="width: 857.167px; height: 100.25px;">
                        <h4>' . $token . '</h4>
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
                }
            } catch (PDOException $th) {
                $response = [
                    'error' => 'El correo ya tiene un token',
                ];
            }
        } else {
            $error = 'No se encontro el area';
            $response = [
                'error' => $error,
            ];
        }
    } catch (PDOException $e) {
        return $httpResponse->withStatus(200)->withJson('{"error": ' . $e->getMessage() . '}');
    }
    return $httpResponse->withStatus(200)->withJson($response);
});

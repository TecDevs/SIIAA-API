<?php

use Slim\Http\Response;
use Slim\Http\Request;

//show profile picture
$app->post('/api/shared/user/pp', function (Request $request, Response $httpResponse) {
    /*defualt */
    $archivo = 10;
    $destino = "https://www.nicepng.com/png/full/202-2022264_usuario-annimo-usuario-annimo-user-icon-png-transparent.png";

    /*info*/
    $id_usuarios       = $request->getParam('idUser');
    $id_usuarios = htmlspecialchars(filter_var($id_usuarios, FILTER_SANITIZE_NUMBER_INT));

    $sql = 'SELECT id_subida FROM archivos_usuarios 
            WHERE id_usuarios=:iduser AND id_archivos=:idfile';
    try {
        $db = new Database();
        $db = $db->connectDB();
        $result = $db->prepare($sql);
        $result->bindParam(':iduser', $id_usuarios);
        $result->bindParam(':idfile', $archivo);
        $result->execute();

        if ($result->rowCount() == 0) {
            $response = [
                'message' => 'PROFILE_PICTURE_EXISTS'
            ];
        } else {
            $result = null;
            $sql = 'INSERT INTO archivos_usuarios (id_usuarios, id_archivos, archivo_ruta) 
                    VALUES (:iduser, :idfile, :link)';
            $result = $db->prepare($sql);
            $result->bindParam(':iduser', $id_usuarios);
            $result->bindParam(':idfile', $archivo);
            $result->bindParam(':link', $destino);
            $result->execute();
        }
        if ($result->rowCount() > 0) {
            $result = null;
            $sql = 'SELECT MAX(archivos_usuarios.id_subida) as id_subida, 
                                areas.nombre_area as area, 
                                archivos_usuarios.archivo_ruta as ruta, 
                                usuarios.id_usuarios as idUser
                                FROM usuarios 
                                    INNER JOIN areas ON areas.id_areas = usuarios.id_areas 
                                    INNER JOIN archivos_usuarios ON archivos_usuarios.id_usuarios = usuarios.id_usuarios 
                                WHERE archivos_usuarios.id_archivos=10 AND archivos_usuarios.id_usuarios=:iduser';
            $result = $db->prepare($sql);
            $result->bindParam(':iduser', $id_usuarios);
            $result->execute();

            if ($result->rowCount() > 0) {
                $response = $result->fetchAll(PDO::FETCH_OBJ);
            } else {
                $response = [
                    'message' => 'ERROR_SELECT_URL_PICTURE'
                ];
            }
        } else {
            $response = [
                'message' => 'FAIL_INSERT_DEFAULT_PICTURE'
            ];
        }

        return $httpResponse->withStatus(200)->withJson($response);
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        return $httpResponse->withStatus(200)->withJson('{"error": ' . $e->getMessage() . '}');
    }
});


//update profile picture
$app->post('/api/shared/user/pp/update', function (Request $request, Response $httpResponse) {
    if (isset($_FILES['file'])) {
        if (strpos($_FILES['file']['type'], "jpeg") || strpos($_FILES['file']['type'], "jpg") || strpos($_FILES['file']['type'], "png")) {

            $dir_folder = '/home/mantehostingacm/public_html/SIIAA_uploads';
            $dir_link = 'http://mante.hosting.acm.org/SIIAA_uploads';
            $idUser = $request->getParam('idUser');
            $_IDTYPE = 10;
            $file = $_FILES;
            $file_type = "foto_perfil";
            $type = "";

            if (strpos($_FILES['file']['type'], "jpeg")) {
                $type = '.jpeg';
            }
            if (strpos($_FILES['file']['type'], "jpg")) {
                $type = '.jpg';
            }
            if (strpos($_FILES['file']['type'], "png")) {
                $type = '.png';
            }

            $sql = 'SELECT id_usuarios FROM usuarios WHERE id_usuarios = :idUser';

            try {
                $db = new Database();
                $db = $db->connectDB();
                $result = $db->prepare($sql);
                $result->bindParam(':iduser', $id_usuarios);
                $result->execute();

                if ($result->fetchColumn() != null) {

                    $dir_folder = $dir_folder . '/' . $idUser;
                    $dir_link = $dir_link . '/' . $idUser;

                    if (!file_exists($dir_folder)) {
                        mkdir($dir_folder, 0777, true);
                    }

                    $file_type = $_FILES['file']['name'];

                    $dir_folder = $dir_folder . '/' . $file . $type;
                    $dir_link = $dir_link . '/' . $file_type . $type;

                    if (move_uploaded_file($file['file']['tmp_name'], $dir_folder)) {
                        $sql = 'UPDATE archivos_usuarios SET archivo_ruta=:dir 
                                WHERE id_usuarios=:idUser AND id_archivos=:idFile';
                        $result = null;
                        $result = $db->prepare($sql);
                        $result->bindParam(':dir', $dir_link);
                        $result->bindParam(':idFile', $_IDTYPE);
                        $result->bindParam(':idUser', $id_usuarios);
                        $result->execute();

                        if ($result->rowCount() > 0) {
                            $response = [
                                'message' => 'SUCCESS_UPDATED'
                            ];
                        } else {
                            unlink($dir_folder);
                            $response = [
                                'message' => 'FAIL_UPDATED_IMAGE'
                            ];
                        }
                    } else {
                        $response = [
                            'message' => 'FAIL_UPLOAD_IMAGE'
                        ];
                    }
                } else {
                    $response = [
                        'message' => 'USER_NOT_EXISTS'
                    ];
                }
            } catch (PDOException $e) {
                return $httpResponse->withStatus(200)->withJson('{"error": ' . $e->getMessage() . '}');
            }
        } else {
            $response = [
                'message' => 'INVALID_TYPE_PNG_JPEG'
            ];
        }
    } else {
        $response = [
            'message' => 'INVALID_TYPE_IMAGE'
        ];
    }
    return $httpResponse->withStatus(200)->withJson($response);
});

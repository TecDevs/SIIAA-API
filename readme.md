# Aquí irá la documentación de la api para frontend

## RECURSOS HUMANOS
- (post) "api/rh/token" Recibe un Email y una area para generar un token de 10 caracteres y enviarlo por correo.

| nombre del dato | tipo de dato |
| ------------- | ------------- |
| mail | varchar(60) |
| area | varchar(x) |

## ENCUESTAS
- (post) "api/encuestas/guardar-resultados" registra los resultados de un bloque de encuesta

| nombre del dato | tipo de dato |
| ------------- | ------------- |
| bloque | varchar(x) |
| id_area | int |
| valor-respuesta | int |
| pregunta | varchar(x) |

## LOGIN :closed_lock_with_key:
  **:pushpin: RECUPERAR CONTRASEÑA**
  - (post) *"/api/login/recover "*  envia email de solicitud a la clave de acceso de la cuenta
  
      | parametro | tipo |
      | --------- |----- |
      | email | varchar(60) |
  
      ###### login/login.recover.php - *@github/JoseKabo*

## USER  :bust_in_silhouette:


  **:pushpin: FOTO DE PERFIL**
  #### - Mostrar foto perfil
  - (post) *"/api/shared/user/pp"*  inserta una foto de perfil por defecto si aun no la tiene, en caso contrario retorna información necesaria para mostrarla.
  
      | parametro | tipo |
      | --------- |----- |
      | idUser | int |
  
      ###### shared/user/user.picture.php - *@github/JoseKabo*
      
  #### - Actualizar foto de perfil
  - (post) *"/api/shared/user/pp/update"*  recibe una imagen de extension *.jpg, .png , .jpeg* y actualiza la foto de perfil en el server, asi como su enlace público y directorio.
  
      | parametro | tipo |
      | --------- |----- |
      | idUser | int |
      | file   | img |
  
      ###### shared/user/user.picture.php - *@github/JoseKabo*


  **:pushpin: INFORMACIÓN DEL PERFIL**
  
   #### - Actualizar informacion perfil
  - (post) *"/api/shared/user/update"*  actualiza toda la información introducida en el formulario.
  
      | parametro | tipo | parametro | tipo |
      | --------- |----- | --------- |----- |
      | nombres | varchar | colonia | varchar |
      | apePat | varchar | calle | varchar |
      | apeMat | varchar | numInt | int |
      | fechNac | date | numExt | int |
      | celular | int | correo | email |
      | cp | int | correo_old | email |
      | ciudad | varchar | contrasena | varchar |
      | estado | varchar | token | varchar |
      | municipio | varchar | id_usuario | int |
      
      ###### *todos los campos recibidos estan basados en las limitaciones de campo establecidas en la base de datos.*
  
      ###### shared/user/user.update.php - *@github/JoseKabo*

  **:pushpin: NOTAS DE USUARIO**

  #### - Cargar y contar notas
  - (post) *"/api/shared/user/notes/load"*  regresa un *JSON* de todas las notas registradas al id_usuario recibido.
  
      | parametro | tipo |
      | --------- |----- |
      | idUser | int |
      
      ###### shared/notes/notes.load.php - *@github/JoseKabo*
      
  #### - Registrar nota
  - (post) *"/api/shared/user/notes/insert"*  inserta en la base de datos la nota
  
      | parametro | tipo |
      | --------- |----- |
      | title | varchar |
      | descriptionn | varchar |
      | datee | date |
      | idUser | int |
      
      ###### shared/notes/notes.insert.php - *@github/JoseKabo*

  #### - Actualizar nota
  - (post) *"/api/shared/user/notes/update"*  actualiza la nota de acuerdo al parametro idNote y idUser
  
      | parametro | tipo |
      | --------- |----- |
      | idUser | int |
      | title | varchar |
      | descriptionn | varchar |
      | idNote | int |
      
      ###### shared/notes/notes.update.php - *@github/JoseKabo*
      
  #### - Eliminar nota
  - (post) *"/api/shared/user/notes/delete"*  elimina la nota de acuerdo al parametro idNote
  
      | parametro | tipo |
      | --------- |----- |
      | idNote | int |
      
      ###### shared/notes/notes.delete.php - *@github/JoseKabo*

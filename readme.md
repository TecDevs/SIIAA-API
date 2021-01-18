# Aquí irá la documentación de la api para frontend

## URL base
- http://mante.hosting.acm.org/SIIAA-API/public/

## RECURSOS HUMANOS
- (post) *"api/rh/token"* Recibe un Email y una area para generar un token de 10 caracteres y enviarlo por correo.

| nombre del parametro | tipo de dato |
| ------------- | ------------- |
| mail | varchar(60) |
| area | varchar(x) |

###### recursos-humanos/generar-token.php - [*@github/Joaquin4562*](https://github.com/Joaquin4562)

- (get) "api/rh/personal" Trae todo el personal.

| nombre del parametro | tipo de dato |
| ------------- | ------------- |
| nombres | varchar(60) |
| apellido_paterno | varchar(x) |
| apellido_materno | varchar(x) |
| fecha_de_nacimiento | varchar(x) |
| colonia | varchar(x) |
| calle | varchar(x) |

###### recursos-humanos/personal.php - [*@github/Joaquin4562*](https://github.com/Joaquin4562)

- (post) *"api/rh/user/new"* Inserta un nuevo usuario desde el apartado de RH.

| nombre del parametro | tipo de dato |
| ------------- | ------------- |
| area | varchar(60) |
| nombres | varchar(60) |
| a_paterno | varchar(50) |
| a_materno | varchar(50) |
| fecha_de_nacimiento | date |
| celular | varchar(10) |
| cp | varchar(11) |
| ciudad | varchar(40) |
| municipio | varchar(30) |
| estado | varchar(30) |
| colonia | varchar(50) |
| calle | varchar(50) |
| numInt | int |
| numExt | int |
| correo | varchar(50) |
| contrasena | varchar(200) |

###### recursos-humanos/registro-empleado.php - [*@github/Joaquin4562*](https://github.com/Joaquin4562)

## ENCUESTAS
- (post) *"api/encuestas/guardar-resultados"* registra los resultados de un bloque de encuesta

| nombre del dato | tipo de dato |
| ------------- | ------------- |
| bloque | varchar(x) |
| id_area | int |
| valor-respuesta | int |
| pregunta | varchar(x) |

 - (post) *"api/encuestas/obtener-bloques"* obtiene los bloques de la encuesta
 
| nombre del parametro | tipo de dato |
| ------------- | ------------- |
| id_usuarios | integer(x) |

- (post)*"api/encuestas/registro-progreso"* obtiene el progreso


| nombre del parametro | tipo de dato |
| ------------- | ------------- |
| id_usuarios | integer(x) |
| bloque | varchar(x) |


###### recursos-humanos/reportes/avisos.php - *@github/DevelopSanchtz*

-(get) *"api/avisos/get-avisos"* obtiene todos los avisos en un JSON de lo contrario retorna un echo de "No hay avisos actualmente"

## Avisos

| nombre del dato      | tipo de dato  |
| -------------------- | ------------- |
| aviso                | varchar (100) |
| fecha_de_publicacion |   date (x)    |
| fecha_de_caducidad   |   date (x)    |


-(post) *"api/avisos/post-avisos"* inserta avisos y retorna un json con un echo de "Aviso guardado exitosamente"

| nombre del dato      | tipo de dato  |
| -------------------- | ------------- |
| aviso                | varchar (100) |
| fecha_de_publicacion |   date (x)    |
| fecha_de_caducidad   |   date (x)    |

-(put) *"api/avisos/put-avisos/{id}"* actualiza avisos y retorna un json con un echo de "Se a modificado el aviso exitosamente"


| nombre del dato      | tipo de dato  |
| -------------------- | ------------- |
| id_avisos            | int (11)      |
| aviso                | varchar (100) |
| fecha_de_publicacion |   date (x)    |
| fecha_de_caducidad   |   date (x)    |

###### recursos-humanos/reportes/eventos.php - *@github/DevelopSanchtz*

-(get) *"api/eventos/get-eventos"* obtiene todos los eventos y retorna un JSON con los eventos de lo contrario retorna un echo de "No hay eventos actualmente"

## Eventos

| nombre del dato      | tipo de dato  |
| -------------------- | ------------- |
| evento               | varchar (50)  |
| fecha_de_evento      |   date (x)    |


-(post) *"api/eventos/post-eventos"* inserta eventos y retorna un JSON con un echo de "Evento guardado exitosamente"

| nombre del dato      | tipo de dato  |
| -------------------- | ------------- |
| evento               | varchar (50)  |
| fecha_de_evento      |   date (x)    |

-(put) *"api/eventos/put-eventos/{id}"* actualiza eventos y retorna un JSON con un echo de "Se a modificado el evento exitosamente"

| nombre del dato      | tipo de dato  |
| -------------------- | ------------- |
| id_eventos           | int (11)      |
| evento               | varchar (50)  |
| fecha_de_evento      |   date (x)    |

###### shared/encuestas/guardar-resultados.php - [*@github/Joaquin4562*](https://github.com/Joaquin4562)

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

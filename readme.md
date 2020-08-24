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

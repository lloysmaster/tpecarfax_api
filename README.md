tpecarfax_api

Facundo Alejo Barrio - alejo_facundo@yahoo.com Leonardo Ariel kowerdink - leonardokowerdink@gmail.com

carfax

base de datos de usuarios y autos registrados

'el capo de leonardo no se a tirado un commit'


Método,Ruta (Endpoint),Descripción,Cuerpo de Solicitud,Respuesta Esperada
GET,/,Obtiene todos los vehículos. Permite ordenamiento y paginación.,N/A,200 OK (JSON de la lista de vehículos)
GET,/{ID},Obtiene un vehículo específico por su identificador.,N/A,200 OK (JSON del vehículo) o 404 Not Found
POST,/,Crea un nuevo vehículo. Requiere id_user válido.,JSON con datos del vehículo (incluido id_user),201 Created (JSON con id del vehículo) o 400 Bad Request
PUT,/{ID},Actualiza un vehículo existente por su identificador.,JSON con los campos a modificar.,200 OK o 404 Not Found
DELETE,/{ID},Elimina un vehículo por su identificador.,N/A,204 No Content o 404 Not Found
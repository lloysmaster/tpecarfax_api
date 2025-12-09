# tpecarfax_api

Facundo Alejo Barrio - alejo_facundo@yahoo.com Leonardo Ariel kowerdink - leonardokowerdink@gmail.com

carfax

base de datos de usuarios y autos registrados

el capo de leonardo no se a tirado un commit

## 🚗 TPECARFAX API
### 📍 Endpoint Base: `http://localhost/tpecarfax_api/vehicles`

Esta documentación detalla las rutas disponibles para interactuar con los recursos de vehículos.

---

### 🛣️ Rutas de la API (CRUD)

| Método HTTP | Endpoint | Descripción | Estado de Respuesta Típico |
| :---: | :--- | :--- | :--- |
| **GET** | `/` | ➡️ **Obtener todos los vehículos**. Soporta ordenamiento y paginación. | `200 OK` |
| **GET** | `/{ID}` | 🔍 **Obtener vehículo por ID**. | `200 OK` / `404 Not Found` |
| **POST** | `/` | ✨ **Crear un nuevo vehículo**. Requiere un `id_user` válido. | `201 Created` / `400 Bad Request` |
| **PUT** | `/{ID}` | 🔄 **Actualizar un vehículo** existente. | `200 OK` / `404 Not Found` |
| **DELETE** | `/{ID}` | 🗑️ **Eliminar un vehículo** por ID. | `204 No Content` / `404 Not Found` |

---

### 📋 Opciones de Búsqueda y Paginación (`GET /`)

La ruta de listado (`GET /`) permite refinar la búsqueda mediante parámetros de consulta (**Query Params**):

| Parámetro | Descripción | Valores Aceptados | Ejemplo de Uso |
| :--- | :--- | :--- | :--- |
| `sort` | Campo para la ordenación. | `price`, `year`, `brand` | `?sort=price` |
| `order` | Dirección de la ordenación. | `ASC` (predeterminado), `DESC` | `&order=desc` |
| `page` | Número de página. | Entero positivo (> 0). | `&page=2` |
| `limit` | Ítems por página. | Entero positivo (> 0). | `&limit=5` |

#### Ejemplo de Consulta Completa:
```http
GET /tpecarfax_api/vehicles?sort=year&order=desc&page=1&limit=10
```
#### 📩 Estructuras de Datos (Payloads)


###1. Crear Vehículo (POST /)
Se requiere un cuerpo JSON con el id_user obligatoriamente para la validación de la existencia del usuario.

{
  "id_user": 15,
  "brand": "Toyota",
  "model": "Hilux",
  "year": 2023,
  "price": 45000.00,
  "id_category": 2
}

###2. Actualizar Vehículo (PUT /{ID})
Se envía un cuerpo JSON solo con los campos que se desean modificar.
{
  "price": 46500.00,
  "brand": ford
}



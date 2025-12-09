-----

# 🚗 TPECARFAX API (Vehículos)

Este `README` documenta la API de vehículos, que simula una base de datos de tipo "Carfax" para la gestión de **usuarios y autos registrados**.

| Información Clave | Detalles |
| :--- | :--- |
| **Integrantes** | Facundo Alejo Barrio (alejo\_facundo@yahoo.com), Leonardo Ariel Kowerdink (leonardokowerdink@gmail.com) |
| **Módulo** | TPECARFAX API |
| **Endpoint Base** | `http://localhost/tpecarfax_api/vehicles` |
| **los commits reflejan quien hiso algo, revisen por favor** |
-----

## 🛣️ Rutas de la API (CRUD para `/vehicles`)

Esta sección detalla las operaciones **CRUD (Crear, Leer, Actualizar, Eliminar)** disponibles para el recurso `/vehicles`.

| Método HTTP | Endpoint | Descripción | Estado de Respuesta Típico |
| :---: | :--- | :--- | :--- |
| **GET** | `/` | ➡️ **Obtener todos los vehículos**. Soporta **ordenamiento** y **paginación**. | `200 OK` |
| **GET** | `/{ID}` | 🔍 **Obtener vehículo por ID**. | `200 OK` / `404 Not Found` |
| **POST** | `/` | ✨ **Crear un nuevo vehículo**. Requiere un `id_user` válido en el cuerpo. | `201 Created` / `400 Bad Request` |
| **PUT** | `/{ID}` | 🔄 **Actualizar un vehículo** existente por ID. | `200 OK` / `404 Not Found` |

-----

## 📋 Estructura del Recurso **Vehículo**

Todos los *payloads* de creación, actualización y las respuestas de obtención usan la siguiente estructura (se han agregado `title` y `description`):

| Campo | Tipo | Descripción |
| :--- | :--- | :--- |
| `id_vehicle` | `Integer` | ID único del vehículo (**Clave Primaria**). |
| `id_user` | `Integer` | ID del usuario al que pertenece el vehículo (**Clave Foránea**, **obligatorio** en `POST`). |
| `title` | `String` | **Título o nombre corto** para el vehículo. |
| `description` | `String` | **Descripción** detallada del vehículo. |
| `brand` | `String` | Marca del vehículo (ej: "Toyota"). |
| `model` | `String` | Modelo del vehículo (ej: "Hilux"). |
| `year` | `Integer` | Año de fabricación. |
| `price` | `Float` | Precio del vehículo. |
| `id_category` | `Integer` | ID de la categoría del vehículo (**Clave Foránea**). |

### ✏️ Ejemplos de **Payloads**

#### **1. Crear Vehículo (POST /)**

Se requiere un cuerpo JSON con el `id_user` obligatoriamente para la validación de la existencia del usuario.

```json
{
  "id_user": 15,
  "title": "4x4 Potente",
  "description": "Ideal para trabajo duro o viajes largos.",
  "brand": "Toyota",
  "model": "Hilux",
  "year": 2023,
  "price": 45000.00,
  "id_category": 2
}
```

#### **2. Actualizar Vehículo (PUT /{ID})**

Se envía un cuerpo JSON solo con los campos que se desean modificar.

```json
{
  "price": 46500.00,
  "brand": "Ford"
}
```

-----

## 🔎 Listado y Búsqueda (`GET /`)

La ruta de listado (`GET /`) permite refinar la búsqueda, el ordenamiento y la paginación a través de **Query Parameters**.

### ⚙️ Parámetros de Consulta

| Parámetro | Descripción | Valores Aceptados | Ejemplo de Uso |
| :--- | :--- | :--- | :--- |
| `sort` | Campo para la ordenación. | `price`, `year`, `brand`, etc. | `?sort=price` |
| `order` | Dirección de la ordenación. | `ASC` (predeterminado), `DESC` | `&order=desc` |
| `page` | Número de página. | Entero positivo (\> 0). | `&page=2` |
| `limit` | Ítems por página. | Entero positivo (\> 0). | `&limit=5` |

#### Ejemplo de Consulta Completa:

```http
GET /tpecarfax_api/vehicles?sort=year&order=desc&page=1&limit=10
```

### 📦 Estructura de Respuesta de Listado (Sin Metadata)

La ruta `GET /` **devuelve directamente un array JSON** que contiene los objetos de los vehículos solicitados, respetando los límites y la paginación si se especifican los Query Parameters. **No incluye metadata de paginación** (como `total_items` o `total_pages`).

#### Ejemplo de Estructura de Respuesta:

```json
[
    {
        "id_vehicle": 8,
        "title": "auto",
        "description": "y pues un auto normal",
        "brand": "fiat",
        "model": "uno",
        "year": "1983",
        "price": "10000000.00",
        "id_category": 2,
        "id_user": 7
    },
    {
        "id_vehicle": 9,
        "title": "la fiera",
        "description": "una motito",
        "brand": "zanella",
        "model": "rx150",
        "year": "2025",
        "price": "1980000.00",
        "id_category": 1,
        "id_user": 6
    },
    // ... hasta el número definido por 'limit'
]
```

-----

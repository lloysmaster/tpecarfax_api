<?php

require_once './libs/router/Router.php';
require_once './app/controllers/vehicle.api.controller.php';

$router = new Router();

// GET /vehicles Obtener todos los vehículos
// El string 'VehicleApiController' debe coincidir con el nombre de la clase.
$router->addRoute('vehicles', 'GET', 'VehicleApiController', 'getAll');

// GET /vehicles/:id (Obtener un vehículo por ID)
// Nota el uso de ':ID' o similar para indicar un parámetro variable.
$router->addRoute('vehicles/:ID', 'GET', 'VehicleApiController', 'getOne');

// POST /vehicles (Crear un nuevo vehículo)
$router->addRoute('vehicles', 'POST', 'VehicleApiController', 'create');

// PUT /vehicles/:id (Actualizar un vehículo por ID)
$router->addRoute('vehicles/:ID', 'PUT', 'VehicleApiController', 'update');

// DELETE /vehicles/:id Borrar un vehículo por ID
// Es buena práctica incluir el DELETE.
//$router->addRoute('vehicles/:ID', 'DELETE', 'VehicleApiController', 'delete');//no funcional




// 4. Le pedis a la librería que procese la solicitud actual
// Este método (route) analiza la URL, el método HTTP,
// y ejecuta el controlador y el método correctos.
$router->route($_GET['resource'] ?? '/', $_SERVER['REQUEST_METHOD']);
?>
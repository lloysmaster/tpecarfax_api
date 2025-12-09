<?php
require_once './app/models/vehicle.model.php';

class VehicleApiController {
    private $model;

    public function __construct() {
        $this->model = new VehicleModel();
        header("Content-Type: application/json");
    }

    public function getAll() {
    $sort = $_GET['sort'] ?? null;
    $order = $_GET['order'] ?? 'ASC';

    $validSorts = ['price', 'year', 'brand'];

    if ($sort && !in_array($sort, $validSorts)) {
        http_response_code(400);
        echo json_encode(["error" => "Campo de orden inválido"]);
        return;
    }

    // PAGINACIÓN
    $page = isset($_GET['page']) ? (int)$_GET['page'] : null;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;

    if ($page !== null && $limit !== null) {
        if ($page < 1 || $limit < 1) {
            http_response_code(400);
            echo json_encode(["error" => "page y limit deben ser mayores a 0"]);
            return;
        }
        $offset = ($page - 1) * $limit;
    } else {
        $offset = null;
    }

    $vehicles = $this->model->getAll($sort, $order, $limit, $offset);

    http_response_code(200);
    echo json_encode($vehicles);
}

    public function getOne($id) {
        $vehicle = $this->model->get($id);

        if (!$vehicle) {
            http_response_code(404);
            echo json_encode(["error" => "Vehículo no encontrado"]);
            return;
        }

        http_response_code(200);
        echo json_encode($vehicle);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"));

        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "JSON inválido"]);
            return;
        }

        $id = $this->model->insert($data);

        http_response_code(201);
        echo json_encode(["message" => "Vehículo creado", "id" => $id]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"));

        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "JSON inválido"]);
            return;
        }

        $exists = $this->model->get($id);
        if (!$exists) {
            http_response_code(404);
            echo json_encode(["error" => "No existe el vehículo"]);
            return;
        }

        $this->model->update($id, $data);

        http_response_code(200);
        echo json_encode(["message" => "Vehículo actualizado"]);
    }
}

<?php
require_once './app/models/vehicle.model.php';
require_once './app/models/user.model.php';

class VehicleApiController {
    private $model;

    public function __construct() {
        $this->model = new VehicleModel();
        header("Content-Type: application/json");
    }

    
    public function getAll($request, $response) { 
        $sort = $_GET['sort'] ?? null;
        $order = $_GET['order'] ?? 'ASC';

        $validSorts = ['price', 'year', 'brand'];

        if ($sort && !in_array($sort, $validSorts)) {
            http_response_code(400);
            echo json_encode(["error" => "Campo de orden inválido"]);
            return;
        }

        
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

    
    public function getOne($request, $response) {
        $id = $request->params->ID;

        $vehicle = $this->model->get($id); 

        if (!$vehicle) {
            http_response_code(404);
            echo json_encode(["error" => "Vehículo no encontrado"]);
            return;
        }

        http_response_code(200);
        echo json_encode($vehicle);
    }


    public function create($request, $response) {
        $data = json_decode(file_get_contents("php://input"));

        if (!$data || !isset($data->id_user)) { 
            http_response_code(400);
            echo json_encode(["error" => "JSON inválido o falta id_user"]);
            return;
        }
    
        $userModel = new UserModel(); 
        $userExists = $userModel->get($data->id_user); 

        if (!$userExists) {
            http_response_code(404);
            echo json_encode(["error" => "El usuario con id: {$data->id_user} no existe."]);
            return;
        }

        $id = $this->model->insert($data);

        http_response_code(201);
        echo json_encode(["message" => "Vehículo creado", "id" => $id]);
    }


    public function update($request, $response) {
        $id = $request->params->ID;
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
    

    public function delete($request, $response) {
        $id = $request->params->ID;

        $exists = $this->model->get($id);
        if (!$exists) {
            http_response_code(404);
            echo json_encode(["error" => "No existe el vehículo a borrar"]);
            return;
        }
        $this->model->delete($id);
        http_response_code(204);
    }
}
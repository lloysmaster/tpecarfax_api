<?php
require_once __DIR__ . '/../../config/config.php';

class VehicleModel {
    
    private $db;

    public function __construct() {
        // Usamos la clase Database para obtener la conexión
        $this->db = Database::connect();
    }

    public function getAll($sort = null, $order = 'ASC', $limit = null, $offset = null) {
        $sql = "SELECT * FROM vehicles";

        if ($sort) {
            $sql .= " ORDER BY $sort $order";
        }

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $query = $this->db->prepare($sql);

        if ($limit !== null && $offset !== null) {
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM vehicles WHERE id_vehicle = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($data) {
        $query = $this->db->prepare(
            "INSERT INTO vehicles (title, description, brand, model, year, price, id_category, id_user)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $query->execute([
            $data->title,
            $data->description,
            $data->brand,
            $data->model,
            $data->year,
            $data->price,
            $data->id_category,
            $data->id_user
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $query = $this->db->prepare(
            "UPDATE vehicles SET 
             title = ?, description = ?, brand = ?, model = ?, year = ?, price = ?, id_category = ?, id_user = ?
             WHERE id_vehicle = ?"
        );

        return $query->execute([
            $data->title,
            $data->description,
            $data->brand,
            $data->model,
            $data->year,
            $data->price,
            $data->id_category,
            $data->id_user,
            $id
        ]);
    }
}

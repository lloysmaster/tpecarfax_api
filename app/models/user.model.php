
<?php
require_once __DIR__ . '/../../config/config.php';

class UserModel {
    
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ); 
    }
}
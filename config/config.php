<?php

class Database {
    private static $db = null;

    public static function connect() {
        if (!self::$db) {
            $host = 'localhost';
            $dbname = 'testbasecarfax';
            $user = 'root';
            $pass = '';

            try {
                self::$db = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $user,
                    $pass
                );
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["error" => "Error de conexión a la base de datos"]);
                die();
            }
        }

        return self::$db;
    }
}

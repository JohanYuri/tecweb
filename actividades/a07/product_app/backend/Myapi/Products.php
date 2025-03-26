<?php
namespace tecweb\Myapi;

use tecweb\Myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $response = array();

    public function __construct(string $db, string $user = 'root', string $pass = '1234', string $host = 'localhost') {
        $this->response = array();
        parent::__construct($host, $user, $pass, $db);
    }

    public function list() {
        $this->response = array();
        $query = "SELECT * FROM productos WHERE eliminado = 0";
        if ($result = $this->conexion->query($query)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!empty($rows)) {
                $this->response = $rows;
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    public function singleByName(string $name) {
        $this->response = array();
        $escaped_name = $this->conexion->real_escape_string($name);
        $query = "SELECT * FROM productos WHERE nombre = '$escaped_name' AND eliminado = 0 LIMIT 1";
        if ($result = $this->conexion->query($query)) {
            $row = $result->fetch_assoc();
            if ($row) {
                $this->response = array($row);
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
    }

    public function getData() {
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

}
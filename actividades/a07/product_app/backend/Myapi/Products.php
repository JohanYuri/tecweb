<?php
namespace tecweb\Myapi;

use tecweb\Myapi\DataBase;

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
            $this->response = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        } else {
            $this->response = ['status' => 'error', 'message' => $this->conexion->error];
        }
    }

    public function singleByName(string $name) {
        $this->response = array();
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE nombre = ? AND eliminado = 0 LIMIT 1");
        $stmt->bind_param("s", $name);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->response = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $this->response = ['status' => 'error', 'message' => $stmt->error];
        }
        $stmt->close();
    }

    public function getData() {
        return json_encode($this->response, JSON_PRETTY_PRINT);
    }

    public function add(string $nombre, string $marca, string $modelo, ?float $precio, string $detalles, int $unidades, string $imagen) {
        $this->response = array();
        $stmt = $this->conexion->prepare("INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssdsss", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
        
        if ($stmt->execute()) {
            $this->response = ['status' => 'success', 'message' => 'Producto agregado'];
        } else {
            $this->response = ['status' => 'error', 'message' => $stmt->error];
        }
        $stmt->close();
    }

    public function delete(int $id) {
        $this->response = array();
        $stmt = $this->conexion->prepare("UPDATE productos SET eliminado = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $this->response = ['status' => 'success', 'message' => 'Producto eliminado'];
        } else {
            $this->response = ['status' => 'error', 'message' => $stmt->error];
        }
        $stmt->close();
    }

    public function update(int $id, string $nombre, string $marca, string $modelo, ?float $precio, string $detalles, int $unidades, string $imagen) {
        $this->response = array();
        $stmt = $this->conexion->prepare("UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, detalles = ?, unidades = ?, imagen = ? WHERE id = ?");
        $stmt->bind_param("sssdsssi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $id);
        
        if ($stmt->execute()) {
            $this->response = ['status' => 'success', 'message' => 'Producto actualizado'];
        } else {
            $this->response = ['status' => 'error', 'message' => $stmt->error];
        }
        $stmt->close();
    }

    public function findById(int $id) {
        $this->response = array();
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id = ? AND eliminado = 0 LIMIT 1");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->response = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $this->response = ['status' => 'error', 'message' => $stmt->error];
        }
        $stmt->close();
    }
}
?>
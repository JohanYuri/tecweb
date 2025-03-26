<?php
namespace tecweb\Myapi;

abstract class DataBase {
    protected $conexion;

    public function __construct($host, $user, $pass, $db) {
        $this->conexion = mysqli_connect($host, $user, $pass, $db);
        
        if (!$this->conexion) {
            die('Error de conexión: ' . mysqli_connect_error());
        }
        
        // Configurar charset a utf8
        $this->conexion->set_charset("utf8");
    }
}
?>
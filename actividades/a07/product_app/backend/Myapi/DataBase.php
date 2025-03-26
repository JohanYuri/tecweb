<?php

namespace tecweb\Myapi;

abstract class DataBase {

    protected $conexion;

    public function __construct($host, $user, $pass, $db) {
        $this->conexion = @mysqli_connect(
            $host,
            $user,
            $pass,
            $db
        );

        if (!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }
    }
}
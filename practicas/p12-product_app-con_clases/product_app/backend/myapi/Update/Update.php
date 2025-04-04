<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Update extends DataBase {
    private $data;

    public function __construct($db, $user='root', $pass='1234') {
        $this->data = array();
        parent::__construct($db, $user, $pass);
    }

    public function edit($jsonOBJ) {
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        if(isset($jsonOBJ->id)) {
            $sql  = "UPDATE productos SET nombre='{$jsonOBJ->nombre}', marca='{$jsonOBJ->marca}',";
            $sql .= "modelo='{$jsonOBJ->modelo}', precio={$jsonOBJ->precio}, detalles='{$jsonOBJ->detalles}',";
            $sql .= "unidades={$jsonOBJ->unidades}, imagen='{$jsonOBJ->imagen}' WHERE id={$jsonOBJ->id}";
            $this->conexion->set_charset("utf8");
            if ($this->conexion->query($sql)) {
                $this->data['status'] =  "success";
                $this->data['message'] =  "Producto actualizado";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
    }
}

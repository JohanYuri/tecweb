<?php
include_once __DIR__ . '/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JASON A OBJETO
    $jsonOBJ = json_decode($producto);

    // VALIDACIÓN DE DATOS REPETIDOS
    $nombre = $jsonOBJ->nombre;
    $marca = $jsonOBJ->marca;
    $modelo = $jsonOBJ->modelo;

    $sql_check = "SELECT id FROM productos WHERE (nombre = '$nombre' AND marca = '$marca' OR marca = '$marca' AND modelo = '$modelo') AND eliminado = 0";
    $result_check = $conexion->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "[SERVIDOR] ERROR: El producto ya existe.";
    } else {

        // INSERCIÓN A LA BASE DE DATOS
        $precio = $jsonOBJ->precio;
        $unidades = $jsonOBJ->unidades;
        $detalles = $jsonOBJ->detalles;
        $imagen = $jsonOBJ->imagen;

        $sql = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen) VALUES ('$nombre', $precio, $unidades, '$modelo', '$marca', '$detalles', '$imagen')";

        if ($conexion->query($sql) === TRUE) {
            echo "[SERVIDOR] Producto agregado con éxito.";
        } else {
            echo "[SERVIDOR] ERROR: " . $sql . "<br>" . $conexion->error;
        }
    }
    $conexion->close();
}
?>
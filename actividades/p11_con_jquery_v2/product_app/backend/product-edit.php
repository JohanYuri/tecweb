<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array();

    if (!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);

        // Validar que los campos requeridos no estén vacíos
        if (empty($jsonOBJ->nombre) || empty($jsonOBJ->precio) || empty($jsonOBJ->unidades) || empty($jsonOBJ->marca)) {
            $data['status'] = "error";
            $data['message'] = "Todos los campos requeridos deben estar llenos.";
        } else {
            $conexion->set_charset("utf8");
            $sql = "UPDATE productos SET nombre = '{$jsonOBJ->nombre}', marca = '{$jsonOBJ->marca}', modelo = '{$jsonOBJ->modelo}', 
                    precio = {$jsonOBJ->precio}, detalles = '{$jsonOBJ->detalles}', unidades = {$jsonOBJ->unidades}, 
                    imagen = '{$jsonOBJ->imagen}' WHERE id = {$jsonOBJ->id}";

            if ($conexion->query($sql)) {
                $data['status'] = "success";
                $data['message'] = "Producto actualizado";
            } else {
                $data['status'] = "error";
                $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
            }
        }

        // Cierra la conexión
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
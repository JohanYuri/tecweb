<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array();

// Si se ha enviado un id en el POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    if ($result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'")) {
        // SE OBTIENEN LOS RESULTADOS
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!is_null($row)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
            foreach ($row as $key => $value) {
                $data[$key] = $value; // utf8_encode($value);
            }
        }
        $result->free();
    } else {
        // Devolver un error en formato JSON si la consulta falla
        echo json_encode(array('error' => 'Query Error: ' . mysqli_error($conexion)));
        exit();  // Detener la ejecución del script
    }
    $conexion->close();
} else if (isset($_POST['nombre']) || isset($_POST['marca']) || isset($_POST['detalles'])) {
    // SE OBTIENEN LOS CRITERIOS DE BÚSQUEDA
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
    $detalles = isset($_POST['detalles']) ? $_POST['detalles'] : '';

    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    $query = "SELECT * FROM productos WHERE nombre LIKE '%{$nombre}%' AND marca LIKE '%{$marca}%' AND detalles LIKE '%{$detalles}%'";
    $result = $conexion->query($query);
    
    // SE RECORREN TODOS LOS RESULTADOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
        $data[] = $row; // Se agrega la fila al arreglo de datos
    }
    $result->free();
} else {
    // Devolver un error en formato JSON si no hay parámetros válidos
    echo json_encode(array('error' => 'Invalid request'));
    exit();  // Detener la ejecución del script
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>
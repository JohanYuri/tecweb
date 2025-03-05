<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    
    // SE VERIFICA SI SE RECIBE UN TÉRMINO DE BÚSQUEDA
    if( isset($_POST['search']) ) {
        $search = $conexion->real_escape_string($_POST['search']);
        
        // SE REALIZA LA QUERY PARA BUSCAR COINCIDENCIAS EN NOMBRE, MARCA O DETALLES
        $query = "SELECT * FROM productos WHERE nombre LIKE '%$search%' OR marca LIKE '%$search%' OR detalles LIKE '%$search%'";
        
        if ($result = $conexion->query($query)) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        
        $conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>

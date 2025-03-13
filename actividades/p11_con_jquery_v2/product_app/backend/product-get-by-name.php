<?php
    include_once __DIR__.'/database.php';

    $response = false;

    if (isset($_POST['name'])) {
        $nombre = $_POST['name'];

        $query = "SELECT * FROM productos WHERE nombre = '{$nombre}'";
        $result = $conexion->query($query);

        if ($result && $result->num_rows > 0) {
            $response = true;
        }

        $result->free();
        $conexion->close();
    }

    echo json_encode($response);
?>
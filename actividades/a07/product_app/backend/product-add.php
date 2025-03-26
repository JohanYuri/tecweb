<?php
    /* include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }

        $result->free();
        // Cierra la conexion
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/




    namespace tecweb\Myapi;
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require_once __DIR__ . '/Myapi/DataBase.php';
    require_once __DIR__ . '/Myapi/Products.php';
    
    // Configuración - REEMPLAZA con tus credenciales reales
    $host = 'localhost';
    $user = 'root';
    $pass = '1234';
    $db_name = 'marketzone'; 
    $productos = new Products($db_name, $user, $pass, $host);
    
    $producto = file_get_contents('php://input');
    $data = ['status' => 'error', 'message' => 'Error al agregar producto'];
    
    if (!empty($producto)) {
        $jsonOBJ = json_decode($producto);
        if ($jsonOBJ !== null) {
            $productos->add(
                $jsonOBJ->nombre ?? '',
                $jsonOBJ->marca ?? '',
                $jsonOBJ->modelo ?? '',
                $jsonOBJ->precio ?? null,
                $jsonOBJ->detalles ?? '',
                $jsonOBJ->unidades ?? 0,
                $jsonOBJ->imagen ?? ''
            );
            $data = json_decode($productos->getData(), true);
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    ?>
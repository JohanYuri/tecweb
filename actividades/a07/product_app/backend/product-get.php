<?php
    /* include_once __DIR__.'/database.php';

    $id = $_GET['id'];

    // $query = "SELECT * FROM productos WHERE id = $id";
    $result = $conexion->query("SELECT * FROM productos WHERE id = $id");

    if(!$result){
        die('Query Error: '.mysqli_error($conexion));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'precio' => $row['precio'],
            'unidades' => $row['unidades'],
            'modelo' => $row['modelo'],
            'marca' => $row['marca'],
            'detalles' => $row['detalles'],
            'imagen' => $row['imagen']
        );
    }           
    // Codificar el array a JSON y devolverlo
    // echo json_encode($json, JSON_PRETTY_PRINT);
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
    */


    namespace tecweb\Myapi;

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    require_once __DIR__ . '/Myapi/DataBase.php';
    require_once __DIR__ . '/Myapi/Products.php';
    
    $host = 'localhost';
    $user = 'root';
    $pass = '1234';
    $db_name = 'marketzone'; 
    
    $productos = new Products($db_name, $user, $pass, $host);
    
    $data = ['status' => 'error', 'message' => 'ID no proporcionado'];
    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $productos->findById($id);
        $response = json_decode($productos->getData(), true);
        $data = !empty($response) ? $response[0] : $data;
    }
    
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    ?>
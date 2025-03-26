<?php
    /* include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_GET['id']) ) {
        $id = $_GET['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
        if ( $conexion->query($sql) ) {
            $data['status'] =  "success";
            $data['message'] =  "Producto eliminado";
		} else {
            $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);

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
        if ($id > 0) {
            $productos->delete($id);
            $data = json_decode($productos->getData(), true);
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    ?>
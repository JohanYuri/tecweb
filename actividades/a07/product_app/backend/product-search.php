<?php
    /* include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_POST['search']) ) {
        $search = $_POST['search'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
        if ( $result = $conexion->query($sql) ) {
            // SE OBTIENEN LOS RESULTADOS
			$rows = $result->fetch_all(MYSQLI_ASSOC);

            if(!is_null($rows)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $data[$num][$key] = utf8_encode($value);
                    }
                }
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
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
            
            $data = ['status' => 'error', 'message' => 'Término no proporcionado'];
            
            if (isset($_POST['search'])) {
                $term = trim($_POST['search']);
                if (!empty($term)) {
                    $productos->search($term);
                    $data = json_decode($productos->getData(), true);
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($data, JSON_PRETTY_PRINT);
            ?>
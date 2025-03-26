<?php
    /* include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();

    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    if ( $result = $conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
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
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
    
        */

  


 
        namespace tecweb\Myapi;
        
        require_once __DIR__ . '/Myapi/DataBase.php';
        require_once __DIR__ . '/Myapi/Products.php';
        
        // Limpia cualquier salida previa
        ob_clean();
        
        // Headers esenciales
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');
        
        // Configuración
        $host = 'localhost';
        $user = 'root';
        $pass = '1234';
        $db_name = 'marketzone';
        
        try {
            $productos = new Products($db_name, $user, $pass, $host);
            $productos->list();
            
            // Validar y limpiar la respuesta
            $responseData = json_decode($productos->getData(), true);
            
            if(json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error formateando JSON: ".json_last_error_msg());
            }
            
            // Estructura de respuesta consistente
            $response = [
                'status' => 'success',
                'data' => $responseData,
                'timestamp' => time()
            ];
            
            // Codificar con opciones para evitar problemas
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        
        // Asegurar que no hay salida adicional
        exit();
        ?>
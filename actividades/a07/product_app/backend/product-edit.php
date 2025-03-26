<?php
    /* include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array();

    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);

            $conexion->set_charset("utf8");
            $sql = "UPDATE productos SET nombre = '{$jsonOBJ->nombre}', marca = '{$jsonOBJ->marca}', modelo = '{$jsonOBJ->modelo}', 
                    precio = {$jsonOBJ->precio}, detalles = '{$jsonOBJ->detalles}', unidades = " . (float)$jsonOBJ->unidades . ", 
                    imagen = '{$jsonOBJ->imagen}' WHERE id = " . (int)$jsonOBJ->id;

            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto Editado";
            } else {
                $data['status'] = "error";
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }

        // Cierra la conexion
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

$producto = file_get_contents('php://input');
$data = ['status' => 'error', 'message' => 'Error al editar producto'];

if (!empty($producto)) {
    $jsonOBJ = json_decode($producto);
    if ($jsonOBJ !== null && isset($jsonOBJ->id)) {
        $productos->update(
            intval($jsonOBJ->id),
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
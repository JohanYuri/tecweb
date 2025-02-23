<?php
$nombre   = $_POST['nombre'];
$marca    = $_POST['marca'];
$modelo   = $_POST['modelo'];
$precio   = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen   = 'img/imagen.png';
$eliminado = $_POST['eliminado'];

/** SE CREA EL OBJETO DE CONEXION */
@$link = new mysqli('localhost', 'root', '1234', 'marketzone');	

/** comprobar la conexión */
if ($link->connect_errno) 
{
    die('Falló la conexión: '.$link->connect_error.'<br/>');
    /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
}

// Validar que nombre, modelo y marca no existan en la base de datos
$sql = "SELECT * FROM productos WHERE nombre = '{$_POST["nombre"]}' AND modelo = '{$_POST["modelo"]}' AND marca = '{$_POST["marca"]}'";
$result = $link->query($sql);
if($result->num_rows > 0)
{
    echo '<h1>Error</h1>
            <p>El producto ya existe en la base de datos</p>';
    $link->close();
    return;
}

/** Crear una tabla que no devuelve un conjunto de resultados */
$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', '{0}')";
if ( $link->query($sql) ) 
{
    echo '<h1>Producto</h1>
    <h2>Datos insertados:</h2>
    <span>ID: </span>'.$link->insert_id.'
    <br><span>Nombre: </span>'.$_POST["nombre"].'
    <br><span>Marca: </span>'.$_POST["marca"].'
    <br><span>Modelo: </span>'.$_POST["modelo"].'
    <br><span>Precio: $</span>'.$_POST["precio"].'
    <br><span>Detalles: </span>'.$_POST["detalles"].'
    <br><span>Unidades: </span>'.$_POST["unidades"].'
    <br><span>Imagen: </span>'.$_POST["imagen"].'
    <br><span>Eliminado: 0 (Falso)</span>';
}
else
{
    echo 'El Producto no pudo ser insertado =(';
}

$link->close();
?>
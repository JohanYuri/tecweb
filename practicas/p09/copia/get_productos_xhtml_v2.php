<?php
header("Content-Type: application/xhtml+xml; charset=utf-8");

/**
 * Función que obtiene los productos vigentes (no eliminados).
 */
function obtenerProductosVigentes() {
    $datos = array();
    $conexion = new mysqli('localhost', 'root', '1234', 'marketzone');

    if ($conexion->connect_errno) {
        die('Falló la conexión: ' . $conexion->connect_error . '<br/>');
    }

    $consulta = "SELECT * FROM productos WHERE eliminado = 0";
    if ($resultado = $conexion->query($consulta)) {
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        $resultado->free();
    }

    $conexion->close();
    return $datos;
}

// Obtenemos los productos vigentes.
$productos = obtenerProductosVigentes();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Productos no eliminados</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
              crossorigin="anonymous" />
    </head>
    <body>
        <h3>Listado de Productos Vigentes</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Detalles</th>
                    <th>Imagen</th>
                    <th>Eliminado</th>
                    <th>Modificar</th>
                    <th>Acción</th> <!-- Nueva columna -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['id']); ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                        <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td><?php echo htmlspecialchars($producto['unidades']); ?></td>
                        <td><?php echo htmlspecialchars($producto['detalles']); ?></td>
                        <td>
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="http://localhost/practicas/p07/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="100" />
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($producto['eliminado']); ?></td>
                        <td>
                            <a href="formulario_productos_v2.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">Modificar</a>
                        </td>
                        <td>
                            <!-- Enlace para modificar el producto -->
                            <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning">Editar</a> <!-- Aquí agregamos el botón de "Editar" -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>

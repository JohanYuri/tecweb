<?php
header("Content-Type: application/xhtml+xml; charset=utf-8");

if (isset($_GET['tope'])) {
    $tope = intval($_GET['tope']); // Convertimos el parámetro a entero para evitar inyecciones SQL
} else {
    die('<p>Parámetro "tope" no detectado...</p>');
}

if (!empty($tope)) {
    @$link = new mysqli('localhost', 'root', '1234', 'marketzone');
    
    if ($link->connect_errno) {
        die('<p>Falló la conexión: ' . $link->connect_error . '</p>');
    }
    
    if ($result = $link->query("SELECT * FROM productos WHERE unidades <= $tope")) {
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    }
    
    $link->close();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
</head>
<body>
    <h3>Lista de Productos</h3>
    
    <?php if (!empty($productos)) : ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Detalles</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($producto['id']); ?></th>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                        <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td><?php echo htmlspecialchars($producto['unidades']); ?></td>
                        <td><?php echo htmlspecialchars($producto['detalles']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" width="100" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No se encontraron productos con unidades menores o iguales a <?php echo $tope; ?>.</p>
    <?php endif; ?>
</body>
</html>

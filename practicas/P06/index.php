<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
    <?php
        require_once 'src/funciones.php'; //Se incluye el archivo funciones.php
    ?>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir un programa para comprobar si un número es múltiplo de 5 y 7</p>

    <form method="get">
        <input type="number" name="numero" required>
        <input type="submit" value="Comprobar">
    </form>

    <?php
        if(isset($_GET['numero'])) {
            $num = $_GET['numero'];
            if ($num % 5 == 0 && $num % 7 == 0) {
                echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
            } else {
                echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
            }
        }
    ?>

    <h2>Ejemplo de POST</h2>
    <form action="index.php" method="post"> <!-- ✅ Ya no tiene la URL absoluta -->
        Nombre: <input type="text" name="name" required><br>
        E-mail: <input type="email" name="email" required><br>
        <input type="submit" value="Enviar">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"])) {
            echo '<h3>Nombre: ' . htmlspecialchars($_POST["name"]) . '</h3>';
            echo '<h3>Email: ' . htmlspecialchars($_POST["email"]) . '</h3>';
        }
    ?>
</body>
</html>

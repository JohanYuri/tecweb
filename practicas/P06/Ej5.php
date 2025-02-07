<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Edad y Sexo</title>
</head>
<body>
    <form action="" method="post">
        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required>
        <br>
        <label for="sexo">Sexo:</label>
        <select name="sexo" id="sexo" required>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
        </select>
        <br>
        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];

        if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
            echo "<p>Bienvenida, usted está en el rango de edad permitido.</p>";
        } else {
            echo "<p>Error: No cumple con los requisitos.</p>";
        }
    }
    ?>
</body>
</html>

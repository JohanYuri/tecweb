<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación</title>
</head>
<body>

    <?php
        if(isset($_POST["sexo"]) && isset($_POST["edad"])){            
            if ($_POST["sexo"] == "Femenino" && $_POST["edad"] >= 18 && $_POST["edad"] <= 35) {
                echo 'Bienvenida, usted está en el rango de edad permitido.';
            }   
            else{
                echo 'Error edad y/o sexo no permitido(s)';
            }
        } 
    ?>
    <br>
    <a href="../EJ5.html">
        <button>Regresar</button>
    </a>
</body>
</html>